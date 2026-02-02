<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Ülőhely módosítása
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            @if(session('error'))
                <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('seats.update', $seat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="seat_number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ülőhely kódja</label>
                    <input type="text" name="seat_number" id="seat_number"
                        value="{{ old('seat_number', $seat->seat_number) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>
                    @error('seat_number')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="base_price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Alap ár</label>
                    <input type="number" name="base_price" id="base_price"
                        value="{{ old('base_price', $seat->base_price) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        required>
                    @error('base_price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Mentés</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
