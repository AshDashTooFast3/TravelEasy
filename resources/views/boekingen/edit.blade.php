<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Boeking wijzigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    {{-- 🟢 Succesmelding --}}
                    @if(session('success'))
                        <div id="successMessage" class="mb-4 p-3 bg-green-600 text-white rounded">
                            {{ session('success') }}
                        </div>

                        <script>
                            setTimeout(function() {
                                window.location.href = "{{ route('boekingen.index') }}";
                            }, 2500);
                        </script>
                    @endif

                    {{-- 🔴 Foutmeldingen --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-600 text-white rounded">
                            <ul class="list-disc ml-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold text-gray-200 mb-4">
                        Wijzig boeking: {{ $boeking->Boekingsnummer }}
                    </h3>

                    <form method="POST" action="{{ route('boekingen.update', $boeking->Id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Boekingsnummer --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Boekingsnummer</label>
                            <input type="text" name="Boekingsnummer"
                                   value="{{ old('Boekingsnummer', $boeking->Boekingsnummer) }}"
                                   class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                        </div>

                        {{-- Vlucht --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Vlucht</label>
                            <select name="VluchtId"
                                    class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                                @foreach($vluchten as $vlucht)
                                    <option value="{{ $vlucht->Id }}"
                                        {{ $vlucht->Id == $boeking->VluchtId ? 'selected' : '' }}>
                                        {{ $vlucht->Vluchtnummer }} — {{ $vlucht->bestemming->Land }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Accommodatie --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Accommodatie</label>
                            <select name="AccommodatieId"
                                    class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                                @foreach($accommodaties as $acc)
                                    <option value="{{ $acc->Id }}"
                                        {{ $acc->Id == $boeking->AccommodatieId ? 'selected' : '' }}>
                                        {{ $acc->Naam }} — {{ $acc->Stad }}, {{ $acc->Land }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Datum --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Boekingsdatum</label>
                            <input type="date" name="Boekingsdatum"
                                   value="{{ old('Boekingsdatum', $boeking->Boekingsdatum) }}"
                                   class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                        </div>

                        {{-- Tijd --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Boekingstijd</label>
                            <input type="time" name="Boekingstijd"
                                   value="{{ old('Boekingstijd', $boeking->Boekingstijd) }}"
                                   class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Boekingsstatus</label>
                            <select name="Boekingsstatus"
                                    class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                                <option value="Bevestigd" {{ $boeking->Boekingsstatus === 'Bevestigd' ? 'selected' : '' }}>Bevestigd</option>
                                <option value="Geannuleerd" {{ $boeking->Boekingsstatus === 'Geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                                <option value="In behandeling" {{ $boeking->Boekingsstatus === 'In behandeling' ? 'selected' : '' }}>In behandeling</option>
                            </select>
                        </div>

                        {{-- Prijs --}}
                        <div class="mb-4">
                            <label class="block text-gray-300 mb-1">Totaalprijs (€)</label>
                            <input type="number" step="0.01" name="TotaalPrijs"
                                   value="{{ old('TotaalPrijs', $boeking->TotaalPrijs) }}"
                                   class="w-full rounded-lg bg-gray-700 text-white border-gray-600">
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-between mt-6">
                            <a href="{{ route('boekingen.index') }}"
                               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                                Annuleren
                            </a>

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Wijzigingen opslaan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
