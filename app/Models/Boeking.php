<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Boeking extends Model
{
    use HasFactory;

    protected $table = 'Boeking';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'VluchtId',
        'AccommodatieId',
        'Boekingsnummer',
        'Boekingsdatum',
        'Boekingstijd',
        'Boekingsstatus',
        'TotaalPrijs',
        'IsActief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function vlucht()
    {
        return $this->belongsTo(Vlucht::class, 'VluchtId');
    }

    public function accommodatie()
    {
        return $this->belongsTo(Accommodatie::class, 'AccommodatieId');
    }

    // Stored procedure om het totaal aantal boekingen op te halen
    public function sp_getBoekingenCount(): int
    {
        try {
            $result = DB::select('CALL sp_getBoekingenCount()');

            if (empty($result)) {
                Log::info('sp_getBoekingenCount retourneerde een lege result omdat er geen data kon opgehaald worden.');

                return -1;
            }
            Log::info('sp_getBoekingenCount retourneerde een count van '.$result[0]->count.'.');
            return $result[0]->count ?? -1;

        } catch (\Exception $e) {
            Log::error('Fout in sp_getBoekingenCount: '.$e->getMessage());

            return -1;
        }
    }

    // Stored procedure om de meest voorkomende reis op te halen
    public function sp_getMeestVoorkomendeReis()
    {
        try {
            $result = DB::select('CALL sp_MeestVoorkomendReis()');

            if (empty($result)) {
                Log::info('sp_MeestVoorkomendReis retourneerde een lege result omdat er geen data kon opgehaald worden.');

                return [];
            }
            Log::info('sp_MeestVoorkomendReis retourneerde '.count($result).' resultaten.');
            return $result;

        } catch (\Exception $e) {
            Log::error('Fout in sp_MeestVoorkomendReis: '.$e->getMessage());

            return [];
        }
    }
}
