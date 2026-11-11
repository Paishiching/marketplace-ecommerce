<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropshippingProduct extends Model
{
    use HasFactory;

    protected $table = 'dropshipping_products';

    protected $fillable = [
        'vendor_id',
        'supplier_product_id',
        'product_id',
        'markup_price',
        'is_active',
    ];

    protected $casts = [
        'markup_price' => 'decimal:2',
        'is_active'    => 'boolean',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function dropshippingOrderItems()
    {
        return $this->hasMany(DropshippingOrderItem::class, 'dropshipping_product_id');
    }

    public function productSyncs()
    {
        return $this->hasMany(ProductSync::class, 'dropshipping_product_id');
    }
}
