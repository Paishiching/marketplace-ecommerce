<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $table = 'affiliates';

    protected $fillable = [
        'user_id',
        'referral_code',
        'commission_rate',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'affiliate_id');
    }

    public function affiliateBalances()
    {
        return $this->hasMany(AffiliateBalance::class, 'affiliate_id');
    }

    public function affiliateTransactions()
    {
        return $this->hasMany(AffiliateTransaction::class, 'affiliate_id');
    }

    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class, 'affiliate_id');
    }

    public function affiliateSales()
    {
        return $this->hasMany(AffiliateSale::class, 'affiliate_id');
    }

    public function affiliateCampaigns()
    {
        return $this->hasMany(AffiliateCampaign::class, 'affiliate_id');
    }

    public function links() { return $this->hasMany(AffiliateLink::class, 'affiliate_id'); }
    public function sales() { return $this->hasMany(AffiliateSale::class, 'affiliate_id'); }
}
