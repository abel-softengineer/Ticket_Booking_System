<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelName>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seat_number' => $this->faker->unique()->regexify('[A-Z][0-9]{3}'),
            'base_price' => $this->faker->numberBetween(5000, 15000),
        ];
    }
}
