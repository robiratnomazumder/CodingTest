<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAgent
{
    public function handle(Request $request, Closure $next, $guard = 'agent')
    {

        if (Auth::guard($guard)->check() && $request->session()->has('agentSessionData')) {
            return $next($request);
        }
        return redirect('/login')->with('warning', 'Log in first for access.');
    }
}
