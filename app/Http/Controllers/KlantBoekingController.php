<?php

namespace App\Http\Controllers;

use App\Models\Accommodatie;
use App\Models\Boeking;
use App\Models\GeboekteReis;
use App\Models\Passagier;
use App\Models\Ticket;
use App\Models\Vlucht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;


class KlantBoekingController extends Controller
{
    // MVC/Security: helper om de passagier te koppelen aan de ingelogde gebruiker.
    // Dit is de basis voor autorisatie op boeking-acties.
    private function resolvePassagierForCurrentUser(): ?Passagier
    {
        $gebruiker = Auth::user();

        if (!$gebruiker) {
            return null;
        }

        return Passagier::whereHas('persoon', function ($q) use ($gebruiker) {
            $q->where('GebruikerId', $gebruiker->Id);
        })->first();
    }

    // Reis overzicht

public function index()
{
    
    $gebruiker = auth()->user();

    // Vluchten + accommodaties altijd tonen
    $vluchten = Vlucht::all();
    $accommodaties = Accommodatie::all();

    // Als NIET ingelogd → geen boekingen tonen, maar wel pagina tonen
    if (!$gebruiker) {
        return view('reis.index', [
            'boekingen' => collect(),
            'vluchten' => $vluchten,
            'accommodaties' => $accommodaties,
        ]);
    }

    // Join via Eloquent-relatie (whereHas): Passagier -> Persoon -> Gebruiker.
    $passagier = Passagier::whereHas('persoon', function ($q) use ($gebruiker) {
        $q->where('GebruikerId', $gebruiker->Id);
    })->first();

    if (!$passagier) {
        $boekingen = collect();
    } else {
        $boekingen = GeboekteReis::with(['vlucht', 'accommodatie', 'ticket'])
    ->where('PassagierId', $passagier->Id)
    ->get();
    }

    return view('reis.index', compact('boekingen', 'vluchten', 'accommodaties'));
}
    // Nieuwe reis boeken
public function create(Request $request)
{
    $vlucht = Vlucht::findOrFail($request->VluchtId);
    $accommodatie = Accommodatie::findOrFail($request->AccommodatieId);

    return view('reis.create', compact('vlucht', 'accommodatie'));
}
    public function store(Request $request)
    
{
    
// Server-side validatie (naast client-side in Blade en DB-constraints).
$request->validate([
   
    'VluchtId' => 'required|integer|exists:Vlucht,Id',
    'AccommodatieId' => 'required|integer|exists:Accommodatie,Id',
    'AantalPassagiers' => 'required|integer|min:1|max:10',
], [
    'AantalPassagiers.max' => 'Je kunt maximaal 10 passagiers per boeking aanmaken.',
]);

    $gebruiker = Auth::user();

    // Try/catch + transaction: alle writes slagen samen of rollen samen terug.
    try {
        DB::transaction(function () use ($request, $gebruiker) {

    // 1. Persoon ophalen of aanmaken
    $persoon = \App\Models\Persoon::firstOrCreate(
        ['GebruikerId' => $gebruiker->Id],
        [
            'Voornaam' => $gebruiker->Gebruikersnaam,
            'Achternaam' => 'Onbekend',
            'Geboortedatum' => '2000-01-01',
            'Isactief' => true,
        ]
    );

    // 2. Passagier ophalen of aanmaken
    $passagier = \App\Models\Passagier::firstOrCreate(
        ['PersoonId' => $persoon->Id],
        [
            'Nummer' => 'P-' . $persoon->Id,
            'PassagierType' => 'Standaard',
            'Isactief' => true,
        ]
    );

    // Vlucht + accommodatie ophalen
    $acc = Accommodatie::findOrFail($request->AccommodatieId);
    $vlucht = Vlucht::findOrFail($request->VluchtId);

    // Prijs per persoon + totaal
    $prijsPerPersoon = $acc->TotaalPrijs;
    $totaalPrijs = $prijsPerPersoon * $request->AantalPassagiers;

    // 3. Boeking aanmaken
$boeking = Boeking::create([
    'PassagierId' => $passagier->Id,   // <-- DIT IS DE FIX
    'VluchtId' => $request->VluchtId,
    'AccommodatieId' => $request->AccommodatieId,
    'Boekingsnummer' => 'BK-' . now()->format('YmdHis'),
    'Boekingsdatum' => now()->toDateString(),
    'Boekingstijd' => now()->toTimeString(),
    'Boekingsstatus' => 'In behandeling',
    'TotaalPrijs' => $totaalPrijs,
    'IsActief' => 1,
]);

// 4. Eén ticket aanmaken met meerdere stoelen
$stoelen = [];

for ($i = 1; $i <= $request->AantalPassagiers; $i++) {
    $stoelen[] = $this->genereerStoelnummer($i);
}

$stoelString = implode('|', $stoelen);

$ticket = Ticket::create([
    'BoekingId' => $boeking->Id, 
    'PassagierId' => $passagier->Id,
    'VluchtId' => $boeking->VluchtId,
    'Stoelnummer' => $stoelString, // A1|A2|A3
    'Aankoopdatum' => now()->toDateString(),
    'Aankooptijd' => now()->toTimeString(),
    'Aantal' => $request->AantalPassagiers, // totaal aantal personen
    'BedragInclBtw' => $totaalPrijs, // prijs voor alle personen
    'Isactief' => true,
    'Opmerking' => null,
    'Datumaangemaakt' => now(),
    'Datumgewijzigd' => now(),
]);
// 5. boeking opslaan en doorsturen naar overzicht
GeboekteReis::create([
    'GebruikerId'   => $gebruiker->Id,
    'PersoonId'     => $persoon->Id,
    'PassagierId'   => $passagier->Id,
    'BoekingId'     => $boeking->Id,
    'TicketId'      => $ticket->Id,
    'VluchtId'      => $vlucht->Id,
    'AccommodatieId'=> $acc->Id,
    'Vluchtstatus'  => $vlucht->Vluchtstatus,
    'Boekingsstatus'=> $boeking->Boekingsstatus,
    'TotaalPrijs'   => $totaalPrijs,
]);
        });
    } catch (Throwable $e) {
        // Technische log voor troubleshooting/audit.
        Log::error('Fout bij aanmaken van een reisboeking', [
            'gebruiker_id' => $gebruiker?->Id,
            'error' => $e->getMessage(),
        ]);

        // Functionele terugkoppeling voor eindgebruiker.
        return redirect()->route('reis.index')
            ->with('error', 'Er is iets misgegaan bij het opslaan van de boeking. Probeer opnieuw.');
    }

    return redirect()->route('reis.index')
        ->with('success', 'Reis succesvol geboekt!');
}

    // Stoelnummer generator
    private function genereerStoelnummer($index)
    {
        $rij = chr(64 + ceil($index / 6)); // A, B, C...
        $stoel = ($index % 6) ?: 6;        // 1 t/m 6

        return $rij.$stoel; // bijv. A1, A2, B1, B2
    }
    // Bewerken
public function edit($id)
{
    // Security: alleen eigen boekingen mogen gewijzigd worden.
    $passagier = $this->resolvePassagierForCurrentUser();

    if (!$passagier) {
        return redirect()->route('reis.index')
            ->with('error', 'Geen passagier gevonden voor deze gebruiker.');
    }

    $reis = GeboekteReis::with(['vlucht', 'accommodatie', 'ticket'])
        ->where(function ($query) use ($id) {
            $query->where('BoekingId', $id)
                ->orWhere('Id', $id);
        })
        ->where('PassagierId', $passagier->Id)
        ->firstOrFail();

    if (!in_array($reis->vlucht->Vluchtstatus, ['Gepland', 'Vertraagd'])) {
        return redirect()->route('reis.index')
            ->with('error', 'Deze boeking kan niet meer worden gewijzigd door de vluchtstatus.');
    }

    return view('reis.edit', ['boeking' => $reis]);
}
public function update(Request $request, $id)
{
    // Server-side validatie van wijziging.
    $request->validate([
        'AantalPassagiers' => 'required|integer|min:1|max:10',
    ]);

    $passagier = $this->resolvePassagierForCurrentUser();

    if (!$passagier) {
        return redirect()->route('reis.index')
            ->with('error', 'Geen passagier gevonden voor deze gebruiker.');
    }

    // Haal geboekte reis + ticket + accommodatie op via BoekingId
    $boeking = GeboekteReis::with(['ticket', 'accommodatie'])
        ->where(function ($query) use ($id) {
            $query->where('BoekingId', $id)
                ->orWhere('Id', $id);
        })
        ->where('PassagierId', $passagier->Id)
        ->firstOrFail();

    $ticket = $boeking->ticket;

    if (!$ticket) {
        return back()->with('error', 'Geen ticket gevonden voor deze boeking.');
    }

    $nieuwAantal = (int) $request->AantalPassagiers;

    // Stoelen opnieuw genereren
    $stoelen = [];
    for ($i = 1; $i <= $nieuwAantal; $i++) {
        $stoelen[] = $this->genereerStoelnummer($i);
    }
    $stoelString = implode('|', $stoelen);

    // Prijs opnieuw berekenen
    $prijsPerPersoon = $boeking->accommodatie->TotaalPrijs;
    $totaalPrijs = $prijsPerPersoon * $nieuwAantal;

    // Try/catch + transaction voor consistente update van ticket/boeking/reis.
    try {
        DB::transaction(function () use ($ticket, $stoelString, $nieuwAantal, $totaalPrijs, $boeking) {
            // Ticket bijwerken
            $ticket->update([
                'Stoelnummer'   => $stoelString,
                'Aantal'        => $nieuwAantal,
                'BedragInclBtw' => $totaalPrijs,
                'Datumgewijzigd'=> now(),
            ]);

            // Geboekte reis bijwerken
            $boeking->update([
                'TotaalPrijs'    => $totaalPrijs,
                'Boekingsstatus' => 'In behandeling',
            ]);

            // Onderliggende boeking ook bijwerken zodat totalen overal gelijk blijven.
            Boeking::where('Id', $boeking->BoekingId)->update([
                'TotaalPrijs' => $totaalPrijs,
                'Boekingsstatus' => 'In behandeling',
                'Datumgewijzigd' => now(),
            ]);
        });
    } catch (Throwable $e) {
        // Technische log voor foutanalyse.
        Log::error('Fout bij wijzigen van boeking', [
            'boeking_id' => $boeking->BoekingId,
            'passagier_id' => $passagier->Id,
            'error' => $e->getMessage(),
        ]);

        // Functionele melding voor eindgebruiker.
        return redirect()->route('reis.index')
            ->with('error', 'Wijzigen is mislukt. Probeer het opnieuw.');
    }

    return redirect()->route('reis.index')
        ->with('success', 'Boeking succesvol bijgewerkt!');
}
    // Verwijderen
    public function destroy($id)
    {
        // Security: verwijdering alleen binnen eigen passagier-context.
        $passagier = $this->resolvePassagierForCurrentUser();

        if (!$passagier) {
            return redirect()->route('reis.index')
                ->with('error', 'Geen passagier gevonden voor deze gebruiker.');
        }

        $reis = GeboekteReis::with(['vlucht'])
            ->where(function ($query) use ($id) {
                $query->where('BoekingId', $id)
                    ->orWhere('Id', $id);
            })
            ->where('PassagierId', $passagier->Id)
            ->firstOrFail();

        $status = strtolower(trim((string) ($reis->Vluchtstatus ?? $reis->vlucht->Vluchtstatus ?? '')));

        // Business rule: alleen annuleren/verwijderen bij Geland of Geannuleerd.
        if (!in_array($status, ['geland', 'geannuleerd'])) {
            return redirect()->route('reis.index')
                ->with('error', 'Je kunt alleen boekingen verwijderen met status Geland of Geannuleerd.');
        }

        // Try/catch + transaction voor consistente database-mutaties.
        try {
            DB::transaction(function () use ($reis) {
                $boekingId = $reis->BoekingId;

                DB::table('Factuur')->where('BoekingId', $boekingId)->delete();
                GeboekteReis::where('BoekingId', $boekingId)->delete();
                Ticket::where('BoekingId', $boekingId)->update([
                    'BoekingId' => null,
                    'Datumgewijzigd' => now(),
                ]);
                Boeking::where('Id', $boekingId)->delete();
            });
        } catch (Throwable $e) {
            // Technische log voor operations/debugging.
            Log::error('Fout bij verwijderen van boeking', [
                'boeking_id' => $reis->BoekingId,
                'passagier_id' => $passagier->Id,
                'error' => $e->getMessage(),
            ]);

            // Functionele melding voor eindgebruiker.
            return redirect()->route('reis.index')
                ->with('error', 'Verwijderen is mislukt. Probeer het opnieuw.');
        }

        return redirect()->route('reis.index')
            ->with('success', 'Boeking verwijderd. Ticket kun je handmatig verwijderen via Tickets.');
    }

    public function ReisBoeken(Request $request, $id)
    {
        $passagier = Passagier::whereHas('persoon', function ($query) {
            $query->where('GebruikerId', Auth::id());
        })->first();

        if (! $passagier) {
            Log::info("geen passagier gevonden voor gebruiker Id: " . Auth::id());
            return redirect()->route('reis.index')
                ->with('error', 'Geen passagier gevonden voor deze gebruiker.');
        }
        // Haal de bestaande reis/boeking op via het ID uit de URL
        $boeking = Boeking::with(['vlucht', 'accommodatie'])->findOrFail($id);

        // Maak de factuur aan voor deze boeking
        $factuurId = $this->maakFactuur($boeking->Id, $boeking->PassagierId ?? Auth::id());

        // Update de boekingstatus naar 'Bevestigd'
        $boeking->update([
            'Boekingsstatus' => 'Bevestigd',
            'Datumgewijzigd' => now(),
        ]);

        Log::info("BoekingId: {$boeking->Id} is bevestigd. Factuurnummer: {$factuurId}");

        return redirect()->route('reis.index')
            ->with('success', 'Reis succesvol geboekt!');
    }

    public function maakFactuur($boekingId, $passagierId)
    {
        $boeking = Boeking::findOrFail($boekingId);

        // Zoek de passagier op via de ingelogde gebruiker
        $passagier = Passagier::whereHas('persoon', function ($query) {
            $query->where('GebruikerId', Auth::id());
        })->first();

        // kijkt of het echt een passagier is als rol

        $factuurnummer = 'FAC-'.now()->format('YmdHis').'-'.$boekingId;

        // maakt een nieuwe factuur aan
        DB::table('Factuur')->insert([
            'BoekingId' => $boekingId,
            'PassagierId' => $passagier->Id,
            'Factuurnummer' => $factuurnummer,
            'Factuurdatum' => now()->toDateString(),
            'Factuurtijd' => now()->toTimeString(),
            'TotaalBedrag' => $boeking->TotaalPrijs,
            'Betaalstatus' => 'Openstaand',
            'Betaalmethode' => 'Debitkaart',
            'IsActief' => 1,
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ]);

        Log::info("Factuur {$factuurnummer} aangemaakt voor boeking Id: {$boekingId} en passagier Id: {$passagier->Id}");

        return $factuurnummer;
    }
}
