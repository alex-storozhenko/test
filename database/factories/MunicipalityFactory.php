<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Municipality>
 */
final class MunicipalityFactory extends Factory
{
    private const array FAKES = [
        'Valencia',
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
