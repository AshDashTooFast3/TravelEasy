<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boeking;

class BoekingController extends Controller
{
    private $BoekingModel;
    
    public function __construct()
    {
        $this->BoekingModel = new Boeking();
    }

    public function index()
    {
        // Ophalen van alle boekingen + alle benodigde relaties
        $boekingen = Boeking::with([
            'vlucht.bestemming',
            'vlucht.vertrek',
            'accommodatie'
        ])->get();

        // Doorsturen naar de view
        return view('boekingen.index', compact('boekingen'));
    }

}


//  php artisan tinker
    /*
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('Boeking')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    */
//    Boeking::factory()->count(5)->create();



