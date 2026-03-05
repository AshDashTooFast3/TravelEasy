<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Mijn Tickets
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto">

        <div class="bg-gray-800 p-6 rounded-lg shadow text-white">
            <h3 class="text-lg font-semibold mb-4">Overzicht van mijn tickets</h3>

            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-2">Ticket</th>
                        <th>Vlucht</th>
                        <th>Datum</th>
                        <th>Prijs</th>
                        <th>Acties</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tickets as $ticket)
@foreach(explode('|', $ticket->Stoelnummer) as $stoel)
    <span class="bg-gray-700 px-2 py-1 rounded text-sm mr-1">
        {{ $stoel }}
    </span>
@endforeach
                            <td>
                                {{ $ticket->vlucht->Vluchtnummer ?? 'Onbekend' }}
                            </td>

                            <td>
                                {{ $ticket->Aankoopdatum }}
                            </td>

                            <td>
                                €{{ number_format($ticket->BedragInclBtw, 2, ',', '.') }}
                            </td>

                            <td class="py-2">
                                <a href="{{ route('ticket.show', $ticket->Id) }}"
                                   class="bg-green-600 hover:bg-green-500 text-white px-3 py-1 rounded-md text-sm">
                                    Bekijken
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-400">
                                Je hebt nog geen tickets.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>