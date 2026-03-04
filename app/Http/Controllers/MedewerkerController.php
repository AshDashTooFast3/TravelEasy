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
        $data = [
            'aantalBoekingen' => $this->BoekingModel->sp_getBoekingenCount(),
            'MeestVoorkomendeReis' => $this->BoekingModel->sp_getMeestVoorkomendeReis(),
        ];

        if (! $data['aantalBoekingen']) {
            Log::info('Er is een fout opgetreden bij de aantalBoekingen stored procedure');
        }

        if (! $data['MeestVoorkomendeReis']) {
            Log::info('Er is een fout opgetreden bij de MeestVoorkomendeReis stored procedure');
        }

        return view('management-dashboard', [
            'title' => 'Management Dashboard',
            'aantalBoekingen' => $data['aantalBoekingen'],
            'MeestVoorkomendeReis' => $data['MeestVoorkomendeReis'],
        ]);
    }
}
