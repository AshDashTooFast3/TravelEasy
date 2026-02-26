<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $reizen = [
            [
                'titel' => 'Zomervakantie Spanje',
                'type' => 'Vliegtuig',
                'prijs' => 599,
                'beschrijving' => 'Geniet van zon, zee en strand in Spanje.'
            ],
            [
                'titel' => 'Mediterrane Cruise',
                'type' => 'Cruise',
                'prijs' => 1299,
                'beschrijving' => 'Luxe cruise langs de mooiste steden.'
            ],
            [
                'titel' => 'Busreis Parijs',
                'type' => 'Bus',
                'prijs' => 199,
                'beschrijving' => 'Ontdek Parijs in een comfortabele bus.'
            ]
        ];

        return view('welcome', compact('reizen')); // <-- stuur $reizen door
    }
}