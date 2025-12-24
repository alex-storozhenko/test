<?php

declare(strict_types=1);

namespace App\Enums;

enum OperationType: string
{
    case RENT = 'rent';
    case SALE = 'sale';
}
