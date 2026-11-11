<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use HasFactory;

    protected $table = 'resellers';

    protected $fillable = [
        'user_id',
        'business_name',
        'markup_rate',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resellerProducts()
    {
        return $this->hasMany(ResellerProduct::class, 'reseller_id');
    }

    public function resellerCustomers()
    {
        return $this->hasMany(ResellerCustomer::class, 'reseller_id');
    }

    public function resellerOrders()
    {
        return $this->hasMany(ResellerOrder::class, 'reseller_id');
    }

    public function resellerBalances()
    {
        return $this->hasMany(ResellerBalance::class, 'reseller_id');
    }

    public function resellerTransactions()
    {
        return $this->hasMany(ResellerTransaction::class, 'reseller_id');
    }
    public function orders()
    {
        return $this->hasMany(ResellerOrder::class, 'reseller_id');
    }
    public function customers()
    {
        return $this->hasMany(ResellerCustomer::class, 'reseller_id');
    }
}
