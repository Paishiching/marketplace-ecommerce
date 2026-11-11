<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshipperOrderItem extends Model
{
    protected $fillable = [
        'dropshipper_order_id', 'supplier_product_id', 'product_name',
        'quantity', 'unit_cost', 'unit_price', 'line_total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(DropshipperOrder::class, 'dropshipper_order_id');
    }

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id');
    }
}
