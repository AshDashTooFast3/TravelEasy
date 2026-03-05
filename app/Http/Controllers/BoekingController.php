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
        return view('boekingen.index');
    }

}
