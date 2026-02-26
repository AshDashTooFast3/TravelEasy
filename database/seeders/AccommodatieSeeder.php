<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Accommodatie;
use SebastianBergmann\FileIterator\Factory;

class AccommodatieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accommodatie::factory()->count(10)->create();
    }
}
