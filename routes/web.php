<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Event\EventCategoryController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Setting\PermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/events');
Route::get('dashboard', function () {
    return view('dashboard');
});
Route::get('form', function () {
    return view('form');
});
Route::get('home', function () {
    return view('home');
});

Route::get('companies/data-select', [CompanyController::class, 'dataSelect'])->name('companies.data-select');

Route::middleware('auth')->group(function () {
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/data-calendar', [EventController::class, 'dataCalendar'])->name('events.data-calendar');
    Route::get('events/example', [EventController::class, 'example'])->name('events.example');
    Route::post('events/store', [EventController::class, 'store'])->name('events.store');
    Route::post('events/{id}/move', [EventController::class, 'move'])->name('events.move');
    Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::delete('events/{id}/destroy', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('events/categories', [EventCategoryController::class, 'index'])->name('events.categories.index');
    Route::get('events/categories/data-select', [EventCategoryController::class, 'dataSelect'])->name('events.categories.data-select');
    Route::post('events/categories/datatable', [EventCategoryController::class, 'datatable'])->name('events.categories.datatable');
    Route::post('events/categories/store', [EventCategoryController::class, 'store'])->name('events.categories.store');
    Route::get('events/categories/{key}/edit', [EventCategoryController::class, 'edit'])->name('events.categories.edit');
    Route::delete('events/categories/{key}/destroy', [EventCategoryController::class, 'destroy'])->name('events.categories.destroy');

    Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::post('companies/datatable', [CompanyController::class, 'datatable'])->name('companies.datatable');
    Route::post('companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('companies/{key}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::delete('companies/{key}/destroy', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::get('setting/permission', [PermissionController::class, 'index'])->name('setting.permission.index');
    Route::post('setting/permission/datatable', [PermissionController::class, 'datatable'])->name('setting.permission.datatable');
    Route::get('setting/permission/{id}/edit', [PermissionController::class, 'edit'])->name('setting.permission.edit');
    Route::post('setting/permission/{user:id}/update', [PermissionController::class, 'update'])->name('setting.permission.update');
    Route::get('setting/get-role-permissions/{role}', action: [PermissionController::class, 'getRolePermissions'])->name('setting.get-role-permissions');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
