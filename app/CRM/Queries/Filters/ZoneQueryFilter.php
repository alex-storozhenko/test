<?php

declare(strict_types=1);

namespace App\CRM\Queries\Filters;

use App\Contracts\QueryFilter;
use App\Enums\ZoneType;
use App\Models\Property;
use App\QueryBuilders\PropertyQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;

final readonly class ZoneQueryFilter implements QueryFilter
{
    public function __construct(
        private ZoneType $zoneType,
        private int $zoneId,
    ) {}

    /**
     * @param  PropertyQueryBuilder<Property>  $builder
     * @return PropertyQueryBuilder<Property>
     */
    public function apply(Builder $builder): Builder
    {
        return $builder->zoneIs($this->zoneType, $this->zoneId);
    }
}
