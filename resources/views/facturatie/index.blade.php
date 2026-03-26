<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Facturatie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100">{{ $title }}</span>

                    {!! str_repeat('<br>', 2) !!}

                    @if(session('success'))
                        <div
                            class="p-4 mb-4 text-sm text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-900 dark:text-green-100 dark:border-green-700">
                            {{ session('success') }}
                            <meta http-equiv="refresh" content="3;url={{ route('facturatie.index') }}">
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="p-4 mb-4 text-sm text-red-800 bg-red-100 border border-red-300 rounded-lg dark:bg-red-900 dark:text-red-100 dark:border-red-700">
                            {{ session('error') }}
                            <meta http-equiv="refresh" content="3;url={{ route('facturatie.index') }}">
                        </div>
                    @endif

                    <div class="mt-5 overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full table-fixed border-collapse">
                            <thead class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Boeking</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-48">
                                        Passagier</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Factuurnummer</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-40">
                                        Factuurdatum</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-28">
                                        Bedrag</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Betaalmethode</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32 text-center">
                                        Wijzigen</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32 text-center">
                                        Annuleren</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($facturen as $factuur)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $factuur->Boekingsnummer }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $factuur->PassagierNaam }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $factuur->Factuurnummer }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($factuur->Factuurdatum)->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">€
                                            {{ number_format($factuur->TotaalBedrag, 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $factuur->Betaalstatus }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $factuur->Betaalmethode }}
                                        </td>
                                        <td class="px-4 py-3 text-xl text-center text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('facturatie.bewerken', ['id' => $factuur->Id]) }}">
                                                <i class="bi bi-pencil-square text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"></i>
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-xl text-center text-gray-900 dark:text-gray-100">
                                            <button type="button" onclick="openDeleteModal({{ $factuur->Id }})"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">Geen
                                            facturen gevonden.
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

    {{-- 🟢 MODAL voor Annuleren --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    
        {{-- 🟢 Modal box --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
    
            {{-- 🟢 Titel --}}
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Annuleren bevestigen
            </h2>
    
            {{-- 🟢 Uitleg --}}
            <p class="text-gray-700 dark:text-gray-300 mb-3">
                Voer de annuleercode in om deze factuur definitief te annuleren.
            </p>
    
            {{-- 🟢 Verwijdercode --}}
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Code: <strong>ANNULEREN</strong>
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
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Terug
                </button>
    
                {{-- 🟢 Annuleren bevestigen --}}
                <button onclick="submitDelete()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Annuleren
                </button>
            </div>
    
        </div>
    </div>
    
    {{-- 🟢 JavaScript voor modal + annuleren --}}
    <script>
        let deleteId = null; // 🟢 Slaat ID op van te annuleren factuur

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