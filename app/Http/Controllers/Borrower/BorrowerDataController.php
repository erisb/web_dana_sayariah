<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Investor;
use App\Proyek;
use App\MasterProvinsi;
use DB;

// estension custom
use Illuminate\Support\Facades\Config;
//use App\Http\Middleware\UserCheck;

class BorrowerDataController extends Controller
{
    
	/*
		$response = $client->request('POST', 'http://httpbin.org/post', [
			'form_params' => [
				'field_name' => 'abc',
				'other_field' => '123',
				'nested_field' => [
					'nested' => 'hello'
				]
			]
		]);
	*/
	
	public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['DataProvinsi', 'DataKota', 'DataPekerjaan', 'DataBidangPekerjaan', 'DataPengalamanPekerjaan', 'DataPendapatan','DataPendidikan', 'CheckNIK', 'CheckNIKBH', 'TipePendanaan', 'PersyaratanPendanaan', 'JenisKelamin', 'KepemilikanRumah', 'Agama', 'StatusPerkawinan', 'BidangPekerjaanOnline', 'DataBank', 'CheckNoTlp','PersyaratanPendanaanProsesPengajuan','JenisJaminan']]);
    }
	
	 public function DataPendidikan(){
		 
	  
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_pendidikan");
		
		echo $response->getBody();
   
    }
	
	public function CheckNIK($nik){
        $client = new client();
		$response = $client->get(config('app.apilink')."/borrower/check_nik/$nik");
		
		echo $response->getBody();
		
    }
	
	public function CheckNoTlp($noTLP){
        $client = new client();
		$response = $client->get(config('app.apilink')."/borrower/check_no_tlp/$noTLP");
		echo $response->getBody();
		
    }
	
	public function DataProvinsi(){
		 
	  
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_provinsi");
		
		echo $response->getBody();
   
    }
    
    public function DataKota($id){
		 
	  
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_kota/$id");
		
		echo $response->getBody();
   
    }

	public function DataPekerjaan(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_pekerjaan");
		
		echo $response->getBody();
   
    }

    public function DataBidangPekerjaan(){
		 
	  
		$getBidangPekerjaan = DB::table('m_bidang_pekerjaan')->select('id_bidang_pekerjaan', 'bidang_pekerjaan')->get();
		
		$i=0; 
        foreach($getBidangPekerjaan as $data){
            $listBidangPekerjaan[$i]= [
                'id'=>$data->id_bidang_pekerjaan,
                'text' => $data->bidang_pekerjaan,
            ];
            $i++;
        }
        

        return json_encode($listBidangPekerjaan);
   
    }

    public function DataPengalamanPekerjaan(){
		 
	  
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_pengalaman_pekerjaan");
		
		echo $response->getBody();
		
   
    }
	public function DataBank(){
		 
	  
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_bank");
		
		echo $response->getBody();
		
   
    }
    public function DataPendapatan(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/data_pendapatan");
		
		echo $response->getBody();
		
	}
	
	public function JenisKelamin(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/jenis_kelamin");
		
		echo $response->getBody();
		
	}
	public function Agama(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/agama");
		
		echo $response->getBody();
		
	}
	public function StatusPerkawinan(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/status_perkawinan");
		
		echo $response->getBody();
		
	}
	public function KepemilikanRumah(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/status_rumah");
		
		echo $response->getBody();
		
	}
	public function BidangPekerjaanOnline(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/bidang_pekerjaan_online");
		
		echo $response->getBody();
		
	}	

    public function TipePendanaan(){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/tipe_pendanaan");
		
		echo $response->getBody();
   
	}

    public function PersyaratanPendanaan($tipe_borrower, $tipe_pendanaan){
		 
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/persyaratan_pendanaan/$tipe_borrower/$tipe_pendanaan");
		
		echo $response->getBody();
		
	}
	
	public function JenisJaminan(){
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/jenis_jaminan");
		
		echo $response->getBody();
	}

    public function CheckNIKBH($nik){
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/check_nik_bh/$nik");

		echo $response->getBody();
        
    }
	
	public function PersyaratanPendanaanProsesPengajuan($brw_id,$tipe_borrower, $tipe_pendanaan){
		$client = new client();
		$response = $client->get(config('app.apilink')."/borrower/persyaratan_pendanaan_proses_pengajuan/$brw_id/$tipe_borrower/$tipe_pendanaan");
		
		echo $response->getBody();
	}
	

    
    
    
}