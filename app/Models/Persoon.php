<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Persoon extends Model
{
    use HasFactory;
    protected $table = 'Persoon';

    public $timestamps = false;

    protected $fillable = [
        'GebruikerId',
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Geboortedatum',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function gebruiker()
    {
        return $this->belongsTo(Gebruiker::class, 'GebruikerId');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'PersoonId', 'Id');
    }
    public function medewerker()
{
    return $this->hasOne(MedewerkerOverzichtModel::class, 'PersoonId', 'Id');
}

}