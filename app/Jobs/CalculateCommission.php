<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Commission;
use App\Models\CommissionRule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateCommission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Order $order)
    {
    }

    public function handle(): void
    {
        foreach ($this->order->vendorOrders as $vendorOrder) {
            $rule = CommissionRule::where('vendor_id', $vendorOrder->vendor_id)
                ->orWhereNull('vendor_id')
                ->orderByDesc('vendor_id')
                ->first();

            $rate = $rule->rate ?? 10;

            Commission::updateOrCreate(
                ['order_id' => $this->order->id, 'vendor_id' => $vendorOrder->vendor_id],
                [
                    'commission_rule_id' => $rule->id ?? null,
                    'rate' => $rate,
                    'amount' => round($vendorOrder->subtotal * ($rate / 100), 2),
                    'status' => 'pending',
                ]
            );
        }
    }
}
