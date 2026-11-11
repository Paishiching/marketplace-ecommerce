<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\SupplierOrder;

class CreateSupplierOrder
{
    /**
     * For order items whose product is fulfilled by a supplier
     * (dropshipping/wholesale sourced), create a supplier sub-order
     * so the supplier can pick, pack, and ship it.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        $supplierItems = $order->orderItems()
            ->whereHas('product', fn ($q) => $q->whereNotNull('id')->whereHas('supplierProducts'))
            ->with('product.supplierProducts')
            ->get();

        $itemsBySupplier = $supplierItems->groupBy(fn ($item) => optional($item->product->supplierProducts->first())->supplier_id);

        foreach ($itemsBySupplier as $supplierId => $items) {
            if (! $supplierId) {
                continue;
            }

            SupplierOrder::firstOrCreate(
                ['order_id' => $order->id, 'supplier_id' => $supplierId],
                ['subtotal' => $items->sum('total'), 'status' => 'pending']
            );
        }
    }
}
