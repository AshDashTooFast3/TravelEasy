<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vlucht extends Model
{
    /** @use HasFactory<\Database\Factories\VluchtFactory> */
    use HasFactory;

    protected $table = 'Vlucht';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';
    
    protected $fillable = [
        'VertrekId',
        'BestemmingId',
        'Vluchtnummer',
        'Vertrekdatum',
        'Vertrektijd',
        'Aankomstdatum',
        'Aankomsttijd',
        'Vluchtstatus',
        'IsActief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function vertrek()
    {
        return $this->belongsTo(Vertrek::class, 'VertrekId');
    }

    public function bestemming()
    {
        return $this->belongsTo(Bestemming::class, 'BestemmingId');
    }
}
