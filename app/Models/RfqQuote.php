<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqQuote extends Model
{
    protected $fillable = ['rfq_id', 'supplier_id', 'unit_price', 'lead_time_days', 'message'];
    protected $casts = ['unit_price' => 'decimal:2', 'lead_time_days' => 'integer'];

    public function rfq() { return $this->belongsTo(Rfq::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
}
