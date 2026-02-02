<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Új esemény létrehozása
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 text-white">Cím</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full p-2 border rounded">
                    @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-white">Leírás</label>
                    <textarea name="description" class="w-full p-2 border rounded">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-white">Esemény kezdete</label>
                    <input type="datetime-local" name="event_date_at" value="{{ old('event_date_at') }}" class="w-full p-2 border rounded">
                    @error('event_date_at') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-white">Jegyvásárlás kezdete</label>
                    <input type="datetime-local" name="sale_start_at" value="{{ old('sale_start_at') }}" class="w-full p-2 border rounded">
                    @error('sale_start_at') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-white">Jegyvásárlás vége</label>
                    <input type="datetime-local" name="sale_end_at" value="{{ old('sale_end_at') }}" class="w-full p-2 border rounded">
                    @error('sale_end_at') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-white">Max. jegyszám</label>
                    <input type="number" name="max_number_allowed" value="{{ old('max_number_allowed') }}" class="w-full p-2 border rounded">
                    @error('max_number_allowed') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 flex items-center space-x-2">
                    <input type="hidden" name="is_dynamic_price" value="0">
                    <input type="checkbox" name="is_dynamic_price" value="1" {{ old('is_dynamic_price') ? 'checked' : '' }}>
                    <label class="text-white">Dinamikus ár</label>
                    @error('is_dynamic_price') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Borítókép</label>
                    <input type="file" name="cover_image">
                    @error('cover_image') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Mentés
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
