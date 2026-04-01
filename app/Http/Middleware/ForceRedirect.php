<?php 

// app/Http/Middleware/ForceRedirect.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceRedirect
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user me-refresh halaman (bukan request htmx)
        if (!$request->header('HX-Request')) {
            $currentPath = $request->path();
            $authPaths = ['login', 'register', 'logout', '/'];
            $isNotificationPath = $request->is('notification-detail-public/*');

            if($isNotificationPath) {
                return $next($request);
            }

            if (Auth::check() && $request->routeIs('home')) {
                return $next($request);
            }

            if (Auth::check() && $currentPath !== 'dashboard') {
                return redirect('/dashboard');
            }

            if (!Auth::check() &&  $request->routeIs('dashboard')) {
                return redirect('/login');
            }

            if (!Auth::check() && !in_array($currentPath, $authPaths)) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
