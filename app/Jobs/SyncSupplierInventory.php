<?php

namespace App\Jobs;

use App\Models\Supplier;
use App\Models\SupplierInventory;
use App\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSupplierInventory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Supplier $supplier)
    {
    }

    /**
     * Pull a supplier's current stock levels across all their
     * products and push them into the shared Inventory table so
     * vendors selling those products see accurate stock.
     */
    public function handle(): void
    {
        SupplierInventory::whereHas('supplierProduct', fn ($q) => $q->where('supplier_id', $this->supplier->id))
            ->with('supplierProduct')
            ->get()
            ->each(function (SupplierInventory $supplierInventory) {
                $productId = $supplierInventory->supplierProduct->product_id ?? null;

                if (! $productId) {
                    return;
                }

                Inventory::updateOrCreate(
                    ['product_id' => $productId],
                    ['quantity' => $supplierInventory->quantity]
                );
            });
    }
}
