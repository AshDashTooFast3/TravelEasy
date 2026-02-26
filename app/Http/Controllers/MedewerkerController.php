<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Boeking;

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



        return view('management-dashboard');
    }
}
