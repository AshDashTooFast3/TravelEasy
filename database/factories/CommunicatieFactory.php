<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Medewerker;
use \App\Models\Patient;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Communicatie>
 */
class CommunicatieFactory extends Factory
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
            'MedewerkerId' => Medewerker::factory(),
            'Bericht' => $this->faker->sentence(),
            'VerzondenDatum' => null,
            'Status' => $this->faker->randomElement(['Betaald', 'Onbetaald', 'In behandeling', 'Afgehandeld']),
            'Isactief' => true,
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
