<?php

namespace App\Http\Controllers\Setting;

use App\Enums\User\Status;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\Setting\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    public function __construct(
        public PermissionService $permissionService
    ) {}

    public function index()
    {
        return view('setting.permission.index');
    }

    public function datatable()
    {
        $data = $this->permissionService->datatable();
        return datatables()->eloquent($data)
            ->addColumn('company', function ($user) {
                return $user->company?->name;
            })
            ->filterColumn('company', function ($query, $keyword) {
                $query->whereHas('company', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('status', function ($user) {
                return $user->status->badge();
            })
            ->addColumn('can_setting', function ($user) {
                return $user->status === Status::VERIFIED;
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->make();
    }

    public function edit($id)
    {
        $user = $this->permissionService->userRepository
            ->getUserByIdWithRelationsOrFail($id, ['permissions:id', 'roles:id']);
        $sidebars = $this->permissionService->getSidebarAlreadyBuild($user);
        $roles = $this->permissionService->roles($user);
        return view('setting.permission.edit', [
            'user' => $user,
            'sidebars' => $sidebars,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        try {
            $user->roles()->sync($request->roles);
            Cache::forget("laratrust_roles_for_users_{$user->id}");
            $user->permissions()->sync($request->permissions);
            Cache::forget("laratrust_permissions_for_users_{$user->id}");
            return to_route('setting.permission.index')
                ->with('success', 'Updated successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())
                ->withInput();
        }
    }

    public function getRolePermissions(Role $role)
    {
        try {
            $permissions = $role->permissions->pluck('id');
            return response()->json([
                'permissions' => $permissions
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
