<?php

namespace App\Http\Controllers;

use App\Models\Factuur;
use App\Models\Passagier;
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
            'passagiers' => $passagiers,
        ]);
    }

    public function wijzigen(Request $request)
    {
        $validatedData = $request->validate([
            'Id' => 'required|integer|exists:Factuur,Id',
            'PassagierId' => 'required|integer',
            'Factuurdatum' => 'required|date',
            'TotaalBedrag' => 'required|numeric|min:0',
            'Betaalmethode' => 'required|string|in:Creditcard,Bankoverschrijving,Contant',
        ]);

        $this->FactuurModel->sp_WijzigFactuur(
            $validatedData['Id'],
            $validatedData['PassagierId'],
            $validatedData['Factuurdatum'],
            $validatedData['TotaalBedrag'],
            $validatedData['Betaalmethode']
        );

        return redirect()->route('facturatie.index')->with('success', 'Factuur succesvol bijgewerkt.');
    }
}
