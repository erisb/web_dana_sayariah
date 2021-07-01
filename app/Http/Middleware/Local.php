<?php

namespace App\Http\Middleware;

use Closure;

class Local
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(session('locale'));
        \App::setLocale(session('locale'));
        return $next($request);
    }
}
