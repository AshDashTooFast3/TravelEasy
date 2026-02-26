<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Medewerker;

class MedewerkerController extends Controller
{
    private $MedewerkerModel;
    public function __construct() {
        $this->MedewerkerModel = new Medewerker();
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
