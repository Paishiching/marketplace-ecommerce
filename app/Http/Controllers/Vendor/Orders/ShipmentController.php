<?php

namespace App\Http\Controllers\Vendor\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $vendor = $this->vendor();

        // Shudhu ei vendor er product ache emon order er shipment
        $orderIds = OrderItem::where('vendor_id', $vendor->id)->select('order_id');

        $shipments = Shipment::with('courier')
            ->whereIn('order_id', $orderIds)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->when(trim((string) $request->input('q')) !== '', function ($q) use ($request) {
                $s = trim((string) $request->input('q'));
                $q->where(function ($w) use ($s) {
                    $w->where('tracking_number', 'like', "%{$s}%")
                        ->orWhere('consignment_id', 'like', "%{$s}%")
                        ->orWhereIn('order_id', Order::where('order_number', 'like', "%{$s}%")->select('id'));
                });
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $orders = Order::whereIn('id', $shipments->pluck('order_id'))
            ->get(['id', 'order_number', 'name', 'phone'])
            ->keyBy('id');

        return view('vendor.shipments.index', compact('shipments', 'orders'));
    }

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