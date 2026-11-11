<?php

namespace App\Jobs;

use App\Models\Order;
use App\Events\OrderPlaced;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(protected Order $order)
    {
    }

    public function handle(): void
    {
        $this->order->update(['status' => 'processing']);

        event(new OrderPlaced($this->order->fresh()));
    }
}
