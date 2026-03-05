<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Mijn Reizen
        </h2>
    </x-slot>

    @if (session('success'))
        <meta http-equiv="refresh" content="3">
        <div class="bg-green-600 text-white px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <meta http-equiv="refresh" content="3">
        <div class="bg-red-600 text-white px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-8 max-w-7xl mx-auto space-y-8">

        {{-- MAP SECTIE --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-white mb-4">Reiskaart</h3>

            <div id="reisMap" class="w-full h-96 rounded-lg"></div>
        </div>

        {{-- REIS OVERZICHT --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-white">Overzicht van mijn reizen</h3>
                @if (Auth::check() && in_array(Auth::user()->RolNaam, ['administrator', 'manager']))
                    <a href="{{ route('reis.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-md">
                        Nieuwe Reis Boeken
                    </a>
                @endif
            </div>

            <table class="w-full text-left text-white">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-2">Bestemming</th>
                        <th>Vlucht</th>
                        <th>Datum</th>
                        <th>Prijs</th>
                        <th>Acties</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($boekingen as $reis)
                        <tr class="border-b border-gray-700">
                            <td class="py-2">
                                {{ $reis->accommodatie->Naam ?? 'Onbekend' }},
                                {{ $reis->accommodatie->Stad ?? '' }}
                            </td>

                            <td>{{ $reis->vlucht->Vluchtnummer ?? 'Onbekend' }}</td>

                            <td>{{ $reis->Boekingsdatum }}</td>

                            <td>€{{ number_format($reis->TotaalPrijs, 2, ',', '.') }}</td>

                            <td class="flex gap-3 py-2">
                                <div class="flex items-center gap-2">

                                    {{-- Verwijderen --}}
                                    <form action="{{ route('reis.destroy', $reis->Id) }}" method="POST"
                                        onsubmit="return confirm('Weet je zeker dat je deze reis wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')

                                        @if (Auth::check() && in_array(Auth::user()->RolNaam, ['administrator', 'manager']))
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md text-sm">
                                               Annuleren
                                            </button>
                                        @endif
                                    </form>
                                    <form action="{{ route('reis.boeken', parameters: $reis->Id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded-md text-sm">
                                            Boeken
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-400">
                                Je hebt nog geen reizen geboekt.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- MAP --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const map = L.map('reisMap').setView([52.0907, 5.1214], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            @foreach ($boekingen as $reis)
                @if(isset($reis->accommodatie->Latitude) && isset($reis->accommodatie->Longitude))
                    L.marker([{{ $reis->accommodatie->Latitude }}, {{ $reis->accommodatie->Longitude }}])
                        .addTo(map)
                        .bindPopup("{{ $reis->accommodatie->Naam }}");
                @endif
            @endforeach
        });
    </script>

</x-app-layout>