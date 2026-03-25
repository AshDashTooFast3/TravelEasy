<?php

namespace App\Http\Controllers;

// Importeer de benodigde modellen en klassen
use App\Models\Factuur;
use App\Models\Passagier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FactuurController extends Controller
{
    // Private eigenschappen voor de model-instanties
    private $FactuurModel;

    private $PassagierModel;

    // Constructor: initialiseer de modellen bij het aanmaken van de controller
    public function __construct()
    {
        $this->FactuurModel = new Factuur;
        $this->PassagierModel = new Passagier;
    }

    // Haal alle facturen op en toon de overzichtspagina
    public function index()
    {
        // Roep de stored procedure aan om alle facturen op te halen
        $facturen = $this->FactuurModel->sp_PakAlleFacturen();

        // Stuur de facturen door naar de index-view
        return view('facturatie.index', [
            'title' => 'Facturen overzicht',
            'facturen' => $facturen,
        ]);
    }

    // Laad de bewerkpagina voor een specifieke factuur op basis van ID
    public function bewerken($id)
    {
        try {
            // Zoek de factuur op via het opgegeven ID
            $factuur = $this->FactuurModel->PakFactuurBijId($id);

            // Als de factuur niet bestaat, log een waarschuwing en stuur terug met foutmelding
            if (! $factuur) {
                Log::warning('Factuur niet gevonden: '.$id);

                return redirect()->route('facturatie.index')->with('error', 'Factuur niet gevonden.');
            }

            // Factuur succesvol geladen, log ter bevestiging
            Log::info('Factuur succesvol geladen: '.$id);
        } catch (\Exception $e) {
            // Vang onverwachte fouten op bij het ophalen van de factuur
            Log::error('Fout bij laden factuur: '.$e->getMessage());

            return redirect()->route('facturatie.index')->with('error', 'Fout bij het laden van de factuur.');
        }

        try {
            // Haal alle passagiers op voor het bewerkformulier (bijv. dropdown)
            $passagiers = $this->PassagierModel->PakAllePassagiers();
            Log::info('Passagiers succesvol geladen');
        } catch (\Exception $e) {
            // Vang fouten op bij het ophalen van passagiers
            Log::error('Fout bij laden passagiers: '.$e->getMessage());

            return redirect()->route('facturatie.index')->with('error', 'Fout bij het laden van de passagiers.');
        }

        // Stuur de factuur- en passagiersdata door naar de bewerk-view
        return view('facturatie.bewerken', [
            'title' => 'Factuur bewerken',
            'factuur' => $factuur,
            'passagiers' => $passagiers,
        ]);
    }

    // Verwerk het formulier om een factuur te wijzigen
    public function wijzigen(Request $request)
    {
        try {
            // Valideer alle binnenkomende formuliergegevens
            $validatedData = $request->validate([
                'Id' => 'required|integer|exists:Factuur,Id', // Id moet bestaan in de database
                'PassagierId' => 'required|integer',
                'Factuurdatum' => 'required|date',
                'TotaalBedrag' => 'required|numeric|min:0',             // Bedrag mag niet negatief zijn
                'Betaalmethode' => 'required|string|in:Creditcard,Bankoverschrijving,Contant', // Alleen toegestane waarden
                'Betaalstatus' => 'required|string',
            ]);

            // Haal alle facturen op voor eventuele terugkeer naar de overzichtspagina
            $facturen = $this->FactuurModel->sp_PakAlleFacturen();

            // Controleer de betaalstatus en handel dienovereenkomstig
            switch ($validatedData['Betaalstatus']) {
                // Factuur is al betaald: blokkeer wijziging
                case 'Betaald':
                    Log::warning('Poging om betaalde factuur aan te passen: '.$validatedData['Id']);

                    return redirect()->route('facturatie.index')->with([
                        'title' => 'Facturen overzicht',
                        'error' => 'Kan de factuur niet wijzigen, omdat de factuur al is betaald',
                        'facturen' => $facturen,
                    ]);

                    // Alle andere statussen: voer de wijziging daadwerkelijk uit
                default:
                    // Roep de stored procedure aan om de factuur bij te werken
                    $this->FactuurModel->sp_WijzigFactuur(
                        $validatedData['Id'],
                        $validatedData['PassagierId'],
                        $validatedData['Factuurdatum'],
                        $validatedData['TotaalBedrag'],
                        $validatedData['Betaalmethode']
                    );

                    // Log de succesvolle update met de gewijzigde gegevens
                    Log::info('Factuur succesvol bijgewerkt: '.$validatedData['Id'], [
                        'PassagierId' => $validatedData['PassagierId'],
                        'Factuurdatum' => $validatedData['Factuurdatum'],
                        'TotaalBedrag' => $validatedData['TotaalBedrag'],
                        'Betaalmethode' => $validatedData['Betaalmethode'],
                    ]);

                    // Redirect naar het overzicht met een succesmelding
                    return redirect()->route('facturatie.index')->with('success', 'Factuur succesvol bijgewerkt.');
            }
        } catch (\Exception $e) {
            // Vang alle onverwachte fouten op tijdens het wijzigingsproces
            Log::error('Fout in wijzigen: '.$e->getMessage());

            return redirect()->route('facturatie.index')->with('error', 'Fout bij het bijwerken van de factuur.');
        }
    }

    public function annuleren($id)
    {
        try {
            // Haal de factuur op voordat je deze annuleert
            $factuur = $this->FactuurModel->PakFactuurBijId($id);

            // Controleer of de factuur bestaat
            if (! $factuur) {
                Log::warning('Poging om niet-bestaande factuur te annuleren: '.$id);

                return redirect()->route('facturatie.index')->with('error', 'Factuur niet gevonden.');
            }

            // Controleer of de factuur al betaald is
            if ($factuur['Betaalstatus'] === 'Betaald') {
                Log::warning('Poging om betaalde factuur te annuleren: '.$id);

                return redirect()->route('facturatie.index')->with('error', 'Kan de factuur niet annuleren, omdat deze al is betaald.');
            }

            // Roep de stored procedure aan om de factuur te annuleren
            $this->FactuurModel->sp_AnnuleerFactuur($id);

            // Log de succesvolle annulering
            Log::info('Factuur succesvol geannuleerd: '.$id);

            // Redirect naar het overzicht met een succesmelding
            return redirect()->route('facturatie.index')->with('success', 'Factuur succesvol geannuleerd.');
        } catch (\Exception $e) {
            // Vang alle onverwachte fouten op
            Log::error('Fout bij annuleren factuur: '.$e->getMessage());

            return redirect()->route('facturatie.index')->with('error', 'Fout bij het annuleren van de factuur.');
        }
    }
}
