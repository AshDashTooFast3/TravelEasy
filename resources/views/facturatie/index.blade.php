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

                    <div class="mt-5 overflow-x-auto rounded-lg border border-gray-700">
                        <table class="min-w-full table-fixed border-collapse">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-32">Boeking</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-48">Passagier</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-32">Factuurnummer</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-40">Factuurdatum</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-28">Bedrag</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-32">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white w-32">Betaalmethode</th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse($facturen as $factuur)
                                    <tr class="hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $factuur->Boekingsnummer }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $factuur->PassagierNaam }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $factuur->Factuurnummer }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">
                                            {{ \Carbon\Carbon::parse($factuur->Factuurdatum)->format('d-m-Y H:i') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">€
                                            {{ number_format($factuur->TotaalBedrag, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $factuur->Betaalstatus }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-100">{{ $factuur->Betaalmethode }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-gray-400">Geen facturen gevonden.
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
    </div>
</x-app-layout>