<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case GOD = 'god';
    case ADMIN = 'admin';
    case COMMERCIAL_DIRECTOR = 'commercial_director';
    case AGENT = 'agent';

    public function scopedByOffice(): bool
    {
        return match ($this) {
            self::AGENT => true,
            default => false,
        };
    }
}
