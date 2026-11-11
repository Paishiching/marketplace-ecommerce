<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshipperProduct extends Model
{
    protected $fillable = ['dropshipper_id', 'supplier_product_id', 'markup_price', 'is_active'];

    protected $casts = ['markup_price' => 'decimal:2', 'is_active' => 'boolean'];

    public function dropshipper()
    {
        return $this->belongsTo(Dropshipper::class);
    }

    public function supplierProduct()
    {
        return $this->belongsTo(SupplierProduct::class);
    }
}
