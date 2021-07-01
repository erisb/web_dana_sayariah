<?php

namespace App\Http\Middleware;

use Closure;

class confirmTelpDana
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
        if ($request->session()->get('no_telp_dana') == null)
        {
            return redirect('user/dashboard')->with('confirmTelpDana','gagal');
        }

        return $next($request);
    }
}
