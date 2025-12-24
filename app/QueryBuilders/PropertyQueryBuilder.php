<?php

namespace App\QueryBuilders;

use App\Enums\ZoneType;
use Illuminate\Database\Eloquent\Builder;

final class PropertyQueryBuilder extends Builder
{
    private const array SEARCHABLE_COLUMNS = [
        'street',
        'internal_reference',
    ];

    public function availableForOperations(): PropertyQueryBuilder
    {
        $this->where('is_active', true)
            ->whereDoesntHave(
                'operations',
                static function (Builder $query) {
                    return $query->where('is_active', true);
                }
            );

        return $this;
    }

    public function search(string $term): PropertyQueryBuilder
    {
        $this->where(static function (Builder $query) use ($term) {
            foreach (self::SEARCHABLE_COLUMNS as $column) {
                $query->orWhereLike($column, "%{$term}%");
            }
        });

        return $this;
    }

    public function typeIs(int $propertyTypeId): PropertyQueryBuilder
    {
        $this->where('property_type_id', $propertyTypeId);

        return $this;
    }

    public function zoneIs(ZoneType $zoneType, int $zoneId): PropertyQueryBuilder
    {
        $column = "{$zoneType->value}_id";

        $this->where($column, $zoneId);

        return $this;
    }

    public function belongsToOffice(int $officeId): PropertyQueryBuilder
    {
        $this->where('office_id', $officeId);

        return $this;
    }
}
