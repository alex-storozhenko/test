<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Neighborhood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Neighborhood>
 */
final class NeighborhoodFactory extends Factory
{
    private const array FAKES = [
        'Sant Pau',
        'Russafa',
        'Gran Via',
        'El Pla del Remei',
        'L\'Olivereta',
        'El Calvari',
        'Les Tendetes',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => self::FAKES[array_rand(self::FAKES)],
        ];
    }
}
