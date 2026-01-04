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

// 1. HALAMAN DEPAN (Landing Page)
// Menampilkan event yang statusnya published
Route::get('/', [EventController::class, 'landingPage'])->name('landing');

// 2. DASHBOARD (Logika Redirect)
Route::get('/dashboard', function () {
    // Cek Role User saat Login
    if (Auth::user()->role === 'penyelenggara') {
        return redirect()->route('events.index'); // <-- Arahkan Penyelenggara ke tabel event
    }

    // Kalau bukan penyelenggara, tampilkan dashboard default
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. ROUTE UNTUK USER YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {

    // Profile (Bawaan Breeze - Biarkan saja)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- KHUSUS PENYELENGGARA (Event Controller) ---
    // Kita bungkus pakai middleware role:penyelenggara biar aman
    Route::middleware('role:penyelenggara')->group(function () {

        // Route Otomatis untuk Index, Create, Store, Edit, Update, Destroy
        Route::resource('events', EventController::class);

        // Route Tambahan untuk tombol "Ajukan ke Admin"
        Route::patch('/events/{event}/submit', [EventController::class, 'submit'])->name('events.submit');
    });

});

require __DIR__.'/auth.php';
