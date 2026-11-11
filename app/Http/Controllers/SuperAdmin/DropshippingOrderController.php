<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DropshippingOrder;
use Illuminate\Http\Request;

class DropshippingOrderController extends Controller
{
    public function index(Request $request)
    {
        $statuses = DropshippingOrder::query()->distinct()->pluck('status');

        $orders = DropshippingOrder::with(['vendor', 'supplier'])
            ->withCount('items')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('superadmin.dropshipping.orders.index', compact('orders', 'statuses'));
    }

    public function show(DropshippingOrder $dropshippingOrder)
    {
        $dropshippingOrder->load(['vendor', 'supplier', 'items.supplierProduct', 'fulfillment', 'shipment']);

        return view('superadmin.dropshipping.orders.show', ['order' => $dropshippingOrder]);
    }
}
