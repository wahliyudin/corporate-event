<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Event\EventCategoryController;
use App\Http\Controllers\Event\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/events');

Route::middleware('auth')->group(function () {
    Route::get('events', [EventController::class, 'index'])->name('event.index');
    Route::get('events/data-calendar', [EventController::class, 'dataCalendar'])->name('event.data-calendar');
    Route::get('events/example', [EventController::class, 'example'])->name('event.example');
    Route::post('events/store', [EventController::class, 'store'])->name('event.store');
    Route::post('events/{id}/move', [EventController::class, 'move'])->name('event.move');
    Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::delete('events/{id}/destroy', [EventController::class, 'destroy'])->name('event.destroy');

    Route::get('events/category/data-select', [EventCategoryController::class, 'dataSelect'])->name('event.category.data-select');

    Route::get('companies/data-select', [CompanyController::class, 'dataSelect'])->name('company.data-select');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
