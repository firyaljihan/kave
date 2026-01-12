<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pendaftaran;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $categoryId = $request->input('category_id');

        $events = Event::with('category')
            ->where('status', 'published')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('mahasiswa.explore', compact('events', 'categories'));
    }

    public function checkout($id)
    {
        $event = Event::with(['category', 'user'])->findOrFail($id);

        if ($event->status !== 'published') {
            return back()->with('error', 'Event tidak dapat diakses.');
        }

        return view('mahasiswa.checkout', compact('event'));
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

        // KONDISI 1: GRATIS -> Langsung Confirmed
        if ((int)$event->price === 0) {
            Pendaftaran::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => 'confirmed',
            ]);

            return redirect()->route('mahasiswa.dashboard')
                ->with('success', "Berhasil daftar (GRATIS): {$event->title}");
        }

        // KONDISI 2: BERBAYAR
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payments', 'public');

        Pendaftaran::create([
            'user_id' => $user->id,
            'event_id' => $event->id,

            // PERBAIKAN DISINI: Ubah 'paid' jadi 'pending' agar sesuai Database
            'status' => 'pending',

            'payment_proof' => $proofPath,
            'payment_uploaded_at' => now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', "Bukti pembayaran terkirim. Menunggu konfirmasi penyelenggara.");
    }

    public function showTicket($id)
    {
        $ticket = Pendaftaran::with('event')->findOrFail($id);

        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan tiket Anda.');
        }

        if ($ticket->status !== 'confirmed') {
            return back()->with('error', 'Tiket belum tersedia. Tunggu konfirmasi admin.');
        }

        $qrData = "KAVE-TIKET-" . $ticket->id . "-" . $ticket->user->email;
        $qrcode = QrCode::size(200)->generate($qrData);

        return view('mahasiswa.tiket', compact('ticket', 'qrcode'));
    }
}
