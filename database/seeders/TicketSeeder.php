<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Event;
use App\Models\Seat;

class TicketSeeder extends Seeder
{
    public function run(): void
{
    $events = Event::all();
    $users = User::all();
    $seats = Seat::all();

    foreach ($events as $event) {
        $eventUsers = $users->random(rand(3, 6));
        $availableSeats = $seats->shuffle();
        
        foreach ($eventUsers as $user) {
            $ticketCount = rand(1, 3);
            
            for ($i = 0; $i < $ticketCount && $availableSeats->isNotEmpty(); $i++) {
                $seat = $availableSeats->pop();
                
                Ticket::factory()->create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'seat_id' => $seat->id,
                    'price' => $seat->base_price,
                ]);
            }
        }
    }
}
}