<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comprobante>
 */
class ComprobanteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'totalAmount' => fake()->numberBetween(200, 2000),
            'totalHours' => fake()->randomDigit(),
            'type' => fake()->randomElement(['Mensual', 'Compensatorio', 'Inicial']),
            'date' => fake()->date(),
            'evidence' => fake()->word(),
            'evidenceType' => fake()->word()
        ];
    }
}