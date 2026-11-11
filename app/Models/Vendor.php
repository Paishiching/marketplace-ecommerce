<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_slug',
        'logo',
        'banner',
        'description',
        'commission_rate',
        'verification_status',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'vendor_id');
    }

    public function dropshippingProducts()
    {
        return $this->hasMany(DropshippingProduct::class, 'vendor_id');
    }

    public function dropshippingSettings()
    {
        return $this->hasMany(DropshippingSetting::class, 'vendor_id');
    }

    public function dropshippingOrders()
    {
        return $this->hasMany(DropshippingOrder::class, 'vendor_id');
    }

    public function productImports()
    {
        return $this->hasMany(ProductImport::class, 'vendor_id');
    }

    public function wholesaleProducts()
    {
        return $this->hasMany(WholesaleProduct::class, 'vendor_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'vendor_id');
    }

    public function vendorOrders()
    {
        return $this->hasMany(VendorOrder::class, 'vendor_id');
    }

    public function commissionRules()
    {
        return $this->hasMany(CommissionRule::class, 'vendor_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'vendor_id');
    }

    public function vendorBalances()
    {
        return $this->hasMany(VendorBalance::class, 'vendor_id');
    }

    public function vendorTransactions()
    {
        return $this->hasMany(VendorTransaction::class, 'vendor_id');
    }
}
