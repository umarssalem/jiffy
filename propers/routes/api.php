<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ListingController;

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


Route::middleware(['throttle:api-token'])->group(function () {
    Route::get('/availability', [ListingController::class, 'check'])
        ->middleware(['basic.token.auth', 'validate.availability.request']);

    Route::post('/availability', [ListingController::class, 'checkDialogFlowRequest'])
    ->middleware(['basic.token.auth']);

    Route::post('/publish/listing', [ListingController::class, 'publish'])
        ->middleware(['basic.token.auth', 'validate.listing.body']);
});
