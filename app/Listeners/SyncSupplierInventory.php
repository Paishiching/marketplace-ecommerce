<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\SupplierInventory;
use App\Models\SupplierProduct;

class SyncSupplierInventory
{
    /**
     * When an order is placed for a product sourced from a supplier
     * (dropshipping/wholesale), decrement the supplier's own stock
     * count to keep it in sync with what's actually been sold.
     */
    public function handle(OrderPlaced $event): void
    {
        foreach ($event->order->orderItems as $item) {
            $supplierProduct = SupplierProduct::where('product_id', $item->product_id)->first();

            if (! $supplierProduct) {
                continue;
            }

            $inventory = SupplierInventory::where('supplier_product_id', $supplierProduct->id)->first();

            if ($inventory) {
                $inventory->decrement('quantity', $item->quantity);
            }
        }
    }
}
