<?php

declare(strict_types=1);

namespace App\CRM\Queries\Filters;

use App\Contracts\QueryFilter;
use App\Enums\OperationType;
use App\Models\Property;
use App\QueryBuilders\PropertyQueryBuilder;
use Illuminate\Contracts\Database\Eloquent\Builder;

final readonly class MaxPriceQueryFilter implements QueryFilter
{
    public function __construct(
        private float $price,
        private ?OperationType $operation = null,
    ) {}

    /**
     * @param  PropertyQueryBuilder<Property>  $builder
     * @return PropertyQueryBuilder<Property>
     */
    public function apply(Builder $builder): Builder
    {
        $priceTypes = $this->determinePriceTypes();

        return $builder->where(function (Builder $query) use ($priceTypes) {
            foreach ($priceTypes as $column) {
                $query->orWhere($column, '<=', $this->price);
            }
        });
    }

    private function determinePriceTypes(): array
    {
        return match (true) {
            $this->operation === OperationType::SALE => ['sell_price'],
            $this->operation === OperationType::RENT => ['rent_price'],
            default => ['sell_price', 'rental_price']
        };
    }
}
