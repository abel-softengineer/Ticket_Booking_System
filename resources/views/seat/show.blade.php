<x-app-layout>
    <x-slot name="header">
        <h2>Ülőhely részletei: {{ $seat->seat_number }}</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <p><strong>Ülőhely kódja:</strong> {{ $seat->seat_number }}</p>
        <p><strong>Alap ár:</strong> {{ number_format($seat->base_price) }} Ft</p>
        <p><strong>Eladott jegyek:</strong> {{ $seat->tickets()->count() }}</p>

        <a href="{{ route('seats.edit', $seat->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Módosítás</a>
        <a href="{{ route('seats.index') }}" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">Vissza a listához</a>
    </div>
</x-app-layout>
