<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\AuthController;


Route::post('/login', [AuthController::class, 'login']);
Route::get('/events', [EventApiController::class, 'index']);
Route::get('/events/{id}', [EventApiController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/events', [EventApiController::class, 'store']);
    Route::post('/events/{id}', [EventApiController::class, 'update']);
    Route::match(['put', 'patch'], '/events/{id}', [EventApiController::class, 'update']);
    Route::delete('/events/{id}', [EventApiController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
