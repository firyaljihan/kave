<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [EventController::class, 'landingPage'])->name('landing');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'penyelenggara') {
        return redirect()->route('penyelenggara.dashboard');
    }

    return redirect()->route('landing');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $totalUser = \App\Models\User::where('role', '!=', 'admin')->count();
            $pendingEvents = \App\Models\Event::where('status', 'pending')->count();
            $totalCategories = \App\Models\Category::count();

            return view('admin.dashboard', compact('totalUser', 'pendingEvents', 'totalCategories'));
        })->name('dashboard');

        Route::resource('categories', CategoryController::class);
    });

    Route::middleware('role:penyelenggara')->prefix('penyelenggara')->name('penyelenggara.')->group(function () {
        Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class)->except(['show']);
        Route::patch('/events/{event}/submit', [EventController::class, 'submit'])->name('events.submit');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
