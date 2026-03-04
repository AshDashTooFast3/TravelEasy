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
        return view('facturatie.index');
    }
}
