<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'Ticket';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'PassagierId',
        'VluchtId',
        'Stoelnummer',
        'Aankoopdatum',
        'Aankooptijd',
        'Aantal',
        'BedragInclBtw',
        'IsActief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'Datumaangemaakt' => 'datetime',
        'Datumgewijzigd' => 'datetime',
    ];

    //  Ticket hoort bij één passagier
    public function passagier()
    {
        return $this->belongsTo(Passagier::class, 'PassagierId', 'Id');
    }

    //  Ticket hoort bij één vlucht
    public function vlucht()
    {
        return $this->belongsTo(Vlucht::class, 'VluchtId', 'Id');
    }

    //  Ticket hoort bij één boeking
    public function boeking()
    {
        return $this->belongsTo(Boeking::class, 'BoekingId', 'Id');
    }
}