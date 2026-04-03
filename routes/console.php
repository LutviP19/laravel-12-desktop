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
    // 1. Ambil semua durasi expiry unik yang digunakan user (misal: 7, 30)
    // agar kita tidak perlu melakukan looping per-user (lebih efisien).
    $expirySettings = DB::table('users')
        ->whereNotNull('notification_expiry_days')
        ->where('notification_expiry_days', '>', 0)
        ->distinct()
        ->pluck('notification_expiry_days');

    foreach ($expirySettings as $days) {
        // 2. Hapus notifikasi untuk semua user yang memiliki setting 'X' hari
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->whereIn('notifiable_id', function($query) use ($days) {
                $query->select('id')
                      ->from('users')
                      ->where('notification_expiry_days', $days);
            })
            // SQLite membandingkan string tanggal, now()->subDays() menghasilkan format yang tepat
            ->where('created_at', '<', now()->subDays($days))
            ->delete();
    }
    
    \Illuminate\Support\Facades\Log::debug("Scheduler: Cleanup notifications older than user settings completed.");
})->daily(); // Dijalankan sekali sehari (atau sesuaikan ke everyFiveMinutes() untuk testing)

