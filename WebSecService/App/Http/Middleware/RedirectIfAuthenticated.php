<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Never redirect to login
                if ($request->is('login') || $request->is('register')) {
                    return redirect('/');
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}