<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenyelenggaraController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        $totalEvents = Event::where('user_id', $userId)->count();

        $activeEvents = Event::where('user_id', $userId)
            ->where('status', 'published')
            ->count();

        $totalParticipants = Pendaftaran::whereHas('event', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();

        $recentEvents = Event::where('user_id', $userId)->latest()->take(5)->get();

        return view('penyelenggara.dashboard', compact('totalEvents', 'activeEvents', 'totalParticipants', 'recentEvents'));
    }

    public function index()
    {
        $events = Event::where('user_id', Auth::id())->latest()->get();

        return view('penyelenggara.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('penyelenggara.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'bank_account_holder' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('posters', 'public');
        $price = (int) preg_replace('/[^\d]/', '', $request->input('price'));

        Event::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'price' => $price,
            'image' => $imagePath,
            'status' => 'draft',
            'bank_name' => $request->bank_name,
            'account_number' => $request->bank_account_number,
            'account_name' => $request->bank_account_holder,
        ]);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event berhasil dibuat! Silakan ajukan ke Admin jika sudah siap.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== Auth::id())
            abort(403);

        $categories = Category::all();
        return view('penyelenggara.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id())
            abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bank_name' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            'bank_account_holder' => 'nullable|string',
        ]);
        $price = (int) preg_replace('/[^\d]/', '', $request->input('price'));

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'price' => $price,
            'bank_name' => $request->bank_name,
            'account_number' => $request->bank_account_number,
            'account_name' => $request->bank_account_holder,
        ];

        $data = $request->except(['image']);
        $price = (int) preg_replace('/[^\d]/', '', $request->input('price'));
        $data['price'] = $price;
        $data['bank_name'] = $request->bank_name;
        $data['bank_account_number'] = $request->bank_account_number;
        $data['bank_account_holder'] = $request->bank_account_holder;

        if ($request->hasFile('image')) {
            if ($event->image)
                Storage::disk('public')->delete($event->image);
            $data['image'] = $request->file('image')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id())
            abort(403);

        if ($event->image)
            Storage::disk('public')->delete($event->image);
        $event->delete();

        return back()->with('success', 'Event berhasil dihapus.');
    }

    public function eventParticipants($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== Auth::id())
            abort(403);

        $pendaftarans = Pendaftaran::with('user')
            ->where('event_id', $id)
            ->latest()
            ->get();

        return view('penyelenggara.events.participants', compact('event', 'pendaftarans'));
    }

    public function submitForReview($id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id())
            abort(403);

        if ($event->status !== 'draft') {
            return back()->with('error', 'Event tidak dapat diajukan.');
        }

        $event->update(['status' => 'pending']);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event berhasil diajukan ke Admin!');
    }
    public function confirmPayment($id)
{
    $pendaftaran = Pendaftaran::with('event')->findOrFail($id);

    if ($pendaftaran->event->user_id !== Auth::id()) abort(403);

    $pendaftaran->update(['status' => 'confirmed']);

    return back()->with('success', 'Pembayaran dikonfirmasi. Tiket peserta menjadi SUCCESS.');
}

    public function rejectPayment($id)
    {
        $pendaftaran = Pendaftaran::with('event')->findOrFail($id);

        if ($pendaftaran->event->user_id !== Auth::id()) abort(403);

        $pendaftaran->update(['status' => 'rejected']);

        return back()->with('success', 'Pendaftaran ditolak.');
    }
}
