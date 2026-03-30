<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Event;
use Native\Desktop\Events\Notifications\NotificationClicked;
use App\Listeners\HandleNotificationClick;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Disabled view cache
        if (config('app.env') === 'local') {
        \Illuminate\Support\Facades\Blade::setEchoFormat('%s');
        // This ensures Blade checks the file modification time every request
        config(['view.cache' => false]);
    }
    }
}
