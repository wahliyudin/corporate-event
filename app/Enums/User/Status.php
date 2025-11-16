<?php

namespace App\Enums\User;

enum Status: string
{
    case VERIFIED = 'verified';
    case PENDING = 'pending';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::VERIFIED => 'Verified',
            self::PENDING => 'Pending',
            self::REJECTED => 'Rejected',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::VERIFIED => '<span class="badge bg-success fs-10">' . self::VERIFIED->label() . '</span>',
            self::PENDING => '<span class="badge bg-warning fs-10">' . self::PENDING->label() . '</span>',
            self::REJECTED => '<span class="badge bg-danger fs-10">' . self::REJECTED->label() . '</span>',
        };
    }
}
