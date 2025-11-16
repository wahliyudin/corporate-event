<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Sidebar;

class SidebarRepository
{
    public function getAll()
    {
        return Sidebar::query()->with('permissions:id,name')->get();
    }

    public function getPermissionsByModule($modul)
    {
        return Permission::query()->where('name', 'LIKE', "%{$modul}%")->get();
    }
}
