<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SmilePro</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-900 mt-20">

    <!-- Hero Sectie -->
    <div class="mx-auto max-w-xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-balance text-white sm:text-6xl">SmilePro</h1>
        <p class="mt-6 text-lg font-medium text-pretty text-gray-400 sm:text-xl">
            SmilePro is dé specialist in tandheelkundige zorg en esthetiek. Log in om onze innovatieve behandelingen te bekijken en direct een afspraak te maken voor een stralende glimlach!
        </p>
        <h3 class="text-2xl font-bold text-white mt-8 mb-4">Log in om verder te gaan met onze website</h3>
        <div class="mt-8 flex items-center justify-center gap-x-4">
            <a href="/login"
                class="rounded-md bg-indigo-500 px-5 py-3 text-base font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Log in</a>
            <a href="/register" class="text-base font-semibold text-white">Account aanmaken <span
                    aria-hidden="true">→</span></a>
        </div>
            <img src="{{ asset('img/smilepro-logo.png') }}" alt="SmilePro-logo" class="mx-auto h-25 w-auto" />
    </div>

    <!-- Sectie met extra info -->
    <div class="mx-auto max-w-6xl py-12">
        <h2 class="text-3xl font-bold text-white text-center mb-10">Waarom SmilePro?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Infokaart 1 -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=600&q=80" alt="Professionele zorg"
                    class="mb-4 rounded-lg h-40 w-full object-cover">
                <h3 class="text-xl font-semibold text-white mb-2">Professionele zorg</h3>
                <p class="text-gray-400 text-center">Ons team bestaat uit ervaren tandartsen en mondhygiënisten die werken met de nieuwste technieken voor optimale mondgezondheid.</p>
            </div>
            <!-- Infokaart 2 -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Esthetische behandelingen"
                    class="mb-4 rounded-lg h-40 w-full object-cover">
                <h3 class="text-xl font-semibold text-white mb-2">Esthetische behandelingen</h3>
                <p class="text-gray-400 text-center">Van tanden bleken tot facings: SmilePro biedt diverse cosmetische behandelingen voor een zelfverzekerde lach. Log in om alle mogelijkheden te ontdekken!</p>
            </div>
            <!-- Infokaart 3 -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=600&q=80"
                    alt="Persoonlijke aandacht" class="mb-4 rounded-lg h-40 w-full object-cover">
                <h3 class="text-xl font-semibold text-white mb-2">Persoonlijke aandacht</h3>
                <p class="text-gray-400 text-center">Wij luisteren naar jouw wensen en stellen samen een behandelplan op dat bij jou past. Log in en ervaar onze persoonlijke service!</p>
            </div>
        </div>
    </div>

    <!-- TailwindPlus Script -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

</body>

</html>
