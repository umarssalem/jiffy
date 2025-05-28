<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/signup',function() {
    return view('signup');
})->name('signup');

Route::get('/logout', function (Request $request) {
    Auth::logout(); // Logs out the user
    $request->session()->invalidate();      // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate the CSRF token

    return redirect('/');
})->name('logout');

Route::post('/signup', [AuthController::class, 'store'])->name('signup.post');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::middleware(['auth'])->group(function () {
    Route::get('/home', function() {
        return view('home');
    })->name('home');


});


