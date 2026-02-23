<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bestemming>
 */
class BestemmingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Land' => $this->faker->country(),
            'Luchthaven' => $this->faker->word(),
            'IsActief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->sentence(),
            'Datumaangemaakt' => $this->faker->dateTime(),
            'Datumgewijzigd' => $this->faker->dateTime()
        ];
    }
}
