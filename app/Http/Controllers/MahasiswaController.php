<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        $today = Carbon::now();

        $activeEvents = Pendaftaran::with('event')
            ->where('user_id', $userId)
            ->whereHas('event', function ($query) use ($today) {
                $query->where('end_date', '>=', $today);
            })
            ->latest()
            ->get();

        $historyEvents = Pendaftaran::with('event')
            ->where('user_id', $userId)
            ->whereHas('event', function ($query) use ($today) {
                $query->where('end_date', '<', $today);
            })
            ->latest()
            ->get();

        return view('mahasiswa.dashboard', compact('activeEvents', 'historyEvents'));
    }
    public function explore(Request $request)
    {
        $search = $request->input('search');

        $events = Event::with('category')
            ->where('status', 'published')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('mahasiswa.explore', compact('events'));
    }

    public function daftar(Request $request, $id)
    {
        $user = Auth::user();
        $event = Event::findOrFail($id);

        if ($event->status !== 'published') {
            return back()->with('error', 'Event tidak dapat diakses.');
        }

        $existing = Pendaftaran::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini!');
        }

        Pendaftaran::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'confirmed',
            'created_at' => now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', "Berhasil mendaftar ke event: {$event->title}");
    }
}
