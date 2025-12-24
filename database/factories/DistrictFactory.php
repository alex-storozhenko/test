<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<District>
 */
final class DistrictFactory extends Factory
{
    private const array FAKES = [
        'Ciutat Vella',
        'L\'Eixample',
        'Extramurs',
        'Poblats Marítims',
        'Benimaclet',
        'Quatre Carreres',
        'Campanar',
        'La Saidia',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => array_rand(self::FAKES),
        ];
    }
}
