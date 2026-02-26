<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boeking extends Model
{
    use HasFactory;
    protected $table = 'Boeking';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';
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
