<?php

namespace App\Services;

use App\Models\Product;
use App\Models\WholesaleTier;
use App\Models\ResellerPrice;

class PricingService
{
    /**
     * Resolve the price a customer pays, taking discount price into account.
     */
    public function getCustomerPrice(Product $product): float
    {
        if ($product->discount_price && $product->discount_price < $product->price) {
            return (float) $product->discount_price;
        }

        return (float) $product->price;
    }

    /**
     * Resolve wholesale unit price for a given quantity based on
     * the matching wholesale tier (bulk pricing breakpoints).
     */
    public function getWholesalePrice(Product $product, int $quantity): float
    {
        $tier = WholesaleTier::where('product_id', $product->id)
            ->where('min_quantity', '<=', $quantity)
            ->orderByDesc('min_quantity')
            ->first();

        return $tier ? (float) $tier->price : $this->getCustomerPrice($product);
    }

    /**
     * Resolve the price a reseller pays for a product, falling back
     * to the standard customer price if no reseller-specific price exists.
     */
    public function getResellerPrice(Product $product, int $resellerId): float
    {
        $price = ResellerPrice::where('product_id', $product->id)
            ->where('reseller_id', $resellerId)
            ->first();

        return $price ? (float) $price->price : $this->getCustomerPrice($product);
    }

    /**
     * Calculate the margin/profit for a dropshipper: sale price minus
     * the supplier's cost price.
     */
    public function calculateDropshippingProfit(float $salePrice, float $supplierCost): float
    {
        return round($salePrice - $supplierCost, 2);
    }

    /**
     * Apply a percentage or flat markup on top of a base cost.
     */
    public function applyMarkup(float $baseCost, float $markupValue, string $type = 'percentage'): float
    {
        if ($type === 'percentage') {
            return round($baseCost + ($baseCost * $markupValue / 100), 2);
        }

        return round($baseCost + $markupValue, 2);
    }
}
