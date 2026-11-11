<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBalance extends Model
{
    use HasFactory;

    protected $table = 'vendor_balances';

    protected $fillable = [
        'vendor_id',
        'available_balance',
        'pending_balance',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
