<?php

namespace App\Http\Controllers\Vendor\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $vendor = $this->vendor();

        // Shudhu ei vendor er product ache emon order
        $base = fn () => Order::query()
            ->whereHas('orderItems', fn ($q) => $q->where('vendor_id', $vendor->id));

        $query = $base()
            ->withCount(['orderItems as vendor_items_count' => fn ($q) => $q->where('vendor_id', $vendor->id)])
            ->withSum(['orderItems as vendor_total' => fn ($q) => $q->where('vendor_id', $vendor->id)], 'total_price');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
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

        $orders = $query->latest('id')->paginate(20)->withQueryString();

        $statusCounts = $base()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('vendor.orders.index', compact('orders', 'statusCounts'));
    }

    public function show($id)
    {
        $vendor = $this->vendor();

        $order = Order::whereHas('orderItems', fn ($q) => $q->where('vendor_id', $vendor->id))
            ->with([
                'shippingAddress',
                'orderItems' => fn ($q) => $q->where('vendor_id', $vendor->id)->with(['product', 'productVariant']),
                'vendorOrders' => fn ($q) => $q->where('vendor_id', $vendor->id),
            ])
            ->findOrFail($id);   // onner vendor er order hole 404

        $itemsTotal = $order->orderItems->sum('total_price');
        $vendorOrder = $order->vendorOrders->first();

        return view('vendor.orders.show', compact('order', 'itemsTotal', 'vendorOrder'));
    }

    /* ---------------- helpers ---------------- */

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }
}