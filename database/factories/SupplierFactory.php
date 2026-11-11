<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        $companyName = fake()->unique()->company();

        return [
            'user_id' => User::factory(),
            'company_name' => $companyName,
            'company_slug' => Str::slug($companyName),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'verification_status' => 'verified',
            'status' => 'active',
        ];
    }
}
