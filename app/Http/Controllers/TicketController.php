<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Passagier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Toon alle tickets van de ingelogde gebruiker.
     */
    public function index()
    {
        // Passagier ophalen
        $passagier = Auth::user()->passagier;

        // Als gebruiker nog geen passagier is → geen tickets
        if (!$passagier) {
            return view('ticket.index', [
                'tickets' => collect(), // lege lijst
            ]);
        }

        // Tickets ophalen
        $tickets = Ticket::where('PassagierId', $passagier->Id)
            ->with(['vlucht'])
            ->get();

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Toon één ticket.
     */
    public function show($id)
    {
        $passagier = Auth::user()->passagier;

        if (!$passagier) {
            abort(403, 'Geen toegang tot dit ticket.');
        }

        // Ticket ophalen
        $ticket = Ticket::where('Id', $id)
            ->where('PassagierId', $passagier->Id)
            ->with(['vlucht'])
            ->firstOrFail();

        return view('ticket.show', compact('ticket'));
    }

    /**
     * Verwijder een ticket.
     */
    public function destroy($id)
    {
        $passagier = Auth::user()->passagier;

        if (!$passagier) {
            abort(403, 'Geen toegang tot dit ticket.');
        }

        // Ticket ophalen
        $ticket = Ticket::where('Id', $id)
            ->where('PassagierId', $passagier->Id)
            ->firstOrFail();

        $ticket->delete();

        return redirect()->route('ticket.index')
            ->with('success', 'Ticket succesvol verwijderd.');
    }
}