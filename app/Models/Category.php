<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'status',
    ];

    // Parent Category (যদি এটা একটা SubCategory হয়)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Child Categories / SubCategories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // এই ক্যাটাগরির অধীনে যত প্রোডাক্ট আছে (category_id হিসেবে)
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // এই ক্যাটাগরি SubCategory হিসেবে ব্যবহৃত হলে যত প্রোডাক্ট আছে
    public function subCategoryProducts()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function commissionRules()
    {
        return $this->hasMany(CommissionRule::class, 'category_id');
    }
}
