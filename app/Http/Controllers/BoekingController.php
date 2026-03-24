<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boeking;
use App\Models\Vlucht;
use App\Models\Accommodatie;

class BoekingController extends Controller
{
    private $BoekingModel;
    
    public function __construct()
    {
        $this->BoekingModel = new Boeking();
    }

    public function index()
    {
        // Ophalen van alle boekingen + alle benodigde relaties
        $boekingen = Boeking::with([
            'vlucht.bestemming',
            'vlucht.vertrek',
            'accommodatie'
        ])->get();

        return view('boekingen.index', compact('boekingen'));
    }

    /**
     * FORMULIER: Nieuwe boeking aanmaken
     */
    public function create()
    {
        // Vluchten + bestemming laden
        $vluchten = Vlucht::with(['bestemming'])->get();
        $accommodaties = Accommodatie::all();

        return view('boekingen.create', compact('vluchten', 'accommodaties'));
    }

    /**
     * OPSLAAN: Nieuwe boeking verwerken
     */
    public function store(Request $request)
{
    // Validatie + Nederlandse foutmeldingen
    $request->validate([
        'Boekingsnummer' => 'nullable|unique:Boeking,Boekingsnummer',
        'VluchtId' => 'required|exists:Vlucht,Id',
        'AccommodatieId' => 'required|exists:Accommodatie,Id',
        'Boekingsdatum' => 'required|date',
        'Boekingstijd' => 'required',
        'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
        'TotaalPrijs' => 'required|numeric|min:0',
    ], [
        'Boekingsnummer.unique' => 'Dit boekingsnummer bestaat al.',
        'VluchtId.required' => 'Selecteer een vlucht.',
        'VluchtId.exists' => 'De geselecteerde vlucht bestaat niet.',
        'AccommodatieId.required' => 'Selecteer een accommodatie.',
        'AccommodatieId.exists' => 'De geselecteerde accommodatie bestaat niet.',
        'Boekingsdatum.required' => 'Vul een boekingsdatum in.',
        'Boekingsdatum.date' => 'De boekingsdatum is ongeldig.',
        'Boekingstijd.required' => 'Vul een tijd in.',
        'Boekingsstatus.required' => 'Selecteer een boekingsstatus.',
        'Boekingsstatus.in' => 'De gekozen status is ongeldig.',
        'TotaalPrijs.required' => 'Vul een totaalprijs in.',
        'TotaalPrijs.numeric' => 'De totaalprijs moet een getal zijn.',
        'TotaalPrijs.min' => 'De totaalprijs moet minimaal 0 zijn.',
    ]);

    // Boekingsnummer: handmatig of automatisch
    $boekingsnummer = $request->Boekingsnummer ?? 'BN-' . rand(100000, 999999);

    // Opslaan
    Boeking::create([
        'VluchtId' => $request->VluchtId,
        'AccommodatieId' => $request->AccommodatieId,
        'Boekingsnummer' => $boekingsnummer,
        'Boekingsdatum' => $request->Boekingsdatum,
        'Boekingstijd' => $request->Boekingstijd,
        'Boekingsstatus' => $request->Boekingsstatus, // <-- FIXED
        'TotaalPrijs' => $request->TotaalPrijs,
        'IsActief' => 1,
    ]);

    return redirect()
        ->route('boekingen.create')
        ->with('success', 'Boeking succesvol toegevoegd!');
}

}
