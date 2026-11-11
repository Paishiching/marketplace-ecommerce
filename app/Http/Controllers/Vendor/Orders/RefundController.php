<?php

namespace App\Http\Controllers\Vendor\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\Vendor;

class RefundController extends Controller
{
    public function index()
    {
        $vendor = $this->vendor();

        // Refund order-wise, tai ei vendor er product ache emon order er refund
        $rows = Refund::whereIn('order_id', OrderItem::where('vendor_id', $vendor->id)->select('order_id'))
            ->latest('id')
            ->paginate(20);

        $orders = Order::whereIn('id', $rows->pluck('order_id'))
            ->get(['id', 'order_number'])
            ->keyBy('id');

        return view('vendor.refunds.index', compact('rows', 'orders'));
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