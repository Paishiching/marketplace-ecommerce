<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResellerCustomer extends Model
{
    protected $table = 'reseller_customers';

    protected $fillable = ['reseller_id', 'name', 'phone', 'address'];

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }
}
