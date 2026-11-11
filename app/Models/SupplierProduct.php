<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;

    protected $table = 'supplier_products';

    protected $fillable = [
        'supplier_id',
        'product_id',
        'supplier_sku',
        'cost_price',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplierProductVariants()
    {
        return $this->hasMany(SupplierProductVariant::class, 'supplier_product_id');
    }

    public function supplierPricings()
    {
        return $this->hasMany(SupplierPricing::class, 'supplier_product_id');
    }

    public function supplierInventories()
    {
        return $this->hasMany(SupplierInventory::class, 'supplier_product_id');
    }

    public function dropshippingProducts()
    {
        return $this->hasMany(DropshippingProduct::class, 'supplier_product_id');
    }

    public function dropshipperProducts()
    {
        return $this->hasMany(DropshipperProduct::class, 'supplier_product_id');
    }
}
