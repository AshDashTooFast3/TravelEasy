<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factuur extends Model
{
    use HasFactory;

    protected $table = 'Factuur';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'BoekingId',
        'PassagierId',
        'Factuurnummer',
        'Factuurdatum',
        'Factuurtijd',
        'TotaalBedrag',
        'Betaalstatus',
        'Betaalmethode',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function boeking()
    {
        return $this->belongsTo(Boeking::class, 'BoekingId', 'Id');
    }

    public function passagier()
    {
        return $this->belongsTo(Passagier::class, 'PassagierId', 'Id');
    }
}
