<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Passagier;
use \App\Models\Vlucht;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'PassagierId' => Passagier::factory(),
            'VluchtId' => Vlucht::factory(),
            'Stoelnummer' => $this->faker->bothify('##?'),
            'Aankoopdatum' => $this->faker->date(),
            'Aankooptijd' => $this->faker->time(),
            'Aantal' => $this->faker->numberBetween(1, 5),
            'BedragInclBtw' => $this->faker->randomFloat(2, 50, 2500),
            'IsActief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->optional()->text(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
