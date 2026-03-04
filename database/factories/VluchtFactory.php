<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Bestemming;
use \App\Models\Vertrek;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vlucht>
 */
class VluchtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'VertrekId' => Vertrek::factory(),
            'BestemmingId' => Bestemming::factory(),
            'Vluchtnummer' => $this->faker->unique()->bothify('V###'),
            'Vertrekdatum' => $this->faker->date(),
            'Vertrektijd' => $this->faker->time(),
            'Aankomstdatum' => $this->faker->date(),
            'Aankomsttijd' => $this->faker->time(),
            'Vluchtstatus' => $this->faker->randomElement(['Op Tijd', 'Vertraging', 'Geannuleerd']),
            'IsActief' => $this->faker->boolean(90),
            'Opmerking' => $this->faker->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
