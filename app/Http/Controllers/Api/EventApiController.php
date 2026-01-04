<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventApiController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Events',
            'data'    => $events
        ], 200);
    }

    public function show($id)
    {
        $event = Event::find($id);

        if ($event) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Event',
                'data'    => $event
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Event Tidak Ditemukan',
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'location'    => 'required',
            'price'       => 'required|numeric',
            'category_id' => 'required',
            'image'       => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = $request->file('image')->store('posters', 'public');

        $event = Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'location'    => $request->location,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
            'user_id'     => $request->user()->id,
            'status'      => 'draft',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event Berhasil Dibuat',
            'data'    => $event
        ], 201);
    }
}
