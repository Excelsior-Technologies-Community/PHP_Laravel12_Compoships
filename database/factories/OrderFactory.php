<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \App\Models\Order::class;

    public function definition(): array
    {
        return [
            'order_no' => 'ORD-'.$this->faker->unique()->numerify('#####'),
            'store_id' => $this->faker->numberBetween(1, 5),
            'customer_name' => $this->faker->name(),
            'status' => $this->faker->randomElement(['pending', 'completed']),
        ];
    }
}
