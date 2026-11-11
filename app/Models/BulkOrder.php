<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    protected $table = 'bulk_orders';

    protected $fillable = ['customer_id', 'wholesaler_id', 'wholesale_product_id', 'quantity', 'total_price', 'status'];

    protected $casts = ['total_price' => 'decimal:2'];

    public function wholesaleProduct()
    {
        return $this->belongsTo(WholesaleProduct::class, 'wholesale_product_id');
    }

    public function wholesaler()
    {
        return $this->belongsTo(Wholesaler::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
