<?php

namespace App\Jobs;

use App\Models\SupplierProduct;
use App\Models\Product;
use App\Models\ProductSync;
use App\Events\ProductSynced;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSupplierProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected SupplierProduct $supplierProduct)
    {
    }

    /**
     * Push the supplier's latest price/description down to the
     * vendor-facing Product record(s) sourced from it.
     */
    public function handle(): void
    {
        Product::where('id', $this->supplierProduct->product_id)->update([
            'price' => $this->supplierProduct->price,
            'description' => $this->supplierProduct->description ?? null,
        ]);

        $this->supplierProduct->touch();

        $sync = ProductSync::create([
            'supplier_product_id' => $this->supplierProduct->id,
            'product_id' => $this->supplierProduct->product_id,
            'synced_at' => now(),
        ]);

        event(new ProductSynced($sync));
    }
}
