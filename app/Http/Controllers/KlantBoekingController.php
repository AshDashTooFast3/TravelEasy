<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Boeking;
use App\Models\Vlucht;
use App\Models\Accommodatie;
use App\Models\KlantBoekingen;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class KlantBoekingController extends Controller
{
    // Reis overzicht
    public function index()
    {
        $boekingen = KlantBoekingen::get();
        return view('reis.index', compact('boekingen'));
    }

    // Reis kaart
    public function map()
    {
        $boekingen = KlantBoekingen::get();
        return view('reis.map', compact('boekingen'));
    }

    // Nieuwe reis boeken
    public function create()
    {
        return view('reis.create', [
            'vluchten' => Vlucht::all(),
            'accommodaties' => Accommodatie::all(),
        ]);
    }

    // Opslaan
   public function store(Request $request)
{
    $request->validate([
        'VluchtId' => 'required',
        'AccommodatieId' => 'required',
        'AantalPassagiers' => 'required|integer|min:1|max:10',
    ], [
        'AantalPassagiers.max' => 'Je kunt maximaal 10 passagiers per boeking aanmaken.',
    ]);

    $acc = Accommodatie::findOrFail($request->AccommodatieId);
    $vlucht = Vlucht::findOrFail($request->VluchtId);

    // Prijs per persoon + totaal
    $prijsPerPersoon = $acc->TotaalPrijs;
    $totaalPrijs = $prijsPerPersoon * $request->AantalPassagiers;

    // Boeking aanmaken
    $boeking = Boeking::create([
        'VluchtId'       => $request->VluchtId,
        'AccommodatieId' => $request->AccommodatieId,
        'Boekingsnummer' => 'BK-' . now()->format('YmdHis'),
        'Boekingsdatum'  => now()->toDateString(),
        'Boekingstijd'   => now()->toTimeString(),
        'Boekingsstatus' => 'In behandeling',
        'TotaalPrijs'    => $totaalPrijs,
        'IsActief'       => 1,
    ]);

    // Voor elke passagier een eigen stoel + ticket
    for ($i = 1; $i <= $request->AantalPassagiers; $i++) {
        $stoelnummer = $this->genereerStoelnummer($i);

        Ticket::create([
            'PassagierId'   => Auth::user()->Id,
            'VluchtId'      => $boeking->VluchtId,
            'Stoelnummer'   => $stoelnummer,          // één stoel per ticket
            'Aankoopdatum'  => now()->toDateString(),
            'Aankooptijd'   => now()->toTimeString(),
            'Aantal'        => 1,                     // 1 per ticket
            'BedragInclBtw' => $prijsPerPersoon,      // prijs per persoon
            'Isactief'      => true,
            'Opmerking'     => null,
            'Datumaangemaakt' => now(),
            'Datumgewijzigd'  => now(),
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

        return $rij . $stoel; // bijv. A1, A2, B1, B2
    }

    // Verwijderen
    public function destroy($id)
    {
        $boeking = Boeking::findOrFail($id);

        DB::table('Ticket')
            ->where('PassagierId', Auth::user()->Id)
            ->where('VluchtId', $boeking->VluchtId)
            ->delete();

        DB::table('factuur')->where('BoekingId', $id)->delete();

        $boeking->delete();

        return redirect()->route('reis.index')
            ->with('success', 'Reis en ticket verwijderd!');
    }
}