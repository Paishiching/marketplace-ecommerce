<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateLink;
use App\Models\AffiliateSale;
use App\Models\Order;

class AffiliateTrackingService
{
    public const COOKIE = 'aff_ref';
    public const COOKIE_MINUTES = 60 * 24 * 30; // 30 din

    public function currentLink(): ?AffiliateLink
    {
        $code = request()->cookie(self::COOKIE);
        if (!$code) {
            return null;
        }

        return AffiliateLink::with('affiliate')
            ->where('code', $code)
            ->where('is_active', true)
            ->first();
    }

    public function currentAffiliateId(): ?int
    {
        $affiliate = $this->currentLink()?->affiliate;

        return $this->isActive($affiliate) ? $affiliate->id : null;
    }

    public function recordSale(Order $order): ?AffiliateSale
    {
        $link = $this->currentLink();
        if (!$link || !$this->isActive($link->affiliate)) {
            return null;
        }

        // Nijer link diye nijer kena jabe na
        $buyerUserId = $order->customer?->user_id;
        if ($buyerUserId && $buyerUserId === $link->affiliate->user_id) {
            return null;
        }

        // Ekoi order e duibar sale na
        if (AffiliateSale::where('order_id', $order->id)->exists()) {
            return null;
        }

        // Link product er order item er total-i sale amount
        $saleAmount = $order->items()
            ->where('product_id', $link->product_id)
            ->sum('total_price');

        if ($saleAmount <= 0) {
            return null;
        }

        return AffiliateSale::create([
            'affiliate_id'      => $link->affiliate_id,
            'affiliate_link_id' => $link->id,
            'order_id'          => $order->id,
            'sale_amount'       => $saleAmount,
            'commission_amount' => round($saleAmount * $link->affiliate->commission_rate / 100, 2),
            'status'            => 'pending',
        ]);
    }

    private function isActive(?Affiliate $affiliate): bool
    {
        return $affiliate && in_array($affiliate->status, ['active', 1, '1'], true);
    }
}
