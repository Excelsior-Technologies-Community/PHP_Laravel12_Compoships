<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        return [
            'region' => 'north',
            'store_code' => 'X1',
            'sku' => $this->faker->unique()->bothify('SKU-####'),
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }

    public function forStore(\App\Models\Store $store): static
    {
        return $this->state(fn (array $attributes) => [
            'region' => $store->region,
            'store_code' => $store->code,
            'sku' => $this->faker->unique()->bothify('SKU-####'),
        ]);
    }
}
