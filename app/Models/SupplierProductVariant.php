<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductVariant extends Model
{
    use HasFactory;

    protected $table = 'supplier_product_variants';

    protected $fillable = [
        'supplier_product_id',
        'product_variant_id',
        'cost_price',
        'stock_quantity',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
