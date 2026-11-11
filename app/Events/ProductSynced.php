<?php

namespace App\Events;

use App\Models\ProductSync;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductSynced
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public ProductSync $productSync
    ) {
    }
}
