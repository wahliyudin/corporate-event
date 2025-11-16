<?php

namespace App\Services\Setting;

use App\Models\Role;
use App\Models\Sidebar;
use App\Models\User;
use App\Repositories\SidebarRepository;
use App\Repositories\UserRepository;

class PermissionService
{
    public function __construct(
        public UserRepository $userRepository,
        public SidebarRepository $sidebarRepository,
    ) {}

    public function datatable()
    {
        return $this->userRepository->datatable();
    }

    public function roles(User $user)
    {
        $roles = Role::query()->select(['id', 'name', 'display_name'])->get();
        foreach ($roles as $role) {
            $role->assigned = $user->roles
                ->pluck('id')
                ->contains($role->id);
        }
        return $roles;
    }

    public function getSidebarAlreadyBuild(User $user)
    {
        $sidebars = $this->sidebarRepository->getAll();
        return $this->build($sidebars, $user);
    }

    private function build($sidebars, $user, $parent = null)
    {
        $results = [];
        foreach ($sidebars as $sidebar) {
            if ($sidebar->parent_id == $parent) {
                $children = [];
                if ($this->hasChild($sidebars, $sidebar->id)) {
                    $children = array_merge($children, $this->build($sidebars, $user, $sidebar->id));
                }
                $sidebar = $this->attributeAdditional($sidebar, $user);
                array_push($results, [
                    'title' => $sidebar->title,
                    'name' => $sidebar->name,
                    'permissions' => $sidebar->permissions,
                    'children' => $children
                ]);
            }
        }
        return $results;
    }

    private function hasChild($sidebars, $sidebar_id)
    {
        foreach ($sidebars as $sidebar) {
            if ($sidebar->parent_id == $sidebar_id) {
                return true;
            }
        }
        return false;
    }

    private function attributeAdditional(Sidebar $sidebar, User $user)
    {
        foreach ($sidebar->permissions as $permission) {
            $permission->assigned = $user->permissions
                ->pluck('id')
                ->contains($permission->id);
            $permissionsMap = config('laratrust-seeder.permissions_map');
            foreach ($permissionsMap as $key => $val) {
                $str = str($permission->name);
                if ($str->contains('_' . $val) && !$str->contains($val . '_')) {
                    $permission->display = str($val)->ucfirst();
                    $permission->input_name = $val . "[]";
                }
            }
        }
        return $sidebar;
    }

    public function getPermissionsByModule($modul)
    {
        $permissions = $this->sidebarRepository->getPermissionsByModule($modul);
        /** @var User $user */
        $user = auth()->guard()->user();
        $actions = $permissions->mapWithKeys(function ($permission) use ($user) {
            return [$permission->name => $user->hasPermission($permission->name)];
        })->toArray();

        return $actions;
    }
}
