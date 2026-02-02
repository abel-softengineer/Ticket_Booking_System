<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminBoardController;
use App\Http\Controllers\SeatController;



Route::get('/', [EventController::class, 'index'])->name('events.index');

//Route::get('/', function () {
//   return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tickets/create/{event}', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('tickets.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   // Route::resource('adminboard', AdminBoardController::class);
    Route::resource('adminboard', AdminBoardController::class);
    Route::resource('seats', SeatController::class);

    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');


    //Vonalkodbeolvasas
    Route::get('/tickets/scan', [TicketController::class, 'scanform'])->name('ticket.scan');
    Route::post('/tickets/scan', [TicketController::class, 'scansubmit'])->name('ticket.scan.post');

});

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';
