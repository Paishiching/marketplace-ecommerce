<?php

namespace Database\Factories;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AffiliateFactory extends Factory
{
    protected $model = Affiliate::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'referral_code' => strtoupper(Str::random(8)),
            'commission_rate' => 5,
            'status' => 'active',
        ];
    }
}
