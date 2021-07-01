<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PendanaanAktif;
use App\Jobs\ProcessPayoutMonthly;
use Illuminate\Support\Facades\Auth;
use App\Subscribe;

class PayoutController extends Controller
{
    //create new payout subscription
    public function newSubscribe(Request $request){
        $investor = Auth::user();
        $pendanaan = PendanaanAktif::find($request->pendanaan);
        
        
        // create new subscription
        $subscribe = Subscribe::create([
            'investor_id' => $investor->id,
            'pendanaanAktif_id' => $pendanaan->id,
            'BANK' => $request->bank,
            'rekening' => $request->rekening,
            'pemilik_rekening' => $investor->detilInvestor->nama_investor,
        ]);
        return redirect('user/manage_investation');
    }
    // public function removeSubscribe(Subcribe $subscribe){
    //     $subscribe->delete();
    //     return redirect('user/dashboard');
    // }

    public function unSubscribe(Request $request){
        $investor = Subscribe::where('pendanaanAktif_id', $request->pendanaanAktif_id)->delete();

        return redirect('user/manage_investation');
    }
}
