<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NativeController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Native PHP
Route::post('/notify', [NativeController::class, 'sendNotification']);
Route::get('/notification-detail/{id}', function (Request $request, string $id) {
    return view('notification-detail', ['id' => $id]);
})->name('notification.detail');

