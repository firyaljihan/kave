<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::where('role', '!=', 'admin')->count();
        $totalEvents = Event::count();
        $totalCategories = Category::count();

        $antrianEvents = Event::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('totalUser', 'totalEvents', 'totalCategories', 'antrianEvents'));
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->id())
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
{
    return view('admin.users.create');
}

public function storeUser(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'role' => 'required|in:admin,penyelenggara,mahasiswa',
        'password' => 'required|string|min:5',
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User baru berhasil dibuat!');
}

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,penyelenggara,mahasiswa',
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', "Role pengguna '{$user->name}' berhasil diubah menjadi {$request->role}.");
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);

        $event->update(['status' => 'published']);

        return back()->with('success', "Event '{$event->title}' berhasil dipublikasikan!");
    }

    public function rejectEvent($id)
    {
        $event = Event::findOrFail($id);

        $event->update(['status' => 'draft']);

        return back()->with('error', "Event '{$event->title}' ditolak dan dikembalikan ke Draft.");
    }

    public function showEvent($id)
    {
        $event = Event::with(['user', 'category'])->findOrFail($id);

        return view('admin.events.show', compact('event'));
    }
    public function publishedEvents()
    {
        $events = \App\Models\Event::with(['user', 'category'])
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('admin.events.published', compact('events'));
    }

    public function destroyPublishedEvent($id)
    {
        $event = \App\Models\Event::findOrFail($id);

        // "Hapus dari tampilan user" = unpublish (AMAN, tidak merusak tiket/pendaftaran)
        if ($event->status !== 'published') {
            return back()->with('error', 'Event ini belum published / sudah diturunkan.');
        }

        $event->update(['status' => 'draft']);

        return redirect()
            ->route('admin.events.published')
            ->with('success', 'Event berhasil diturunkan (tidak tampil di user).');
    }

}
