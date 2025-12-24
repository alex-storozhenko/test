<?php

declare(strict_types=1);

namespace App\CRM\Queries;

use App\Contracts\QueryFilter;
use App\Models\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class AvailableForOperationsQuery
{
    /**
     * @param  array<QueryFilter>  $filters
     */
    public function execute(
        string $search = '',
        array $filters = [],
        int $perPage = 20,
        int $page = 1
    ): LengthAwarePaginator {
        $query = Property::query()->with([
            'office',
            'type',
            'mainAgent',
            'secondaryAgent',
            'district',
            'municipality',
            'location',
            'region',
            'neighborhood',
            'operations',
        ])->availableForOperations();

        if (! empty($search)) {
            $query = $query->search($search);
        }

        foreach ($filters as $filter) {
            $query = $filter->apply($query);
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(perPage: $perPage, page: $page);
    }
}
