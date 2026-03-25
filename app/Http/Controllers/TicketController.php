<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

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

    return view('ticket.show', compact('ticket'));
}
}