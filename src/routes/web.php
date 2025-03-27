<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/comments', function () {
    return view('comments');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/authentication', function () {
    return view('authentication');
});

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/password-recovery', function () {
    return view('password-recovery');
});