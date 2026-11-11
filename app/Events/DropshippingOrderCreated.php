<?php

namespace App\Events;

use App\Models\DropshippingOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DropshippingOrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public DropshippingOrder $dropshippingOrder
    ) {
    }
}
