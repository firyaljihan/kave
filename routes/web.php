<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController; // <--- Wajib di-import
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes (Fokus: Event Controller)
|--------------------------------------------------------------------------
*/

Route::get('/', [EventController::class, 'landingPage'])->name('landing');

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'penyelenggara') {
        return redirect()->route('events.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:penyelenggara')->group(function () {

        Route::resource('events', EventController::class);

        Route::patch('/events/{event}/submit', [EventController::class, 'submit'])->name('events.submit');
    });

});

require __DIR__.'/auth.php';
