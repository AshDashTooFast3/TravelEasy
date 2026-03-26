<?php

namespace Database\Factories;

use App\Models\Accommodatie;
use App\Models\Vlucht;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boeking>
 */
class BoekingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'VluchtId' => Vlucht::factory(),
            'AccommodatieId' => Accommodatie::factory(),
            'Boekingsnummer' => $this->faker->unique()->numerify('BN-######'),
            'Boekingsdatum' => $this->faker->dateTimeBetween('2000-01-01', 'now'),
            'Boekingstijd' => $this->faker->time(),
            'Boekingsstatus' => $this->faker->randomElement(['In behandeling', 'Bevestigd', 'Geannuleerd']),
            'TotaalPrijs' => $this->faker->randomFloat(2, 100, 5000),
            'IsActief' => $this->faker->boolean(90),
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}

