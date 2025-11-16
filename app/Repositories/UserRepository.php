<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function datatable()
    {
        return User::query();
    }

    public function getAdmins()
    {
        return User::query()->where('email', 'admin@admin.com')->get();
    }

    public function getUserByIdWithRelationsOrFail($id, string|array $relations = [])
    {
        return User::query()->with($relations)
            ->where('id', $id)->firstOrFail();
    }
}
