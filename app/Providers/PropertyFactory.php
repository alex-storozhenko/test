<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Property;
use Database\Factories\DistrictFactory;
use Database\Factories\LocationFactory;
use Database\Factories\MunicipalityFactory;
use Database\Factories\NeighborhoodFactory;
use Database\Factories\OfficeFactory;
use Database\Factories\PropertyTypeFactory;
use Database\Factories\RegionFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Property>
 */
final class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $office = OfficeFactory::new();

        return [
            'ulid' => Str::random(26),
            'internal_reference' => Str::random(12),
            'title' => $this->faker->sentence(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'zipcode' => $this->faker->postcode(),
            'is_active' => true,
            'is_sell' => true,
            'is_rent' => true,
            'sell_price' => $this->faker->randomFloat(2, 10000),
            'rental_price' => $this->faker->randomFloat(2, 900),
            'built_m2' => $this->faker->randomFloat(2, 1, 2),
            'office_id' => $office,
            'property_type_id' => PropertyTypeFactory::new(),
            'user_id' => UserFactory::new()->for($office),
            'secondary_user_id' => UserFactory::new($office),
            'neighborhood_id' => NeighborhoodFactory::new(),
            'district_id' => DistrictFactory::new(),
            'location_id' => LocationFactory::new(),
            'region_id' => RegionFactory::new(),
            'municipality_id' => MunicipalityFactory::new(),
        ];
    }
}
