<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Nieuwe Reis Boeken
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-gray-800 p-6 rounded-lg shadow text-white">
            <h3 class="text-lg font-semibold mb-4">Bevestig je reis</h3>

            {{-- FOUTMELDING --}}
            @if ($errors->any())
                <div id="errorAlert" class="bg-red-600 text-white p-4 rounded-md mb-4">
                    <ul class="list-disc ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reis.store') }}" method="POST">
                @csrf

                {{-- Gekozen vlucht --}}
                <div class="mb-4">
                    <label class="block mb-1">Gekozen vlucht</label>
                    <p class="font-semibold">
                        Vlucht {{ $vlucht->Vluchtnummer }}
                    </p>
                    <input type="hidden" name="VluchtId" value="{{ $vlucht->Id }}">
                </div>

                {{-- Gekozen accommodatie --}}
                <div class="mb-4">
                    <label class="block mb-1">Gekozen accommodatie</label>
                    <p class="font-semibold">
                        {{ $accommodatie->Naam }} — {{ $accommodatie->Stad }}, {{ $accommodatie->Land }}
                        (Prijs per persoon: €{{ number_format($accommodatie->TotaalPrijs, 2, ',', '.') }})
                    </p>
                    <input type="hidden" name="AccommodatieId" value="{{ $accommodatie->Id }}">
                </div>

                {{-- Aantal passagiers --}}
                <div class="mb-4">
                    <label class="block mb-1">Aantal passagiers</label>
                    <input id="passagiersInput"
                           type="number"
                           name="AantalPassagiers"
                           min="1"
                           value="1"
                           class="w-full bg-gray-700 text-white p-2 rounded"
                           required>
                </div>

                {{-- Totale prijs --}}
                <div class="mb-4">
                    <p class="text-gray-300 text-sm">Totale prijs:</p>
                    <p id="totaalPrijs" class="text-xl font-bold text-green-400">€0,00</p>
                </div>

                <button class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded text-white">
                    Reis Boeken
                </button>

            </form>
        </div>

    </div>

    {{-- Live prijsberekening --}}
    <script>
        const prijsPerPersoon = {{ $accommodatie->TotaalPrijs }};
        const passagiersInput = document.getElementById('passagiersInput');
        const totaalPrijsEl = document.getElementById('totaalPrijs');

        function updatePrijs() {
            const aantal = parseInt(passagiersInput.value) || 0;
            const totaal = prijsPerPersoon * aantal;
            totaalPrijsEl.textContent = "€" + totaal.toFixed(2).replace('.', ',');
        }

        passagiersInput.addEventListener('input', updatePrijs);
        updatePrijs();
    </script>

</x-app-layout>