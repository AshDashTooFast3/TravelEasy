<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Nieuwe Reis Boeken
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-gray-800 p-6 rounded-lg shadow text-white">
            <h3 class="text-lg font-semibold mb-4">Boek een nieuwe reis</h3>

            <form action="{{ route('reis.store') }}" method="POST">
                @csrf

                {{-- Vlucht --}}
                <div class="mb-4">
                    <label class="block mb-1">Kies een vlucht</label>
                    <select name="VluchtId" class="w-full bg-gray-700 text-white p-2 rounded">
                        @foreach ($vluchten as $vlucht)
                            <option value="{{ $vlucht->Id }}">
                                {{ $vlucht->Vluchtnummer }} — {{ $vlucht->Vertrekdatum }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Accommodatie --}}
                <div class="mb-4">
                    <label class="block mb-1">Kies een accommodatie</label>
                    <select id="accSelect" name="AccommodatieId" class="w-full bg-gray-700 text-white p-2 rounded">
                        @foreach ($accommodaties as $acc)
                            <option value="{{ $acc->Id }}" data-price="{{ $acc->TotaalPrijs }}">
                                {{ $acc->Naam }} — {{ $acc->Stad }}, {{ $acc->Land }}
                                (Prijs per persoon: €{{ number_format($acc->TotaalPrijs, 2, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Aantal passagiers --}}
                <div class="mb-4">
                    <label class="block mb-1">Aantal passagiers</label>
                    <input id="passagiersInput" type="number" name="AantalPassagiers" min="1"
                           class="w-full bg-gray-700 text-white p-2 rounded"
                           required>
                </div>

                {{-- Totale prijs live berekening --}}
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
        const accSelect = document.getElementById('accSelect');
        const passagiersInput = document.getElementById('passagiersInput');
        const totaalPrijsEl = document.getElementById('totaalPrijs');

        function updatePrijs() {
            const prijsPerPersoon = parseFloat(accSelect.selectedOptions[0].dataset.price);
            const aantal = parseInt(passagiersInput.value) || 0;

            const totaal = prijsPerPersoon * aantal;

            totaalPrijsEl.textContent = "€" + totaal.toFixed(2).replace('.', ',');
        }

        accSelect.addEventListener('change', updatePrijs);
        passagiersInput.addEventListener('input', updatePrijs);
    </script>

</x-app-layout>