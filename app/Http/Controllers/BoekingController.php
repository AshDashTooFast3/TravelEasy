<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boeking;
use App\Models\Vlucht;
use App\Models\Accommodatie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        try {
            Log::info('BoekingController@index: Boekingen ophalen gestart');

            $boekingen = Boeking::with([
                'vlucht.bestemming',
                'vlucht.vertrek',
                'accommodatie'
            ])->get();

            Log::info('BoekingController@index: ' . count($boekingen) . ' boekingen opgehaald');

            return view('boekingen.index', compact('boekingen'));

        } catch (\Exception $e) {
            Log::error('BoekingController@index: Fout - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van boekingen.');
        }
    }

    // 📌 Create formulier
    public function create()
    {
        try {
            Log::info('BoekingController@create: Formulier laden');

            $vluchten = Vlucht::with(['bestemming'])->get();
            $accommodaties = Accommodatie::all();

            return view('boekingen.create', compact('vluchten', 'accommodaties'));

        } catch (\Exception $e) {
            Log::error('BoekingController@create: Fout - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    // 📌 Opslaan nieuwe boeking
    public function store(Request $request)
    {
        Log::info('BoekingController@store: Opslaan gestart', $request->all());

        // ❗ Validatie BUITEN try/catch
        $request->validate([
            'Boekingsnummer' => 'nullable|unique:Boeking,Boekingsnummer',
            'VluchtId' => 'required|exists:Vlucht,Id',
            'AccommodatieId' => 'required|exists:Accommodatie,Id',
            'Boekingsdatum' => 'required|date',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        try {
            $boekingsnummer = $request->Boekingsnummer ?? 'BN-' . rand(100000, 999999);

            $boeking = Boeking::create([
                'VluchtId' => $request->VluchtId,
                'AccommodatieId' => $request->AccommodatieId,
                'Boekingsnummer' => $boekingsnummer,
                'Boekingsdatum' => $request->Boekingsdatum,
                'Boekingstijd' => $request->Boekingstijd,
                'Boekingsstatus' => $request->Boekingsstatus,
                'TotaalPrijs' => $request->TotaalPrijs,
                'IsActief' => 1,
            ]);

            Log::info('BoekingController@store: Boeking aangemaakt ID ' . $boeking->Id);

            return redirect()
                ->route('boekingen.create')
                ->with('success', 'De boeking is succesvol toegevoegd!');

        } catch (\Exception $e) {
            Log::error('BoekingController@store: Fout - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het opslaan van de boeking.');
        }
    }

    // 📌 Edit formulier
    public function edit($id)
    {
        try {
            Log::info('BoekingController@edit: Formulier laden voor ID ' . $id);

            $boeking = Boeking::findOrFail($id);
            $vluchten = Vlucht::with('bestemming')->get();
            $accommodaties = Accommodatie::all();

            return view('boekingen.edit', compact('boeking', 'vluchten', 'accommodaties'));

        } catch (\Exception $e) {
            Log::error('BoekingController@edit: Fout - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van de boeking.');
        }
    }

    // 📌 Update boeking
    public function update(Request $request, $id)
    {
        Log::info('BoekingController@update: Bijwerken gestart voor ID ' . $id);

        // ❗ Validatie BUITEN try/catch
        $request->validate([
            'Boekingsnummer' => 'required|unique:Boeking,Boekingsnummer,' . $id . ',Id',
            'VluchtId' => 'required|exists:Vlucht,Id',
            'AccommodatieId' => 'required|exists:Accommodatie,Id',
            'Boekingsdatum' => 'required|date',
            'Boekingstijd' => 'required',
            'Boekingsstatus' => 'required|in:Bevestigd,Geannuleerd,In behandeling',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        try {
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

            Log::info('BoekingController@update: Boeking bijgewerkt ID ' . $id);

            return redirect()
                ->back()
                ->with('success', 'De boeking is succesvol bijgewerkt!');

        } catch (\Exception $e) {
            Log::error('BoekingController@update: Fout - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het bijwerken van de boeking.');
        }
    }

    // 📌 Verwijderen via AJAX + vaste code
    public function destroy(Request $request, $id)
    {
        Log::info('BoekingController@destroy: Verwijderen gestart voor ID ' . $id);

        // ❗ Validatie BUITEN try/catch
        $request->validate([
            'confirm_code' => 'required'
        ], [
            'confirm_code.required' => 'Je moet de verwijdercode invullen.'
        ]);

        try {
            $correctCodes = ["VERWIJDEREN", "ANNULEREN"];
            

            if (!in_array(strtoupper($request->confirm_code), $correctCodes)) {
                Log::warning('BoekingController@destroy: Onjuiste code voor ID ' . $id);

                return response()->json([
                    'status' => 'error',
                    'message' => 'De ingevoerde verwijdercode is onjuist.'
                ], 400);
            }

            // ❗ Eerst facturen verwijderen (anders FK error)
            DB::table('Factuur')->where('BoekingId', $id)->delete();

            $boeking = Boeking::findOrFail($id);
            $boeking->delete();

            Log::info('BoekingController@destroy: Boeking verwijderd ID ' . $id);

            $message = in_array(strtoupper($request->confirm_code), ["ANNULEREN"]) 
                ? 'De factuur is succesvol geannuleerd!' 
                : 'De boeking is succesvol verwijderd!';

            return response()->json([
                'status' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('BoekingController@destroy: Fout - ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Er is een fout opgetreden bij het verwijderen van de boeking.'
            ], 500);
        }
    }
}
