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
            <meta http-equiv="refresh" content="3;url={{ route('reis.index') }}">
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-600 text-white px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
            <meta http-equiv="refresh" content="3;url={{ route('reis.index') }}">
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
                            <th class="px-4">Aantal Geboekte Reizigers</th>
                            <th class="px-4">Status vlucht</th>
                            <th class="px-4">Acties</th> 
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($boekingen as $reis)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">

                                {{-- Bestemming --}}
                                <td class="py-2 px-4">
                                    {{ $reis->accommodatie->Naam ?? 'Onbekend' }},
                                    {{ $reis->accommodatie->Stad ?? '' }}
                                </td>

                                {{-- Vlucht --}}
                                <td class="px-4">
                                    Vlucht {{ $reis->vlucht->Vluchtnummer ?? 'Onbekend' }}
                                </td>

                                {{-- Datum --}}
                                <td class="px-4">
                                    {{ $reis->created_at->format('Y-m-d') }}
                                </td>

                                {{-- Prijs --}}
                                <td class="px-4">
                                    €{{ number_format($reis->TotaalPrijs, 2, ',', '.') }}
                                </td>

                                {{-- Aantal passagiers --}}
                                <td class="px-4">
                                    {{ $reis->ticket->Aantal ?? 1 }}
                                </td>

                                {{-- Status --}}
                                <td class="px-4">
                                    <x-status-badge :status="$reis->Vluchtstatus" type="vluchtstatus" />
                                </td>

                                {{--  ACTIES --}}
                                <td class="px-4">
                                    <div class="flex gap-2">

                                        {{-- WIJZIGEN --}}
                                        <a href="{{ route('reis.edit', $reis->BoekingId) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                            Wijzigen
                                        </a>

                                        {{-- VERWIJDEREN --}}
                                        <form action="{{ route('reis.destroy', $reis->BoekingId) }}"
                                              method="POST"
                                              onsubmit="return confirm('Weet je zeker dat je deze reis wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                Verwijderen
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500 dark:text-gray-400">
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
                        @php($heeftBeschikbareReizen = false)
                        @foreach ($vluchten as $vlucht)
                            @foreach ($vlucht->accommodaties as $acc)
                                @php($heeftBeschikbareReizen = true)
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

                        @if (!$heeftBeschikbareReizen)
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">
                                    Er zijn momenteel geen beschikbare reizen.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- KAART SCRIPT --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen@3.0.0/Control.FullScreen.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script src="https://unpkg.com/leaflet.fullscreen@3.0.0/Control.FullScreen.js"></script>
    <script src="https://unpkg.com/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylineDecorator.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const map = L.map('reisMap').setView([52.0907, 5.1214], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            if (L.control.fullscreen) {
                map.addControl(new L.Control.Fullscreen({ position: 'topleft' }));
            }

            const markerLayer = L.markerClusterGroup
                ? L.markerClusterGroup({ disableClusteringAtZoom: 7 })
                : L.layerGroup();

            // Vaste routes met echte luchthavens (onafhankelijk van DB-luchthavennamen).
            const fixedRoutes = [
                {
                    fromName: "Amsterdam Schiphol",
                    from: [52.3105, 4.7683],
                    toName: "Barcelona El Prat",
                    to: [41.2974, 2.0833],
                    toCity: "Barcelona",
                },
                {
                    fromName: "Brussels Airport",
                    from: [50.9010, 4.4844],
                    toName: "Rome Fiumicino",
                    to: [41.8003, 12.2389],
                    toCity: "Rome",
                },
                {
                    fromName: "Dusseldorf Airport",
                    from: [51.2808, 6.7573],
                    toName: "Athens International",
                    to: [37.9364, 23.9475],
                    toCity: "Athens",
                },
                {
                    fromName: "Eindhoven Airport",
                    from: [51.4501, 5.3745],
                    toName: "Lisbon Humberto Delgado",
                    to: [38.7742, -9.1342],
                    toCity: "Lisbon",
                },
                {
                    fromName: "Rotterdam The Hague",
                    from: [51.9569, 4.4372],
                    toName: "Paris Charles de Gaulle",
                    to: [49.0097, 2.5479],
                    toCity: "Paris",
                },
                {
                    fromName: "Amsterdam Schiphol",
                    from: [52.3105, 4.7683],
                    toName: "London Heathrow",
                    to: [51.4700, -0.4543],
                    toCity: "London",
                },
            ];

            const cityHighlights = {
                "Barcelona": "Wist je dat: Barcelona heeft 9 UNESCO-werelderfgoedlocaties van Gaudi.",
                "Rome": "Wist je dat: In Rome kun je in een paar minuten van het Colosseum naar het Forum lopen.",
                "Athens": "Wist je dat: Athene is een van de oudste continu bewoonde steden ter wereld.",
                "Lisbon": "Wist je dat: Lissabon is gebouwd op 7 heuvels en staat bekend om gele trams.",
                "Paris": "Wist je dat: Parijs heeft meer dan 1.800 bakkerijen verspreid over de stad.",
                "London": "Wist je dat: Londen heeft meer dan 170 musea, veel daarvan gratis toegankelijk.",
            };

            const statusColor = {
                "Gepland": "#6b7280",
                "Vertraagd": "#f59e0b",
                "Vertrokken": "#3b82f6",
                "Geland": "#10b981",
                "Geannuleerd": "#ef4444",
            };

            const trips = @json($kaartReizen);

            const bounds = [];

            trips.forEach((trip) => {
                // Koppel boeking stabiel aan een vaste route op basis van vluchtnummer.
                const numberPart = parseInt(String(trip.vluchtnummer || '').replace(/\D/g, ''), 10);
                const routeIndex = Number.isNaN(numberPart)
                    ? Math.abs(String(trip.vluchtnummer || '').split('').reduce((acc, c) => acc + c.charCodeAt(0), 0)) % fixedRoutes.length
                    : numberPart % fixedRoutes.length;

                const route = fixedRoutes[routeIndex];
                const vertrekCoords = route.from;
                const bestemmingCoords = route.to;
                const color = statusColor[trip.status] || "#6b7280";

                if (vertrekCoords) {
                    markerLayer.addLayer(L.circleMarker(vertrekCoords, {
                        radius: 6,
                        color,
                        weight: 2,
                        fillColor: color,
                        fillOpacity: 0.9,
                    }).bindPopup(`Vertrek: ${route.fromName}`));
                    bounds.push(vertrekCoords);
                }

                if (bestemmingCoords) {
                    const cityFact = cityHighlights[route.toCity] || "";
                    markerLayer.addLayer(L.circleMarker(bestemmingCoords, {
                        radius: 6,
                        color,
                        weight: 2,
                        fillColor: color,
                        fillOpacity: 0.9,
                    }).bindPopup(`Bestemming: ${route.toName}<br>${cityFact}`));
                    bounds.push(bestemmingCoords);
                }

                if (vertrekCoords && bestemmingCoords) {
                    const routeLine = L.polyline([vertrekCoords, bestemmingCoords], {
                        color,
                        weight: 3,
                        opacity: 0.85,
                        dashArray: trip.status === "Vertraagd" ? "8,6" : null,
                    }).addTo(map).bindPopup(
                        `Vlucht ${trip.vluchtnummer}<br>Route: ${route.fromName} -> ${route.toName}<br>Status: ${trip.status}<br>${cityHighlights[route.toCity] || ""}`
                    );

                    if (L.polylineDecorator) {
                        L.polylineDecorator(routeLine, {
                            patterns: [{
                                offset: '50%',
                                repeat: 0,
                                symbol: L.Symbol.arrowHead({
                                    pixelSize: 8,
                                    pathOptions: { color, fillOpacity: 1, weight: 2 },
                                }),
                            }],
                        }).addTo(map);
                    }
                }

                if (trip.accommodatieLat && trip.accommodatieLng) {
                    const accommodatieCoords = [trip.accommodatieLat, trip.accommodatieLng];
                    markerLayer.addLayer(L.marker(accommodatieCoords)
                        .bindPopup(`Accommodatie: ${trip.accommodatie || "Onbekend"}`));
                    bounds.push(accommodatieCoords);
                }
            });

            markerLayer.addTo(map);

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [40, 40] });
            }
        });
    </script>

</x-app-layout>