<?php

declare(strict_types=1);

namespace App\Models;

use App\QueryBuilders\PropertyQueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $ulid
 * @property-read string $internal_reference
 * @property-read string $title
 * @property-read string $street
 * @property-read int $number
 * @property-read string $zipcode
 * @property-read bool $is_active
 * @property-read bool $is_sell
 * @property-read bool $is_rent
 * @property-read ?float $sell_price
 * @property-read ?float $rental_price
 * @property-read float $built_m2
 * @property-read PropertyType $type
 * @property-read Office $office,
 * @property-read User $main_agent,
 * @property-read ?User $secondary_agent,
 * @property-read ?District $district
 * @property-read ?Location $location
 * @property-read ?Municipality $municipality
 * @property-read ?Region $region
 * @property-read ?Neighborhood $neighborhood
 * @property-read Collection<Operation> $operations
 *
 * @method static PropertyQueryBuilder query()
 */
final class Property extends Model
{
    use HasFactory;

    public $casts = [
        'id' => 'integer',
        'ulid' => 'string',
        'internal_reference' => 'string',
        'title' => 'string',
        'street' => 'string',
        'number' => 'integer',
        'zipcode' => 'string',
        'is_active' => 'boolean',
        'is_sell' => 'boolean',
        'is_rent' => 'boolean',
        'sell_price' => 'float',
        'rental_price' => 'float',
        'built_m2' => 'float',
    ];

    /**
     * @return HasMany<Operation>
     */
    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }

    /**
     * @return BelongsTo<Location>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo<Municipality>
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * @return BelongsTo<Region>
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return BelongsTo<District>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * @return BelongsTo<Neighborhood>
     */
    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    /**
     * @return BelongsTo<PropertyType>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * @return BelongsTo<Office>
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * @return BelongsTo<User>
     */
    public function mainAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<User>
     */
    public function secondaryAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'secondary_user_id');
    }

    #[\Override]
    public function newEloquentBuilder($query): PropertyQueryBuilder
    {
        return new PropertyQueryBuilder($query);
    }
}
