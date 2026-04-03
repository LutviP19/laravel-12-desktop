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
        // 1. Biarkan request HTMX lewat tanpa gangguan
        if ($request->header('HX-Request')) {
            return $next($request);
        }

        // 2. Daftar pengecualian (Public Paths & Patterns)
        // Gunakan pattern '*' agar lebih dinamis untuk ID atau sub-path
        $excludedPatterns = [
            '/',
            'refresh-csrf',
            'notification-detail-public/*',
            'reset-password/*',
            'profile*',
        ];

        // 3. Daftar Route Names untuk Auth (Lebih aman daripada hardcoded path)
        $authRoutes = [
            'login', 
            'register', 
            'password.request', 
            'password.email', 
            'password.reset', 
            'password.update',
            'logout',
        ];

        // Jalankan pengecualian pattern
        foreach ($excludedPatterns as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        // 4. Logika Pengalihan Dinamis
        $isLoggedIn = Auth::check();
        $isHome = $request->routeIs('home') || $request->path() === '/';

        if ($isLoggedIn) {
            // Jika sudah login tapi mencoba akses '/' atau route auth, lempar ke dashboard
            if ($isHome || $request->routeIs($authRoutes)) {
                return redirect()->route('dashboard');
            }
            
            // Jika sudah login tapi mengakses path lain secara langsung (Full Reload), 
            // tetap arahkan ke dashboard (pola SPA NativePHP)
            if (!$request->routeIs('dashboard')) {
                return redirect()->route('dashboard');
            }
        } else {
            // Jika BELUM login dan mencoba akses dashboard atau area terproteksi
            if ($request->routeIs('dashboard') || !$request->routeIs($authRoutes) && !$isHome) {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
