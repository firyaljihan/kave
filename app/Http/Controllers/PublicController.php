<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return redirect()->route(route: 'penyelenggara.dashboard');
            }
            if ($role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }
        }

        $events = Event::with(['category', 'user'])
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('events'));
    }

    public function show($id)
    {
        $event = Event::with(['category', 'user'])
            ->where('status', 'published')
            ->findOrFail($id);

        return view('events.show', compact('event'));
    }
}
