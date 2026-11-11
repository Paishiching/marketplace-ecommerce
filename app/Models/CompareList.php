<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompareList extends Model
{
    use HasFactory;

    protected $table = 'compare_lists';

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * এই কম্পেয়ার এন্ট্রি যে User এর
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * এই কম্পেয়ার এন্ট্রি যে Product এর
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
