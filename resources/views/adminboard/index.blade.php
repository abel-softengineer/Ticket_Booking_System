<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Board
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-white">
            <p>Összes esemény: {{ $totalevents }}</p>
            <p>Összes eladott jegy: {{ $totaltickets }}</p>
            <p>Összbevétel: {{ number_format($totalrevenue, 2) }} Ft</p>

            <h3 class="mt-4 font-semibold">Top 3 kedvelt ülőhely</h3>
            <ul>
                @foreach($topseats as $seat)
                    <li>Ülőhely: {{ $seat->seat->seat_number}} - Eladott jegyek: {{ $seat->count_sold }}</li>
                @endforeach
            </ul>

            <h3 class="mt-4 font-semibold">Események</h3>
            <table class="min-w-full mt-2">
                <thead>
                    <tr>
                        <th>Esemény</th>
                        <th>Eladott jegyek</th>
                        <th>Szabad jegyek</th>
                        <th>Bevétel</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->tickets_count }}</td>
                        <td>{{ $event->max_number_allowed - $event->tickets_count }}</td>
                        <td>{{ number_format($event->tickets->sum('price'), 2) }} Ft</td>
                        <td class="flex space-x-2">

                              <a href="{{ route('events.edit', $event->id) }}" 
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Módosítás
                                </a>


                            <form action="{{ route('events.destroy', $event->id) }}" 
                                method="POST"
                                onsubmit="return confirm('Biztosan törölni szeretnéd az eseményt?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Törlés
                                </button>
                            </form>
                                


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-6 mb-4">
            <a href="{{ route('events.create') }}" 
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Új esemény létrehozása
            </a>

            <a href="{{ route('seats.create') }}" 
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Új ülés létrehozása
            </a>

            </div>

            <div class="mt-4">
                {{ $events->links() }}
            </div>

        </div>
    </div>

<h3 class="mt-8 font-semibold text-white">Ülőhelyek</h3>
<div class="overflow-x-auto mt-2">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Ülőhely szám</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Eladott jegyek</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Műveletek</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700">
            @foreach($seats as $seat)
            <tr>
                <td class="px-4 py-2 text-white">{{ $seat->seat_number }}</td>
                <td class="px-4 py-2 text-white">{{ $seat->tickets()->count() }}</td>
                <td class="px-4 py-2 flex space-x-2">
                    <a href="{{ route('seats.edit', $seat->id) }}" 
                       class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Módosítás
                    </a>
                    <form action="{{ route('seats.destroy', $seat->id) }}" method="POST" onsubmit="return confirm('Biztosan törölni szeretnéd ezt az ülőhelyet?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Törlés
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-app-layout>
