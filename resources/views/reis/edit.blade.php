<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Reis Wijzigen
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-gray-800 p-6 rounded-lg shadow text-white">
            <h3 class="text-lg font-semibold mb-4">Wijzig je reis</h3>

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

            <form action="{{ route('reis.update', $boeking->BoekingId) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Vlucht --}}
                <div class="mb-4">
                    <label class="block mb-1">Vlucht</label>
                    <p class="font-semibold">
                        Vlucht {{ $boeking->vlucht->Vluchtnummer }}
                    </p>

                    {{-- Vluchtstatus --}}
                    <div class="mb-4">
                        <label class="block mb-1">Status</label>
                        <div>
                            <x-status-badge :status="$boeking->Vluchtstatus" type="vluchtstatus" />
                        </div>
                    </div>
                </div>

                {{-- Accommodatie --}}
                <div class="mb-4">
                    <label class="block mb-1">Accommodatie</label>
                    <p class="font-semibold">
                        {{ $boeking->accommodatie->Naam }} — 
                        {{ $boeking->accommodatie->Stad }}, 
                        {{ $boeking->accommodatie->Land }}
                        (Prijs per persoon: €{{ number_format($boeking->accommodatie->TotaalPrijs, 2, ',', '.') }})
                    </p>
                </div>

                {{-- Aantal passagiers --}}
                <div class="mb-4">
                    <label class="block mb-1">Aantal passagiers</label>
                    <input id="passagiersInput"
                           type="number"
                           name="AantalPassagiers"
                           min="1"
                           max="10"
                           value="{{ $boeking->ticket->Aantal }}"
                           class="w-full bg-gray-700 text-white p-2 rounded"
                           required>
                </div>

                {{-- Totale prijs --}}
                <div class="mb-4">
                    <p class="text-gray-300 text-sm">Totale prijs:</p>
                    <p id="totaalPrijs" class="text-xl font-bold text-green-400">
                        €{{ number_format($boeking->TotaalPrijs, 2, ',', '.') }}
                    </p>
                </div>

                <button class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded text-white">
                    Wijzigingen Opslaan
                </button>

            </form>
        </div>

    </div>

    {{-- Live prijsberekening --}}
    <script>
        const prijsPerPersoon = {{ $boeking->accommodatie->TotaalPrijs }};
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