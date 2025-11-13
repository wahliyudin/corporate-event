<?php

use App\Http\Controllers\Event\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/events');

Route::get('events', [EventController::class, 'index'])->name('event.index');
Route::get('events/data-calendar', [EventController::class, 'dataCalendar'])->name('event.data-calendar');
Route::get('events/example', [EventController::class, 'example'])->name('event.example');
Route::post('events/store', [EventController::class, 'store'])->name('event.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
