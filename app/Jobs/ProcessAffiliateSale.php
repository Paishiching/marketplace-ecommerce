<?php

namespace App\Jobs;

use App\Models\AffiliateSale;
use App\Models\AffiliateBalance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAffiliateSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected AffiliateSale $affiliateSale)
    {
    }

    public function handle(): void
    {
        // Default affiliate commission rate; could be pulled from a
        // per-affiliate or per-campaign rule instead.
        $commissionRate = 5;
        $commission = round($this->affiliateSale->sale_amount * ($commissionRate / 100), 2);

        $this->affiliateSale->update([
            'commission' => $commission,
            'status' => 'confirmed',
        ]);

        $balance = AffiliateBalance::firstOrCreate(
            ['affiliate_id' => $this->affiliateSale->affiliate_id],
            ['on_hold' => 0, 'available' => 0]
        );

        $balance->increment('on_hold', $commission);
    }
}
