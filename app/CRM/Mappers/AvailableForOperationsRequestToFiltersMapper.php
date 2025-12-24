<?php

namespace App\CRM\Mappers;

use App\Contracts\QueryFilter;
use App\CRM\Queries\Filters\MaxPriceQueryFilter;
use App\CRM\Queries\Filters\MinPriceQueryFilter;
use App\CRM\Queries\Filters\OfficeQueryFilter;
use App\CRM\Queries\Filters\PropertyTypeQueryFilter;
use App\CRM\Queries\Filters\ZoneQueryFilter;
use App\CRM\Requests\AvailableForOperationsRequest;
use App\Enums\OperationType;
use App\Enums\ZoneType;
use App\Models\User;

final readonly class AvailableForOperationsRequestToFiltersMapper
{
    /**
     * @return array<QueryFilter>
     */
    public function map(AvailableForOperationsRequest $request): array
    {
        $filters = [];
        $attributes = $request->validated();

        /** @var User $user */
        $user = User::find(1);

        $this->parseOfficeFilterForCurrentUser($filters, $attributes, $user);
        $this->parseOfficeFilter($filters, $attributes);
        $this->parsePropertyTypeFilter($filters, $attributes);
        $this->parsePriceFilters($filters, $attributes);
        $this->parseSurfaceFilters($filters, $attributes);
        $this->parseZoneFilters($filters, $attributes);

        return $filters;
    }

    private function parseOfficeFilterForCurrentUser(
        array &$filters,
        array &$attributes,
        User $currentUser,
    ): void {
        if ($currentUser->role->scopedByOffice()) {
            unset($attributes['office_id']);

            $filters[] = new OfficeQueryFilter($currentUser->office_id);
        }
    }

    private function parseOfficeFilter(array &$filters, array $attributes): void
    {
        if (! empty($attributes['office_id'])) {
            $filters[] = new OfficeQueryFilter($attributes['office_id']);
        }
    }

    private function parsePropertyTypeFilter(array &$filters, array $attributes): void
    {
        if (! empty($attributes['property_type_id'])) {
            $filters[] = new PropertyTypeQueryFilter($attributes['office_id']);
        }
    }

    private function parsePriceFilters(array &$filters, array $attributes): void
    {
        $operationType = null;

        if (! empty($attributes['operation_type'])) {
            $operationType = OperationType::tryFrom($attributes['operation_type']);
        }

        if (! empty($attributes['min_price'])) {
            $filters[] = new MinPriceQueryFilter($attributes['min_price'], $operationType);
        }

        if (! empty($attributes['max_price'])) {
            $filters[] = new MaxPriceQueryFilter($attributes['max_price'], $operationType);
        }
    }

    private function parseSurfaceFilters(array &$filters, array $attributes): void
    {
        if (! empty($attributes['min_surface_m2'])) {
            $filters[] = new MinPriceQueryFilter($attributes['min_price']);
        }

        if (! empty($attributes['max_surface_m2'])) {
            $filters[] = new MaxPriceQueryFilter($attributes['max_price']);
        }
    }

    private function parseZoneFilters(array &$filters, array $attributes): void
    {
        if (! empty($attributes['zone_id']) && ! empty($attributes['zone_type'])) {
            $filters[] = new ZoneQueryFilter(ZoneType::from($attributes['zone_type']), $attributes['zone_id']);
        }
    }
}
