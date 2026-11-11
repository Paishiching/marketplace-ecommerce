<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Collection;

class CouponService
{
    public function all(): Collection
    {
        return Coupon::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Coupon::latest()->paginate($perPage);
    }

    public function find(int $id): Coupon
    {
        return Coupon::findOrFail($id);
    }

    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    public function update(int $id, array $data): Coupon
    {
        $record = Coupon::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Coupon::findOrFail($id);

        return (bool) $record->delete();
    }

    /**
     * Validate a coupon code and calculate the discount amount for
     * a given order subtotal. Returns 0 if the coupon is invalid,
     * expired, or the subtotal doesn't meet its minimum spend.
     */
    public function calculateDiscount(string $code, float $subtotal): float
    {
        $coupon = Coupon::where('code', $code)
            ->where('status', 'active')
            ->first();

        if (! $coupon) {
            return 0;
        }

        if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
            return 0;
        }

        if ($coupon->minimum_spend && $subtotal < $coupon->minimum_spend) {
            return 0;
        }

        $discount = $coupon->type === 'percentage'
            ? $subtotal * ($coupon->value / 100)
            : $coupon->value;

        if ($coupon->max_discount) {
            $discount = min($discount, $coupon->max_discount);
        }

        return round($discount, 2);
    }
}
