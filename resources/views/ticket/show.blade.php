<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Ticket #{{ $ticket->Id }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto">

        <div class="bg-gray-800 p-6 rounded-lg shadow text-white space-y-6">

            {{-- Titel --}}
            <h3 class="text-2xl font-semibold">Jouw Ticket</h3>

            @if (session('success'))
                <div data-flash-message class="bg-green-600 text-white px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div data-flash-message class="bg-red-600 text-white px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('[data-flash-message]').forEach(function (el) {
                        setTimeout(function () {
                            el.style.transition = 'opacity 0.35s ease';
                            el.style.opacity = '0';
                            setTimeout(function () {
                                el.remove();
                            }, 350);
                        }, 5000);
                    });
                });
            </script>

            {{-- Vluchtinformatie --}}
            <div class="bg-gray-700 p-4 rounded">
                <h4 class="font-semibold text-lg mb-2">Vluchtinformatie</h4>

                <p><strong>Vluchtnummer:</strong> {{ $ticket->vlucht->Vluchtnummer }}</p>
                <p><strong>Vertrekdatum:</strong> {{ $ticket->vlucht->Vertrekdatum }}</p>
                <p><strong>Vluchtstatus:</strong> 
                    <x-status-badge :status="$ticket->Vluchtstatus ?? ($ticket->vlucht->Vluchtstatus ?? 'Onbekend')" type="vluchtstatus" />
                </p>
            </div>
<div class="flex flex-wrap gap-2 mt-2">
    @foreach(explode('|', $ticket->Stoelnummer) as $stoel)
        <span class="bg-gray-600 px-3 py-1 rounded text-sm">
            {{ $stoel }}
        </span>
    @endforeach
</div>
            {{-- Vertrek --}}
            <div class="bg-gray-700 p-4 rounded">
                <h4 class="font-semibold text-lg mb-2">Vertrek</h4>

                <p><strong>Luchthaven:</strong> {{ $ticket->vlucht->vertrek->Luchthaven }}</p>
                <p><strong>Land:</strong> {{ $ticket->vlucht->vertrek->Land }}</p>
            </div>

            {{-- Bestemming --}}
            <div class="bg-gray-700 p-4 rounded">
                <h4 class="font-semibold text-lg mb-2">Bestemming</h4>

                <p><strong>Luchthaven:</strong> {{ $ticket->vlucht->bestemming->Luchthaven }}</p>
                <p><strong>Land:</strong> {{ $ticket->vlucht->bestemming->Land }}</p>
            </div>

            {{-- Ticketgegevens --}}
            <div class="bg-gray-700 p-4 rounded">
                <h4 class="font-semibold text-lg mb-2">Ticketgegevens</h4>
                 <p><strong>Datum aangemaakt:</strong> {{ \Carbon\Carbon::parse($ticket->Datumaangemaakt)->format('d-m-Y') }}</p>
       
                <p><strong>Prijs:</strong> 
     €{{ number_format($ticket->BedragInclBtw, 2, ',', '.') }}
</p>
               
            </div>

            {{-- Terugknop --}}
            <div class="pt-4">
                <a href="{{ route('ticket.index') }}"
                   class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded text-white">
                    Terug naar tickets
                </a>
            </div>

        </div>

    </div>
</x-app-layout>