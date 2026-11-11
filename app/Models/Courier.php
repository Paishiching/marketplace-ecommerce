<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $table = 'couriers';

    protected $fillable = [
        'name',
        'driver',
        'tracking_url',
        'credentials',
        'status',
    ];

    protected $hidden = ['credentials'];

    protected $casts = [
        'credentials' => 'encrypted:array',
        'status'      => 'boolean',
    ];

    public function dropshippingShipments()
    {
        return $this->hasMany(DropshippingShipment::class, 'courier_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'courier_id');
    }

    public function getDriverLabelAttribute(): string
    {
        return config("couriers.drivers.{$this->driver}.label", ucfirst((string) $this->driver));
    }
}