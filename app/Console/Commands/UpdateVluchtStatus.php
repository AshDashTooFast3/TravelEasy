<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vlucht;
use App\Models\GeboekteReis;

class UpdateVluchtStatus extends Command
{
    protected $signature = 'vlucht:status {vluchtId} {status}';
    protected $description = 'Wijzig de status van een vlucht en alle bijbehorende geboekte reizen';

    public function handle()
    {
        $vluchtId = $this->argument('vluchtId');
        $status = $this->argument('status');

        // Update vlucht
        $vlucht = Vlucht::find($vluchtId);

        if (!$vlucht) {
            $this->error("Vlucht met ID {$vluchtId} bestaat niet.");
            return;
        }

        $vlucht->Vluchtstatus = $status;
        $vlucht->save();

        // Update geboekte reizen
        $aantal = GeboekteReis::where('VluchtId', $vluchtId)
            ->update(['Vluchtstatus' => $status]);

        $this->info("Vlucht {$vlucht->Vluchtnummer} status gewijzigd naar: {$status}");
        $this->info("{$aantal} geboekte reizen bijgewerkt.");
    }
}
/*
|--------------------------------------------------------------------------
| Handleiding voor gebruik van dit command
|--------------------------------------------------------------------------
|
| 1. Vlucht-ID opvragen via Tinker
|    Gebruik Tinker om te achterhalen welke VluchtId je moet aanpassen.
|
|    php artisan tinker
|
|    // Toon alle vlucht-ID's uit geboekte reizen
|    \App\Models\GeboekteReis::pluck('VluchtId');
|
|    // Toon unieke vlucht-ID's
|    \App\Models\GeboekteReis::pluck('VluchtId')->unique();
|
|    // Toon alle geboekte reizen voor een specifieke vlucht
|    \App\Models\GeboekteReis::where('VluchtId', Id)->get();
|
|
| 2. Status controleren via Tinker
|
|    // Status in vluchten-tabel
|    \App\Models\Vlucht::find(Id)->Vluchtstatus;
|
|    // Status in geboekte_reizen-tabel
|    \App\Models\GeboekteReis::where('VluchtId', Id)->pluck('Vluchtstatus');
|
|
| 3. Status wijzigen met het custom command
|
|    php artisan vlucht:status {vluchtId} {status}
|
|    Status:
|    - Gepland
|    - Vertrokken
|    - Geannuleerd
|    - Geland
|    - Vertraagd
|
|    Dit command:
|    - past de status aan in de 'vluchten' tabel
|    - past de status aan in alle bijbehorende 'geboekte_reizen' records
|
*/