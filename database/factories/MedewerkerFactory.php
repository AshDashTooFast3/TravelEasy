<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Persoon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medewerker>
 */
class MedewerkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'PersoonId' => Persoon::factory(),
            'Nummer' => $this->faker->unique()->numerify('M####'),
            'Medewerkertype' => $this->faker->word(),
            'Specialisatie' => $this->faker->word(),
            'Beschikbaarheid' => $this->faker->boolean(),
            'Isactief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
