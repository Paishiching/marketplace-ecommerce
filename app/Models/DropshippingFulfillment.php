<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshippingFulfillment extends Model
{
    protected $table = 'dropshipping_fulfillments';

    protected $fillable = ['dropshipping_order_id', 'status'];

    public function order()
    {
        return $this->belongsTo(DropshippingOrder::class, 'dropshipping_order_id');
    }
}
