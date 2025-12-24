<?php

declare(strict_types=1);

namespace App\CRM\Controllers;

use App\CRM\Mappers\AvailableForOperationsRequestToFiltersMapper;
use App\CRM\Queries\AvailableForOperationsQuery;
use App\CRM\Requests\AvailableForOperationsRequest;
use App\CRM\Resources\AvailablePropertyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class AvailablePropertiesController
{
    public function index(
        AvailableForOperationsRequest $request,
        AvailableForOperationsRequestToFiltersMapper $mapper,
        AvailableForOperationsQuery $query
    ): AnonymousResourceCollection {
        $search = $request->validated('search', '');
        $filters = $mapper->map($request);

        return AvailablePropertyResource::collection(
            $query->execute(
                $search,
                $filters,
                min($request->validated('per_page', 20), 50),
                $request->validated('page', 1),
            )
        );
    }
}
