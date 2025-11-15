<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Event\EventCategoryController;
use App\Http\Controllers\Event\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/events');

Route::middleware('auth')->group(function () {
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('events/data-calendar', [EventController::class, 'dataCalendar'])->name('events.data-calendar');
    Route::get('events/example', [EventController::class, 'example'])->name('events.example');
    Route::post('events/store', [EventController::class, 'store'])->name('events.store');
    Route::post('events/{id}/move', [EventController::class, 'move'])->name('events.move');
    Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::delete('events/{id}/destroy', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('events/category/data-select', [EventCategoryController::class, 'dataSelect'])->name('events.categories.data-select');

    Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('companies/data-select', [CompanyController::class, 'dataSelect'])->name('companies.data-select');
    Route::post('companies/datatable', [CompanyController::class, 'datatable'])->name('companies.datatable');
    Route::post('companies/store', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('companies/{key}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::delete('companies/{key}/destroy', [CompanyController::class, 'destroy'])->name('companies.destroy');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
