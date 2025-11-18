<?php

use App\Http\Controllers\Approval\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Event\CalendarController;
use App\Http\Controllers\Event\EventCategoryController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Approval\EventController as ApprovalEventController;
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
    Route::get('events', [EventController::class, 'index'])->name('events.index')->middleware('permission:event_read');
    Route::post('events/datatable', [EventController::class, 'datatable'])->name('events.datatable');
    Route::post('events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::delete('events/{id}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('events/latest-activity', [EventController::class, 'latestActivity'])->name('events.latest-activity');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index')->middleware('permission:calendar_read');
    Route::get('calendar/data-calendar', [CalendarController::class, 'dataCalendar'])->name('calendar.data-calendar');
    Route::get('calendar/example', [CalendarController::class, 'example'])->name('calendar.example');
    Route::post('calendar/store', [CalendarController::class, 'store'])->name('calendar.store');
    Route::post('calendar/{id}/move', [CalendarController::class, 'move'])->name('calendar.move');
    Route::get('calendar/{id}/edit', [CalendarController::class, 'edit'])->name('calendar.edit');
    Route::delete('calendar/{id}/destroy', [CalendarController::class, 'destroy'])->name('calendar.destroy');

    Route::get('events/categories', [EventCategoryController::class, 'index'])->name('events.categories.index')->middleware('permission:event_category_read');
    Route::get('events/categories/data-select', [EventCategoryController::class, 'dataSelect'])->name('events.categories.data-select');
    Route::post('events/categories/datatable', [EventCategoryController::class, 'datatable'])->name('events.categories.datatable');
    Route::post('events/categories/store', [EventCategoryController::class, 'store'])->name('events.categories.store');
    Route::get('events/categories/{key}/edit', [EventCategoryController::class, 'edit'])->name('events.categories.edit');
    Route::delete('events/categories/{key}/destroy', [EventCategoryController::class, 'destroy'])->name('events.categories.destroy');

    Route::get('companies', [CompanyController::class, 'index'])->name('companies.index')->middleware('permission:companies_read');
    Route::post('companies/datatable', [CompanyController::class, 'datatable'])->name('companies.datatable');
    Route::post('companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('companies/{key}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::delete('companies/{key}/destroy', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::get('approvals/user', [UserController::class, 'index'])->name('approvals.user.index')->middleware('permission:settings_user_management_approve|settings_user_management_reject');
    Route::post('approvals/user/outstanding-datatable', [UserController::class, 'datatable'])->name('approvals.user.outstanding-datatable');
    Route::post('approvals/user/{key}/approve', [UserController::class, 'approve'])->name('approvals.user.approve');
    Route::post('approvals/user/{key}/reject', [UserController::class, 'reject'])->name('approvals.user.reject');

    Route::get('approvals/event', [ApprovalEventController::class, 'index'])->name('approvals.event.index')->middleware('permission:event_approve|event_reject');
    Route::post('approvals/event/outstanding-datatable', [ApprovalEventController::class, 'datatable'])->name('approvals.event.outstanding-datatable');
    Route::get('approvals/event/{key}/show', [ApprovalEventController::class, 'show'])->name('approvals.event.show');
    Route::post('approvals/event/{key}/approve', [ApprovalEventController::class, 'approve'])->name('approvals.event.approve');
    Route::post('approvals/event/{key}/reject', [ApprovalEventController::class, 'reject'])->name('approvals.event.reject');

    Route::get('setting/permission', [PermissionController::class, 'index'])->name('setting.permission.index')->middleware('permission:settings_user_management_read');
    Route::post('setting/permission/datatable', [PermissionController::class, 'datatable'])->name('setting.permission.datatable');
    Route::get('setting/permission/{id}/edit', [PermissionController::class, 'edit'])->name('setting.permission.edit');
    Route::post('setting/permission/{user:id}/update', [PermissionController::class, 'update'])->name('setting.permission.update');
    Route::get('setting/get-role-permissions/{role}', action: [PermissionController::class, 'getRolePermissions'])->name('setting.get-role-permissions');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
