@php
use App\Models\Seat;
use App\Models\Ticket;
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Jövőbeli események
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    @php

                    $allSeats = Seat::all();
                    $availableSeats = [];

                    foreach ($allSeats as $seat) {
                        $booked = Ticket::where('event_id', $event->id)->where('seat_id', $seat->id)->exists();
                        if (!$booked) {
                            $availableSeats[] = $seat;
                        }
                    }

                    $available = count($availableSeats);
                    $totalSeats = count($allSeats);
                    $percent = $totalSeats > 0 ? ($available / $totalSeats) * 100 : 0;
                    @endphp

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg transition transform hover:scale-105">
                        <img src="{{ asset('images/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $event->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $event->event_date_at->format('Y-m-d H:i') }}</p>
                            
                            <p class="text-green">{{ $percent }}%</p>
                            <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 h-4 rounded-full overflow-hidden">
                                <div class="h-4 bg-green-500 rounded-full" style="width: {{ $percent }}%">
                                </div>
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                Szabad jegyek: {{ $available }}
                            </p>

                            <a href="{{ route('events.show', $event) }}" class="mt-2 inline-block hover:underline font-medium text-white">
                                Részletek
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
