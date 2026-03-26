<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Mijn Tickets
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto">

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow dark:text-white">
            <h3 class="text-lg font-semibold mb-4">Overzicht van mijn tickets</h3>

            @if (session('success'))
                <div class="bg-green-600 text-white px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-600 text-white px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-700 dark:border-gray-300">
                        <th class="py-2">Ticket</th>
                        <th>Vlucht</th>
                        <th>Status vlucht</th>
                        <th>Datum</th>
                        <th>Prijs</th>
                        <th>Aantal personen</th> 
                        <th>Acties</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>
                                @foreach(explode('|', $ticket->Stoelnummer) as $stoel)
                                    <span
                                        class="bg-gray-700 dark:bg-gray-200 px-2 py-1 rounded text-sm mr-1 text-white dark:text-gray-900">
                                        {{ $stoel }}
                                    </span>
                                @endforeach
                            </td>

                            <td>
                                {{ $ticket->vlucht->Vluchtnummer ?? 'Onbekend' }}
                            </td>

                            <td>
                                {{ $ticket->Vluchtstatus ?? 'Onbekend' }}
                            </td>

                            <td>
                                {{ $ticket->Aankoopdatum }}
                            </td>

                            <td>
                                €{{ number_format($ticket->BedragInclBtw, 2, ',', '.') }}
                            </td>

                            <td>
                                {{ $ticket->Aantal }} persoon{{ $ticket->Aantal > 1 ? 'en' : '' }}
                            </td>

                            <td class="py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('ticket.show', $ticket->Id) }}"
                                        class="bg-green-600 hover:bg-green-500 dark:bg-green-500 dark:hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                        Bekijken
                                    </a>

                                    <form action="{{ route('ticket.destroy', $ticket->Id) }}" method="POST"
                                          onsubmit="return confirm('Weet je zeker dat je dit ticket wilt verwijderen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">
                                            Verwijderen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-400 dark:text-gray-600">
                                Je hebt nog geen tickets.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>