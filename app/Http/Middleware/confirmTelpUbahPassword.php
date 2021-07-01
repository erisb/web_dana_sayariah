<?php

namespace App\Http\Middleware;

use Closure;

class confirmTelpUbahPassword
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
        
        if ($request->session()->get('no_telp_ubah_password') == null)
        {
            return redirect('user/dashboard')->with('confirmTelpUbahPassword','gagal');
        }
        
        return $next($request);
    }
}
