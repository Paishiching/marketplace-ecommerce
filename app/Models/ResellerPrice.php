<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResellerPrice extends Model
{
    protected $table = 'reseller_prices';

    protected $fillable = ['reseller_product_id', 'selling_price'];

    protected $casts = ['selling_price' => 'decimal:2'];

    public function resellerProduct()
    {
        return $this->belongsTo(ResellerProduct::class, 'reseller_product_id');
    }
}
