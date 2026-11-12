<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEmiPlan extends Model
{
    protected $fillable = [
        'product_id', 'bank_name', 'tenure_months', 'fee_percentage', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'tenure_months' => 'integer',
        'fee_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
