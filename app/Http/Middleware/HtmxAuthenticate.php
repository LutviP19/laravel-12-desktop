<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HtmxAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->header('HX-Request')) {
                // Mengirim header khusus HTMX untuk redirect satu layar penuh
                return response('', 200)->header('HX-Redirect', route('login'));
            }

            return redirect()->route('login');
        }
        
        return $next($request);
    }
}
