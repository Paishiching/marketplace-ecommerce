<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshippingShipment extends Model
{
    protected $table = 'dropshipping_shipments';

    protected $fillable = ['dropshipping_order_id', 'tracking_number', 'courier_name', 'shipped_at'];

    protected $casts = ['shipped_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(DropshippingOrder::class, 'dropshipping_order_id');
    }
}
