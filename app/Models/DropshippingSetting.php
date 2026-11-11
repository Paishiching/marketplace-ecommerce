<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DropshippingSetting extends Model
{
    protected $table = 'dropshipping_settings';

    protected $fillable = ['vendor_id', 'auto_sync', 'markup_percentage'];

    protected $casts = [
        'auto_sync'         => 'boolean',
        'markup_percentage' => 'decimal:2',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
