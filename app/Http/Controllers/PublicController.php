<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // <--- 1. WAJIB DITAMBAHKAN

class PublicController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($role === 'penyelenggara') {
                return redirect()->route('penyelenggara.dashboard'); // Note: syntax route: di hapus biar standar
            }
            if ($role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }
        }

        $events = Event::with(['category', 'user'])
            ->where('status', 'published')
            ->whereDate('end_date', '>=', Carbon::now()) // <--- 2. LOGIKA OTOMATIS HILANG (Expired)
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('events'));
    }

    public function show($id)
    {
        // Opsional: Kalau mau link event lama tetap bisa dibuka (untuk history), biarkan seperti ini.
        // Tapi kalau mau link event lama jadi 404 (tidak ditemukan), tambahkan whereDate di sini juga.

        $event = Event::with(['category', 'user'])
            ->where('status', 'published')
            ->findOrFail($id);

        return view('events.show', compact('event'));
    }
}
