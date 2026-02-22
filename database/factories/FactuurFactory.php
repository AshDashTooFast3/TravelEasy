<?php

namespace Database\Factories;

use App\Models\Behandeling;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factuur>
 */
class FactuurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'PatientId' => Patient::factory(),
            'BehandelingId' => Behandeling::factory(),
            'Nummer' => $this->faker->unique()->bothify('FCT-#####'),
            'Omschrijving' => $this->faker->sentence(),
            'Datum' => $this->faker->date(),
            'Tijd' => $this->faker->time('H:i'),
            'Bedrag' => $this->faker->randomFloat(2, 50, 1000),
            'Status' => $this->faker->randomElement(['Verzonden', 'Niet-Verzonden', 'Betaald', 'Onbetaald']),
            'Isactief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => $this->faker->dateTime(),
            'Datumgewijzigd' => $this->faker->optional()->dateTime(),

        ];
    }
}
