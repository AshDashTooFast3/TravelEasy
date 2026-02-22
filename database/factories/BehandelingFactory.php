<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Behandeling>
 */
class BehandelingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prijzen = [
            'Controles' => 50.00,
            'Vullingen' => 150.00,
            'Gebitsreiniging' => 75.00,
            'Orthodontie' => 500.00,
            'Wortelkanaalbehandelingen' => 350.00,
        ];

        $behandelingtype = $this->faker->randomElement(array_keys($prijzen));

        return [
            'MedewerkerId' => \App\Models\Medewerker::factory(),
            'PatientId' => \App\Models\Patient::factory(),
            'Datum' => $this->faker->date(),
            'Tijd' => $this->faker->time(),
            'Behandelingtype' => $behandelingtype,
            'Omschrijving' => $this->faker->optional()->sentence(),
            'Kosten' => $prijzen[$behandelingtype],
            'Status' => $this->faker->randomElement(['Behandeld', 'Onbehandeld', 'Uitgesteld']),
            'Isactief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => $this->faker->dateTime(),
            'Datumgewijzigd' => $this->faker->optional()->dateTime(),
        ];
    }
}
