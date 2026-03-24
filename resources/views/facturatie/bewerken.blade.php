<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ _('Factuur Bijwerken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Factuur Gegevens</h3>
                </div>

                <div class="px-4 py-6 sm:px-6">
                    <form action="{{ route('facturatie.wijzigen', $factuur->Id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="passagier_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Passagier
                            </label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('passagier_id') border-red-500 @enderror"
                                id="passagier_id" name="passagier_id" required>
                                <option value="">Selecteer een passagier</option>
                                @foreach($passagiers as $passagier)
                                    <option value="{{ $passagier->Id }}" {{ old('passagier_id', $factuur->PassagierId) == $passagier->Id ? 'selected' : '' }}>
                                        {{ $passagier->Persoon->Voornaam }} {{ $passagier->Persoon->Achternaam }}
                                    </option>
                                @endforeach
                            </select>
                            @error('passagier_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="factuurdatum"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Factuurdatum
                            </label>
                            <input type="date"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('factuurdatum') border-red-500 @enderror"
                                id="factuurdatum" name="factuurdatum"
                                value="{{ old('factuurdatum', $factuur->Factuurdatum) }}" required>
                            @error('factuurdatum')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bedrag" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Totaal Bedrag
                            </label>
                            <input type="number" step="0.01" inputmode="decimal"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('bedrag') border-red-500 @enderror"
                                id="bedrag" name="bedrag" value="{{ old('bedrag', $factuur->Bedrag) }}" required
                                min="0">
                            @error('bedrag')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="betaalmethode"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Betaalmethode
                            </label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('betaalmethode') border-red-500 @enderror"
                                id="betaalmethode" name="betaalmethode" required>
                                <option value="">Selecteer een betaalmethode</option>
                                <option value="Creditcard" {{ old('betaalmethode', $factuur->Betaalmethode) == 'Creditcard' ? 'selected' : '' }}>Creditcard</option>
                                <option value="Bankoverschrijving" {{ old('betaalmethode', $factuur->Betaalmethode) == 'Bankoverschrijving' ? 'selected' : '' }}>
                                    Bankoverschrijving</option>
                                <option value="Contant" {{ old('betaalmethode', $factuur->Betaalmethode) == 'Contant' ? 'selected' : '' }}>Contant</option>
                            </select>
                            @error('betaalmethode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Opslaan
                            </button>
                            <a href="{{ route('facturatie.index') }}"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Annuleren
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>