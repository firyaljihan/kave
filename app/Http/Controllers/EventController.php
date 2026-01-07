<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function landingPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin')
                return redirect()->route('admin.dashboard');
            if (Auth::user()->role === 'penyelenggara')
                return redirect()->route('penyelenggara.dashboard');
            if (Auth::user()->role === 'mahasiswa')
                return redirect()->route('mahasiswa.dashboard');
        }

        $events = Event::with('category', 'user')
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('events'));
    }

    public function show(Event $event)
    {
        $isOwner = Auth::check() && $event->user_id === Auth::id();
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';
        $isPublished = $event->status === 'published';

        if (!$isOwner && !$isAdmin && !$isPublished) {
            abort(403, 'Event ini belum dipublikasikan.');
        }

        $event->load(['category', 'user']);
        return view('events.show', compact('event'));
    }

    public function index()
    {
        $events = Event::where('user_id', Auth::id())->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('posters', 'public');

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'status' => 'draft',
        ]);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event dibuat! Status: Draft.');
    }

    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id())
            abort(403);
        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id())
            abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($event->image)
                Storage::disk('public')->delete($event->image);
            $data['image'] = $request->file('image')->store('posters', 'public');
        }

        $data['status'] = 'draft';
        $event->update($data);

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id())
            abort(403);
        if ($event->image)
            Storage::disk('public')->delete($event->image);
        $event->delete();

        return redirect()->route('penyelenggara.events.index')
            ->with('success', 'Event dihapus.');
    }

    public function submit(Event $event)
    {
        if ($event->user_id !== Auth::id())
            abort(403);
        $event->update(['status' => 'pending']);
        return back()->with('success', 'Event diajukan ke Admin.');
    }

    public function approve(Event $event)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda bukan Admin!');
        }

        $event->update(['status' => 'published']);

        return back()->with('success', "Event '{$event->title}' berhasil dipublikasikan!");
    }

    public function reject(Event $event)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda bukan Admin!');
        }

        $event->update(['status' => 'draft']);

        return back()->with('error', "Event '{$event->title}' ditolak dan dikembalikan ke Draft.");
    }
}
