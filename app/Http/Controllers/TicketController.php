<?php

namespace App\Http\Controllers;

use App\Models\GeboekteReis;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
public function index()
{
    $user = auth()->user();

    
    $persoon = $user->personen->first();

    if (!$persoon) {
        abort(403, 'Geen persoon gekoppeld aan dit account.');
    }

  
    $passagier = $persoon->patient;

    if (!$passagier) {
        abort(403, 'Geen passagier gekoppeld aan dit account.');
    }

    $tickets = Ticket::with(['vlucht'])
        ->where('PassagierId', $passagier->Id)
        ->orderBy('Datumaangemaakt', 'desc')
        ->get();

    $tickets->each(function ($ticket) {
        $ticket->Vluchtstatus = $ticket->vlucht->Vluchtstatus
            ?? GeboekteReis::where('TicketId', $ticket->Id)->value('Vluchtstatus')
            ?? 'Onbekend';
    });

    return view('ticket.index', compact('tickets'));
}

public function show($id)
{
    $user = auth()->user();
    $persoon = $user->personen->first();
    $passagier = $persoon->patient;

    $ticket = Ticket::with(['vlucht'])
        ->where('PassagierId', $passagier->Id)
        ->findOrFail($id);

    $ticket->Vluchtstatus = $ticket->vlucht->Vluchtstatus
        ?? GeboekteReis::where('TicketId', $ticket->Id)->value('Vluchtstatus')
        ?? 'Onbekend';

    return view('ticket.show', compact('ticket'));
}

public function destroy($id)
{
    $user = auth()->user();
    $persoon = $user->personen->first();
    $passagier = $persoon->patient;

    $ticket = Ticket::with(['vlucht'])
        ->where('PassagierId', $passagier->Id)
        ->findOrFail($id);

    $status = strtolower(trim((string) (
        $ticket->vlucht->Vluchtstatus
        ?? GeboekteReis::where('TicketId', $ticket->Id)->value('Vluchtstatus')
        ?? ''
    )));

    if (!in_array($status, ['geland', 'geannuleerd'])) {
        return redirect()->route('ticket.index')
            ->with('error', 'Je kunt alleen tickets verwijderen met status Geland of Geannuleerd.');
    }

    DB::transaction(function () use ($ticket) {
        GeboekteReis::where('TicketId', $ticket->Id)->delete();

        $ticket->delete();
    });

    return redirect()->route('ticket.index')
        ->with('success', 'Ticket succesvol verwijderd.');
}
}