<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boeking;
use App\Models\Vlucht;
use App\Models\Accommodatie;

class BoekingController extends Controller
{
    // ✅ Private eigenschap voor Boeking model
    private $BoekingModel;
    
    // ✅ Constructor initialiseert het Boeking model
    public function __construct()
    {
        $this->BoekingModel = new Boeking();
    }

    // 📌 Overzicht - Toont alle boekingen met gerelateerde vlucht- en accommodatiegegevens
    public function index()
    {
        // ✅ Haalt alle boekingen op met relaties naar vluchten en accommodaties
        $boekingen = Boeking::with([
            'vlucht.bestemming',
            'vlucht.vertrek',
            'accommodatie'
        ])->get();

        // ✅ Stuurt gegevens naar view 'boekingen.index'
        return view('boekingen.index', compact('boekingen'));
    }

    // 📌 Create formulier - Toont het formulier voor nieuwe boeking
    public function create()
    {
        // ✅ Haalt alle vluchten met bestemmingen op
        $vluchten = Vlucht::with(['bestemming'])->get();
        // ✅ Haalt alle accommodaties op
        $accommodaties = Accommodatie::all();

        // ✅ Stuurt gegevens naar create view
        return view('boekingen.create', compact('vluchten', 'accommodaties'));
    }

    // 📌 Nieuwe boeking opslaan - Slaat formuliergegevens op in database
    public function store(Request $request)
    {
        // ✅ Valideert inkomende requestgegevens
        $request->validate([
            'Boekingsnummer' => 'nullable|unique:Boeking,Boekingsnummer',
            'VluchtId' => 'required|exists:Vlucht,Id',
            'AccommodatieId' => 'required|exists:Accommodatie,Id',
            'Boekingsdatum' => 'required|date',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        // ✅ Genereert boekingsnummer als niet opgegeven
        $boekingsnummer = $request->Boekingsnummer ?? 'BN-' . rand(100000, 999999);

        // ✅ Maakt nieuwe boeking aan in database
        Boeking::create([
            'VluchtId' => $request->VluchtId,
            'AccommodatieId' => $request->AccommodatieId,
            'Boekingsnummer' => $boekingsnummer,
            'Boekingsdatum' => $request->Boekingsdatum,
            'Boekingstijd' => $request->Boekingstijd,
            'Boekingsstatus' => $request->Boekingsstatus,
            'TotaalPrijs' => $request->TotaalPrijs,
            'IsActief' => 1,
        ]);

        // ✅ Redirect naar create pagina met succesmessage
        return redirect()
            ->route('boekingen.create')
            ->with('success', 'De boeking is succesvol toegevoegd!');
    }

    // 📌 Edit formulier - Toont formulier om boeking te bewerken
    public function edit($id)
    {
        // ✅ Haalt specifieke boeking op of toont 404 fout
        $boeking = Boeking::findOrFail($id);
        // ✅ Haalt vluchten en accommodaties op voor dropdown selectie
        $vluchten = Vlucht::with('bestemming')->get();
        $accommodaties = Accommodatie::all();

        // ✅ Stuurt gegevens naar edit view
        return view('boekingen.edit', compact('boeking', 'vluchten', 'accommodaties'));
    }

    // 📌 Update opslaan - Werkt bestaande boeking bij
    public function update(Request $request, $id)
    {
        // ✅ Valideert gegevens met unieke constraint voor huidige boeking
        $request->validate([
            'Boekingsnummer' => 'required|unique:Boeking,Boekingsnummer,' . $id . ',Id',
            'VluchtId' => 'required|exists:Vlucht,Id',
            'AccommodatieId' => 'required|exists:Accommodatie,Id',
            'Boekingsdatum' => 'required|date',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        // ✅ Haalt boeking op
        $boeking = Boeking::findOrFail($id);

        // ✅ Werkt boeking bij met valideerde gegevens
        $boeking->update([
            'Boekingsnummer' => $request->Boekingsnummer,
            'VluchtId' => $request->VluchtId,
            'AccommodatieId' => $request->AccommodatieId,
            'Boekingsdatum' => $request->Boekingsdatum,
            'Boekingstijd' => $request->Boekingstijd,
            'Boekingsstatus' => $request->Boekingsstatus,
            'TotaalPrijs' => $request->TotaalPrijs,
        ]);

        // ✅ Redirect terug met succesmessage
        return redirect()
            ->back()
            ->with('success', 'De boeking is succesvol bijgewerkt!');
    }

    // 📌 Verwijderen via AJAX + vaste code - Verwijdert boeking na codevalidatie
    public function destroy(Request $request, $id)
    {
        // ✅ Valideert dat verwijdercode is opgegeven
        $request->validate([
            'confirm_code' => 'required'
        ], [
            'confirm_code.required' => 'Je moet de verwijdercode invullen.'
        ]);

        // ✅ Controleert of ingevoerde code overeenkomt met vaste verwijdercode
        $correctCode = "VERWIJDEREN";

        if (strtoupper($request->confirm_code) !== $correctCode) {
            // ✅ Retourneert error JSON response bij onjuiste code
            return response()->json([
                'status' => 'error',
                'message' => 'De ingevoerde verwijdercode is onjuist.'
            ], 400);
        }

        // ✅ Haalt boeking op en verwijdert deze
        $boeking = Boeking::findOrFail($id);
        $boeking->delete();

        // ✅ Retourneert succes JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'De boeking is succesvol verwijderd!'
        ]);
    }
}
