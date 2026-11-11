<?php

namespace App\Listeners;

use App\Events\OrderDelivered;
use App\Models\VendorBalance;

class ReleaseVendorBalance
{
    /**
     * Once an order is confirmed delivered (past the return/dispute
     * window), release the vendor's share of the sale (subtotal minus
     * commission) from "on hold" into their withdrawable balance.
     */
    public function handle(OrderDelivered $event): void
    {
        $order = $event->order;

        foreach ($order->vendorOrders as $vendorOrder) {
            $commission = $order->commissions()->where('vendor_id', $vendorOrder->vendor_id)->first();

            $releasable = $vendorOrder->subtotal - ($commission->amount ?? 0);

            $balance = VendorBalance::firstOrCreate(
                ['vendor_id' => $vendorOrder->vendor_id],
                ['on_hold' => 0, 'available' => 0]
            );

            $balance->decrement('on_hold', min($releasable, $balance->on_hold));
            $balance->increment('available', $releasable);
        }
    }
}
