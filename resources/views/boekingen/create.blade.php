<x-app-layout>
    {{-- Koptekst van de pagina --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nieuwe Boeking Aanmaken
        </h2>
    </x-slot>

    {{-- Hoofdcontainer met padding --}}
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Witte kaart met formulier --}}
            <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">

                {{-- Link terug naar boekingsoverzicht --}}
                <a href="{{ route('boekingen.index') }}"
                   class="text-blue-500 hover:text-blue-700 text-sm mb-4 inline-block">
                    ← Terug naar overzicht
                </a>

                {{-- Succesbericht weergeven bij succesvolle opslaan --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-600 text-white rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Validatiefouten weergeven als er fouten zijn --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-600 text-white rounded">
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulier voor nieuwe boeking --}}
                <form action="{{ route('boekingen.store') }}" method="POST">
                    @csrf

                    {{-- Invoerveld voor boekingsnummer --}}
                    <label class="block text-gray-300 mb-1">Boekingsnummer</label>
                    <input type="text" name="Boekingsnummer"
                           class="w-full mb-4 p-2 rounded bg-gray-700 text-white"
                           placeholder="Bijv. BN-123456">

                    {{-- Dropdown voor vlucht selectie met bestemming --}}
                    <label class="block text-gray-300 mb-1">Vlucht (met bestemming)</label>
                    <select name="VluchtId" class="w-full mb-4 p-2 rounded bg-gray-700 text-white">
                        @foreach($vluchten as $vlucht)
                            <option value="{{ $vlucht->Id }}">
                                {{ $vlucht->Vluchtnummer }}
                                — {{ $vlucht->bestemming->Land }}
                                ({{ $vlucht->bestemming->Luchthaven }})
                            </option>
                        @endforeach
                    </select>

                    {{-- Dropdown voor accommodatie selectie --}}
                    <label class="block text-gray-300 mb-1">Accommodatie</label>
                    <select name="AccommodatieId" class="w-full mb-4 p-2 rounded bg-gray-700 text-white">
                        @foreach($accommodaties as $acc)
                            <option value="{{ $acc->Id }}">
                                {{ $acc->Naam }} — {{ $acc->Stad }}, {{ $acc->Land }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Datuminvoerveld voor boekingsdatum --}}
                    <label class="block text-gray-300 mb-1">Datum</label>
                    <input type="date" name="Boekingsdatum"
                           class="w-full mb-4 p-2 rounded bg-gray-700 text-white">

                    {{-- Tijdinvoerveld voor boekingstijd --}}
                    <label class="block text-gray-300 mb-1">Tijd</label>
                    <input type="time" name="Boekingstijd"
                           class="w-full mb-4 p-2 rounded bg-gray-700 text-white">

                    {{-- Dropdown voor boekingsstatus --}}
                    <label class="block text-gray-300 mb-1">Status</label>
                    <select name="Boekingsstatus" class="w-full mb-4 p-2 rounded bg-gray-700 text-white">
                        <option>Bevestigd</option>
                        <option>Geannuleerd</option>
                        <option>In behandeling</option>
                    </select>

                    {{-- Nummerveld voor totaalprijs in euro's --}}
                    <label class="block text-gray-300 mb-1">Prijs (€)</label>
                    <input type="number" step="0.01" name="TotaalPrijs"
                           class="w-full mb-4 p-2 rounded bg-gray-700 text-white">

                    {{-- Submit-knop om formulier op te slaan --}}
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Opslaan
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- Automatisch terug naar overzicht na 3 seconden bij succesvolle opslaan --}}
    @if(session('success'))
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('boekingen.index') }}";
        }, 3000);
    </script>
    @endif

</x-app-layout>
