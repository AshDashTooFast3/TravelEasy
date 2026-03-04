<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Boeking;
use App\Models\Vlucht;
use App\Models\Accommodatie;
use App\Models\KlantBoekingen;
use Illuminate\Http\Request;
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

    // Reis details (ENIGE show()!)
    public function show($id)
    {
        $boekingen = KlantBoekingen::get();

        $boeking = $boekingen->where('Id', $id)->first();

        if (!$boeking) {
            abort(404);
        }

        return view('reis.show', compact('boeking'));
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
            'AantalPassagiers' => 'required|integer|min:1',
        ]);

        $acc = Accommodatie::findOrFail($request->AccommodatieId);

        // Prijsberekening
        $totaalPrijs = $acc->TotaalPrijs * $request->AantalPassagiers;

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

        return redirect()->route('reis.show', $boeking->Id)
            ->with('success', 'Reis succesvol geboekt!');
    }

    // Verwijderen
   public function destroy($id)
{
    // Verwijder eerst facturen die gekoppeld zijn aan deze boeking
    DB::table('factuur')->where('BoekingId', $id)->delete();

    // Verwijder daarna de boeking zelf
    Boeking::where('Id', $id)->delete();

    return redirect()->route('reis.index')
        ->with('success', 'Reis verwijderd!');

}
}