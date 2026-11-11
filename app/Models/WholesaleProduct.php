<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholesaleProduct extends Model
{
    use HasFactory;

    protected $table = 'wholesale_products';

    protected $fillable = ['wholesaler_id', 'product_id', 'is_wholesale_enabled'];

    protected $casts = ['is_wholesale_enabled' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function wholesaler()
    {
        return $this->belongsTo(Wholesaler::class);
    }

    public function wholesaleTiers()
    {
        return $this->hasMany(WholesaleTier::class, 'wholesale_product_id');
    }

    public function wholesalePrices()
    {
        return $this->hasManyThrough(
            WholesalePrice::class, WholesaleTier::class,
            'wholesale_product_id', 'wholesale_tier_id'
        );
    }

    public function minimumOrderQuantity()
    {
        return $this->hasOne(MinimumOrderQuantity::class, 'wholesale_product_id');
    }

    public function bulkOrders()
    {
        return $this->hasMany(BulkOrder::class, 'wholesale_product_id');
    }
}
