<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NativeController;

Route::get('/', function () {
    return view('welcome');
});

// Native PHP
Route::post('/notify', [NativeController::class, 'sendNotification']);
Route::get('/notification-detail', function () {
    return view('notification-detail', ['id' => cache()->get('last_notif_id')]);
})->name('notification.detail');