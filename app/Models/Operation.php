<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OperationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id,
 * @property-read OperationType $type,
 * @property-read Property $property
 */
final class Operation extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'int',
        'type' => OperationType::class,
    ];

    /**
     * @return BelongsTo<Property>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
