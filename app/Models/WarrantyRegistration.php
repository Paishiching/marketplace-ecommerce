<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRegistration extends Model
{
    protected $fillable = [
        'serial_number', 'product_name', 'customer_name', 'phone',
        'purchase_date', 'warranty_months',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function getExpiresAtAttribute()
    {
        return $this->purchase_date->copy()->addMonths((int) $this->warranty_months);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->expires_at->endOfDay()->isFuture();
    }
}