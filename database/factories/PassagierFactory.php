<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Persoon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passagier>
 */
class PassagierFactory extends Factory
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
            'Nummer' => $this->faker->unique()->numerify('P###'),
            'PassagierType' => $this->faker->randomElement(['Kind', 'Volwassen', 'Baby']),
            'IsActief' => $this->faker->boolean(890), 
            'Opmerking' => $this->faker->optional()->sentence(),
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => now(),
        ];
    }
}
