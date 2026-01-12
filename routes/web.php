<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenyelenggaraController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/', [PublicController::class, 'index'])->name('landing');
Route::get('/event/{id}', [PublicController::class, 'show'])->name('events.show');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'penyelenggara') return redirect()->route('penyelenggara.dashboard');
    if ($role === 'mahasiswa') return redirect()->route('mahasiswa.dashboard');
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::patch('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::patch('/events/{id}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
        Route::patch('/events/{id}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');
        Route::get('/events/{id}', [AdminController::class, 'showEvent'])->name('events.show');

        Route::resource('categories', CategoryController::class);
    });

    Route::middleware('role:penyelenggara')->prefix('penyelenggara')->name('penyelenggara.')->group(function () {
        Route::get('/dashboard', [PenyelenggaraController::class, 'dashboard'])->name('dashboard');
        Route::resource('events', PenyelenggaraController::class);

        Route::get('/events/{id}/participants', [PenyelenggaraController::class, 'eventParticipants'])->name('events.participants');
        Route::patch('/events/{id}/submit', [PenyelenggaraController::class, 'submitForReview'])->name('events.submit');

        Route::post('/payment/{id}/confirm', [PenyelenggaraController::class, 'confirmPayment'])->name('payment.confirm');
        Route::post('/payment/{id}/reject', [PenyelenggaraController::class, 'rejectPayment'])->name('payment.reject');
    });

    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/explore', [MahasiswaController::class, 'explore'])->name('explore');
        Route::post('/event/{id}/daftar', [MahasiswaController::class, 'daftar'])->name('pendaftaran.store');
        Route::get('/event/{id}/checkout', [MahasiswaController::class, 'checkout'])->name('checkout');
        Route::get('/tiket/{id}', [MahasiswaController::class, 'showTicket'])->name('tiket.show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
