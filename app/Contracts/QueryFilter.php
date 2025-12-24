<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder;

interface QueryFilter
{
    public function apply(Builder $builder): Builder;
}
