<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use App\Models\Vlucht;
use App\Models\Accommodatie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KlantBoekingController extends Controller
{
   
    public function index()
    {
        $boekingen = Boeking::with(['vlucht', 'accommodatie'])
            ->where('GebruikerId', Auth::id())
            ->get();

        return view('klant.boekingen.index', compact('boekingen'));
    }

    
    public function show($id)
    {
        $boeking = Boeking::with(['vlucht', 'accommodatie', 'facturen'])
            ->where('GebruikerId', Auth::id())
            ->findOrFail($id);

        return view('klant.boekingen.show', compact('boeking'));
    }

    // Nieuwe boeking
    public function create()
    {
        return view('klant.boekingen.create', [
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
            'Boekingsnummer' => 'required',
            'Boekingsdatum' => 'required',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required',
            'TotaalPrijs' => 'required|numeric',
        ]);

        $boeking = Boeking::create([
            'VluchtId' => $request->VluchtId,
            'AccommodatieId' => $request->AccommodatieId,
            'Boekingsnummer' => $request->Boekingsnummer,
            'Boekingsdatum' => $request->Boekingsdatum,
            'Boekingstijd' => $request->Boekingstijd,
            'Boekingsstatus' => $request->Boekingsstatus,
            'TotaalPrijs' => $request->TotaalPrijs,
            'GebruikerId' => Auth::id(),
            'IsActief' => 1,
        ]);

        return redirect()->route('klant.boekingen.show', $boeking->Id)
            ->with('success', 'Boeking succesvol aangemaakt!');
    }

   
    public function destroy($id)
    {
        $boeking = Boeking::where('Id', $id)
            ->where('GebruikerId', Auth::id())
            ->firstOrFail();

        $boeking->delete();

        return redirect()->route('klant.boekingen.index')
            ->with('success', 'Boeking verwijderd!');
    }

    
    public function addFactuur($boekingId)
    {
        $boeking = Boeking::where('Id', $boekingId)
            ->where('GebruikerId', Auth::id())
            ->firstOrFail();

     

        return redirect()->route('klant.boekingen.show', $boekingId)
            ->with('success', 'Factuur toegevoegd!');
    }
}