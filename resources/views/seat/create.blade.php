<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Új ülőhely létrehozása</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form action="{{ route('seats.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="text-white">Ülőhely kódja</label>
                <input type="text" name="seat_number" value="{{ old('seat_number') }}" class="w-full border p-2 rounded">
                @error('seat_number')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="text-white">Alap ár</label>
                <input type="number" name="base_price" value="{{ old('base_price') }}" class="w-full border p-2 rounded">
                @error('base_price')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-green-600">Mentés</button>
        </form>
    </div>
</x-app-layout>
