<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierBalance extends Model
{
    use HasFactory;

    protected $table = 'supplier_balances';

    protected $fillable = [
        'supplier_id',
        'available_balance',
        'pending_balance',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
