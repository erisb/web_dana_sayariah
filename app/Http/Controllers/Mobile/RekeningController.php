<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\RekeningInvestor;
use App\MutasiInvestor;
use App\DetilInvestor;
use App\Events\MutasiInvestorEvent;
use App\PenarikanDana;
use JWTAuth;
use JWTFactory;

class RekeningController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function listMutasi() {
        $mutasi_user = MutasiInvestor::where('investor_id', Auth::guard('api')->user()->id)->orderby('id', 'desc')->get();

        $i = 0;
        foreach ($mutasi_user as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        return json_encode($return);
    }

    public function showPenarikan() {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        return [
            'unallocated' => $rekening->unallocated,
            'total_dana' => $rekening->total_dana,
            'rekening' => $detil->rekening,
            'bank' => $detil->bank,
            'nama' => $detil->nama_investor
        ];
    }

    public function requestPenarikan(Request $request) {
        $rekening = Auth::user()->rekeningInvestor;
        $requestAmount = $request->nominal;

        // use laravel collection method SUM()
        $sumAvailable = $rekening->unallocated;

        if($requestAmount<100000){
            return response()->json(['error'=>'Penarikan minimum adalah Rp. 100.000,-']);
        }

        if($requestAmount > $sumAvailable){
            // Throw error, cant  request more than available sum
            return response()->json(['error'=>'Penarikan dana anda lebih dari dana tersedia, silahkan mengambil uang pada pendanaan anda terlebih dahulu']);
        }

        // Create new record penarikan dana
        PenarikanDana::create([
            'investor_id' => Auth::user()->id,
            'jumlah' => $request->nominal,
            'no_rekening' => $request->rekening,
            'bank' => $request->bank,
            'accepted' => 0,
        ]);

        $rekening->unallocated -= $requestAmount;
        $rekening->total_dana -= $requestAmount;
        $rekening->save();
        
        // throw event MutasiInvestorEvent
        event(new MutasiInvestorEvent(Auth::user()->id,'request DEBIT',-$request->nominal,'Penarikan dana sedang diproses'));
        return response()->json(['success'=>'Penarikan anda sedang diproses']);
    }

    public function encrypt(Request $request) {
        //make payload for encryption
        $payload = JWTFactory::make();
        //push data to payload
        $payres = JWTFactory::data($request);
        //encrypt payload
        $encrypt = JWTAuth::encode($payload);
        //decrypt message
        $decrypt = JWTAuth::decode($encrypt);
        //get data
        $result = $decrypt['data'];
        return $result;
    }
}
