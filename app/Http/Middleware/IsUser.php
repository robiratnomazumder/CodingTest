<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    public function handle(Request $request, Closure $next, $guard = 'user')
    {
        if (Auth::guard($guard)->check() && $request->session()->has('userSessionData')) {
            return $next($request);
        }
        return redirect('/login')->with('warning', 'Log in first for access.');
    }
}
