<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class TicketController extends Controller
{
public function index()
{
    $tickets = Ticket::with(['vlucht'])
        ->where('PassagierId', 1) // vaste passagier
        ->orderBy('Datumaangemaakt', 'desc')
        ->get();

    return view('ticket.index', compact('tickets'));
}

public function show($id)
{
    $ticket = Ticket::with(['vlucht'])
        ->where('PassagierId', 1) // vaste passagier
        ->findOrFail($id);

    return view('ticket.show', compact('ticket'));
}
}