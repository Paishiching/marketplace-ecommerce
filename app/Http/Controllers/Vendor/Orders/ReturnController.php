<?php

namespace App\Http\Controllers\Vendor\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnRequest;
use App\Models\Vendor;

class ReturnController extends Controller
{
    public function index()
    {
        $vendor = $this->vendor();

        // Shudhu ei vendor er product er return
        $rows = ReturnRequest::whereIn('order_item_id', OrderItem::where('vendor_id', $vendor->id)->select('id'))
            ->latest('id')
            ->paginate(20);

        $orders = Order::whereIn('id', $rows->pluck('order_id'))
            ->get(['id', 'order_number'])
            ->keyBy('id');

        return view('vendor.returns.index', compact('rows', 'orders'));
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