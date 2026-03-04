<?php

namespace Database\Factories;

use App\Models\Boeking;
use App\Models\Passagier;
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
            'BoekingId' => Boeking::factory(),
            'PassagierId' => Passagier::factory(),
            'Factuurnummer' => $this->faker->unique()->numerify('FAC-####'),
            'Factuurdatum' => $this->faker->date(),
            'Factuurtijd' => $this->faker->time(),
            'TotaalBedrag' => $this->faker->randomFloat(2, 10, 1000),
            'Betaalstatus' => $this->faker->randomElement(['Betaald', 'Openstaand', 'Geannuleerd']),
            'Betaalmethode' => $this->faker->randomElement(['Creditcard', 'Pinnen', 'Overschrijving']),
            'Isactief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->sentence(),
            'Datumaangemaakt' => $this->faker->dateTime(),
            'Datumgewijzigd' => $this->faker->dateTime(),
        ];
    }
}
