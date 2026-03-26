<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Accommodaties - TravelEasy</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .page-header {
                color: #0066cc;
                font-weight: 600;
                margin-bottom: 30px;
            }

            .card {
                border: none;
                border-top: 4px solid #0099ff;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 153, 255, 0.15) !important;
            }

            .card-title {
                color: #0066cc;
                font-weight: 600;
            }

            .btn-primary {
                background-color: #0099ff;
                border-color: #0099ff;
            }

            .btn-primary:hover {
                background-color: #0077cc;
                border-color: #0077cc;
            }

            .price-highlight {
                color: #0099ff;
                font-weight: 600;
                font-size: 1.1em;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="page-header">Accommodaties</h1>
            @if (Auth::check() && in_array(Auth::user()->RolNaam, ['administrator', 'manager']))
                <a href="{{ route('accommodaties.create') }}" class="btn btn-warning btn-sm mb-4">Nieuwe
                    Accommodatie</a>
            @endif

            <!-- Filter Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filters</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Naam</label>
                            <input type="text" class="form-control" id="filterNaam" placeholder="Zoek op naam...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" id="filterType">
                                <option value="">Alle types</option>
                                @php
                                    $types = $accommodaties->pluck('Type')->unique()->sort();
                                @endphp
                                @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Land</label>
                            <select class="form-select" id="filterLand">
                                <option value="">Alle landen</option>
                                @php
                                    $landen = $accommodaties->pluck('Land')->unique()->sort();
                                @endphp
                                @foreach ($landen as $land)
                                    <option value="{{ $land }}">{{ $land }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Min. Prijs per nacht</label>
                            <input type="number" class="form-control" id="filterMinPrice" placeholder="0"
                                min="0">
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-3">
                            <label class="form-label">Max. Prijs per nacht</label>
                            <input type="number" class="form-control" id="filterMaxPrice" placeholder="9999"
                                min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Aantal Kamers</label>
                            <input type="number" class="form-control" id="filterKamers" placeholder="Aantal kamers"
                                min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100" onclick="resetFilters()">Reset Filters</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="accommodatiesContainer">
                @forelse($accommodaties as $accommodatie)
                    <div class="col-lg-6 col-xl-4 accommodatie-card" data-naam="{{ strtolower($accommodatie->Naam) }}"
                        data-type="{{ $accommodatie->Type }}" data-land="{{ $accommodatie->Land }}"
                        data-price="{{ $accommodatie->PrijsPerNacht }}" data-kamers="{{ $accommodatie->AantalKamers }}">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $accommodatie->Naam }}</h5>
                                <p class="card-text mb-3"><small
                                        class="badge bg-light text-primary">{{ $accommodatie->Type }}</small></p>

                                <p class="card-text text-muted mb-2">
                                    {{ $accommodatie->straat }} {{ $accommodatie->Huisnummer }}
                                    @if ($accommodatie->toevoeging)
                                        {{ $accommodatie->toevoeging }}
                                    @endif
                                </p>

                                <p class="card-text text-muted mb-3">
                                    {{ $accommodatie->Postcode }} {{ $accommodatie->Stad }},
                                    {{ $accommodatie->Land }}
                                </p>

                                <hr class="my-2">

                                <div class="mb-3">
                                    <p class="card-text mb-2"><strong>Kamers:</strong>
                                        {{ $accommodatie->AantalKamers }}
                                    </p>
                                    <p class="card-text mb-2"><strong>Personen:</strong>
                                        {{ $accommodatie->AantalPersonen }}</p>
                                    <p class="card-text mb-2"><strong>Per nacht:</strong> <span
                                            class="price-highlight">€{{ $accommodatie->PrijsPerNacht }}</span></p>
                                    <p class="card-text"><strong>Totaal:</strong> <span
                                            class="price-highlight">€{{ $accommodatie->TotaalPrijs }}</span></p>
                                </div>

                                <div class="d-flex gap-2 mt-auto">
                                    @if (Auth::check() && in_array(Auth::user()->RolNaam, ['administrator', 'manager']))
                                        <form action="{{ route('accommodaties.edit', $accommodatie->Id) }}"
                                            method="GET" style="display:inline;">
                                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                        </form>
                                        <form action="{{ route('accommodaties.delete', $accommodatie->Id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            Geen accommodaties beschikbaar
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function filterAccommodaties() {
                const naam = document.getElementById('filterNaam').value.toLowerCase();
                const type = document.getElementById('filterType').value;
                const land = document.getElementById('filterLand').value;
                const minPrice = parseFloat(document.getElementById('filterMinPrice').value) || 0;
                const maxPrice = parseFloat(document.getElementById('filterMaxPrice').value) || 999999;
                const kamers = parseInt(document.getElementById('filterKamers').value) || 0;

                const cards = document.querySelectorAll('.accommodatie-card');
                cards.forEach(card => {
                    const cardNaam = card.getAttribute('data-naam');
                    const cardType = card.getAttribute('data-type');
                    const cardLand = card.getAttribute('data-land');
                    const cardPrice = parseFloat(card.getAttribute('data-price'));
                    const cardKamers = parseInt(card.getAttribute('data-kamers'));

                    const naamMatch = cardNaam.includes(naam);
                    const typeMatch = !type || cardType === type;
                    const landMatch = !land || cardLand === land;
                    const priceMatch = cardPrice >= minPrice && cardPrice <= maxPrice;
                    const kamersMatch = kamers === 0 || cardKamers === kamers;

                    card.style.display = naamMatch && typeMatch && landMatch && priceMatch && kamersMatch ? '' : 'none';
                });
            }

            function resetFilters() {
                document.getElementById('filterNaam').value = '';
                document.getElementById('filterType').value = '';
                document.getElementById('filterLand').value = '';
                document.getElementById('filterMinPrice').value = '';
                document.getElementById('filterMaxPrice').value = '';
                document.getElementById('filterKamers').value = '';
                filterAccommodaties();
            }

            document.getElementById('filterNaam').addEventListener('input', filterAccommodaties);
            document.getElementById('filterType').addEventListener('change', filterAccommodaties);
            document.getElementById('filterLand').addEventListener('change', filterAccommodaties);
            document.getElementById('filterMinPrice').addEventListener('input', filterAccommodaties);
            document.getElementById('filterMaxPrice').addEventListener('input', filterAccommodaties);
            document.getElementById('filterKamers').addEventListener('input', filterAccommodaties);
        </script>
    </body>

    </html>
</x-app-layout>
