<?php

use App\Http\Controllers\AddReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\ChangeAvatarController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CheckPasswordController;
use App\Http\Controllers\GetProfileController;
use App\Http\Controllers\GetReviewsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SortReviewsController;
use App\Http\Controllers\UpdateDataController;
use App\Http\Controllers\UpdateReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('index');

Route::get('/comments', [GetReviewsController::class, 'get'])->name('comments');
Route::post('/search-reviews-comments', [GetReviewsController::class, 'search'])->name('search-reviews-comments');
Route::post('/add-review', [AddReviewController::class, 'add'])->name('add-review');
Route::post('/update-review', [UpdateReviewController::class, 'updateReview'])->middleware('auth')->name('update-review');
Route::get('/sort-reviews', [SortReviewsController::class, 'sort'])->middleware('auth')->name('sort-reviews');
Route::post('/search-reviews', [SortReviewsController::class, 'search'])->middleware('auth')->name('search-reviews');

Route::get('/authentication', function () {
    return view('authentication');
})->middleware('guest')->name('authentication');
Route::post('/authentication', [RegisterController::class, 'store'])->middleware('guest')->name('register');
Route::post('/auth', [LoginController::class, 'store'])->middleware('guest')->name('auth');
Route::get('/password-recovery', function () {
    return view('password-recovery');
})->middleware('guest')->name('password-recovery');
Route::post('/password-recovery', [PasswordRecoveryController::class, 'sendPasswordRecoveryEmail'])->name('password.recovery');
Route::get('/password-reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/profile', [GetProfileController::class, 'get'])->middleware('auth')->name('profile');
Route::post('/change-avatar', [ChangeAvatarController::class, 'change'])->middleware('auth')->name('change-avatar');
Route::post('/update-data', [UpdateDataController::class, 'updateData'])->middleware('auth')->name('update-data');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->middleware('auth')->name('change-password');
Route::post('/check-password', [CheckPasswordController::class, 'check'])->middleware('auth')->name('check-password');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');