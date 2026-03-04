<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ _('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-900 dark:text-gray-100">{{ $title }}</span>
                </div>

                <div
                    class="p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-2xl">
                    <strong>
                        <p class="p-4">
                            Aantal gemaakte boekingen:
                            @if (!empty($aantalBoekingen) && $aantalBoekingen > 0)
                                <span
                                    style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #4F46E5; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    {{ $aantalBoekingen }}
                                </span>
                            @else
                                <span
                                    style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #ffa600ff; color: #fff; text-align: center; line-height: 40px; font-weight: bold; margin-left: 10px;">
                                    0
                                </span>
                                <span style="margin-left: 10px; color: #ffa600ff; dark:text-gray-400;">
                                    er zijn nog geen boekingen gemaakt
                                </span>
                            @endif
                        </p>
                    </strong>
                    <strong>
                        <p class="p-4">
                        <div class="text-2xl font-bold mb-4">Meest geboekte reisbestemmingen:</div>
                        @if (!empty($MeestVoorkomendeReis) && count($MeestVoorkomendeReis) > 0)
                            <div class="space-y-3">
                                @foreach (array_slice($MeestVoorkomendeReis, 0, 5) as $index => $reis)
                                    <div
                                        class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="ml-4 flex-grow">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $reis->VertrekLuchthaven }} ({{ $reis->VertrekLand }}) → {{ $reis->BestemmingLuchthaven }} ({{ $reis->BestemmingLand }})
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <span
                                                class="inline-block px-4 py-2 bg-indigo-500 text-white rounded-full font-bold text-lg">
                                                {{ $reis->AantalBoekingen }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg text-yellow-800 dark:text-yellow-200">
                                Geen gegevens beschikbaar
                            </div>
                        @endif
                        </p>
                    </strong>
                    <br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>