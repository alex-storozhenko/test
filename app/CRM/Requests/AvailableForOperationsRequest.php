<?php

declare(strict_types=1);

namespace App\CRM\Requests;

use App\Enums\OperationType;
use App\Enums\ZoneType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class AvailableForOperationsRequest extends FormRequest
{
    public function rules(): array
    {
        $zoneTable = null;
        $zoneType = $this->enum('zone_type', ZoneType::class);

        if ($zoneType) {
            $zoneTable = Str::plural($zoneType->value);
        }

        return [
            'property_type_id' => ['sometimes', 'integer', 'exists:property_types,id'],
            'office_id' => ['sometimes', 'integer', 'exists:offices,id'],
            'zone_type' => [
                'sometimes',
                'required_with:zone_id',
                'string',
                Rule::enum(ZoneType::class),
            ],
            'zone_id' => [
                'sometimes',
                'required_with:zone_type',
                'integer',
                'prohibited_if:zone_type,null',
                Rule::when(! empty($zoneTable), ['exists:'.$zoneTable.',id']),
            ],
            'operation_type' => ['sometimes', Rule::enum(OperationType::class)],
            'min_price' => [
                'sometimes',
                'decimal:2',
                'min:0',
                Rule::when($this->filled('max_price'), ['lte:max_price']),
            ],
            'max_price' => [
                'sometimes',
                'decimal:2',
                Rule::when($this->filled('min_price'), ['gt:min_price']),
            ],
            'min_surface_m2' => [
                'sometimes',
                'decimal:2',
                'min:0',
                Rule::when($this->filled('max_surface_m2'), ['lte:max_surface_m2']),
            ],
            'max_surface_m2' => [
                'sometimes',
                'required',
                'decimal:2',
                Rule::when($this->filled('min_surface_m2'), ['gt:min_surface_m2']),
            ],
            'search' => ['sometimes', 'string', 'min:3', 'max:255'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'max:50'],
        ];
    }
}
