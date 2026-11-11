<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPricing extends Model
{
    use HasFactory;

    protected $table = 'supplier_pricing';

    protected $fillable = [
        'supplier_product_id',
        'min_quantity',
        'price',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id');
    }
}
