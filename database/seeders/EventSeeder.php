<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\Seat;

class EventSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory()->count(fake()->numberBetween(5, 8))->create();
    }
}
