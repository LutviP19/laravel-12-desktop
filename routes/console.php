<?php


use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/**
 * Task Scheduling: Pembersihan Notifikasi Otomatis
 */
Schedule::call(function () {
    
    // // Mysql
    // DB::table('notifications')
    //     ->join('users', 'notifications.notifiable_id', '=', 'users.id')
    //     ->where('notifications.notifiable_type', '=', 'App\Models\User')
    //     ->whereNotNull('users.notification_expiry_days')
    //     ->whereRaw('notifications.created_at < DATE_SUB(NOW(), INTERVAL users.notification_expiry_days DAY)')
    //     ->delete();

    // SQLite
    DB::table('notifications')
        ->where('notifiable_type', 'App\Models\User')
        ->whereIn('notifiable_id', function($query) {
            $query->select('id')->from('users')->whereNotNull('notification_expiry_days');
        })
        ->whereRaw("created_at < datetime('now', '-' || (
            SELECT notification_expiry_days 
            FROM users 
            WHERE users.id = notifications.notifiable_id
        ) || ' days')")
        ->delete();
    
    \Illuminate\Support\Facades\Log::debug("Scheduler: Cleanup notifications older than user settings completed.");
})->daily(); // Dijalankan sekali sehari daily() (atau sesuaikan ke everyFiveMinutes() untuk testing)

