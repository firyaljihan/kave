<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

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
}
