<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\DropshippingOrder;
use App\Models\DropshippingProduct;
use App\Events\DropshippingOrderCreated;

class ProcessDropshippingOrder
{
    /**
     * When a paid order contains dropshipped products, create a
     * DropshippingOrder per supplier so the fulfillment job can
     * forward it to that supplier automatically.
     */
    public function handle(OrderPaid $event): void
    {
        $order = $event->order;

        $dropshipItems = $order->orderItems()
            ->whereHas('product', fn ($q) => $q->whereHas('dropshippingProducts'))
            ->get();

        foreach ($dropshipItems as $item) {
            $dropshippingProduct = DropshippingProduct::where('product_id', $item->product_id)->first();

            if (! $dropshippingProduct) {
                continue;
            }

            $dropshippingOrder = DropshippingOrder::create([
                'order_id' => $order->id,
                'supplier_id' => $dropshippingProduct->supplier_id,
                'vendor_id' => $item->vendor_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'status' => 'pending',
            ]);

            event(new DropshippingOrderCreated($dropshippingOrder));
        }
    }
}
