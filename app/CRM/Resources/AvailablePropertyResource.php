<?php

declare(strict_types=1);

namespace App\CRM\Resources;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Property
 */
final class AvailablePropertyResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ulid,
            'internal_ref' => $this->internal_reference,
            'title' => $this->title,
            'address' => $this->street,
            'surface_m2' => $this->built_m2,
            'sell_price' => $this->sell_price,
            'rent_price' => $this->rental_price,
            'is_sell' => $this->is_sell,
            'is_rent' => $this->is_rent,
            'office' => $this->office,
            'main_agent' => $this->main_agent,
            'secondary_agent' => $this->secondary_agent,
            'type' => $this->type,
            'district' => $this->district,
            'location' => $this->location,
            'municipality' => $this->municipality,
            'neighborhood' => $this->neighborhood,
            'region' => $this->region,
        ];
    }
}
