<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierWarehouse extends Model
{
    use HasFactory;

    protected $table = 'supplier_warehouses';

    protected $fillable = [
        'supplier_id',
        'name',
        'address',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
