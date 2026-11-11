<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->randomFloat(2, 100, 5000);

        return [
            'vendor_id' => Vendor::factory(),
            'category_id' => Category::inRandomOrder()->value('id')
                ?? Category::create(['name' => 'General', 'slug' => 'general', 'status' => 'active'])->id,
            'brand_id' => Brand::inRandomOrder()->value('id')
                ?? Brand::create(['name' => 'Generic', 'slug' => 'generic', 'status' => 'active'])->id,
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'sku' => strtoupper(Str::random(3)) . '-' . fake()->unique()->numberBetween(10000, 99999),
            'description' => fake()->paragraph(),
            'price' => $price,
            'discount_price' => fake()->boolean(30) ? round($price * 0.85, 2) : null,
            'product_type' => fake()->randomElement(['simple', 'variable']),
            'thumbnail' => 'products/placeholder.png',
            'status' => 'active',
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'out_of_stock',
        ]);
    }
}
