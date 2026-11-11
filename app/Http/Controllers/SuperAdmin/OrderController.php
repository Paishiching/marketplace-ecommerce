<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\Shipment;
use App\Services\Couriers\CourierManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->withCount('orderItems');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        $statusCounts = Order::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->status => (int) $r->total]);

        // Bulk e shudhu API courier
        $apiCouriers = Courier::where('status', true)
            ->where('driver', '!=', 'manual')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('superadmin.orders.index', compact('orders', 'statusCounts', 'apiCouriers'));
    }

    public function show(Order $order)
    {
        $order->load([
            'customer',
            'shippingAddress',
            'shippingZone',
            'orderItems.product',
            'orderItems.vendor',
            'payments.depositDetails',
            'shipments.courier',
            'orderNotes' => fn ($q) => $q->latest(),
            'orderNotes.createdBy',
        ]);

        $allowedStatuses = config('order.transitions.' . $order->status, []);
        $couriers        = Courier::where('status', true)->orderBy('name')->get(['id', 'name', 'driver']);
        $shipment        = $order->shipments->sortByDesc('id')->first();

        return view('superadmin.orders.show', compact('order', 'allowedStatuses', 'couriers', 'shipment'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $allowed = config('order.transitions.' . $order->status, []);

        $data = $request->validate([
            'status' => ['required', Rule::in($allowed)],
            'note'   => ['nullable', 'string', 'max:1000'],
        ], [
            'status.in' => 'This status change is not allowed for the current order status.',
        ]);

        DB::transaction(function () use ($order, $data) {
            $old = $order->status;

            $order->update(['status' => $data['status']]);

            $text = "Status changed from {$old} to {$data['status']}.";
            if (! empty($data['note'])) {
                $text .= ' ' . $data['note'];
            }

            $this->addNote($order, $text);
        });

        return back()->with('success', 'Order status updated.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'payment_status' => ['required', Rule::in(array_keys(config('order.payment_statuses')))],
        ]);

        if ($order->payment_status === $data['payment_status']) {
            return back()->with('error', 'Payment is already in this status.');
        }

        DB::transaction(function () use ($order, $data) {
            $old = $order->payment_status;

            $order->update(['payment_status' => $data['payment_status']]);

            $this->addNote($order, "Payment status changed from {$old} to {$data['payment_status']}.");
        });

        return back()->with('success', 'Payment status updated.');
    }

    public function storeNote(Request $request, Order $order)
    {
        $data = $request->validate([
            'note' => ['required', 'string', 'max:1000'],
        ]);

        $this->addNote($order, $data['note']);

        return back()->with('success', 'Note added.');
    }

    public function destroy(Order $order)
    {
        if (! in_array($order->status, config('order.deletable', []), true)) {
            return back()->with('error', 'Only cancelled orders can be deleted.');
        }

        $label = '#' . ($order->order_number ?? $order->id);
        $order->delete();

        return redirect()->route('superadmin.orders.index')->with('success', "Order {$label} deleted.");
    }

    public function bulkDelete(Request $request)
    {
        $data = $request->validate([
            'order_ids'   => ['required', 'array', 'min:1', 'max:100'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
        ], [
            'order_ids.required' => 'Select at least one order.',
        ]);

        $deleted = 0;
        $skipped = [];

        foreach (Order::whereIn('id', $data['order_ids'])->get() as $order) {
            if (! in_array($order->status, config('order.deletable', []), true)) {
                $skipped[] = '#' . ($order->order_number ?? $order->id) . ": {$order->status} order cannot be deleted. Only cancelled orders can.";
                continue;
            }

            $order->delete();
            $deleted++;
        }

        $redirect = back();

        if ($deleted > 0) {
            $redirect->with('success', "{$deleted} order(s) deleted.");
        }

        if ($skipped) {
            $redirect->with('bulk_errors', $skipped);
        }

        return $redirect;
    }

    public function sendToCourier(Request $request, Order $order, CourierManager $couriers)
    {
        $data = $request->validate([
            'courier_id'      => ['required', Rule::exists('couriers', 'id')->where('status', true)],
            'cod_amount'      => ['required', 'numeric', 'min:0'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'note'            => ['nullable', 'string', 'max:500'],
        ]);

        if ($order->status !== 'processing') {
            return back()->with('error', 'Only orders in Processing status can be sent to a courier.');
        }

        if ($this->hasActiveShipment($order)) {
            return back()->with('error', 'This order is already sent to a courier.');
        }

        $courier = Courier::findOrFail($data['courier_id']);
        $order->load('shippingAddress');

        try {
            $this->book(
                $order,
                $courier,
                $couriers,
                (float) $data['cod_amount'],
                $data['note'] ?? null,
                $data['tracking_number'] ?? null
            );
        } catch (Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return back()->with('success', "Order sent to {$courier->name} and marked as shipped.");
    }

    /** List theke select kora order gulo ke ekshathe courier e pathay */
    public function bulkCourier(Request $request, CourierManager $couriers)
    {
        $data = $request->validate([
            'order_ids'   => ['required', 'array', 'min:1', 'max:20'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
            'courier_id'  => ['required', Rule::exists('couriers', 'id')->where('status', true)],
        ], [
            'order_ids.required' => 'Select at least one order.',
            'order_ids.max'      => 'You can send up to 20 orders at a time.',
        ]);

        $courier = Courier::findOrFail($data['courier_id']);

        if ($courier->driver === 'manual') {
            return back()->with('error', "{$courier->name} is a manual courier and needs a tracking number per order. Send those from each order page.");
        }

        set_time_limit(300);

        $orders  = Order::with('shippingAddress')->whereIn('id', $data['order_ids'])->get();
        $success = 0;
        $failed  = [];

        foreach ($orders as $order) {
            $label = '#' . ($order->order_number ?? $order->id);

            if ($order->status !== 'processing') {
                $failed[] = "{$label}: status is {$order->status}, must be Processing.";
                continue;
            }

            if ($this->hasActiveShipment($order)) {
                $failed[] = "{$label}: already sent to a courier.";
                continue;
            }

            $cod = $order->payment_status === 'paid' ? 0 : (float) $order->total;

            try {
                $this->book($order, $courier, $couriers, $cod, null, null);
                $success++;
            } catch (Throwable $e) {
                $failed[] = "{$label}: " . $e->getMessage();
            }
        }

        $redirect = back();

        if ($success > 0) {
            $redirect->with('success', "{$success} order(s) sent to {$courier->name} and marked as shipped.");
        }

        if ($failed) {
            $redirect->with('bulk_errors', $failed);
        }

        return $redirect;
    }

    /** Select kora order gulor status ekshathe change (shudhu allowed transition) */
    public function bulkStatus(Request $request)
    {
        $data = $request->validate([
            'order_ids'   => ['required', 'array', 'min:1', 'max:100'],
            'order_ids.*' => ['integer', 'exists:orders,id'],
            'status'      => ['required', Rule::in(['processing', 'cancelled', 'completed'])],
        ], [
            'order_ids.required' => 'Select at least one order.',
        ]);

        $updated = 0;
        $skipped = [];

        foreach (Order::whereIn('id', $data['order_ids'])->get() as $order) {
            $label = '#' . ($order->order_number ?? $order->id);

            if (! in_array($data['status'], config('order.transitions.' . $order->status, []), true)) {
                $skipped[] = "{$label}: cannot change from {$order->status} to {$data['status']}.";
                continue;
            }

            DB::transaction(function () use ($order, $data) {
                $old = $order->status;
                $order->update(['status' => $data['status']]);
                $this->addNote($order, "Status changed from {$old} to {$data['status']} (bulk).");
            });

            $updated++;
        }

        $redirect = back();

        if ($updated > 0) {
            $redirect->with('success', "{$updated} order(s) updated to {$data['status']}.");
        }

        if ($skipped) {
            $redirect->with('bulk_errors', $skipped);
        }

        return $redirect;
    }

    public function syncCourier(Order $order, CourierManager $couriers)
    {
        $shipment = $order->shipments()->with('courier')->latest('id')->first();

        if (! $shipment || ! $shipment->courier) {
            return back()->with('error', 'No courier booking found for this order.');
        }

        try {
            $courierStatus = $couriers->driver($shipment->courier)->status($shipment);
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        if ($courierStatus === null) {
            return back()->with('error', "{$shipment->courier->name} has no auto-sync. Update the status manually.");
        }

        DB::transaction(function () use ($order, $shipment, $courierStatus) {
            $changed = $shipment->courier_status !== $courierStatus;

            $shipment->update([
                'courier_status' => $courierStatus,
                'last_synced_at' => now(),
            ]);

            if (! $changed) {
                return;
            }

            $this->addNote($order, "Courier status: {$courierStatus}.");

            if (in_array($courierStatus, ['delivered', 'partial_delivered'], true) && $order->status === 'shipped') {
                $shipment->update(['status' => 'delivered', 'delivered_at' => now()]);
                $order->update(['status' => 'delivered']);
                $this->addNote($order, 'Order marked as delivered from courier status.');
            }
        });

        return back()->with('success', 'Courier status: ' . Str::headline($courierStatus));
    }

    /* ---------------- helpers ---------------- */

    protected function hasActiveShipment(Order $order): bool
    {
        return $order->shipments()->whereNotIn('status', ['cancelled', 'returned'])->exists();
    }

    /**
     * Courier API call (transaction er baire), tarpor shipment save + status shipped.
     * API fail korle exception dey, order status change hoy na.
     */
    protected function book(
        Order $order,
        Courier $courier,
        CourierManager $couriers,
        float $cod,
        ?string $note,
        ?string $trackingNumber
    ): void {
        $result = $couriers->driver($courier)->book($order, $cod, $note, ['tracking_number' => $trackingNumber]);

        DB::transaction(function () use ($order, $courier, $cod, $result) {
            Shipment::create([
                'order_id'        => $order->id,
                'courier_id'      => $courier->id,
                'consignment_id'  => $result['consignment_id'] ?: null,
                'tracking_number' => $result['tracking_number'] ?? null,
                'cod_amount'      => $cod,
                'status'          => 'in_transit',
                'courier_status'  => $result['status'] ?? 'booked',
                'shipped_at'      => now(),
                'last_synced_at'  => now(),
            ]);

            $order->update(['status' => 'shipped']);

            $this->addNote(
                $order,
                "Sent to {$courier->name}. Tracking: " . ($result['tracking_number'] ?? 'n/a') . ", COD Tk. {$cod}."
            );
        });
    }
        
    public function invoice(Order $order)
    {
        $order->load(['shippingAddress', 'orderItems.product', 'payments', 'createdBy']);

        $site = \App\Models\WebsiteSetting::current() ?? new \App\Models\WebsiteSetting();

        return view('superadmin.orders.invoice', compact('order', 'site'));
    }
    protected function addNote(Order $order, string $text): void
    {
        OrderNote::create([
            'order_id'   => $order->id,
            'note'       => $text,
            'created_by' => auth()->id(),
        ]);
    }
}
