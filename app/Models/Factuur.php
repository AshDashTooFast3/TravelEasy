<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Factuur extends Model
{
    use HasFactory;

    protected $table = 'Factuur';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'BoekingId',
        'PassagierId',
        'Factuurnummer',
        'Factuurdatum',
        'Factuurtijd',
        'TotaalBedrag',
        'Betaalstatus',
        'Betaalmethode',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function boeking()
    {
        return $this->belongsTo(Boeking::class, 'BoekingId', 'Id');
    }

    public function passagier()
    {
        return $this->belongsTo(Passagier::class, 'PassagierId', 'Id');
    }

    public function sp_PakAlleFacturen()
    {
        try {
            $result = DB::select('CALL sp_PakAlleFacturen()');

            if (empty($result)) {
                Log::info('sp_PakAlleFacturen retourneerde een lege result omdat er geen data kon worden opgehaald.');

                return [];
            }
            Log::info('sp_PakAlleFacturen retourneerde '.count($result).' resultaten.');

            return $result;

        } catch (\Exception $e) {
            Log::error('Fout in sp_PakAlleFacturen: '.$e->getMessage());

            return [];
        }
    }

    public function PakFactuurBijId($factuurId) {
        
        return DB::selectOne('CALL sp_PakFactuurBijId(?)', [$factuurId]);
    }

    public function sp_FactuurWijzigen($Id, $BoekingId, $PassagierId, $Factuurnummer, $Factuurdatum, $Factuurtijd, $TotaalBedrag, $Betaalstatus, $Betaalmethode, $Isactief, $Opmerking)
    {
        try {
            DB::statement('CALL sp_WijzigFactuur(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $Id,
                $BoekingId,
                $PassagierId,
                $Factuurnummer,
                $Factuurdatum,
                $Factuurtijd,
                $TotaalBedrag,
                $Betaalstatus,
                $Betaalmethode,
                $Isactief,
                $Opmerking,
            ]);
            Log::info('sp_WijzigFactuur succesvol uitgevoerd voor FactuurId: '.$Id);

            return $Id;
        } catch (\Exception $e) {
            Log::error('Fout in sp_WijzigFactuur: '.$e->getMessage());

            return -1;
        }
    }
}
