<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Accommodatie Aanmaken') }}
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
                        <h4 class="mb-0">Accommodatie Aanmaken</h4>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('accommodaties.store') }}" method="POST">
                            @csrf

                            <div class="col-12">
                                <label class="form-label fw-semibold">Vlucht</label>
                                <select class="form-select @error('Vluchtnummer') is-invalid @enderror"
                                    name="Vluchtnummer" required>
                                    <option value="">-- Selecteer een vlucht --</option>
                                    @foreach ($vluchten as $vlucht)
                                        <option value="{{ $vlucht->Vluchtnummer }}" {{ old('Vluchtnummer') == $vlucht->Vluchtnummer ? 'selected' : '' }}>
                                            {{ $vlucht->Vluchtnummer }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Vluchtnummer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Naam</label>
                                <input type="text" class="form-control @error('Naam') is-invalid @enderror"
                                    name="Naam" value="{{ old('Naam') }}" required>
                                @error('Naam')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Type</label>
                                <select class="form-select @error('Type') is-invalid @enderror"
                                    name="Type" required>
                                    <option value="">-- Selecteer een type --</option>
                                    <option value="Hotel" {{ old('Type') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                    <option value="Hostel" {{ old('Type') == 'Hostel' ? 'selected' : '' }}>Hostel</option>
                                    <option value="Apartament" {{ old('Type') == 'Apartament' ? 'selected' : '' }}>Apartament</option>
                                    <option value="Resort" {{ old('Type') == 'Resort' ? 'selected' : '' }}>Resort</option>
                                </select>
                                @error('Type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Straat</label>
                                <input type="text" class="form-control @error('Straat') is-invalid @enderror"
                                    name="Straat" value="{{ old('Straat') }}" required>
                                @error('Straat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Huisnummer</label>
                                <input type="text" class="form-control @error('Huisnummer') is-invalid @enderror"
                                    name="Huisnummer" value="{{ old('Huisnummer') }}" required>
                                @error('Huisnummer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Toevoeging</label>
                                <input type="text" class="form-control @error('toevoeging') is-invalid @enderror"
                                    name="toevoeging" value="{{ old('toevoeging') }}">
                                @error('toevoeging')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Postcode</label>
                                <input type="text" class="form-control @error('Postcode') is-invalid @enderror"
                                    name="Postcode" value="{{ old('Postcode') }}" required>
                                @error('Postcode')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Stad</label>
                                <input type="text" class="form-control @error('Stad') is-invalid @enderror"
                                    name="Stad" value="{{ old('Stad') }}" required>
                                @error('Stad')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Land</label>
                                <input type="text" class="form-control @error('Land') is-invalid @enderror"
                                    name="Land" value="{{ old('Land') }}" required>
                                @error('Land')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Aantal Kamers</label>
                                <input type="number" class="form-control @error('AantalKamers') is-invalid @enderror"
                                    name="AantalKamers" value="{{ old('AantalKamers') }}"
                                    required min="1">
                                @error('AantalKamers')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Aantal Personen</label>
                                <input type="number" class="form-control @error('AantalPersonen') is-invalid @enderror"
                                    name="AantalPersonen"
                                    value="{{ old('AantalPersonen') }}" required
                                    min="1">
                                @error('AantalPersonen')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Check-in Datum</label>
                                <input type="date" class="form-control @error('CheckInDatum') is-invalid @enderror"
                                    name="CheckInDatum" value="{{ old('CheckInDatum') }}" required>
                                @error('CheckInDatum')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Check-out Datum</label>
                                <input type="date" class="form-control @error('CheckOutDatum') is-invalid @enderror"
                                    name="CheckOutDatum" value="{{ old('CheckOutDatum') }}" required>
                                @error('CheckOutDatum')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Prijs per Nacht (€)</label>
                                <input type="number" class="form-control @error('PrijsPerNacht') is-invalid @enderror"
                                    name="PrijsPerNacht" value="{{ old('PrijsPerNacht') }}"
                                    required step="0.01" min="0">
                                @error('PrijsPerNacht')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Totaal Prijs (€)</label>
                                <input type="number" class="form-control @error('TotaalPrijs') is-invalid @enderror"
                                    name="TotaalPrijs" value="{{ old('TotaalPrijs') }}"
                                    required step="0.01" min="0">
                                @error('TotaalPrijs')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-semibold">Opmerking</label>
                                <textarea class="form-control @error('Opmerking') is-invalid @enderror"
                                    name="Opmerking" rows="4">{{ old('Opmerking') }}</textarea>
                                @error('Opmerking')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mt-5 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Aanmaken</button>
                                <a href="{{ route('accommodatie.index') }}" class="btn btn-outline-secondary btn-lg px-5">Terug</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>