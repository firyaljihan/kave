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
        $events = Event::with('category', 'user')
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('welcome', compact('events'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dibuat! Status saat ini: Draft.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }

        $event->load(['category', 'user']);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit event ini.');
        }

        $categories = Category::all();

        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Boleh kosong
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('posters', 'public');
        }

        $data['status'] = 'draft';

        $event->update($data);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diperbarui! Status kembali menjadi Draft.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus event ini.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus permanen.');
    }

    public function submit(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->update(['status' => 'pending']);

        return back()->with('success', 'Event berhasil diajukan! Mohon tunggu persetujuan Admin.');
    }

}
