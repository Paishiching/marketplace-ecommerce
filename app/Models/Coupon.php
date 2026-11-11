<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'value'            => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'usage_limit'      => 'integer',
        'starts_at'        => 'datetime',
        'expires_at'       => 'datetime',
        'status'           => 'boolean',
    ];

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }

    /* ---------------- Scopes ---------------- */

    public function scopeLive($query)
    {
        return $query->where('status', true)
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')->where('expires_at', '<', now());
    }

    /* ---------------- Accessors ---------------- */

    public function getUsedCountAttribute(): int
    {
        return $this->coupon_usages_count ?? $this->couponUsages()->count();
    }

    // active | inactive | expired | scheduled | exhausted
    public function getStateAttribute(): string
    {
        if (! $this->status) {
            return 'inactive';
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'expired';
        }
        if ($this->starts_at && $this->starts_at->isFuture()) {
            return 'scheduled';
        }
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'exhausted';
        }

        return 'active';
    }

    public function getStateBadgeAttribute(): string
    {
        return match ($this->state) {
        'active'    => 'bg-success',
            'scheduled' => 'bg-info',
            'exhausted' => 'bg-warning text-dark',
            'expired'   => 'bg-danger',
            default     => 'bg-secondary',
        };
    }

    public function getDiscountLabelAttribute(): string
    {
        $symbol = '৳';

        return $this->type === 'percentage'
            ? rtrim(rtrim(number_format($this->value, 2), '0'), '.') . '%'
            : $symbol . number_format($this->value, 2);
    }
}
