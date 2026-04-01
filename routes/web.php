<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NativeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChartController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Native PHP
Route::post('/notify', [NativeController::class, 'sendNotification']);

// Route::get('/notification-detail-public/{id}', function (Request $request, string $id) {
//     return view('notification-detail', ['id' => $id]);
//     // return view('notifications.detail.full', ['id' => $id]);
// })->name('notification.public');
// Route::get('/notification-detail-public', function () {
//     return view('notification-detail');
// })->name('notification');


// Rute Publik untuk Detail Notifikasi (Akses dari Klik Desktop)
Route::get('/notification-detail-public/{id}', function (Illuminate\Http\Request $request, string $id) {
    
    // Cari notifikasi berdasarkan UUID
    // Kita gunakan model DatabaseNotification agar bisa mencari tanpa harus 'auth' dulu jika perlu
    $notification = \Illuminate\Notifications\DatabaseNotification::find($id);

    // Jika user sedang login, tandai sebagai sudah dibaca
    if (auth()->check() && $notification) {
        $notification->markAsRead();
    }

    return view('notification-detail', [
        'id' => $id,
        'notification' => $notification // Kirim objek notification ke view
    ]);
})->name('notification.public');

// Fallback jika tidak ada ID
Route::get('/notification-detail-public', function () {
    return view('notification-detail');
})->name('notification');

// Auth middleware 'auth', 
Route::middleware(['htmx.auth'])->group(function () {

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

    // Route::get('/notification-detail', function () {
    //     return view('notifications.index'); // Arahkan ke list saja jika ID tidak ada
    // })->name('notification');

});