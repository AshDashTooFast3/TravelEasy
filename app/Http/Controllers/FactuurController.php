<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use \App\Models\Passagier;
use Illuminate\Http\Request;

class FactuurController extends Controller
{
    private $FactuurModel;
    private $PassagierModel;

    public function __construct()
    {
        $this->FactuurModel = new Factuur;
        $this->PassagierModel = new Passagier;
    }

    public function index()
    {
        $facturen = $this->FactuurModel->sp_PakAlleFacturen();

        return view('facturatie.index', [
            'title' => 'Facturen overzicht',
            'facturen' => $facturen,
        ]);
    }

    public function bewerken($id)
    {
        $factuur = $this->FactuurModel->PakFactuurBijId($id);

        $passagiers = $this->PassagierModel->PakAllePassagiers();

        return view('facturatie.bewerken', [
            'title' => 'Factuur bewerken',
            'factuur' => $factuur,
            'passagiers' => $passagiers
        ]);
    }

    public function wijzigen(Request $request)
    {
        $validatedData = $request->validate([
            'Id' => 'required|integer',
            'BoekingId' => 'required|integer',
            'PassagierId' => 'required|integer',
            'Factuurnummer' => 'required|string|max:255',
            'Factuurdatum' => 'required|date',
            'Factuurtijd' => 'required|date_format:H:i:s',
            'TotaalBedrag' => 'required|numeric',
            'Betaalstatus' => 'required|string|max:255',
            'Betaalmethode' => 'required|string|max:255',
            'Isactief' => 'required|boolean',
            'Opmerking' => 'nullable|string|max:255',
        ]);

        $this->FactuurModel->sp_WijzigFactuur(
            $validatedData['Id'],
            $validatedData['BoekingId'],
            $validatedData['PassagierId'],
            $validatedData['Factuurnummer'],
            $validatedData['Factuurdatum'],
            $validatedData['Factuurtijd'],
            $validatedData['TotaalBedrag'],
            $validatedData['Betaalstatus'],
            $validatedData['Betaalmethode'],
            $validatedData['Isactief'],
            $validatedData['Opmerking']
        );

        return redirect()->route('facturatie.index')->with('success', 'Factuur succesvol bijgewerkt.');
    }
}
