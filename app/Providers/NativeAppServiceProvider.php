<?php

namespace App\Providers;


// use Native\Desktop\Facades\MenuBar;
// use Native\Desktop\Facades\Menu;
// use Native\Desktop\Menu\Items\MenuItem;
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

        // Menu::create(
        //     Menu::app(),    // Khusus macOS
        //     Menu::file(),
        //     Menu::edit(),
        //     Menu::view(),
        //     Menu::window()
        // );

        // Window::open();
        Window::open()
                ->title(config('app.name'))
                // ->url(route('notification.detail'))
                ->showDevTools(false)
                ->rememberState();

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
