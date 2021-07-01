<?php

namespace App\Http\Middleware;

use Closure;
use App\Investor;
use Auth;
use App\Http\Controllers\UserController;
use App\MasterProvinsi;
use App\MasterAgama;
use App\MasterAsset;
use App\MasterBadanHukum;
use App\MasterBank;
use App\MasterBidangPekerjaan;
use App\MasterJenisKelamin;
use App\MasterJenisPengguna;
use App\MasterKawin;
use App\MasterKepemilikanRumah;
use App\MasterNegara;
use App\MasterOnline;
use App\MasterPekerjaan;
use App\MasterPendapatan;
use App\MasterPendidikan;
use App\MasterPengalamanKerja;
use App\DetilInvestor;

class brwCheck
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
        if(Auth::guard('borrower')->check()){
            $borrower = Auth::guard('borrower')->user();
            if ($borrower->status == 'notfilled'){
                return redirect('borrower/lengkapi_profile');
            }

            else if ($borrower->status == 'reject'){
                return redirect('borrower/status_reject');
            }

            else if($borrower->status == 'pending'){
                return redirect('borrower/status_pending');
            } 

            else if($borrower->status == 'suspend'){
                return redirect('/#loginModal');
            }
            else if($borrower->status == 'active'){
                return redirect('borrower/dashboardPendanaan');
            }
        }
        
        
        else
        {
            return redirect('/#loginModal');
        }
        
        return $next($request);
    }
}
