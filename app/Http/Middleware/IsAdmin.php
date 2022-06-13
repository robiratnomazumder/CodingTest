<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next, $guard = 'admin')
    {

        if (Auth::guard($guard)->check() && $request->session()->has('adminSessionData')) {
            return $next($request);
        }
        return redirect('/login')->with('warning', 'Log in first for access.');
    }
}
