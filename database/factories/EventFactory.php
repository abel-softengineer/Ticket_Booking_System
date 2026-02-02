<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salestart = fake()->dateTimeBetween('-15 days', '+5 days');
        $salesstartcopy = $salestart;
        $saleend   = fake()->dateTimeBetween($salesstartcopy, '+10 days');
        $saleendcopy = $saleend;
        $eventdate = fake()->dateTimeBetween($saleendcopy, '+20 days');

        $filename = fake()->boolean() ? 'file.png' : null;

        return [
            'title' => fake()->sentence(fake()->numberBetween(3, 6)),
            'description' => fake()->text(500),
            'sale_start_at' => $salestart,
            'sale_end_at' => $saleend,
            'event_date_at' => $eventdate,
            'is_dynamic_price' => fake()->boolean(),
            'max_number_allowed' => fake()->numberBetween(2, 5),
            'cover_image' => $filename, 
        ];
    }
}
