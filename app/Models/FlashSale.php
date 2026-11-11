<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $table = 'flash_sales';

    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
        'status',
    ];

    public function flashSaleProducts()
    {
        return $this->hasMany(FlashSaleProduct::class, 'flash_sale_id');
    }
}
