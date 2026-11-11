<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;

    protected $table = 'shipping_zones';

    protected $fillable = [
        'name',
        'regions',
        'status',
    ];

    protected $casts = [
        'regions' => 'array',
        'status'  => 'boolean',
    ];

    public function shippingRates()
    {
        return $this->hasMany(ShippingRate::class, 'shipping_zone_id');
    }
}
