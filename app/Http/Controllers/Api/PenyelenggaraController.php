<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PenyelenggaraController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'List event saya berhasil diambil',
            'data' => $events
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posters', 'public');
        }

        $event = Event::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'image' => $imagePath,
            'status' => 'draft',
        ]);

        return response()->json([
            'message' => 'Event berhasil dibuat',
            'data' => $event
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan'], 404);
        }

        if ($event->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke event ini'], 403);
        }

        return response()->json(['data' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event)
            return response()->json(['message' => 'Event tidak ditemukan'], 404);

        if ($event->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 422);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            if ($event->image)
                Storage::disk('public')->delete($event->image);
            $data['image'] = $request->file('image')->store('posters', 'public');
        }

        $event->update($data);

        return response()->json([
            'message' => 'Event berhasil diperbarui',
            'data' => $event
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event)
            return response()->json(['message' => 'Event tidak ditemukan'], 404);

        if ($event->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($event->image)
            Storage::disk('public')->delete($event->image);

        $event->delete();

        return response()->json(['message' => 'Event berhasil dihapus']);
    }
}
