<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    use HasFactory;

    protected $table = 'tracking_events';

    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'event_time',
    ];

    protected $casts = [
        'event_time' => 'datetime',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
}
