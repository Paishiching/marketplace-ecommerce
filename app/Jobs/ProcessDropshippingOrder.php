<?php

namespace App\Jobs;

use App\Models\DropshippingOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDropshippingOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $backoff = 60;

    public function __construct(protected DropshippingOrder $dropshippingOrder)
    {
    }

    public function handle(): void
    {
        // Placeholder for forwarding the order to the supplier's
        // system (API call, email, or manual queue) for fulfillment.
        $this->dropshippingOrder->update(['status' => 'sent_to_supplier']);
    }
}
