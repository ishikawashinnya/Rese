<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\RegisterRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/thanks', function() {return view('auth.thanks');})->name('thanks');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::get('/email/verify', function() {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Public Routes
Route::get('/', [ReseController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/detail/{shop_id}', [ReseController::class, 'detail']);
Route::get('/done', [ReseController::class, 'done'])->name('reservation.done');

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/reservation', [ReseController::class, 'store'])->name('reservation.store');

    Route::get('/mypage', [ReseController::class, 'mypage']);
    Route::post('/delete', [ReseController::class, 'delete']);

    Route::post('/favorites', [ReseController::class, 'create'])->name('favorites.create');
    Route::delete('/favorites/{id}', [ReseController::class, 'destroy'])->name('favorites.destroy');
});
