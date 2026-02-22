<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Afspraak>
 */
class AfspraakFactory extends Factory
{
    public function definition(): array
    {
        return [
            'PatientId' => \App\Models\Patient::factory(), // Ensures a valid Patient is created
            'MedewerkerId' => \App\Models\Medewerker::factory(), // Ensures a valid Medewerker is created
            'Datum' => $this->faker->date(),
            'Tijd' => $this->faker->time(),
            'Status' => $this->faker->randomElement(['Bevestigd', 'Geannuleerd']),
            'Isactief' => true,
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt'=> now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
