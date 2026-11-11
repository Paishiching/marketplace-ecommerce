<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WholesaleTier extends Model
{
    protected $table = 'wholesale_tiers';

    protected $fillable = ['wholesale_product_id', 'min_quantity', 'max_quantity'];

    public function wholesaleProduct()
    {
        return $this->belongsTo(WholesaleProduct::class, 'wholesale_product_id');
    }

    public function wholesalePrice()
    {
        return $this->hasOne(WholesalePrice::class, 'wholesale_tier_id');
    }
}
