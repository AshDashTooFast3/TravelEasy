<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Models\Passagier;

class PassagierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Passagier::factory()->count(5)->create();
    }
}
