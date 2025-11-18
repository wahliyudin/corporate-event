<?php

namespace App\Enums\Event;

enum Status: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';

    public function label()
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::VERIFIED => 'Verified',
            self::REJECTED => 'Rejected',
            self::COMPLETED => 'Completed',
        };
    }

    public function badge($className = 'fs-10')
    {
        return match ($this) {
            self::PENDING => '<span class="badge bg-warning ' . $className . '">' . self::PENDING->label() . '</span>',
            self::VERIFIED => '<span class="badge bg-info ' . $className . '">' . self::VERIFIED->label() . '</span>',
            self::REJECTED => '<span class="badge bg-danger ' . $className . '">' . self::REJECTED->label() . '</span>',
            self::COMPLETED => '<span class="badge bg-success ' . $className . '">' . self::COMPLETED->label() . '</span>',
        };
    }
}
