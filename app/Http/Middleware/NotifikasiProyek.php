<?php

namespace App\Http\Middleware;

use Closure;
use App\Proyek;
use Carbon\Carbon;
use App\Jobs\NotifikasiProyekJob;
use App\Admins;

class NotifikasiProyek
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
        $jumlahProyek = Proyek::where('status',1)->count();
        $dataLogin = Admins::where(\DB::raw('substr(last_login_at,1,10)'),Carbon::now()->format('Y-m-d'))->count();

        if ($jumlahProyek < 19)
        {
            session(['jumlahNotif' => 1, 'kalimat' => 'Jumlah proyek yang aktif tinggal '.$jumlahProyek.'. Terima Kasih Bro.']);
            if ($dataLogin == 1)
            {
                if (session('dataTgl') != Carbon::now()->format('Y-m-d'))
                {
                    dispatch(new NotifikasiProyekJob);
                }
                session(['dataTgl' => Carbon::now()->format('Y-m-d')]);
            }
        }
        else
        {
            session(['jumlahNotif' => 0, 'kalimat' => '']);
        }
        return $next($request);
    }
}
