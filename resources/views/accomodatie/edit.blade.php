@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="page-header mb-4">Accommodatie Bewerken</h1>

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

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('accommodaties.update', $accommodatie->Id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Naam</label>
                        <input type="text" class="form-control @error('Naam') is-invalid @enderror" 
                               name="Naam" value="{{ old('Naam', $accommodatie->Naam) }}" required>
                        @error('Naam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control @error('Type') is-invalid @enderror" 
                               name="Type" value="{{ old('Type', $accommodatie->Type) }}" required>
                        @error('Type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Straat</label>
                        <input type="text" class="form-control @error('straat') is-invalid @enderror" 
                               name="straat" value="{{ old('straat', $accommodatie->straat) }}" required>
                        @error('straat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Huisnummer</label>
                        <input type="text" class="form-control @error('Huisnummer') is-invalid @enderror" 
                               name="Huisnummer" value="{{ old('Huisnummer', $accommodatie->Huisnummer) }}" required>
                        @error('Huisnummer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Toevoeging</label>
                        <input type="text" class="form-control @error('toevoeging') is-invalid @enderror" 
                               name="toevoeging" value="{{ old('toevoeging', $accommodatie->toevoeging) }}">
                        @error('toevoeging') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Postcode</label>
                        <input type="text" class="form-control @error('Postcode') is-invalid @enderror" 
                               name="Postcode" value="{{ old('Postcode', $accommodatie->Postcode) }}" required>
                        @error('Postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Stad</label>
                        <input type="text" class="form-control @error('Stad') is-invalid @enderror" 
                               name="Stad" value="{{ old('Stad', $accommodatie->Stad) }}" required>
                        @error('Stad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Land</label>
                        <input type="text" class="form-control @error('Land') is-invalid @enderror" 
                               name="Land" value="{{ old('Land', $accommodatie->Land) }}" required>
                        @error('Land') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Aantal Kamers</label>
                        <input type="number" class="form-control @error('AantalKamers') is-invalid @enderror" 
                               name="AantalKamers" value="{{ old('AantalKamers', $accommodatie->AantalKamers) }}" required min="1">
                        @error('AantalKamers') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Aantal Personen</label>
                        <input type="number" class="form-control @error('AantalPersonen') is-invalid @enderror" 
                               name="AantalPersonen" value="{{ old('AantalPersonen', $accommodatie->AantalPersonen) }}" required min="1">
                        @error('AantalPersonen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Prijs per Nacht (€)</label>
                        <input type="number" class="form-control @error('PrijsPerNacht') is-invalid @enderror" 
                               name="PrijsPerNacht" value="{{ old('PrijsPerNacht', $accommodatie->PrijsPerNacht) }}" required step="0.01" min="0">
                        @error('PrijsPerNacht') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Totaal Prijs (€)</label>
                        <input type="number" class="form-control @error('TotaalPrijs') is-invalid @enderror" 
                               name="TotaalPrijs" value="{{ old('TotaalPrijs', $accommodatie->TotaalPrijs) }}" required step="0.01" min="0">
                        @error('TotaalPrijs') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                    <a href="{{ route('accommodatie.index') }}" class="btn btn-secondary">Terug</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
        min-height: 100vh;
        padding: 20px 0;
    }

    .page-header {
        color: #0066cc;
        font-weight: 600;
    }

    .card {
        border: none;
        border-top: 4px solid #0099ff;
    }

    .btn-primary {
        background-color: #0099ff;
        border-color: #0099ff;
    }

    .btn-primary:hover {
        background-color: #0077cc;
        border-color: #0077cc;
    }
</style>
@endsection