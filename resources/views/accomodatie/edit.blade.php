<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Accommodatie Bewerken') }}
        </h2>
    </x-slot>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Er waren fouten:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white py-4">
                        <h4 class="mb-0">Accommodatie Bewerken</h4>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('accommodaties.update', $accommodatie->Id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="col-12">
                                <label class="form-label fw-semibold">Naam</label>
                                <input type="text" class="form-control @error('Naam') is-invalid @enderror"
                                    name="Naam" value="{{ old('Naam', $accommodatie->Naam) }}" required>
                                @error('Naam')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Type</label>
                                <input type="text" class="form-control @error('Type') is-invalid @enderror"
                                    name="Type" value="{{ old('Type', $accommodatie->Type) }}" required>
                                @error('Type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Straat</label>
                                <input type="text" class="form-control @error('straat') is-invalid @enderror"
                                    name="straat" value="{{ old('straat', $accommodatie->Straat) }}" required>
                                @error('straat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Huisnummer</label>
                                <input type="text" class="form-control @error('Huisnummer') is-invalid @enderror"
                                    name="Huisnummer" value="{{ old('Huisnummer', $accommodatie->Huisnummer) }}" required>
                                @error('Huisnummer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Toevoeging</label>
                                <input type="text" class="form-control @error('toevoeging') is-invalid @enderror"
                                    name="toevoeging" value="{{ old('toevoeging', $accommodatie->toevoeging) }}">
                                @error('toevoeging')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Postcode</label>
                                <input type="text" class="form-control @error('Postcode') is-invalid @enderror"
                                    name="Postcode" value="{{ old('Postcode', $accommodatie->Postcode) }}" required>
                                @error('Postcode')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Stad</label>
                                <input type="text" class="form-control @error('Stad') is-invalid @enderror"
                                    name="Stad" value="{{ old('Stad', $accommodatie->Stad) }}" required>
                                @error('Stad')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Land</label>
                                <input type="text" class="form-control @error('Land') is-invalid @enderror"
                                    name="Land" value="{{ old('Land', $accommodatie->Land) }}" required>
                                @error('Land')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Aantal Kamers</label>
                                <input type="number" class="form-control @error('AantalKamers') is-invalid @enderror"
                                    name="AantalKamers" value="{{ old('AantalKamers', $accommodatie->AantalKamers) }}"
                                    required min="1">
                                @error('AantalKamers')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Aantal Personen</label>
                                <input type="number" class="form-control @error('AantalPersonen') is-invalid @enderror"
                                    name="AantalPersonen"
                                    value="{{ old('AantalPersonen', $accommodatie->AantalPersonen) }}" required
                                    min="1">
                                @error('AantalPersonen')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Prijs per Nacht (€)</label>
                                <input type="number" class="form-control @error('PrijsPerNacht') is-invalid @enderror"
                                    name="PrijsPerNacht" value="{{ old('PrijsPerNacht', $accommodatie->PrijsPerNacht) }}"
                                    required step="0.01" min="0">
                                @error('PrijsPerNacht')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Totaal Prijs (€)</label>
                                <input type="number" class="form-control @error('TotaalPrijs') is-invalid @enderror"
                                    name="TotaalPrijs" value="{{ old('TotaalPrijs', $accommodatie->TotaalPrijs) }}"
                                    required step="0.01" min="0">
                                @error('TotaalPrijs')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mt-5 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Opslaan</button>
                                <a href="{{ route('accommodatie.index') }}" class="btn btn-outline-secondary btn-lg px-5">Terug</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
