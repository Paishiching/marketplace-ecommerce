<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('order')->latest()->paginate(20);

        return view('admin.orders.shipments.index', compact('shipments'));
    }

    public function create()
    {
        $orders = collect();

        return view('admin.orders.shipments.create', compact('orders'));
    }

    public function searchOrders(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        if ($term === '' || (mb_strlen($term) < 2 && ! ctype_digit($term))) {
            return response()->json([]);
        }

        $orders = Order::query()->with('customer.user')
            ->whereIn('status', ['pending', 'processing'])
            ->whereDoesntHave('shipments')
            ->where(function ($query) use ($term) {
                $query->where('order_number', 'like', "%{$term}%")
                    ->orWhere('name', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
                if (ctype_digit($term)) $query->orWhere('id', (int) $term);
                $query->orWhereHas('customer.user', fn ($user) => $user->where('name', 'like', "%{$term}%"));
            })->latest()->limit(25)->get();

        return response()->json($orders->map(fn ($order) => [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'name' => $order->name ?: $order->customer?->user?->name ?: 'Customer',
            'phone' => $order->phone ?: '—',
            'party' => $order->customer_id ? '#'.$order->customer_id : '—',
        ]));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'driver_name' => ['required', 'string', 'max:150'],
            'driver_phone' => ['required', 'string', 'max:30'],
            'vehicle_number' => ['required', 'string', 'max:50'],
            'vehicle_owner' => ['required', 'string', 'max:150'],
            'expected_arrival_at' => ['required', 'date', 'after_or_equal:today'],
            'delivery_date' => ['nullable', 'date', 'after_or_equal:today'],
            'delivery_estimate' => ['nullable', 'string', 'max:120'],
        ]);

        DB::transaction(function () use ($validated) {
            $order = Order::whereKey($validated['order_id'])->whereIn('status', ['pending', 'processing'])->lockForUpdate()->first();
            abort_unless($order && ! $order->shipments()->exists(), 422, 'This order already has transport details or is not ready for delivery.');

            Shipment::create([
                ...$validated,
                'transport_type' => 'self',
                'tracking_number' => 'SELF-' . now()->format('ymd') . '-' . Str::upper((string) Str::uuid()),
                'status' => 'pending',
            ]);
        });

        $indexRoute = $request->user()->hasRole('superadmin') ? 'superadmin.delivery-transport.index' : 'admin.orders.shipments.index';

        return redirect()->route($indexRoute)->with('success', 'Delivery transport saved successfully.');
    }

    public function updateStatus(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,out_for_delivery,completed,cancelled'],
        ]);

        $shipment->update(['status' => $validated['status']]);
        $indexRoute = $request->user()->hasRole('superadmin')
            ? 'superadmin.delivery-transport.index'
            : 'admin.orders.shipments.index';

        return redirect()->route($indexRoute)->with('success', 'Delivery status updated.');
    }

    public function show(Shipment $shipment)
    {
        return view('admin.orders.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        $shipment->load('order');

        return view('admin.orders.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'driver_name' => ['required', 'string', 'max:150'],
            'driver_phone' => ['required', 'string', 'max:30'],
            'vehicle_number' => ['required', 'string', 'max:50'],
            'vehicle_owner' => ['required', 'string', 'max:150'],
            'expected_arrival_at' => ['required', 'date'],
            'delivery_date' => ['nullable', 'date'],
            'delivery_estimate' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'in:pending,processing,out_for_delivery,completed,cancelled'],
        ]);

        $shipment->update($validated);
        $indexRoute = $request->user()->hasRole('superadmin')
            ? 'superadmin.delivery-transport.index'
            : 'admin.orders.shipments.index';

        return redirect()->route($indexRoute)->with('success', 'Delivery transport entry updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Shipment deleted successfully.');
    }
}
