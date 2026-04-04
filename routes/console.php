<?php


use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/**
 * Task Scheduling: Pembersihan Notifikasi Otomatis
 */
Schedule::call(function () {
    try {

        // // Mysql
        // $deletedCount = DB::table('notifications')
        //     ->join('users', 'notifications.notifiable_id', '=', 'users.id')
        //     ->where('notifications.notifiable_type', '=', 'App\Models\User')
        //     ->whereNotNull('users.notification_expiry_days')
        //     ->whereRaw('notifications.created_at < DATE_SUB(NOW(), INTERVAL users.notification_expiry_days DAY)')
        //     ->delete();

        // SQLite: Hapus notifikasi berdasarkan setting expiry masing-masing user
        $deletedCount = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\User')
            ->whereIn('notifiable_id', function($query) {
                $query->select('id')
                      ->from('users')
                      ->whereNotNull('notification_expiry_days')
                      ->where('notification_expiry_days', '>', 0);
            })
            ->whereRaw("created_at < datetime('now', '-' || (
                SELECT notification_expiry_days 
                FROM users 
                WHERE users.id = notifications.notifiable_id
            ) || ' days')")
            ->delete();

        if ($deletedCount > 0) {
            Log::info("Scheduler: Cleanup completed. {$deletedCount} old notifications deleted.");
        } else {
            Log::debug("Scheduler: Cleanup executed, but no notifications were old enough to delete.");
        }

    } catch (\Throwable $e) {
        // Menangkap semua jenis error (Database locked, Query error, dll)
        Log::error("Scheduler Error [Notification Cleanup]: " . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
})->twiceDaily(1, 13); // twiceDaily(1, 13) Dijalankan pada jam 1 pagi dan jam 1 siang (interval 12 jam) atau sesuaikan ke everyMinute() untuk testing