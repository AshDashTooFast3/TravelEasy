<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boeking extends Model
{
    protected $table = 'boekingen';

    protected $fillable = [
        'VluchtId',
        'AccommodatieId',
        'Boekingsnummer',
        'Boekingsdatum',
        'Boekingstijd',
        'Boekingsstatus',
        'TotaalPrijs',
        'IsActief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd'
    ];

    public function vlucht()
    {
        return $this->belongsTo(Vlucht::class, 'VluchtId');
    }

    public function accommodatie()
    {
        return $this->belongsTo(Accommodatie::class, 'AccommodatieId');
    }

}
