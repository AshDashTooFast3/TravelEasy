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

    public function sp_PakBoekingenAantal(): int
    {
        Log::info('sp_PakBoekingenAantal: Start');
        try {
            $result = DB::select('CALL sp_PakBoekingenAantal()');
            if (empty($result)) {
                Log::info('sp_PakBoekingenAantal: Lege result ontvangen');
                return -1;
            }
            $count = $result[0]->count ?? -1;
            Log::info('sp_PakBoekingenAantal: Resultaat='.$count);
            return $count;
        } catch (\Exception $e) {
            Log::error('sp_PakBoekingenAantal: Exception='.$e->getMessage());
            return -1;
        }
    }

    public function sp_MeestVoorkomendeReis()
    {
        Log::info('sp_MeestVoorkomendeReis: Start');
        try {
            $result = DB::select('CALL sp_MeestVoorkomendReis()');
            if (empty($result)) {
                Log::info('sp_MeestVoorkomendeReis: Lege result ontvangen');
                return [];
            }
            Log::info('sp_MeestVoorkomendeReis: Aantal resultaten='.count($result));
            return $result;
        } catch (\Exception $e) {
            Log::error('sp_MeestVoorkomendeReis: Exception='.$e->getMessage());
            return [];
        }
    }
}
