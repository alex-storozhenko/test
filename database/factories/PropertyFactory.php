<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Property;
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
            'ulid' => Str::ulid(),
            'internal_reference' => Str::random(12),
            'title' => $this->faker->sentence(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'zipcode' => $this->faker->postcode(),
            'is_active' => true,
            'is_sell' => true,
            'is_rent' => true,
            'sell_price' => $this->faker->randomFloat(2, 100000, 500000),
            'rental_price' => $this->faker->randomFloat(2, 500, 2000),
            'built_m2' => $this->faker->randomFloat(2, 50, 300),
            'office_id' => $office,
            'property_type_id' => PropertyTypeFactory::new(),
            'user_id' => UserFactory::new()->for($office),
            'secondary_user_id' => UserFactory::new()->for($office),
            'neighborhood_id' => NeighborhoodFactory::new(),
            'district_id' => DistrictFactory::new(),
            'location_id' => LocationFactory::new(),
            'region_id' => RegionFactory::new(),
            'municipality_id' => MunicipalityFactory::new(),
        ];
    }
}
