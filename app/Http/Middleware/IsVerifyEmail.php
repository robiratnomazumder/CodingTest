<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard(Session::get('GlobalSession'))->user()->email_verified_at) {
            Auth::guard(Session::get('GlobalSession'))->logout();
            return redirect()->route('login')
                ->with('error', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return $next($request);
    }
}
