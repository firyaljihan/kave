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

        $totalParticipants = Pendaftaran::whereHas('event', function($q) use ($userId) {
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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'location'    => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'price'       => 'required|numeric|min:0',
        ]);

        $imagePath = $request->file('image')->store('posters', 'public');

        Event::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'location'    => $request->location,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'image'       => $imagePath,
            'status'      => 'draft',
        ]);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event berhasil dibuat! Silakan ajukan ke Admin jika sudah siap.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== Auth::id()) abort(403);

        $categories = Category::all();
        return view('penyelenggara.events.edit', compact('event', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'location'    => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($event->image) Storage::disk('public')->delete($event->image);
            $data['image'] = $request->file('image')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id()) abort(403);

        if ($event->image) Storage::disk('public')->delete($event->image);
        $event->delete();

        return back()->with('success', 'Event berhasil dihapus.');
    }

    public function eventParticipants($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== Auth::id()) abort(403);

        $pendaftarans = Pendaftaran::with('user')
            ->where('event_id', $id)
            ->latest()
            ->get();

        return view('penyelenggara.events.participants', compact('event', 'pendaftarans'));
    }
}
