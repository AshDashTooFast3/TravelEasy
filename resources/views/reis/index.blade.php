<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
            Mijn Reizen
        </h2>
    </x-slot>

    {{-- SUCCESS / ERROR --}}
    @if (session('success'))
        <div class="bg-green-600 text-white px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-600 text-white px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-8 max-w-7xl mx-auto space-y-8 px-4">

        {{-- KAART --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Reiskaart</h3>
            <div id="reisMap" class="w-full h-96 rounded-lg"></div>
        </div>

        {{-- MIJN BOEKINGEN --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Mijn geboekte reizen
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-900 dark:text-gray-100">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                            <th class="py-2 px-4">Bestemming</th>
                            <th class="px-4">Vlucht</th>
                            <th class="px-4">Datum</th>
                            <th class="px-4">Prijs</th>
                            <th class="px-4">Acties</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($boekingen as $reis)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-2 px-4">
                                    {{ $reis->accommodatie->Naam ?? 'Onbekend' }},
                                    {{ $reis->accommodatie->Stad ?? '' }}
                                </td>

                                <td class="px-4">
                                    Vlucht {{ $reis->vlucht->Vluchtnummer ?? 'Onbekend' }}
                                </td>

                                <td class="px-4">
                                    {{ $reis->Boekingsdatum }}
                                </td>

                                <td class="px-4">
                                    €{{ number_format($reis->TotaalPrijs, 2, ',', '.') }}
                                </td>

                                <td class="flex gap-3 py-2 px-4">
                                    <form action="{{ route('reis.destroy', $reis->Id) }}" method="POST"
                                          onsubmit="return confirm('Weet je zeker dat je deze reis wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-md text-sm">
                                            Annuleren
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                    Je hebt nog geen reizen geboekt.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BESCHIKBARE REIZEN --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Beschikbare reizen
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-900 dark:text-gray-100">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                            <th class="py-2 px-4">Vlucht</th>
                            <th class="px-4">Accommodatie</th>
                            <th class="px-4">Prijs p.p.</th>
                            <th class="px-4">Acties</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($vluchten as $vlucht)
                            @foreach ($accommodaties as $acc)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-2 px-4">
                                        Vlucht {{ $vlucht->Vluchtnummer }}
                                    </td>

                                    <td class="px-4">
                                        {{ $acc->Naam }} — {{ $acc->Stad }}
                                    </td>

                                    <td class="px-4">
                                        €{{ number_format($acc->TotaalPrijs, 2, ',', '.') }}
                                    </td>

                                    <td class="px-4">
                                        <a href="{{ route('reis.create', ['VluchtId' => $vlucht->Id, 'AccommodatieId' => $acc->Id]) }}"
                                           class="bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1 rounded-md text-sm">
                                            Boeken
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- KAART SCRIPT --}}
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