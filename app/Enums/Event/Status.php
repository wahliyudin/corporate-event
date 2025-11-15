<?php

namespace App\Enums\Event;

enum Status: string
{
    case PLANNED = 'planned';
    case CONFIRMED = 'confirmed';
    case TENATIVE = 'tentative';

    public function label()
    {
        return match ($this) {
            self::PLANNED => 'Planned',
            self::CONFIRMED => 'Confirmed',
            self::TENATIVE => 'Tentative',
        };
    }
}
