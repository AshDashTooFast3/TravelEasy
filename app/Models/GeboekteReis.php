<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeboekteReis extends Model
{
    protected $table = 'geboekte_reizen';

    protected $fillable = [
        'GebruikerId',
        'PersoonId',
        'PassagierId',
        'BoekingId',
        'TicketId',
        'VluchtId',
        'AccommodatieId',
        'Vluchtstatus',
        'Boekingsstatus',
        'TotaalPrijs',
    ];

    public function vlucht()
    {
        return $this->belongsTo(Vlucht::class, 'VluchtId', 'Id');
    }

    public function accommodatie()
    {
        return $this->belongsTo(Accommodatie::class, 'AccommodatieId', 'Id');
    }

    public function boeking()
    {
        return $this->belongsTo(Boeking::class, 'BoekingId', 'Id');
    }

    public function passagier()
    {
        return $this->belongsTo(Passagier::class, 'PassagierId', 'Id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'TicketId', 'Id');
    }
}