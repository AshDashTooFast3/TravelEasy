<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
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

    public function passagier()
    {
        return $this->belongsTo(Passagier::class, 'PassagierId', 'Id');
    }

    public function vlucht()
    {
        return $this->belongsTo(Vlucht::class, 'VluchtId', 'Id');
    }
    
}
