<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController; // Wajib Import (Admin)
// use App\Http\Controllers\RegistrationController; // Wajib Import (Mahasiswa)
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Halaman Depan)
|--------------------------------------------------------------------------
*/

// Landing Page (Info web & event terbaru)
Route::get('/', [EventController::class, 'landingPage'])->name('landing');


/*
|--------------------------------------------------------------------------
| 2. DASHBOARD REDIRECTOR (Lampu Lalu Lintas)
|--------------------------------------------------------------------------
| Logic: Setelah login, user dilempar kesini. Kita cek rolenya,
| lalu arahkan ke "markas" (prefix) masing-masing.
*/

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'penyelenggara') {
        return redirect()->route('penyelenggara.dashboard');
    } else {
        // Default: Mahasiswa
        return redirect()->route('mahasiswa.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| 3. AUTHENTICATED ROUTES (Harus Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // --- GROUP ADMIN (Akses Penuh) ---
    // Akses URL: /admin/...
    // Nama Route: admin.categories.index, admin.dashboard, dll
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard Admin (Statistik)
        Route::get('/dashboard', function () {
            // Kita ambil data ringkas untuk dashboard
            $totalUser      = \App\Models\User::where('role', '!=', 'admin')->count();
            $pendingEvents  = \App\Models\Event::where('status', 'pending')->count();
            $totalCategories= \App\Models\Category::count();

            return view('admin.dashboard', compact('totalUser', 'pendingEvents', 'totalCategories'));
        })->name('dashboard');

        // CRUD Kategori
        Route::resource('categories', CategoryController::class);

        // TODO: Nanti tambahkan route approval event disini jika sudah siap
    });


    // --- GROUP PENYELENGGARA (Event Organizer) ---
    // Akses URL: /penyelenggara/...
    Route::middleware('role:penyelenggara')->prefix('penyelenggara')->name('penyelenggara.')->group(function () {

        // Dashboard Penyelenggara (Langsung lihat list event mereka)
        Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');

        // CRUD Event
        Route::resource('events', EventController::class);

        // Fitur Submit Event (Mengajukan publish ke admin)
        Route::patch('/events/{event}/submit', [EventController::class, 'submit'])->name('events.submit');
    });


    // --- GROUP MAHASISWA (Peserta) ---
    // Akses URL: /mahasiswa/...
    // Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {

    //     // Dashboard Mahasiswa (Sementara redirect ke Landing Page atau buat view khusus)
    //     Route::get('/dashboard', function () {
    //          // Opsional: Buat view 'mahasiswa.dashboard' atau redirect ke landing page
    //          return redirect()->route('landing');
    //     })->name('dashboard');

    //     // Route untuk Daftar Event (Klik tombol Daftar)
    //     Route::post('/events/{id}/register', [RegistrationController::class, 'store'])->name('events.register');

    //     // Route untuk Lihat History (Menu History)
    //     Route::get('/history', [RegistrationController::class, 'history'])->name('history');
    // });


    // --- PROFILE SETTINGS (Bawaan Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
