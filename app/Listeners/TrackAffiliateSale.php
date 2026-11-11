<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\AffiliateSale;
use App\Models\AffiliateLink;

class TrackAffiliateSale
{
    /**
     * When an order is paid, if it was attributed to an affiliate
     * (tracked earlier via the TrackAffiliate middleware/session),
     * record the sale so commission can be calculated on it.
     */
    public function handle(OrderPaid $event): void
    {
        $order = $event->order;
        $affiliateLinkId = session('affiliate_link_id');

        if (! $affiliateLinkId) {
            return;
        }

        $link = AffiliateLink::find($affiliateLinkId);

        if (! $link) {
            return;
        }

        AffiliateSale::firstOrCreate(
            ['order_id' => $order->id, 'affiliate_link_id' => $link->id],
            [
                'affiliate_id' => $link->affiliate_id,
                'sale_amount' => $order->total,
                'status' => 'pending',
            ]
        );
    }
}
