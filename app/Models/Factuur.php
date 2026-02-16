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
        'PatientId',
        'BehandelingId',
        'Nummer',
        'Omschrijving',
        'Datum',
        'Tijd',
        'Bedrag',
        'Status',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public static function getAllFacturen()
    {
        // Haalt alle facturen op via de stored procedure
        try {
            $result = DB::select('CALL sp_GetAllFactuur()');

            if (is_null($result)) {
                //logt als de result null is
                Log::warning('sp_GetAllFactuur retourneerde null.');

                return [];
            } elseif (empty($result)) {
                //logd als de array leeg is
                Log::info('sp_GetAllFactuur retourneerde een lege array.');

                return [];
            }

            return $result;

        } catch (\Exception $e) {
            //log
            Log::error('Fout bij het ophalen van facturen: '.$e->getMessage());

            return [];
        }
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId', 'Id');
    }

    public function behandeling()
    {
        return $this->belongsTo(Behandeling::class, 'BehandelingId', 'Id');
    }

    /*Probeert om de sp_OmzetBerekenen in de database aan te roepen,
    anders geeft hij een error en stuurt hij een lege array terug en logt de error in storage/logs/laravel.log
    */

    public function BerekenOmzet()
    {
        try {
            $result = DB::select('CALL sp_OmzetBerekenen()');

            if ($result === null) {
                Log::warning('sp_OmzetBerekenen retourneerde null.');

                return [];
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Fout in BerekenOmzet: '.$e->getMessage());

            return [];
        }
    }
}
