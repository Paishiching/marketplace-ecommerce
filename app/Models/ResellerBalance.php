<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerBalance extends Model
{
    use HasFactory;

    protected $table = 'reseller_balances';

    protected $fillable = [
        'reseller_id',
        'available_balance',
        'pending_balance',
    ];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }
}
