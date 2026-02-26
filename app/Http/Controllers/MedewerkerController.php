<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Boeking;
use Illuminate\Support\Facades\Log;

class MedewerkerController extends Controller
{
    private $BoekingModel;

    public function __construct() {
        $this->BoekingModel = new Boeking();
    }
    
    //pagina voor alle medewerkers
    public function index() {

        return view('dashboard');
    }

    // Alleen Administrators en Managers kunnen deze pagina zien
    public function ManagementDashboard() {

        $aantalBoekingen = $this->BoekingModel->sp_getBoekingenCount();

        if($aantalBoekingen > 0) {
          Log::info('Aantal boekingen opgehaald: '.$aantalBoekingen);
        }

        return view('management-dashboard', [
            'title' => 'Management Dashboard',
            'aantalBoekingen' => $aantalBoekingen
        ]);
    }
}
