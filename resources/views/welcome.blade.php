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
        <h1 class="text-4xl font-bold tracking-tight text-balance text-white sm:text-6xl">TravelEasy</h1>
        <p class="mt-6 text-lg font-medium text-pretty text-gray-400 sm:text-xl">
            TravelEasy is dé specialist in reisadvies en reisbegeleiding. Log in om onze innovatieve reisproducten te
            bekijken en direct een afspraak te maken voor een onvergetelijke reis!
        </p>
        <h3 class="text-2xl font-bold text-white mt-8 mb-4">Log in om verder te gaan met onze website</h3>
        <div class="mt-8 flex items-center justify-center gap-x-4">
            @if (Auth::check() === true)
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit"
                        class="rounded-md bg-indigo-500 px-5 py-3 text-base font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Uitloggen
                    </button>
                </form>
            @else
                <a href="/login"
                    class="rounded-md bg-indigo-500 px-5 py-3 text-base font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Inloggen
                </a>
            @endif
            <a href="/register" class="text-base font-semibold text-white">
                Account aanmaken
            </a>
        </div>
        <img src="{{ asset('img/traveleasy-logo-groot.png') }}" alt="TravelEasy-logo" class="mx-auto h-25 w-auto" />
    </div>

    <!-- Sectie met extra info -->
    <div class="mx-auto max-w-6xl py-12">
        <h2 class="text-3xl font-bold text-white text-center mb-10">Waarom TravelEasy?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Infokaart 1 -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=600&q=80"
                    alt="Expert reisadvies" class="mb-4 rounded-lg h-40 w-full object-cover">
                <h3 class="text-xl font-semibold text-white mb-2">Expert reisadvies</h3>
                <p class="text-gray-400 text-center">Ons team bestaat uit ervaren reisadviseurs die je helpen de
                    perfecte bestemming te kiezen met persoonlijk reisadvies.</p>
            </div>
            <!-- Infokaart 2 -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=600&q=80"
                    alt="Maatwerk reistours" class="mb-4 rounded-lg h-40 w-full object-cover">
                <h3 class="text-xl font-semibold text-white mb-2">Maatwerk reistours</h3>
                <p class="text-gray-400 text-center">Van strandvakanties tot avontuurlijke trekkings: TravelEasy biedt
                    diverse reisproducten voor elke reizigers. Log in om onze aanbiedingen te zien!</p>
            </div>
            <!-- Infokaart 3 -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80"
                    alt="24/7 reisbegeleiding" class="mb-4 rounded-lg h-40 w-full object-cover">
                <h3 class="text-xl font-semibold text-white mb-2">24/7 reisbegeleiding</h3>
                <p class="text-gray-400 text-center">Wij ondersteunen je voor, tijdens en na je reis. Log in en geniet
                    van onafgebroken reisbegeleiding en klantenservice!</p>
            </div>
        </div>
    </div>

    <!-- TailwindPlus Script -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

</body>

</html>