<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';

    protected $fillable = [
        'order_id',
        'courier_id',
        'transport_type',
        'driver_name',
        'driver_phone',
        'vehicle_number',
        'vehicle_owner',
        'expected_arrival_at',
        'tracking_number',
        'consignment_id',
        'cod_amount',
        'status',
        'courier_status',
        'shipped_at',
        'delivered_at',
        'last_synced_at',
    ];

    protected $casts = [
        'shipped_at'     => 'datetime',
        'delivered_at'   => 'datetime',
        'expected_arrival_at' => 'date',
        'last_synced_at' => 'datetime',
        'cod_amount'     => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }

    public function trackingEvents()
    {
        return $this->hasMany(TrackingEvent::class, 'shipment_id');
    }
        public function trackingLink(): ?string
    {
        $url = $this->courier?->tracking_url;

        if (! $url || ! $this->tracking_number) {
            return null;
        }

        return str_replace('{tracking_number}', urlencode($this->tracking_number), $url);
    }
}
