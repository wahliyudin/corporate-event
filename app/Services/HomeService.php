<?php

namespace App\Services;

use App\Enums\Event\Status;
use App\Enums\User\Status as UserStatus;
use App\Models\Event;
use App\Models\User;

class HomeService
{
    public function getStats()
    {
        return [
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('start_date', '>', now())->count(),
            'total_users' => User::count(),
            'pending_event_approvals' => Event::where('status', Status::PENDING)->count(),
            'pending_user_approvals' => User::where('status', UserStatus::PENDING)->count(),
        ];
    }
}
