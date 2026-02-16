<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persoon>
 */
class PersoonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'GebruikerId' => \App\Models\Gebruiker::factory(),
            'Voornaam' => $this->faker->firstName(),
            'Tussenvoegsel' => $this->faker->optional()->randomElement(['van', 'de', 'der', 'den', 'ter']),
            'Achternaam' => $this->faker->lastName(),
            'Geboortedatum' => $this->faker->date('Y-m-d'),
            'Isactief' => true,
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
