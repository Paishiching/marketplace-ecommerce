<?php

namespace App\Jobs;

use App\Models\Refund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRefund implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(protected Refund $refund)
    {
    }

    public function handle(): void
    {
        // In a real gateway integration this would call the payment
        // provider's refund API before marking it complete.
        $this->refund->update(['status' => 'completed', 'processed_at' => now()]);

        $order = $this->refund->order;
        $order?->update(['status' => 'refunded']);
    }
}
