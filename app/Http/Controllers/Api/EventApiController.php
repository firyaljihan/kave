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
}
