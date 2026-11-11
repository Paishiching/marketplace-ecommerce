<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResellerProduct extends Model
{
    protected $table = 'reseller_products';

    protected $fillable = ['reseller_id', 'product_id', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function price()
    {
        return $this->hasOne(ResellerPrice::class, 'reseller_product_id');
    }

    public function orders()
    {
        return $this->hasMany(ResellerOrder::class, 'reseller_product_id');
    }
}
