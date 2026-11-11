<?php

namespace App\Support;

use App\Models\Vendor;
use App\Models\VendorOrder;
use App\Models\Withdrawal;

class VendorWallet
{
    public const MIN_WITHDRAWAL = 100;

    public static function summary(Vendor $vendor): array
    {
        // Shudhu delivered / completed order er taka earning
        $orders = fn () => VendorOrder::where('vendor_id', $vendor->id)
            ->whereHas('order', fn ($q) => $q->whereIn('status', ['delivered', 'completed']));

        $earned = (float) $orders()->sum('subtotal') - (float) $orders()->sum('commission_amount');

        $w = fn (array $statuses) => (float) Withdrawal::where('withdrawable_type', Vendor::class)
            ->where('withdrawable_id', $vendor->id)
            ->whereIn('status', $statuses)
            ->sum('amount');

        $paid    = $w(['paid']);
        $pending = $w(['pending', 'approved']);

        return [
            'earned'    => $earned,
            'paid'      => $paid,
            'pending'   => $pending,
            'available' => max($earned - $paid - $pending, 0),
        ];
    }
}