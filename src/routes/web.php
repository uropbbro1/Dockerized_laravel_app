<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('index');

Route::get('/comments', function () {
    return view('comments');
})->name('comments');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/authentication', function () {
    return view('authentication');
})->middleware('guest')->name('authentication');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/password-recovery', function () {
    return view('password-recovery');
})->name('password-recovery');

Route::post('/authentication', [RegisterController::class, 'store'])->middleware('guest')->name('register');
Route::post('/auth', [LoginController::class, 'store'])->middleware('guest')->name('auth');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');