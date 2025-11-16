<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Sidebar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = config('laratrust-seeder.roles');
        $modules = config('laratrust-seeder.sidebars');
        $mapPermission = collect(config('laratrust-seeder.permissions_map'));


        foreach ($modules as $module) {
            $parentName = str($module['title'])->lower()->value();
            $parent = Sidebar::query()->updateOrCreate([
                'name' => str($parentName)->snake()->value(),
                'parent_id' => null,
            ], [
                'title' => isset($module['label']) ? $module['label'] : $module['title'],
                'name' => str($parentName)->snake()->value(),
            ]);
            if (isset($module['permissions'])) {
                $result = $this->checkPermission($module['permissions'], $mapPermission, $parentName);
                $parent->permissions()->sync($result);
            }
            foreach (isset($module['child']) ? $module['child'] : [] as $child) {
                $childName = str($child['title'])->lower()->value();
                $data = [
                    'title' => isset($child['label']) ? $child['label'] : $child['title'],
                    'name' => str($childName)->snake()->value(),
                    'parent_id' => $parent->getKey(),
                ];
                $sidebar = Sidebar::query()->updateOrCreate([
                    'name' => str($childName)->snake()->value(),
                    'parent_id' => $parent->getKey(),
                ], $data);
                if (isset($child['permissions'])) {
                    $result = $this->checkPermission($child['permissions'], $mapPermission, $childName, $parentName);
                    $sidebar->permissions()->sync($result);
                }
            }
        }

        $this->createRolesWithPermissions($roles);
    }

    public function checkPermission($strPermissions, $mapPermission, $name, $parentName = null)
    {
        $permissions = [];
        foreach (explode(',', $strPermissions) as $p => $perm) {
            $permissionValue = $mapPermission->get($perm);
            $resultName = $this->name($name, $parentName);
            $permission = \App\Models\Permission::firstOrCreate([
                'name' => $resultName . '_' . $permissionValue,
                'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($name),
                'description' => ucfirst($permissionValue) . ' ' . ucfirst($name),
            ])->id;
            $permissions[] = $permission;
            $permis[] = $permission;

            $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $resultName);
        }
        return $permissions;
    }

    public function name($childName, $parentName = null)
    {
        $name = str($childName)->snake();
        return $parentName ? str($parentName)->snake() . '_' . $name : $name;
    }

    public function createRolesWithPermissions($rolesData)
    {
        foreach ($rolesData as $roleData) {
            $name = str($roleData['role'])->lower()->snake()->value();
            $role = Role::firstOrCreate([
                'name' => $name,
                'display_name' => ucfirst($roleData['role']),
                'description' => 'Role for ' . ucfirst($roleData['role']),
            ]);

            foreach ($roleData['permissions'] ?? [] as $permissionName) {
                logger('Permission Name: ' . $permissionName . '');
                $permission = Permission::query()
                    ->where('name', $permissionName)
                    ->first();

                if (!$role->hasPermission($permission->name)) {
                    $role->givePermission($permission);
                }
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();

        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();

        if (Config::get('laratrust_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();

            if (Config::get('laratrust_seeder.create_users')) {
                $usersTable = (new \App\Models\User)->getTable();
                DB::table($usersTable)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
