<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\District;
use App\Models\Location;
use App\Models\Municipality;
use App\Models\Neighborhood;
use App\Models\Office;
use App\Models\Operation;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Geographic Hierarchy
        $region = Region::firstOrCreate(['name' => 'Valencia']);
        $municipality = Municipality::firstOrCreate(['name' => 'Valencia']);
        $location = Location::firstOrCreate(['name' => 'Valencia']);

        $districtNames = ['Ciutat Vella', 'L\'Eixample', 'Extramurs', 'Poblats Marítims'];
        $districts = collect($districtNames)->map(fn ($name) => District::firstOrCreate(['name' => $name]));

        $neighborhoodNames = ['Sant Pau', 'Russafa', 'Gran Via', 'El Pla del Remei', 'L\'Olivereta', 'El Calvari', 'Les Tendetes'];
        $neighborhoods = collect($neighborhoodNames)->map(fn ($name) => Neighborhood::firstOrCreate(['name' => $name]));

        // 2. Create Property Types
        $propertyTypeNames = ['Flat', 'Townhouse', 'House', 'Apartment', 'Duplex', 'Room', 'Office', 'Retail', 'Warehouses', 'Manufacturing', 'Vacant Land'];
        $propertyTypes = collect($propertyTypeNames)->map(fn ($name) => PropertyType::firstOrCreate(['name' => $name]));

        // 3. Create Offices
        $offices = Office::factory()->count(5)->create();

        // 4. Create Test User
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'ulid' => Str::ulid(),
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'office_id' => $offices->first()->id,
                'role' => Role::GOD,
            ]
        );

        // 5. Create Users with Role Variety
        // 3 ADMIN users (one for each of first 3 offices)
        foreach ($offices->take(3) as $office) {
            User::factory()
                ->withRole(Role::ADMIN)
                ->for($office)
                ->create();
        }

        // 2 COMMERCIAL_DIRECTOR users
        User::factory()
            ->count(2)
            ->withRole(Role::COMMERCIAL_DIRECTOR)
            ->recycle($offices)
            ->create();

        // 8 AGENT users distributed across offices (1-2 per office)
        foreach ($offices as $office) {
            User::factory()
                ->count(rand(1, 2))
                ->for($office)
                ->create();
        }

        // 6. Create Properties
        foreach ($offices as $office) {
            // Get agents from this office for main/secondary agent assignment
            $officeUsers = $office->users;

            // Ensure office has at least one user
            if ($officeUsers->isEmpty()) {
                $officeUsers = collect([User::factory()->for($office)->create()]);
            }

            Property::factory()
                ->count(rand(10, 12))
                ->for($office)
                ->for($officeUsers->random(), 'mainAgent')
                ->state([
                    'property_type_id' => $propertyTypes->random()->id,
                    'secondary_user_id' => $officeUsers->count() > 1 ? $officeUsers->random()->id : null,
                    'region_id' => $region->id,
                    'municipality_id' => $municipality->id,
                    'district_id' => $districts->random()->id,
                    'neighborhood_id' => $neighborhoods->random()->id,
                    'location_id' => $location->id,
                    'is_active' => fake()->boolean(70),
                ])
                ->create();
        }

        // 7. Create Operations
        Property::all()->each(function ($property) {
            $operationCount = rand(2, 3);

            for ($i = 0; $i < $operationCount; $i++) {
                Operation::factory()
                    ->for($property)
                    ->when(fake()->boolean(), fn ($factory) => $factory->rent(), fn ($factory) => $factory->sale())
                    ->when(fake()->boolean(60), fn ($factory) => $factory->active(), fn ($factory) => $factory->unactive())
                    ->create();
            }
        });
    }
}
