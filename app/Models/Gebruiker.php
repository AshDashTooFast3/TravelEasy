<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Gebruiker extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Gebruiker';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Gebruikersnaam',
        'Wachtwoord',
        'Email',
        'RolNaam',
        'Ingelogd',
        'Uitgelogd',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    protected $hidden = [
        'Wachtwoord',
        'remember_token',
    ];

    protected $casts = [
        'Ingelogd' => 'datetime',
        'Uitgelogd' => 'datetime',
    ];

    public function personen()
    {
        return $this->hasMany(Persoon::class, 'GebruikerId');
    }

    public function passagier()
    {
        return $this->hasOneThrough(
            Passagier::class,
            Persoon::class,
            'GebruikerId', // Persoon.GebruikerId
            'PersoonId',   // Passagier.PersoonId
            'Id',          // Gebruiker.Id
            'Id'           // Persoon.Id
        );
    }

    // Laravel will use this column for password verification
    public function getAuthPassword()
    {
        return $this->Wachtwoord;
    }
}
