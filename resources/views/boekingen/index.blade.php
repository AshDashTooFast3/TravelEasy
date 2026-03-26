{{-- 🟢 Wrapper component voor de app layout (basis layout van de pagina) --}}
<x-app-layout>

    {{-- 🟢 Header slot waarin de titel van de pagina wordt gezet --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Boekingen {{-- 🟢 Titel van de pagina --}}
        </h2>
    </x-slot>

    {{-- 🟢 Hoofdcontainer met padding --}}
    <div class="py-12">
        {{-- 🟢 Centreren en maximale breedte instellen --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🟢 Kaart/container met achtergrond en schaduw --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- 🟢 Binnenste padding en border --}}
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    {{-- 🟢 Titel + knop naast elkaar --}}
                    <div class="flex items-center justify-between">
                        <span class="text-gray-900 dark:text-gray-100 text-lg font-semibold">
                            Overzicht van alle boekingen {{-- 🟢 Subtitel --}}
                        </span>

                        {{-- 🟢 Knop om nieuwe boeking aan te maken --}}
                        <a href="{{ route('boekingen.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition">
                            + Boeking toevoegen
                        </a>
                    </div>

                    {{-- 🟢 Kleine spacing (1 lege regel) --}}
                    {!! str_repeat('<br>', 1) !!}

                    {{-- 🟢 Tabel container met scroll als nodig --}}
                    <div class="mt-5 overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">

                        {{-- 🟢 Tabel met vaste kolombreedtes --}}
                        <table class="min-w-full table-fixed border-collapse">

                            {{-- 🟢 Tabel header --}}
                            <thead class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    {{-- 🟢 Kolomnamen --}}
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">Boekingsnr</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">Vlucht</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-40">Bestemming</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-48">Accommodatie</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-40">Datum</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-40">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-28">Prijs</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-20">Wijzigen</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-20">Verwijderen</th>
                                </tr>
                            </thead>

                            {{-- 🟢 Tabel body --}}
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                {{-- 🟢 Loop door alle boekingen --}}
                                @forelse($boekingen as $boeking)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                                        {{-- 🟢 Boekingsnummer --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->Boekingsnummer }}
                                        </td>

                                        {{-- 🟢 Vluchtnummer via relatie --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->vlucht->Vluchtnummer }}
                                        </td>

                                        {{-- 🟢 Bestemming (land + luchthaven) --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->vlucht->bestemming->Land }}
                                            ({{ $boeking->vlucht->bestemming->Luchthaven }})
                                        </td>

                                        {{-- 🟢 Accommodatie info --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->accommodatie->Naam }}<br>
                                            <span class="text-gray-600 dark:text-gray-400 text-xs">
                                                {{ $boeking->accommodatie->Stad }},
                                                {{ $boeking->accommodatie->Land }}
                                            </span>
                                        </td>

                                        {{-- 🟢 Datum en tijd formatteren --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($boeking->Boekingsdatum)->format('d-m-Y') }}
                                            <br>
                                            <span class="text-gray-600 dark:text-gray-400 text-xs">
                                                {{ $boeking->Boekingstijd }}
                                            </span>
                                        </td>

                                        {{-- 🟢 Status met dynamische kleur --}}
                                        <td class="px-4 py-3 text-sm text-gray-100">
                                            <span class="px-3 py-1 rounded-full text-xs text-white
                                                @if(strtolower($boeking->Boekingsstatus) === 'bevestigd') bg-green-600
                                                @elseif(strtolower($boeking->Boekingsstatus) === 'geannuleerd') bg-red-600
                                                @elseif(strtolower($boeking->Boekingsstatus) === 'in behandeling') bg-yellow-600
                                                @else bg-gray-600 @endif">
                                                {{ $boeking->Boekingsstatus }}
                                            </span>
                                        </td>

                                        {{-- 🟢 Prijs formatteren naar euro --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            €{{ number_format($boeking->TotaalPrijs, 2, ',', '.') }}
                                        </td>

                                        {{-- 🟢 Bewerken knop --}}
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('boekingen.edit', $boeking->Id) }}"
                                               class="text-blue-500 hover:text-blue-700">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>

                                        {{-- 🟢 Verwijderen knop (opent modal) --}}
                                        <td class="px-4 py-3 text-center">
                                            <button onclick="openDeleteModal({{ $boeking->Id }})"
                                                    class="text-red-500 hover:text-red-700">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </td>

                                    </tr>

                                {{-- 🟢 Als er geen boekingen zijn --}}
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-3 text-center text-gray-900 dark:text-gray-100">
                                            Geen boekingen gevonden.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- 🟢 MODAL voor verwijderen --}}
    <div id="deleteModal"
         class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

        {{-- 🟢 Modal box --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">

            {{-- 🟢 Titel --}}
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Verwijderen bevestigen
            </h2>

            {{-- 🟢 Uitleg --}}
            <p class="text-gray-700 dark:text-gray-300 mb-3">
                Voer de verwijdercode in om deze boeking definitief te verwijderen.
            </p>

            {{-- 🟢 Verwijdercode --}}
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Code: <strong>VERWIJDEREN</strong>
            </p>

            {{-- 🟢 Meldingen (success/fout) --}}
            <div id="modalMessage" class="hidden mb-4 p-2 rounded text-sm"></div>

            {{-- 🟢 Input veld voor code --}}
            <input type="text" id="confirmCodeInput"
                   class="w-full rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white p-2 mb-4"
                   placeholder="Voer de code in">

            {{-- 🟢 Knoppen --}}
            <div class="flex justify-end gap-3">
                {{-- 🟢 Annuleren --}}
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Annuleren
                </button>

                {{-- 🟢 Verwijderen bevestigen --}}
                <button onclick="submitDelete()"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Verwijderen
                </button>
            </div>

        </div>
    </div>

    {{-- 🟢 JavaScript voor modal + verwijderen --}}
    <script>
        let deleteId = null; // 🟢 Slaat ID op van te verwijderen boeking

        function openDeleteModal(id) {
            deleteId = id; // 🟢 Zet ID
            document.getElementById('modalMessage').classList.add('hidden'); // 🟢 Reset melding
            document.getElementById('confirmCodeInput').value = ""; // 🟢 Leeg input

            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden'); // 🟢 Toon modal
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden'); // 🟢 Verberg modal
            modal.classList.remove('flex');
        }

        function submitDelete() {
            const code = document.getElementById('confirmCodeInput').value; // 🟢 Haal ingevoerde code op
            const messageBox = document.getElementById('modalMessage'); // 🟢 Meldingen box

            // 🟢 Verstuur DELETE request naar backend
            fetch(`/boekingen/${deleteId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // 🟢 Laravel CSRF beveiliging
                },
                body: JSON.stringify({ confirm_code: code }) // 🟢 Stuur code mee
            })
            .then(async response => {
                const data = await response.json();

                if (!response.ok) {
                    // 🟢 Foutmelding tonen
                    messageBox.textContent = data.message;
                    messageBox.className = "mb-4 p-2 rounded text-sm bg-red-600 text-white";
                    messageBox.classList.remove("hidden");
                    return;
                }

                // 🟢 Succesmelding tonen
                messageBox.textContent = data.message;
                messageBox.className = "mb-4 p-2 rounded text-sm bg-green-600 text-white";
                messageBox.classList.remove("hidden");

                // 🟢 Sluit modal en refresh pagina
                setTimeout(() => {
                    closeDeleteModal();
                    window.location.reload();
                }, 2000);
            })
            .catch(error => console.error(error)); // 🟢 Error loggen
        }
    </script>

</x-app-layout>