<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gebruiker>
 */

class PatientFactory extends Factory
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
            'Nummer' => $this->faker->unique()->numerify('P####'),
            'MedischDossier' => $this->faker->optional()->text(100),
            'Isactief' => true,
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),

        ];
    }
}
