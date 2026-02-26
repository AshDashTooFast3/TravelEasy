<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vlucht;
use App\Models\Accommodatie;

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
            'Boekingsnummer' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{6}'),
            'Boekingsdatum' => $this->faker->date(),
            'Boekingstijd' => $this->faker->time(),
            'Boekingsstatus' => $this->faker->randomElement(['confirmed', 'pending', 'cancelled']),
            'TotaalPrijs' => $this->faker->randomFloat(2, 100, 5000),
            'IsActief' => $this->faker->boolean(90),
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
