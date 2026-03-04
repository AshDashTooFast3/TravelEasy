<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factuur;

class FactuurController extends Controller
{
    private $FactuurModel;
    public function __construct()
    {
        $this->FactuurModel = new Factuur;
    }
    public function index()
    {
        $facturen = $this->FactuurModel->sp_getAllFactuurs();


        return view('facturatie.index',  [
            'title' => 'Facturen overzicht',
            'facturen' => $facturen
        ]);
    }
}
