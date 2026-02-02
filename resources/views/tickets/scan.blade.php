<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Jegybeolvasás
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            
            @if(session('success'))
                <div class="mb-4 p-2 bg-green-500 text-white rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-2 bg-red-500 text-white rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('ticket.scan.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 text-white">Jegy vonalkód</label>
                    <input type="text" name="barcode" class="w-full p-2 border rounded" autofocus>
                    @error('barcode') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Beolvasás
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
