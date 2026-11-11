<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Samsung', 'Apple', 'Xiaomi', 'Sony', 'LG',
            'Nike', 'Adidas', 'Puma', 'H&M', 'Zara',
            'Philips', 'Panasonic', 'Walton', 'Generic',
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['slug' => Str::slug($brand)],
                ['name' => $brand, 'status' => 'active']
            );
        }
    }
}
