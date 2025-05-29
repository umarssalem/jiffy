<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/endpoint', function () {
    $mockData = [
        'id' => rand(1, 100),
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'created_at' => now()->toDateTimeString()
    ];

    return response()->json($mockData);
});