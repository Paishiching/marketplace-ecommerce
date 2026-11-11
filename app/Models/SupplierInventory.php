<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInventory extends Model
{
    use HasFactory;

    protected $table = 'supplier_inventory';

    protected $fillable = [
        'supplier_product_id',
        'quantity',
    ];

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class, 'supplier_product_id');
    }
}
