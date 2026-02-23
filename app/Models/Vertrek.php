<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vertrek extends Model
{
    /** @use HasFactory<\Database\Factories\VertrekFactory> */
    use HasFactory;

    protected $table = 'Vertrek';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Land',
        'Luchthaven',
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
}
