<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodatie;

class AccommodatieController extends Controller
{
    public function index()
    {
        $accommodaties = Accommodatie::all();
        return view('accomodatie.index')
        ->with('accommodaties', $accommodaties);
    }

    public function edit($id)
    {
        $accommodatie = Accommodatie::findOrFail($id);
        return view('accomodatie.edit', compact('accommodatie'));
    }

    public function update(Request $request, $id)
    {
        $accommodatie = Accommodatie::findOrFail($id);

        $request->validate([
            'Naam' => 'required|string|max:255',
            'Type' => 'required|string|max:255',
            'Straat' => 'required|string|max:255',
            'Huisnummer' => 'required|string|max:10',
            'toevoeging' => 'nullable|string|max:10',
            'Postcode' => 'required|string|max:10',
            'Stad' => 'required|string|max:255',
            'Land' => 'required|string|max:255',
            'AantalKamers' => 'required|integer|min:1',
            'AantalPersonen' => 'required|integer|min:1',
            'PrijsPerNacht' => 'required|numeric|min:0',
            'TotaalPrijs' => 'required|numeric|min:0',
        ]);

        $accommodatie->update($request->only([
            'Naam', 'Type', 'Straat', 'Huisnummer', 'toevoeging',
            'Postcode', 'Stad', 'Land', 'AantalKamers', 'AantalPersonen',
            'PrijsPerNacht', 'TotaalPrijs', 
        ]));

        return redirect()->route('accommodatie.index')->with('success', 'Accommodatie bijgewerkt!');
    }

    public function create()
    {
        $vluchten = \App\Models\Vlucht::all();
        return view('accomodatie.create', compact('vluchten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Naam' => 'required|string|max:255',
            'Type' => 'required|string|max:255',
            'Straat' => 'required|string|max:255',
            'Huisnummer' => 'required|string|max:10',
            'toevoeging' => 'nullable|string|max:10',
            'Postcode' => 'required|string|max:10',
            'Stad' => 'required|string|max:255',
            'Land' => 'required|string|max:255',
            'AantalKamers' => 'required|integer|min:1',
            'AantalPersonen' => 'required|integer|min:1',
            'PrijsPerNacht' => 'required|numeric|min:0',
            'TotaalPrijs' => 'required|numeric|min:0',
            'Vluchtnummer' => 'required|string|max:255',
            'CheckInDatum' => 'required|date',
            'CheckOutDatum' => 'required|date',
            'Opmerking' => 'nullable|string|max:1000',
        ]);

        // haal de vlucht id waar de Vluchtnummer overeenkomt
        $vlucht = \App\Models\Vlucht::where('Vluchtnummer', $request->input('Vluchtnummer'))->first();
        if (!$vlucht) {
            return redirect()->back()->withErrors(['Vluchtnummer' => 'Ongeldige Vluchtnummer'])->withInput();
        }

        // check of de accommodatie al bestaat
        $exists = Accommodatie::where('Naam', $request->input('Naam'))
            ->where('Straat', $request->input('Straat'))
            ->where('Huisnummer', $request->input('Huisnummer'))
            ->whereDate('CheckInDatum', $request->input('CheckInDatum'))
            ->exists();
        
        if ($exists) {
            return redirect()->back()->withErrors(['Naam' => 'Deze accommodatie bestaat al'])->withInput();
        }

        $data = $request->only([
            'Naam', 'Type', 'Straat', 'Huisnummer', 'toevoeging',
            'Postcode', 'Stad', 'Land', 'AantalKamers', 'AantalPersonen',
            'PrijsPerNacht', 'TotaalPrijs', 'CheckInDatum', 'CheckOutDatum', 'Opmerking'
        ]);
        $data['VluchtId'] = $vlucht->Id;
        
        Accommodatie::create($data);

        return redirect()->route('accommodatie.index')->with('success', 'Accommodatie toegevoegd!');
    }

}
