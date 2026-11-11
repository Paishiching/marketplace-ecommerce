<?php

namespace App\Jobs;

use App\Models\SupplierOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSupplierFulfillment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $backoff = 60;

    public function __construct(protected SupplierOrder $supplierOrder)
    {
    }

    public function handle(): void
    {
        $this->supplierOrder->update(['status' => 'fulfilling']);

        // Placeholder: create a shipment record / notify supplier
        // that a purchase order is ready to be picked and packed.
    }
}
