<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NativeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Form minta link (Lupa Password)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Proses kirim email
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Form reset password (dari email)
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Proses update password baru
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Auth
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Native PHP test kirim Notifikasi manual
Route::post('/notify', [NativeController::class, 'sendNotification']);

// Rute Publik untuk Detail Notifikasi (Akses dari Klik Desktop)
Route::get('/notification-detail-public/{id}', function (Illuminate\Http\Request $request, string $id) {
    $notification = \Illuminate\Notifications\DatabaseNotification::find($id);
    if (auth()->check() && $notification) {
        $notification->markAsRead();
    }

    return view('notification-detail', [
        'id' => $id,
        'notification' => $notification
    ]);
})->name('notification.public');
Route::get('/notification-detail-public', function () {
    return view('notification-detail');
})->name('notification');


// Auth middleware 'auth', 
Route::middleware(['htmx.auth'])->group(function () {

    // Pastikan lewat middleware 'web' agar session aktif
    Route::middleware(['web'])->group(function () {
        // Refresh CSRF
        Route::get('/refresh-csrf', function () {
            // // Menghapus token lama dan membuat yang baru dalam sesi yang sama
            // \Illuminate\Support\Facades\Session::regenerateToken(); 
            
            // // Atau jika ingin ID Sesi-nya juga ganti (lebih aman dari Session Fixation)
            // request()->session()->regenerate();

            $token = csrf_token();
            \Illuminate\Support\Facades\Log::debug('New CSRF-TOKEN: '.$token);
            return response()->json(['token' => $token]);
            exit;
        })->name('refresh.csrf'); 
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Main Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Partials - HTMX
    Route::get('/dashboard-partial', function () {
        return view('partials.dashboard');
    })->name('dashboard.partial');

    // Dashboard - Chart
    Route::get('/api/chart-data', [ChartController::class, 'getChartData']);

    // TodoController
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/todos', [TodoController::class, 'store']);
    Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggle']);
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy']);

    // Notification Module
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notification-detail/{id}', function (Illuminate\Http\Request $request, string $id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead(); 
        
        return view('notifications.detail', compact('notification'));
    })->name('notification.detail');

});