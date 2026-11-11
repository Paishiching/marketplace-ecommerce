<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\VendorOrder;

class CreateVendorOrder
{
    /**
     * Split a freshly placed marketplace order into per-vendor
     * sub-orders, so each vendor only sees their own items.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        $itemsByVendor = $order->orderItems()->get()->groupBy('vendor_id');

        foreach ($itemsByVendor as $vendorId => $items) {
            VendorOrder::firstOrCreate(
                ['order_id' => $order->id, 'vendor_id' => $vendorId],
                ['subtotal' => $items->sum('total'), 'status' => 'pending']
            );
        }
    }
}
