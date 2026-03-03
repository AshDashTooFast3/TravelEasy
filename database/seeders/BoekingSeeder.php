<?php

namespace Database\Seeders;

use App\Models\Boeking;
use Illuminate\Database\Seeder;

class BoekingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Boeking::create([
            'VluchtId' => 1,
            'AccommodatieId' => 1,
            'Boekingsnummer' => 'BK001',
            'Boekingsdatum' => now(),
            'Boekingstijd' => now(),
            'Boekingsstatus' => 'Bevestigd',
            'TotaalPrijs' => 1500.00,
            'IsActief' => true,
            'Opmerking' => 'Test boeking',
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ]);

            Boeking::create([
                'VluchtId' => 1,
                'AccommodatieId' => 1,
                'Boekingsnummer' => 'BK002',
                'Boekingsdatum' => now(),
                'Boekingstijd' => now(),
                'Boekingsstatus' => 'Bevestigd',
                'TotaalPrijs' => 2000.00,
                'IsActief' => true,
                'Opmerking' => 'Test boeking 2',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ]);

            Boeking::create([
                'VluchtId' => 1,
                'AccommodatieId' => 1,
                'Boekingsnummer' => 'BK003',
                'Boekingsdatum' => now(),
                'Boekingstijd' => now(),
                'Boekingsstatus' => 'Bevestigd',
                'TotaalPrijs' => 1800.00,
                'IsActief' => true,
                'Opmerking' => 'Test boeking 3',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ]);
             Boeking::create([
                'VluchtId' => 1,
                'AccommodatieId' => 1,
                'Boekingsnummer' => 'BK003',
                'Boekingsdatum' => now(),
                'Boekingstijd' => now(),
                'Boekingsstatus' => 'Bevestigd',
                'TotaalPrijs' => 1800.00,
                'IsActief' => true,
                'Opmerking' => 'Test boeking 3',
                'Datumaangemaakt' => now(),
                'Datumgewijzigd' => now(),
            ]);

        Boeking::factory()->count(5)->create();
    }
}
