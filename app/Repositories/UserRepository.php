<?php

namespace App\Repositories;

use App\Enums\User\Status;
use App\Models\User;

class UserRepository
{
    public function datatable()
    {
        return User::query()
            ->with('company')
            ->select([
                'id',
                'name',
                'email',
                'company_id',
                'status',
            ])
            ->where('status', '!=', Status::PENDING);
    }

    public function outstandingDatatable()
    {
        return User::query()
            ->with('company')
            ->select([
                'id',
                'name',
                'email',
                'company_id',
                'status',
            ])
            ->addCanApproveAndCanReject('settings_user_management')
            ->where('status', Status::PENDING);
    }

    public function getAdmins()
    {
        return User::whereHasRole('administrator')->get();
    }

    public function getUserByIdWithRelationsOrFail($id, string|array $relations = [])
    {
        return User::query()->with($relations)
            ->where('id', $id)->firstOrFail();
    }

    public function findOrFail($id)
    {
        return User::query()
            ->where('id', $id)
            ->firstOrFail();
    }

    public function find($email)
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }
}
