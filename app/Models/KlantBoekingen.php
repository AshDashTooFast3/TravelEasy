<?php

namespace App\Models;

class KlantBoekingen
{
    public static function get()
    {
        return Boeking::with(['vlucht', 'accommodatie'])->get();
    }
}