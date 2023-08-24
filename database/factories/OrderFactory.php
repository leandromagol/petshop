<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid,
            'user_id' => User::factory()->create()->uuid,
            'order_status_id' => OrderStatus::factory()->create()->uuid,
            'products' => [],
            'address' => ['billing' => fake()->address, 'shipping' => fake()->address],
            'delivery_fee' => fake()->randomFloat(2, 5, 20),
            'amount' => fake()->randomFloat(2, 50, 200),
            'shipped_at' => fake()->dateTimeThisYear(),
        ];
    }
}
