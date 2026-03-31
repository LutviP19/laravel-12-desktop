<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NativeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Native PHP
Route::post('/notify', [NativeController::class, 'sendNotification']);
Route::get('/notification-detail/{id}', function (Request $request, string $id) {
    return view('notification-detail', ['id' => $id]);
})->name('notification.detail');
Route::get('/notification-detail', function () {
    return view('notification-detail');
})->name('notification');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Partials - HTMX
Route::get('/dashboard-partial', function () {
    return view('partials.dashboard');
})->name('dashboard.partial');
Route::get('/notification-partial', function () {
    return view('partials.notification');
})->name('notification.partial');

Route::middleware(['auth'])->group(function () {
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/todos', [TodoController::class, 'store']);
    Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggle']);
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);
});