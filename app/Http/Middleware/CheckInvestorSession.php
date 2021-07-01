<?php

namespace App\Http\Middleware;

use Closure;

class CheckInvestorSession
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
        $previousSessionId = \Auth::user()->remember_token;
        $nextSessionId = \Session::getId();
        // echo $previousSessionId;die;
 
        if ($nextSessionId !== $previousSessionId) {
            \Session::getHandler()->destroy($previousSessionId);
            $request->session()->regenerate();
            \Auth::user()->remember_token = \Session::getId();
            \Auth::user()->save();
        }
        return $next($request);
    }
}
