<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateBalance extends Model
{
    use HasFactory;

    protected $table = 'affiliate_balances';

    protected $fillable = [
        'affiliate_id',
        'available_balance',
        'pending_balance',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class, 'affiliate_id');
    }
}
