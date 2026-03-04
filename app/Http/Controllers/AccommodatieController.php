<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accommodatie;

class AccommodatieController extends Controller
{
    public function index()
    {
        $accommodaties = Accommodatie::all();
        return view('accomodatie.index')
        ->with('accommodaties', $accommodaties);
    }

    public function edit($id)
    {
        $accommodatie = Accommodatie::findOrFail($id);
        return view('accomodatie.edit', compact('accommodatie'));
    }

}
