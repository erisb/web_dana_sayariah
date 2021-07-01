<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($guard=='marketer'){
            if (Auth::guard($guard)->check()) {
                return redirect()->route('marketer.dashboard');
              }
        }
        if($guard=='admin'){
            if (Auth::guard($guard)->check()) {
                return redirect()->route('admin.dashboard');
              }
        }
        if($guard=='borrower'){
            if (Auth::guard($guard)->check()) {
                return redirect('/');
              }
        }
        
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
