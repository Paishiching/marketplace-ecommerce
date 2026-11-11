<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResellerOrder extends Model
{
    protected $table = 'reseller_orders';

    protected $fillable = [
        'reseller_id', 'reseller_customer_id', 'reseller_product_id',
        'quantity', 'total_price', 'status',
    ];

    protected $casts = ['total_price' => 'decimal:2'];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }

    public function customer()
    {
        return $this->belongsTo(ResellerCustomer::class, 'reseller_customer_id');
    }

    public function resellerProduct()
    {
        return $this->belongsTo(ResellerProduct::class, 'reseller_product_id');
    }
}
