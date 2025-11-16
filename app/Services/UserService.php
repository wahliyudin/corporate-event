<?php

namespace App\Services;

use App\Enums\User\Status;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        public UserRepository $repository
    ) {}

    public function outstandingDatatable()
    {
        return $this->repository->outstandingDatatable();
    }

    public function approve($key)
    {
        $user = $this->repository->findOrFail($key);
        $user->syncPermissions([
            'event_read',
            'event_create',
            'event_update',
            'event_delete',
        ]);
        return $user->update([
            'status' => Status::VERIFIED,
        ]);
    }

    public function reject($key, $reason)
    {
        $user = $this->repository->findOrFail($key);
        return $user->update([
            'status' => Status::REJECTED,
            'reason' => $reason,
        ]);
    }
}
