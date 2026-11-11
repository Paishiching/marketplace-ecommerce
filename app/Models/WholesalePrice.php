<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WholesalePrice extends Model
{
    protected $table = 'wholesale_prices';

    protected $fillable = ['wholesale_tier_id', 'unit_price'];

    protected $casts = ['unit_price' => 'decimal:2'];

    public function tier()
    {
        return $this->belongsTo(WholesaleTier::class, 'wholesale_tier_id');
    }
}
