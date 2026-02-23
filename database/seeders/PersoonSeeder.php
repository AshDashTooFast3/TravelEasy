<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Persoon;

class PersoonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Persoon::factory()->create([
            'GebruikerId' => 2,
            'Voornaam' => 'Achraf',
            'Tussenvoegsel' => 'El',
            'Achternaam' => 'Arrasi',
            'Geboortedatum' => '2006-01-01',
            'Isactief' => true,
        ]);
    }
}
