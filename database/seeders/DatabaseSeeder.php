<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@email.hu',
            'admin' => true,
            'password' => Hash::make('123'),
        ]);

        User::factory()->create([
            'name' => 'Super User',
            'email' => 'user@email.hu',
            'admin' => false,
            'password' => Hash::make('123'),
        ]);

        User::factory(10)->create();

        $this->call([SeatSeeder::class, EventSeeder::class,TicketSeeder::class]);
    }
}
