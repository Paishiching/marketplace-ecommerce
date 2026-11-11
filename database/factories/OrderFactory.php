<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 200, 10000);
        $discount = fake()->boolean(25) ? round($subtotal * 0.1, 2) : 0;
        $shippingCost = fake()->randomElement([60, 120]);

        return [
            'customer_id' => Customer::factory(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_cost' => $shippingCost,
            'total' => $subtotal - $discount + $shippingCost,
            'status' => fake()->randomElement(['pending', 'processing', 'paid', 'shipped', 'delivered']),
            'payment_method' => fake()->randomElement(['cod', 'card', 'mobile_banking']),
        ];
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
        ]);
    }
}
