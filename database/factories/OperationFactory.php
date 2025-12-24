<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OperationType;
use App\Models\Operation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Operation>
 */
final class OperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => array_rand(OperationType::cases()),
            'is_active' => array_rand([true, false]),
        ];
    }

    public function unactive(): static
    {
        return $this->state(function () {
            return [
                'is_active' => false,
            ];
        });
    }

    public function active(): static
    {
        return $this->state(function () {
            return [
                'is_active' => true,
            ];
        });
    }

    public function rent(): static
    {
        return $this->state(function () {
            return [
                'type' => OperationType::RENT,
            ];
        });
    }

    public function sale(): static
    {
        return $this->state(function () {
            return [
                'type' => OperationType::SALE,
            ];
        });
    }
}
