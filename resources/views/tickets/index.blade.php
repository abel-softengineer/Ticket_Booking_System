<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Megvásárolt jegyeim
        </h2>
    </x-slot>

    @php
        $grouped = $tickets->groupBy('event_id');
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($tickets->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-600 dark:text-gray-400">Még nincs megvásárolt jegyed.</p>
                </div>
            @else
                @foreach($grouped as $eventId => $eventTickets)

                    @php
                        $event = $eventTickets->first()->event;
                    @endphp
                    
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            {{ $event->event_date_at->format('Y. m. d. H:i') }}
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($eventTickets as $ticket)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                {{ $ticket->seat->seat_number ?? 'Ismeretlen ülőhely' }}
                                                                                                                            
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ number_format($ticket->price, 0, ',', ' ') }} Ft
                                            </p>
                                        </div>
                                        @if($ticket->admission_time)
                                            <span class="bg-green-100 text-white text-xs px-2 py-1 rounded">
                                                Beolvasva
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-white text-xs px-2 py-1 rounded">
                                                Nem beolvasva
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="bg-gray-800 p-4 rounded-lg flex flex-col items-center space-y-3">
                                         <p class="text-white text-sm tracking-widest font-mono">
                                            {{ $ticket->barcode }}
                                        </p>
                                        <svg class="barcode" data-barcode="{{ $ticket->barcode }}" width="150" height="50"></svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.barcode').forEach(el => {
        JsBarcode(el, el.dataset.barcode, {
            format: "CODE128",
            displayValue: true,
            fontSize: 14,
            width: 2,
            height: 50
        });
    });
});
</script>



</x-app-layout>