<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medewerker;

class MedewerkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Maak 20 medewerkers met realistische data
        Medewerker::factory()->count(1)->create();
    }
}
