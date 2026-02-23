<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodatie extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodatieFactory> */
    use HasFactory;

    protected $table = 'Accommodatie';
    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'VluchtId',
        'Naam',
        'Type',
        'Straat',
        'Huisnummer',
        'Toevoeging',
        'Postcode',
        'Stad',
        'Land',
        'CheckInDatum',
        'CheckOutDatum',
        'AantalKamers',
        'AantalPersonen',
        'PrijsPerNacht',
        'TotaalPrijs',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'CheckInDatum' => 'date',
        'CheckOutDatum' => 'date',
        'Datumaangemaakt' => 'datetime',
        'Datumgewijzigd' => 'datetime',
        'IsActief' => 'boolean',
    ];
}
