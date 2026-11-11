<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics' => ['Mobile Phones', 'Laptops', 'Cameras', 'Accessories'],
            'Fashion' => ["Men's Wear", "Women's Wear", 'Kids Wear', 'Shoes'],
            'Home & Living' => ['Furniture', 'Kitchenware', 'Decor'],
            'Health & Beauty' => ['Skincare', 'Makeup', 'Personal Care'],
            'Groceries' => ['Fresh Food', 'Packaged Food', 'Beverages'],
            'Sports & Outdoors' => ['Fitness Equipment', 'Outdoor Gear'],
            'Books & Stationery' => ['Books', 'Office Supplies'],
            'Toys & Baby' => ['Toys', 'Baby Care'],
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['slug' => Str::slug($parentName)],
                ['name' => $parentName, 'parent_id' => null, 'status' => 'active']
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($parentName . '-' . $childName)],
                    ['name' => $childName, 'parent_id' => $parent->id, 'status' => 'active']
                );
            }
        }
    }
}
