{{-- <!-- Header sectie met titelbalk --> --}}
<x-app-layout>
    <x-slot name="header">
        {{-- <!-- Titelbalk: toont "Boekingen" pagina titel --> --}}
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Boekingen') }}
        </h2>
    </x-slot>

    {{-- <!-- Hoofdcontainer met padding en responsieve breedte --> --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- <!-- Witte kaart met schaduw --> --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    {{-- <!-- Pagina titel --> --}}
                    <span class="text-gray-900 dark:text-gray-100 text-lg font-semibold">
                        Overzicht van alle boekingen
                    </span>

                    {{-- <!-- Verticale ruimte --> --}}
                    {!! str_repeat('<br>', 2) !!}


                    {{-- <!-- Scrollbare tabel container --> --}}
                    <div class="mt-5 overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        {{-- <!-- Boekingen tabel --> --}}
                        <table class="min-w-full table-fixed border-collapse">
                            {{-- <!-- Tabelkop met kolom titels --> --}}
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-40">
                                        Boekingsnr</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Vlucht</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-48">
                                        Bestemming</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-48">
                                        Accommodatie</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-40">
                                        Datum</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white w-32">
                                        Prijs</th>
                                </tr>
                            </thead>

                            {{-- <!-- Tabelrijen met boekingsgegevens --> --}}
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($boekingen as $boeking)
                                    {{-- <!-- Elke rij vertegenwoordigt één boeking --> --}}
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                                        {{-- <!-- Boekingsnummer --> --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->Boekingsnummer }}
                                        </td>

                                        {{-- <!-- Vluchtnummer --> --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->vlucht->Vluchtnummer }}
                                        </td>

                                        {{-- <!-- Bestemming land en luchthaven --> --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->vlucht->bestemming->Land }}
                                            ({{ $boeking->vlucht->bestemming->Luchthaven }})
                                        </td>

                                        {{-- <!-- Accommodatienaam met stad en land --> --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $boeking->accommodatie->Naam }}<br>
                                            <span class="text-gray-600 dark:text-gray-400 text-xs">
                                                {{ $boeking->accommodatie->Stad }},
                                                {{ $boeking->accommodatie->Land }}
                                            </span>
                                        </td>

                                        {{-- <!-- Boekingsdatum en tijd --> --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($boeking->Boekingsdatum)->format('d-m-Y') }}<br>
                                            <span class="text-gray-600 dark:text-gray-400 text-xs">
                                                {{ $boeking->Boekingstijd }}
                                            </span>
                                        </td>

                                        {{-- Status badge met kleur --}}
                                        <td class="px-4 py-3 text-sm">
                                            <x-status-badge :status="$boeking->Boekingsstatus" type="boekingsstatus" />
                                        </td>

                                        {{-- <!-- Totale prijs in euro met decimalen --> --}}
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            €{{ number_format($boeking->TotaalPrijs, 2, ',', '.') }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 text-center">
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
</x-app-layout>