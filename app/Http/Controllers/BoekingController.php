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

    // 📌 Overzicht
    public function index()
    {
        $boekingen = Boeking::with([
            'vlucht.bestemming',
            'vlucht.vertrek',
            'accommodatie'
        ])->get();

        return view('boekingen.index', compact('boekingen'));
    }

    // 📌 Create formulier
    public function create()
    {
        $vluchten = Vlucht::with(['bestemming'])->get();
        $accommodaties = Accommodatie::all();

        return view('boekingen.create', compact('vluchten', 'accommodaties'));
    }

    // 📌 Nieuwe boeking opslaan
    public function store(Request $request)
    {
        $request->validate([
            'Boekingsnummer' => 'nullable|unique:Boeking,Boekingsnummer',
            'VluchtId' => 'required|exists:Vlucht,Id',
            'AccommodatieId' => 'required|exists:Accommodatie,Id',
            'Boekingsdatum' => 'required|date',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        $boekingsnummer = $request->Boekingsnummer ?? 'BN-' . rand(100000, 999999);

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

        return redirect()
            ->route('boekingen.create')
            ->with('success', 'De boeking is succesvol toegevoegd!');
    }

    // 📌 Edit formulier
    public function edit($id)
    {
        $boeking = Boeking::findOrFail($id);
        $vluchten = Vlucht::with('bestemming')->get();
        $accommodaties = Accommodatie::all();

        return view('boekingen.edit', compact('boeking', 'vluchten', 'accommodaties'));
    }

    // 📌 Update opslaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'Boekingsnummer' => 'required|unique:Boeking,Boekingsnummer,' . $id . ',Id',
            'VluchtId' => 'required|exists:Vlucht,Id',
            'AccommodatieId' => 'required|exists:Accommodatie,Id',
            'Boekingsdatum' => 'required|date',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        $boeking = Boeking::findOrFail($id);

        $boeking->update([
            'Boekingsnummer' => $request->Boekingsnummer,
            'VluchtId' => $request->VluchtId,
            'AccommodatieId' => $request->AccommodatieId,
            'Boekingsdatum' => $request->Boekingsdatum,
            'Boekingstijd' => $request->Boekingstijd,
            'Boekingsstatus' => $request->Boekingsstatus,
            'TotaalPrijs' => $request->TotaalPrijs,
        ]);

        return redirect()
            ->back()
            ->with('success', 'De boeking is succesvol bijgewerkt!');
    }

    // 📌 Verwijderen via AJAX + vaste code
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'confirm_code' => 'required'
        ], [
            'confirm_code.required' => 'Je moet de verwijdercode invullen.'
        ]);

        // De vaste code die altijd gebruikt moet worden
        $correctCode = "VERWIJDEREN";

        if (strtoupper($request->confirm_code) !== $correctCode) {
            return response()->json([
                'status' => 'error',
                'message' => 'De ingevoerde verwijdercode is onjuist.'
            ], 400);
        }

        $boeking = Boeking::findOrFail($id);
        $boeking->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'De boeking is succesvol verwijderd!'
        ]);
    }
}
