<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinimumOrderQuantity extends Model
{
    protected $table = 'minimum_order_quantities';

    protected $fillable = ['wholesale_product_id', 'moq'];

    public function wholesaleProduct()
    {
        return $this->belongsTo(WholesaleProduct::class, 'wholesale_product_id');
    }
}
