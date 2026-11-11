<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $fillable = [
        'withdrawable_type', 'withdrawable_id', 'amount', 'method',
        'account_details', 'status', 'note', 'processed_at',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function withdrawable()
    {
        return $this->morphTo();
    }

    public function getHolderNameAttribute(): string
    {
        $h = $this->withdrawable;

        if (! $h) {
            return '—';
        }

        return match (true) {
        $h instanceof Vendor    => $h->shop_name ?? $h->name ?? '—',
            $h instanceof Supplier  => $h->company_name ?? '—',
            $h instanceof Dropshipper => $h->business_name ?? $h->user?->name ?? '—',
            $h instanceof Wholesaler => $h->business_name ?? $h->user?->name ?? '—',
            $h instanceof Reseller  => $h->business_name ?? '—',
            $h instanceof Affiliate => $h->user?->name ?? $h->referral_code ?? '—',
            default                 => '—',
        };
    }
}

