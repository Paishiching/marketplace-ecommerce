<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshipperOrder extends Model
{
    protected $fillable = ['dropshipper_id', 'customer_id', 'source_order_id', 'supplier_id', 'status', 'sales_total', 'total_cost', 'profit'];

    protected $casts = ['sales_total' => 'decimal:2', 'total_cost' => 'decimal:2', 'profit' => 'decimal:2'];

    public function dropshipper()
    {
        return $this->belongsTo(Dropshipper::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(DropshipperOrderItem::class, 'dropshipper_order_id');
    }

    public function sourceOrder()
    {
        return $this->belongsTo(Order::class, 'source_order_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
