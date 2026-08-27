<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = \App\Models\OrderItem::class;

    public function definition(): array
    {
        return [
            'order_no' => 'ORD-00001',
            'store_id' => 1,
            'product_name' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function forOrder(\App\Models\Order $order): static
    {
        return $this->state(fn (array $attributes) => [
            'order_no' => $order->order_no,
            'store_id' => $order->store_id,
        ]);
    }
}
