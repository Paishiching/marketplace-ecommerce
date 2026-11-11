<?php

namespace Database\Factories;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        $shopName = fake()->unique()->company();

        return [
            'user_id' => User::factory(),
            'shop_name' => $shopName,
            'shop_slug' => Str::slug($shopName),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'verification_status' => 'verified',
            'status' => 'active',
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'pending',
        ]);
    }
}
