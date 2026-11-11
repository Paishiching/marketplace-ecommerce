<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Events\OrderPaid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(protected Payment $payment)
    {
    }

    public function handle(): void
    {
        // In a real gateway integration this would verify the
        // transaction with the payment provider before marking paid.
        $this->payment->update(['status' => 'completed']);

        $order = $this->payment->order;
        $order->update(['status' => 'paid']);

        event(new OrderPaid($order->fresh()));
    }
}
