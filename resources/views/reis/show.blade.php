<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Reis Details
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">

        <div class="bg-gray-800 p-6 rounded-lg shadow text-white">
            <h3 class="text-lg font-semibold mb-4">Reis #{{ $boeking->Id }}</h3>

            <p><strong>Vlucht:</strong> {{ $boeking->vlucht->Vluchtnummer ?? 'Onbekend' }}</p>
            <p><strong>Bestemming:</strong> {{ $boeking->accommodatie->Naam ?? 'Onbekend' }}</p>
            <p><strong>Datum:</strong> {{ $boeking->Boekingsdatum }}</p>
            <p><strong>Prijs:</strong> €{{ number_format($boeking->TotaalPrijs, 2, ',', '.') }}</p>

            <a href="{{ route('reis.index') }}"
               class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded text-white">
                Terug naar overzicht
            </a>
        </div>

    </div>
</x-app-layout>