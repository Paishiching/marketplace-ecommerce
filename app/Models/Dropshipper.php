<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dropshipper extends Model
{
    protected $fillable = ['user_id', 'business_name', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(DropshipperProduct::class);
    }

    public function orders()
    {
        return $this->hasMany(DropshipperOrder::class);
    }

    public function withdrawals()
    {
        return $this->morphMany(Withdrawal::class, 'withdrawable');
    }
}
