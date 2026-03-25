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
        'Vluchtstatus',
        'IsActief',
    ];

    //  Boeking hoort bij één passagier
    public function passagier()
    {
        return $this->belongsTo(Passagier::class, 'PassagierId', 'Id');
    }

    //  Boeking hoort bij één vlucht
    public function vlucht()
    {
        return $this->belongsTo(Vlucht::class, 'VluchtId', 'Id');
    }

    //  Boeking hoort bij één accommodatie
    public function accommodatie()
    {
        return $this->belongsTo(Accommodatie::class, 'AccommodatieId', 'Id');
    }

    //  Boeking heeft meerdere tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'BoekingId', 'Id');
    }
    public function getVluchtstatusColorAttribute()
{
    return match ($this->Vluchtstatus) {
        'Gepland' => 'secondary',
        'Vertrokken' => 'primary',
        'Geland' => 'success',
        'Geannuleerd' => 'danger',
        default => 'secondary',
    };
}
}