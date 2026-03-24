<?php

namespace App\Http\Controllers;

use App\Models\Accommodatie;
use App\Models\Boeking;
use App\Models\Factuur;
use App\Models\Gebruiker;
use App\Models\KlantBoekingen;
use App\Models\Passagier;
use App\Models\Ticket;
use App\Models\Vlucht;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KlantBoekingController extends Controller
{
    // Reis overzicht

public function index()
{
    $gebruiker = auth()->user();

    // Vluchten + accommodaties voor reisplan
    $vluchten = Vlucht::all();
    $accommodaties = Accommodatie::all();

    // Zoek passagier van deze gebruiker
    $passagier = Passagier::whereHas('persoon', function ($q) use ($gebruiker) {
        $q->where('GebruikerId', $gebruiker->Id);
    })->first();

    if (!$passagier) {
        $boekingen = collect();
    } else {
        $boekingen = KlantBoekingen::with(['vlucht', 'accommodatie'])
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
$request->validate([
   
    'VluchtId' => 'required',
    'AccommodatieId' => 'required',
    'AantalPassagiers' => 'required|integer|min:1|max:10',
], [
    'AantalPassagiers.max' => 'Je kunt maximaal 10 passagiers per boeking aanmaken.',
]);

    $gebruiker = Auth::user();

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

    // 4. Tickets aanmaken
    for ($i = 1; $i <= $request->AantalPassagiers; $i++) {
        $stoelnummer = $this->genereerStoelnummer($i);

        Ticket::create([
            'PassagierId' => $passagier->Id,   // <-- BELANGRIJK: Passagier.Id, NIET Gebruiker.Id
            'VluchtId' => $boeking->VluchtId,
            'Stoelnummer' => $stoelnummer,
            'Aankoopdatum' => now()->toDateString(),
            'Aankooptijd' => now()->toTimeString(),
            'Aantal' => 1,
            'BedragInclBtw' => $prijsPerPersoon,
            'Isactief' => true,
            'Opmerking' => null,
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ]);
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

    // Verwijderen
    public function destroy($id)
    {
        $boeking = Boeking::findOrFail($id);

        DB::table('Ticket')
            ->where('PassagierId', Auth::user()->Id)
            ->where('VluchtId', $boeking->VluchtId)
            ->delete();

        DB::table('Factuur')->where('BoekingId', $id)->delete();

        $boeking->delete();

        return redirect()->route('reis.index')
            ->with('success', 'Reis en ticket verwijderd!');
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
