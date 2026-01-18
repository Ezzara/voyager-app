<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Book Controller
use App\Http\Controllers\Api\BookController; 
// Auth Facade
use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// API login route
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $token = $request->user()->createToken('postman')->plainTextToken;

    return response()->json(['token' => $token]);
});

//Route::apiResource('books', BookController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('books', BookController::class);
});
