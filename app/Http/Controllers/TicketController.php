<?php

namespace App\Http\Controllers;

use App\Models\GeboekteReis;
use App\Models\Passagier;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TicketController extends Controller
{
    // MVC/Security: resolve passagier op basis van ingelogde gebruiker.
    private function resolvePassagierForCurrentUser(): ?Passagier
    {
        $user = auth()->user();

        if (!$user) {
            return null;
        }

        $persoon = $user->personen->first();

        if (!$persoon) {
            return null;
        }

        return $persoon->patient;
    }

    // Join/relatie-fallback: status uit Vlucht, anders uit geboekte_reizen.
    private function resolveVluchtstatusForTicket(Ticket $ticket): string
    {
        return $ticket->vlucht->Vluchtstatus
            ?? GeboekteReis::where('TicketId', $ticket->Id)->value('Vluchtstatus')
            ?? 'Onbekend';
    }

    public function index()
    {
        // Security: alleen tickets van de eigen passagier ophalen.
        $passagier = $this->resolvePassagierForCurrentUser();

        if (!$passagier) {
            return redirect()->route('reis.index')
                ->with('error', 'Geen passagier gekoppeld aan dit account.');
        }

        $tickets = Ticket::with(['vlucht'])
            ->where('PassagierId', $passagier->Id)
            ->orderBy('Datumaangemaakt', 'desc')
            ->get();

        $tickets->each(function ($ticket) {
            $ticket->Vluchtstatus = $this->resolveVluchtstatusForTicket($ticket);
        });

        return view('ticket.index', compact('tickets'));
    }

    public function show($id)
    {
        // Security: detailpagina alleen voor eigen ticket.
        $passagier = $this->resolvePassagierForCurrentUser();

        if (!$passagier) {
            return redirect()->route('reis.index')
                ->with('error', 'Geen passagier gekoppeld aan dit account.');
        }

        $ticket = Ticket::with(['vlucht'])
            ->where('PassagierId', $passagier->Id)
            ->findOrFail($id);

        $ticket->Vluchtstatus = $this->resolveVluchtstatusForTicket($ticket);

        return view('ticket.show', compact('ticket'));
    }

    public function destroy($id)
    {
        // Security: delete alleen in eigen passagier-context.
        $passagier = $this->resolvePassagierForCurrentUser();

        if (!$passagier) {
            return redirect()->route('ticket.index')
                ->with('error', 'Geen passagier gekoppeld aan dit account.');
        }

        $ticket = Ticket::with(['vlucht'])
            ->where('PassagierId', $passagier->Id)
            ->findOrFail($id);

        $status = strtolower(trim((string) $this->resolveVluchtstatusForTicket($ticket)));

        // Business-validatie: verwijderen alleen toegestaan bij Geland/Geannuleerd.
        if (!in_array($status, ['geland', 'geannuleerd'])) {
            return redirect()->route('ticket.index')
                ->with('error', 'Je kunt alleen tickets verwijderen met status Geland of Geannuleerd.');
        }

        // Try/catch + transaction: afhankelijke data en ticket atomisch verwijderen.
        try {
            DB::transaction(function () use ($ticket) {
                GeboekteReis::where('TicketId', $ticket->Id)->delete();
                $ticket->delete();
            });
        } catch (Throwable $e) {
            // Technische log voor foutanalyse in productie.
            Log::error('Fout bij verwijderen van ticket', [
                'ticket_id' => $ticket->Id,
                'passagier_id' => $passagier->Id,
                'error' => $e->getMessage(),
            ]);

            // Functionele terugkoppeling voor eindgebruiker.
            return redirect()->route('ticket.index')
                ->with('error', 'Ticket verwijderen is mislukt. Probeer het opnieuw.');
        }

        return redirect()->route('ticket.index')
            ->with('success', 'Ticket succesvol verwijderd.');
    }
}