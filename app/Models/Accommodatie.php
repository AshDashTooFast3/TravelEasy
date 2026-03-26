<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodatie extends Model
{
    /** @use HasFactory<\Database\Factories\AccommodatieFactory> */
    use HasFactory;

    // Tabel naam in de database
    protected $table = 'Accommodatie';
    
    // Primaire sleutel
    protected $primaryKey = 'Id';

    // Timestamps zijn niet automatisch aangemaakt
    public $timestamps = false;

    // Aangepaste timestamp kolom names
    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    // Mass assignable attributes
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

    // Type casting voor attributen
    protected $casts = [
        'CheckInDatum' => 'date',
        'CheckOutDatum' => 'date',
        'Datumaangemaakt' => 'datetime',
        'Datumgewijzigd' => 'datetime',
        'IsActief' => 'boolean',
    ];

    // Relatie: een accommodatie kan meerdere accommodaties hebben
    public function accommodaties()
{
    return $this->hasMany(Accommodatie::class, 'VluchtId');
}

}
