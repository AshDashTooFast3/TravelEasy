<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passagier extends Model
{
    /** @use HasFactory<\Database\Factories\PassagierFactory> */
    use HasFactory;

    protected $table = 'Passagier';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'PersoonId',
        'Nummer',
        'PassagierType',
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

    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }
}
