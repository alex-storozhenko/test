<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Municipality extends Model
{
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
    ];
}
