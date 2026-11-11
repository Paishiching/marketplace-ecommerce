<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\Commission;
use App\Models\CommissionRule;
use App\Events\CommissionCreated;

class CalculateOrderCommission
{
    /**
     * When an order is paid, calculate the platform commission owed
     * on each vendor sub-order based on the applicable commission rule.
     */
    public function handle(OrderPaid $event): void
    {
        $order = $event->order;

        foreach ($order->vendorOrders as $vendorOrder) {
            $rule = CommissionRule::where('vendor_id', $vendorOrder->vendor_id)
                ->orWhereNull('vendor_id')
                ->orderByDesc('vendor_id')
                ->first();

            $rate = $rule->rate ?? 10; // fallback default 10%
            $amount = round($vendorOrder->subtotal * ($rate / 100), 2);

            $commission = Commission::create([
                'order_id' => $order->id,
                'vendor_id' => $vendorOrder->vendor_id,
                'commission_rule_id' => $rule->id ?? null,
                'rate' => $rate,
                'amount' => $amount,
                'status' => 'pending',
            ]);

            event(new CommissionCreated($commission));
        }
    }
}
