<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'variant_name',
        'unit_type',
        'unit_value',
        'price',
        'compare_price',
        'stock_quantity',
        'is_default',
    ];

    protected $casts = [
        'unit_value'    => 'decimal:2',
        'price'         => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_default'    => 'boolean',
    ];

    // Accessor: "1 kg", "500 gram", "1 piece" এইভাবে দেখাবে
    public function getDisplayNameAttribute()
    {
        $value = rtrim(rtrim($this->unit_value, '0'), '.');
        return $value . ' ' . $this->unit_type;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_variant_id');
    }

    public function supplierProductVariants()
    {
        return $this->hasMany(SupplierProductVariant::class, 'product_variant_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_variant_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_variant_id');
    }
}
