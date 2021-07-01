<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserSession
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
        $userId   = \Session::get('id');
        $previous_session = \Auth::User()->session_id;
        $sessionId = \Session::getId();
 
        if ($previous_session !== $sessionId) {
            \Session::getHandler()->destroy($previous_session);
            $request->session()->regenerate();
            \Auth::user()->session_id = \Session::getId();

            \Auth::user()->save();
        }
        return $next($request);
    }
}
