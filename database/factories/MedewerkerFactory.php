<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medewerker>
 */
class MedewerkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'PersoonId' => \App\Models\Persoon::factory(),
            'Nummer' => $this->faker->unique()->numerify('M####'),

          
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
