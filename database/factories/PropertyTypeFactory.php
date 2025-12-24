<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyType>
 */
final class PropertyTypeFactory extends Factory
{
    private const array FAKES = [
        'Flat',
        'Townhouse',
        'House',
        'Apartment',
        'Duplex',
        'Room',
        'Office',
        'Retail',
        'Warehouses',
        'Manufacturing',
        'Vacant Land',
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
