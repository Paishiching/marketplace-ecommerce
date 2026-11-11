<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'loyalty_points',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bulkOrders()
    {
        return $this->hasMany(BulkOrder::class, 'customer_id');
    }

    public function dropshipperOrders()
    {
        return $this->hasMany(DropshipperOrder::class, 'customer_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class, 'customer_id');
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'customer_id');
    }

    public function shippingAddress()
    {
        return $this->hasMany(ShippingAddress::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
}
