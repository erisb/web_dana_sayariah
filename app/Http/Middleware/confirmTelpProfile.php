<?php

namespace App\Http\Middleware;

use Closure;

class confirmTelpProfile
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
        
        if ($request->session()->get('no_telp_profile') == null)
        {
            return redirect('user/dashboard')->with('confirmTelpProfile','gagal');
        }
        
        return $next($request);
    }
}
