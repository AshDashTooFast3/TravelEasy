<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ _('Facturatie') }}
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
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">Geen
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
</x-app-layout>