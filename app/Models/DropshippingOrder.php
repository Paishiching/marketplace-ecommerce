<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshippingOrder extends Model
{
    protected $table = 'dropshipping_orders';

    protected $fillable = ['vendor_id', 'supplier_id', 'order_id', 'status', 'total_cost'];

    protected $casts = ['total_cost' => 'decimal:2'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(DropshippingOrderItem::class, 'dropshipping_order_id');
    }

    public function fulfillment()
    {
        return $this->hasOne(DropshippingFulfillment::class, 'dropshipping_order_id');
    }

    public function shipment()
    {
        return $this->hasOne(DropshippingShipment::class, 'dropshipping_order_id');
    }
}
