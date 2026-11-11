<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshippingOrderItem extends Model
{
    protected $table = 'dropshipping_order_items';

    protected $fillable = ['dropshipping_order_id', 'supplier_product_id', 'quantity', 'unit_cost'];

    protected $casts = ['unit_cost' => 'decimal:2'];

    public function order()
    {
        return $this->belongsTo(DropshippingOrder::class, 'dropshipping_order_id');
    }

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id');
    }
}
