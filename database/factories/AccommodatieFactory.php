<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accommodatie>
 */
class AccommodatieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'VluchtId' => $this->faker->numberBetween(1, 10),
            'Naam' => $this->faker->word(),
            'Type' => $this->faker->randomElement(['Hotel', 'Hostel', 'Apartment', 'Resort']),
            'Straat' => $this->faker->streetName(),
            'Huisnummer' => $this->faker->numberBetween(1, 999),
            'Toevoeging' => $this->faker->optional()->bothify('??'),
            'Postcode' => $this->faker->postcode(),
            'Stad' => $this->faker->city(),
            'Land' => $this->faker->country(),
            'CheckInDatum' => $this->faker->dateTime(),
            'CheckOutDatum' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'AantalKamers' => $this->faker->numberBetween(1, 20),
            'AantalPersonen' => $this->faker->numberBetween(1, 10),
            'PrijsPerNacht' => $this->faker->randomFloat(2, 50, 1000),
            'TotaalPrijs' => $this->faker->randomFloat(2, 100, 5000),
            'IsActief' => $this->faker->boolean(),
            'Opmerking' => $this->faker->optional()->sentence(),
        ];
    }
}
