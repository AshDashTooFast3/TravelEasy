<?php

namespace App\Http\Controllers;

use App\Models\Boeking;
use Illuminate\Support\Facades\Log;

class MedewerkerController extends Controller
{
    private $BoekingModel;

    public function __construct()
    {
        $this->BoekingModel = new Boeking;
    }

    // pagina voor alle medewerkers
    public function index()
    {

        return view('dashboard');
    }

    // Alleen Administrators en Managers kunnen deze pagina zien
    public function ManagementDashboard()
    {
        try {
            $data = [
                'AantalBoekingen' => $this->BoekingModel->sp_PakBoekingenAantal(),
                'MeestVoorkomendeReis' => $this->BoekingModel->sp_MeestVoorkomendeReis(),
            ];

            // kijkt of er resultaten zijn voor de AantalBoekingen stored procedure
            if (! $data['AantalBoekingen']) {
                Log::info('Er is een fout opgetreden bij de AantalBoekingen stored procedure');
            } else {
                Log::info('AantalBoekingen: '.$data['AantalBoekingen']);
            }

            // kijkt of er resultaten zijn voor de MeestVoorkomendeReis stored procedure
            if (! $data['MeestVoorkomendeReis']) {
                Log::info('Er is een fout opgetreden bij de MeestVoorkomendeReis stored procedure');
            } else {
                Log::info('Boekingen voor meest voorkomende reis bestaan');
            }

            if ($data['AantalBoekingen'] > 0) {
                Log::info('Aantal boekingen opgehaald: '.$data['AantalBoekingen']);
            } else {
                Log::info('Geen boekingen gevonden in de database.');
            }
        } catch (\Exception $e) {
            Log::error('Error in ManagementDashboard: '.$e->getMessage());
            $data = [
                'AantalBoekingen' => 0,
                'MeestVoorkomendeReis' => [],
            ];
        }

        return view('management-dashboard', [
            'title' => 'Management Dashboard',
            'AantalBoekingen' => $data['AantalBoekingen'],
            'MeestVoorkomendeReis' => $data['MeestVoorkomendeReis'],
        ]);
    }
}
