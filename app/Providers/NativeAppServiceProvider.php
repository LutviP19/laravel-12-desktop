<?php

namespace App\Providers;


use Native\Desktop\Facades\ChildProcess;

use Native\Desktop\Facades\Menu;
use Native\Desktop\Facades\Window;
use Native\Desktop\Contracts\ProvidesPhpIni;

use Illuminate\Support\Facades\Log;


class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        // MenuBar::create()->route('notification.detail');

        // Menu::default();

        // Menu Navigasi Kustom
        $menu = Menu::make(
                        Menu::link(route('home'), 'Home', 'CmdOrCtrl+H'),
                        Menu::separator(),
                        Menu::link(route('dashboard'), 'Dashboard', 'CmdOrCtrl+D'),
                        Menu::separator(),
                        Menu::quit()->label('Quit')
                )->label('Laravel 12');

        // Membuat struktur menu sesuai standar dokumentasi terbaru
        Menu::create(
            $menu,
            // // Menu Edit Standar (Copy, Paste, dsb)
            // Menu::edit(),
            // Menu View & Window Standar
            Menu::view(),
            Menu::window()
        );

        // Window::open();
        Window::open('main')
                ->title(config('app.name'))
                // ->url(route('notification'))
                ->showDevTools(false)
                ->rememberState();

        // Menjalankan Laravel Scheduler sebagai background process di Desktop
        // 'schedule:work' akan terus berjalan selama aplikasi terbuka
        ChildProcess::artisan(
            cmd: 'schedule:work',
            alias: 'laravel-scheduler-bg'
        );
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
            // 'memory_limit' => '512M',
            // 'display_errors' => '1',
            // 'error_reporting' => 'E_ALL',
            // 'max_execution_time' => '0',
            // 'max_input_time' => '0',
        ];
    }
}
