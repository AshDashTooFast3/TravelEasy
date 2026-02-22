<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Correct base class
use Illuminate\Notifications\Notifiable;

class Gebruiker extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Gebruiker';

    protected $primaryKey = 'Id'; // ← add this

    public $timestamps = false;

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

    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Persoon::class,
            'GebruikerId', // Persoon.GebruikerId
            'PersoonId',   // Patient.PersoonId
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
