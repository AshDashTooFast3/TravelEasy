<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            🎴 Charmander Kaart Uitdaging
        </h2>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto px-4">
        <div class="bg-gray-800 text-white p-8 rounded-xl shadow-lg space-y-6">

            {{-- Title --}}
            <div class="text-center space-y-2">
                <p class="text-4xl">🎴</p>
                <h1 class="text-2xl font-bold">Raad het getal – win de zeldzame Charmander kaart!</h1>
                <p class="text-gray-300 text-sm">
                    Een man heeft een getal tussen <strong>{{ $min }}</strong> en
                    <strong>{{ number_format($max, 0, ',', '.') }}</strong> in gedachten.
                    Raad het correct en de kaart is van jou. Je hebt maar één kans.
                </p>
            </div>

            {{-- Reasoning box (always visible) --}}
            <div class="bg-gray-700 rounded-lg p-5 space-y-3 text-sm">
                <h2 class="font-semibold text-base text-yellow-400">🧮 Logica & Psychologie</h2>

                <p>
                    <strong>Gouden ratio (φ)</strong><br>
                    φ⁻¹ = (√5 − 1) ÷ 2 ≈ <span class="text-yellow-300">0,61803</span><br>
                    0,61803 × 100&nbsp;000 = <span class="text-yellow-300 font-bold">61&nbsp;803</span>
                </p>

                <p>
                    <strong>Waarom 61&nbsp;803?</strong>
                </p>
                <ul class="list-disc list-inside space-y-1 text-gray-300">
                    <li>Mensen vermijden ronde getallen (50&nbsp;000) en extremen (1 of 100&nbsp;000).</li>
                    <li>Het bovenste middenbereik (60&nbsp;000–70&nbsp;000) voelt "willekeurig" maar doordacht aan.</li>
                    <li>61&nbsp;803 is een <em>Schelling-focuspunt</em>: twee rationele spelers die onafhankelijk redeneren komen hier samen uit.</li>
                    <li>De gouden ratio is universeel herkenbaar en daarmee de meest waarschijnlijke keuze voor iemand die wiskundig denkt.</li>
                </ul>

                <p class="text-gray-400 italic text-xs">
                    "Als jij en de man allebei rationeel redeneren, kies je allebei 61&nbsp;803."
                </p>
            </div>

            {{-- Result (only shown after a guess) --}}
            @isset($guess)
                @if ($won)
                    <div class="bg-green-700 border border-green-500 rounded-lg p-5 text-center space-y-2">
                        <p class="text-3xl">🏆🎉</p>
                        <p class="text-xl font-bold">Gefeliciteerd! Jij hebt gewonnen!</p>
                        <p>Je raadde <strong>{{ number_format($guess, 0, ',', '.') }}</strong> — dat is precies het geheime getal.</p>
                        <p class="text-green-200">De zeldzame Charmander kaart is van jou! 🔥</p>
                    </div>
                @else
                    <div class="bg-red-800 border border-red-500 rounded-lg p-5 text-center space-y-2">
                        <p class="text-3xl">❌</p>
                        <p class="text-xl font-bold">Helaas, dat is niet het juiste getal.</p>
                        <p>Jouw gok: <strong>{{ number_format($guess, 0, ',', '.') }}</strong></p>
                        <p>Het geheime getal was: <strong class="text-yellow-300">{{ number_format($secret, 0, ',', '.') }}</strong></p>
                        <p class="text-red-200 text-sm">De gouden ratio had je kunnen helpen. Probeer het opnieuw!</p>
                    </div>
                @endif
            @endisset

            {{-- Guess form --}}
            <form method="POST" action="{{ route('numbergame.guess') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="number" class="block text-sm font-medium text-gray-300 mb-1">
                        Jouw getal ({{ $min }} – {{ number_format($max, 0, ',', '.') }})
                    </label>
                    <input
                        type="number"
                        id="number"
                        name="number"
                        min="{{ $min }}"
                        max="{{ $max }}"
                        placeholder="bijv. 61803"
                        value="{{ old('number', isset($guess) ? $guess : '') }}"
                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        required
                    >
                    @error('number')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold py-3 rounded-lg transition"
                >
                    🎯 Doe mijn gok!
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
