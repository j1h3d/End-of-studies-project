<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // User is not authenticated, redirect to login page
            return redirect('/login');
        }

        // User is authenticated, proceed with the request
        return $next($request);
        if (!$request->expectsJson()) {
            return route('login'); // Replace 'login' with your desired login route
        }
    }
}
