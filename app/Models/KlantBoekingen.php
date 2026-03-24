<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class KlantBoekingen extends Model
{
    protected $table = 'Boeking';
    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'PassagierId',
        'VluchtId',
        'AccommodatieId',
        'TotaalPrijs',
        'Boekingsdatum',
        'Boekingstijd',
        'Boekingsstatus',
        'IsActief',
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