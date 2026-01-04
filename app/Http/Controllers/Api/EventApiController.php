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
}
