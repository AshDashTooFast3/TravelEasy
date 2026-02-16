<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medewerker extends Model
{
    use HasFactory;
    protected $table = 'Medewerker';

    public $timestamps = false;

    protected $fillable = [
        'PersoonId',
        'Nummer',
        'Medewerkertype',
        'Specialisatie',
        'Beschikbaarheid',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    // A Medewerker belongs to a Persoon
    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }

}
