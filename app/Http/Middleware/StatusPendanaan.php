<?php

namespace App\Http\Middleware;

use Closure;
use App\Proyek;
use App\PendanaanAktif;
use Carbon\Carbon;
use App\BorrowerPendanaan;
use App\LogAkadDigiSignBorrower;
use App\BorrowerRekening;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;

class StatusPendanaan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	 
    private function updatePendanaan($id,$status)
    {
        if ($id)
        {
            $update = BorrowerPendanaan::where('pendanaan_id',$id)->update(['status' => $status]);
            return $update;
        }
    }
    public function handle($request, Closure $next)
    {
        $client = new client();
		$getPendanaan = BorrowerPendanaan::where('id_proyek', '!=', 0)->get();
		if($getPendanaan){
            foreach($getPendanaan as $Pendanaans){
				$getStatus = Proyek::where('id',$Pendanaans->id_proyek)->first();
				if(empty($getStatus)){
                    $status =0;
                }else{
                    $status = $getStatus->status;
                }
                //cek
				if($status == 2 && $Pendanaans->status == 1 || $status == 3 && $Pendanaans->status == 1){
                  
					$this->updatePendanaan($Pendanaans->pendanaan_id,6);
					
                }
				
                
            }
        }
		/*
		// $getPendanaan = DB::table('brw_pendanaan as a')
			// ->join('proyek as b', 'b.id', '=', 'a.id_proyek')
			// ->select('a.brw_id', 'a.pendanaan_id',  'a.id_proyek as id_proyek_pendanaan', 'a.status as status_pendanaan', 'b.id as id_proyek', 'b.nama', 'b.status_tampil', 'b.status as status_proyek')
			// ->where('a.brw_id','=', Auth::guard('borrower')->user()->brw_id)
			// ->get();
			
		// $countPendanaan = count($getPendanaan);
		// $arrayPendanaan[] = array();
		
		
		
		
		// $nilaiInvest = 0; // nilai summary invest pendanaan aktif
		
		// for($i=0; $i<$countPendanaan; $i++){
			
			
			// $arrayPendanaan[$i] = [
				// "id_proyek" => $getPendanaan[$i]->id_proyek, 
				// "status_proyek" => $getPendanaan[$i]->status_proyek, 
				// "status_tampil" => $getPendanaan[$i]->status_tampil,
				// "status_pendanaan" => $getPendanaan[$i]->status_pendanaan,
				// "id_proyek_pendanaan" => $getPendanaan[$i]->id_proyek];
			
		// }
		
		
		// $countArray = count($arrayPendanaan);
		
		
		// for($ii = 0; $ii<$countArray; $ii++){
			
			
			
			// $selectTTD = DB::table('log_akad_digisign_borrower as a')
				// ->where('a.status', '=', 'complete')
				// ->where('a.id_proyek','=', $arrayPendanaan[$ii]["id_proyek"])
				// ->first();
			
				
			// //foreach($selectTTD as $value_ttd){
				
				
				
				// if($arrayPendanaan[$ii]["status_proyek"] == 2  || $arrayPendanaan[$ii]["status_proyek"] == 3 ){
					
					// $update = BorrowerPendanaan::where('id_proyek',$arrayPendanaan[$ii]["id_proyek"])->update(['status' => 6]);
				
				// }
				
				// elseif($arrayPendanaan[$ii]["status_pendanaan"] == 6 && $selectTTD->status == "complete"){
					
					// $sumInvestDana = DB::table('pendanaan_aktif as a')
					
					// ->select(DB::raw("SUM(a.total_dana) as counts"))
					// ->where('a.proyek_id','=', $selectTTD->id_proyek)
					// ->get();
					
					// $nilaiInvest += $sumInvestDana[0]->counts;
					// $update = BorrowerPendanaan::where('id_proyek',$selectTTD->id_proyek)->update(['status' => 7]);
				// }
				
			// //}
				
			// if($arrayPendanaan[$ii]["status_proyek"] == 4 && $arrayPendanaan[$ii]["status_tampil"] == 2){
				// $update = BorrowerPendanaan::where('id_proyek',$arrayPendanaan[$ii]["id_proyek"])->update(['status' => 4]);
			// }	
			
		// }
		
		
		
		
		
		// $pendanaan = DB::table('brw_pendanaan as a')
            // ->join('proyek as b', 'b.id', '=', 'a.id_proyek')
			// ->select('a.brw_id', 'a.pendanaan_id',  'a.id_proyek', 'a.status as status_pendanaan', 'b.id', 'b.nama', 'b.status as status_proyek')
            // ->where('a.id_proyek', '!=',0)
            // ->where('a.brw_id', '=', Auth::guard('borrower')->user()->brw	_id)
            // ->get();
		// $countPendanaan = count($pendanaan);
		// $array = array();
		// $nilaiInvest = 0;
		
		
		
		// for($i=0; $i<$countPendanaan; $i++){
			
			
			// if($pendanaan[$i]->status_proyek == 2 or $pendanaan[$i]->status_proyek == 3){
				// //echo json_encode($pendanaan);
				// //$this->updatePendanaan($pendanaan[$i]->pendanaan_id,6);
				
			// }
			
			
			
			
			
			
			// $selectTTD = DB::table('log_akad_digisign_borrower as a')
			// ->join('pendanaan_aktif as b', 'b.proyek_id', '=', 'a.id_proyek')
			// ->select('a.brw_id', 'a.id_proyek',  'a.status', 'b.proyek_id')
			// ->select(DB::raw("SUM(b.total_dana) as counts"))
			// ->where('a.status', '=', 'complete')
			// ->where('a.id_proyek','=', $pendanaan[$i]->id_proyek)
			// ->get();
			
			// var_dump($selectTTD);
			// if($selectTTD){
				// $nilaiInvest += $selectTTD[0]->counts;
				// $this->updatePendanaan($pendanaan[$i]->pendanaan_id,2);
			// }
				
				
				
			
			
			
			// $selectTTD = DB::table('log_akad_digisign_borrower as a')
            // ->join('pendanaan_aktif as b', 'b.proyek_id', '=', 'a.id_proyek')
			// ->select('a.brw_id', 'a.id_proyek',  'a.status', 'b.proyek_id')
			// ->select(DB::raw("SUM(b.total_dana) as counts"))
            // ->where('a.status', '=', 'complete')
            // ->where('id_proyek','=', $pendanaan[$i]->id_proyek)
            // ->get();
			
			// $nilaiInvest += $selectTTD[0]->counts;
			
		// }
		// $nilai_terpakai = $nilaiInvest;
		// $nilai_sisa 	= $total_plafon - $nilai_terpakai;
		// $updatePlafon 	= BorrowerRekening::where('brw_id','=', Auth::guard('borrower')->user()->brw_id)
						// ->update(['total_terpakai'=>$nilai_terpakai, 'total_sisa'=>$nilai_sisa]);
			
		// }
        */

        // $id = Auth::guard('borrower')->user()->brw_id;
        // //status brw
        // $response = $client->request('GET', config('app.apilink')."/borrower/statusbrw/".$id);
        // $status = json_decode($response->getBody()->getContents());
        // Session::put('status',$status->statusBrw);

        // //plafon
    	// $response = $client->request('GET', config('app.apilink')."/borrower/updateSession/".$id);
        // $body = json_decode($response->getBody()->getContents());
        
        // Session::put('brw_nama',$body->brw_nama);
        // Session::put('brw_type',$body->brw_type);
        // Session::put('brw_ptotal',$body->brw_ptotal);
        // Session::put('brw_ppake',$body->brw_ppake);
        // Session::put('brw_psisa',$body->brw_psisa);
        // Session::put('pendanaan',$body->data_pendanaan);
        
        return $next($request);
        
    }
}
