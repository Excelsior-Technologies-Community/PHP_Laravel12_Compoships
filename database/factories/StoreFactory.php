<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = \App\Models\Store::class;

    public function definition(): array
    {
        return [
            'region' => $this->faker->randomElement(['north', 'south', 'east', 'west']),
            'code' => $this->faker->unique()->bothify('??###'),
            'name' => $this->faker->company(),
            'location' => $this->faker->city(),
        ];
    }
}
