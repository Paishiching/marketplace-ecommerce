<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    protected $table = 'affiliate_links';

    protected $fillable = ['affiliate_id', 'product_id', 'code', 'target_url', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function clicks()
    {
        return $this->hasMany(AffiliateClick::class, 'affiliate_link_id');
    }

    public function sales()
    {
        return $this->hasMany(AffiliateSale::class, 'affiliate_link_id');
    }
}
