<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSync extends Model
{
    protected $table = 'product_syncs';

    protected $fillable = ['dropshipping_product_id', 'last_synced_at', 'sync_status'];

    protected $casts = ['last_synced_at' => 'datetime'];

    public function dropshippingProduct()
    {
        return $this->belongsTo(DropshippingProduct::class, 'dropshipping_product_id');
    }
}
