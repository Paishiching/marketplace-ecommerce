<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateSale extends Model
{
    protected $table = 'affiliate_sales';

    protected $fillable = [
        'affiliate_id', 'affiliate_link_id', 'order_id',
        'sale_amount', 'commission_amount', 'status',
    ];

    protected $casts = [
        'sale_amount'       => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    public function link()
    {
        return $this->belongsTo(AffiliateLink::class, 'affiliate_link_id');
    }
}
