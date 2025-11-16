@extends('layouts.app')

@section('title', 'User Permission')

@section('page-header')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">User Permission</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Setting</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Permission</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        User Permission
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('setting.permission.update', $user->id) }}">
                        @csrf
                        <div class="d-flex align-items-center justify-content-between mb-2 ms-3">
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input all" name="all" id="all">
                                    Select
                                    All <i class="input-helper"></i></label>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" @checked($role->assigned) class="form-check-input"
                                                name="roles[]" id="{{ $role->name }}" value="{{ $role->getKey() }}"
                                                onclick="handleRoleClick(this)">
                                            {{ $role->display_name }} <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="momTable" width="100%" cellpadding="0" cellspacing="0" border="0"
                                class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Main Menu</th>
                                        <th>
                                            Modul
                                        </th>
                                        <th colspan="6">Available Fitur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sidebars as $sidebar)
                                        @php
                                            $sidebarChildren = isset($sidebar['children']) ? $sidebar['children'] : [];
                                            $totalHaveChildren = 0;
                                            foreach ($sidebarChildren as $child) {
                                                $totalHaveChildren =
                                                    $totalHaveChildren +
                                                    collect($child['permissions'])->pluck('assigned')->sum();
                                            }
                                            $totalDosntHaveChildren = 0;
                                            if (isset($sidebar['permissions']) && count($sidebar['permissions']) > 0) {
                                                $totalDosntHaveChildren = collect($sidebar['permissions'])
                                                    ->pluck('assigned')
                                                    ->sum();
                                            }
                                        @endphp
                                        @if (count($sidebarChildren) > 0)
                                            <tr>
                                                <td
                                                    rowspan="{{ count($sidebarChildren) + (isset($sidebar['permissions']) && count($sidebar['permissions']) > 0 ? 1 : 0) + 1 }}">
                                                    <div class="form-check form-check-flat form-check-primary">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input checkall_modul"
                                                                {{ $totalHaveChildren >= count($sidebarChildren) ? 'checked' : '' }}
                                                                type="checkbox" value="{{ $sidebar['name'] }}"
                                                                name="menu">
                                                            {{ $sidebar['title'] }} <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if (isset($sidebar['permissions']) && count($sidebar['permissions']) > 0)
                                            <tr>
                                                @if (count($sidebarChildren) <= 0)
                                                    <td rowspan="{{ count($sidebarChildren) + 1 }}">
                                                        <div class="form-check form-check-flat form-check-primary">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input checkall_fitur"
                                                                    {{ $totalDosntHaveChildren >= count($sidebar['permissions']) ? 'checked' : '' }}
                                                                    type="checkbox" value="{{ $sidebar['name'] }}"
                                                                    name="menu">
                                                                {{ $sidebar['title'] }} <i class="input-helper"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td></td>
                                                @foreach ($sidebar['permissions'] as $permission)
                                                    <td>
                                                        <div class="form-check form-check-flat form-check-primary">
                                                            <label class="form-check-label">
                                                                <input
                                                                    class="form-check-input fitur sub_{{ $sidebar['name'] }}"
                                                                    data-modulid="{{ $sidebar['name'] }}" type="checkbox"
                                                                    value="{{ $permission->getKey() }}"
                                                                    {{ $permission->assigned ? 'checked' : '' }}
                                                                    name="permissions[]">
                                                                {{ $permission->display }} <i class="input-helper"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endif
                                        @foreach ($sidebarChildren as $children)
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-flat form-check-primary">
                                                        <label class="form-check-label">
                                                            <input
                                                                class="form-check-input checkall_fitur {{ $sidebar['name'] }}"
                                                                type="checkbox" value="{{ $sidebar['name'] }}"
                                                                {{ collect($children['permissions'])->pluck('assigned')->sum() > 0 ? 'checked' : '' }}
                                                                name="modul[]">
                                                            {{ $children['title'] }} <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </td>
                                                @foreach ($children['permissions'] as $permission)
                                                    <td>
                                                        <div class="form-check form-check-flat form-check-primary">
                                                            <label class="form-check-label">
                                                                <input
                                                                    class="form-check-input fitur sub_{{ $sidebar['name'] }}"
                                                                    data-modulid="{{ $sidebar['name'] }}" type="checkbox"
                                                                    value="{{ $permission->getKey() }}"
                                                                    {{ $permission->assigned ? 'checked' : '' }}
                                                                    name="permissions[]">
                                                                {{ $permission->display }} <i class="input-helper"></i>
                                                            </label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @vite(['resources/js/pages/setting/permission/edit.js'])
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endpush
