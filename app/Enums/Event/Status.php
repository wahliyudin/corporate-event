<?php

namespace App\Enums\Event;

enum Status: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';

    public function label()
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::VERIFIED => 'Verified',
            self::REJECTED => 'Rejected',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::PENDING => '<span class="badge bg-warning fs-10">' . self::PENDING->label() . '</span>',
            self::VERIFIED => '<span class="badge bg-success fs-10">' . self::VERIFIED->label() . '</span>',
            self::REJECTED => '<span class="badge bg-danger fs-10">' . self::REJECTED->label() . '</span>',
        };
    }
}
