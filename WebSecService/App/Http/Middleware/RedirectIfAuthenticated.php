<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Add debug logging
                \Log::info('Redirecting authenticated user from: ' . $request->path());
                return redirect('/'); // Redirect authenticated users to home
            }
        }

        return $next($request);
    }
}