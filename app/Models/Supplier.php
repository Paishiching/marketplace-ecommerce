<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'user_id',
        'company_name',
        'company_slug',
        'logo',
        'description',
        'is_verified',
        'status',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supplierProducts()
    {
        return $this->hasMany(SupplierProduct::class, 'supplier_id');
    }

    public function supplierWarehouses()
    {
        return $this->hasMany(SupplierWarehouse::class, 'supplier_id');
    }

    public function dropshippingOrders()
    {
        return $this->hasMany(DropshippingOrder::class, 'supplier_id');
    }

    public function productImports()
    {
        return $this->hasMany(ProductImport::class, 'supplier_id');
    }

    public function supplierOrders()
    {
        return $this->hasMany(SupplierOrder::class, 'supplier_id');
    }

    public function supplierBalances()
    {
        return $this->hasMany(SupplierBalance::class, 'supplier_id');
    }

    public function supplierTransactions()
    {
        return $this->hasMany(SupplierTransaction::class, 'supplier_id');
    }

}
