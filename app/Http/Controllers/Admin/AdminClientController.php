<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Guzzle
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Borrower;
use DB;

// Model
use App\BorrowerTipePendanaan;


class AdminClientController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth:api', ['except'=>[]]);
  }
  
  
  // Start Client Jenis Pendanaan Here
  public function getTableJenisBorrower()
  {
    
    $client = new Client();
    $request = $client->get(config('app.apilink')."/borrower-admin/client-side/jenisPendanaanPage");
    $response = $request->getBody()->getContents();
    // return response()->json($request->getBody()->getContents());
    return response($response);
  }

	public function tableGetBorrower()
	{    
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/tableBorrowerData");
		$response = $request->getBody()->getContents();
    
		return response($response);
	}
  
	public function getDataBorrower(){
		
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataBorrower");
		$response = $request->getBody()->getContents();
    
		return response($response);
	}
	public function getDetailsBorrower($borrower_id){
		
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/getDetailsBorrower/".$borrower_id."");
		$response = $request->getBody()->getContents();
    
		return response($response);
	}
	
	/**************************** DATA *********************************************/
	
	public function DataPendidikan(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataPendidikan/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataJenisKelamin(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataJenisKelamin/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataAgama(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataAgama/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataNikah(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataNikah/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataProvinsi(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataProvinsi/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataKota($kota){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataKota/$kota");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function GantiDataKota($kota){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/GantiDataKota/$kota");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	// public function GantiDataKota($kota){
        
		// $client = new Client();
		// $request = $client->get(config('app.apilink')."/borrower-admin/client-side/GantiDataKota/$kota");
		// $response = $request->getBody()->getContents();
    
		// return response($response);
        
    // }
	
	public function DataBank(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataBank/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataPekerjaan(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataPekerjaan/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataBidangPekerjaan(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataBidangPekerjaan/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataBidangOnline(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataBidangOnline/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataPengalaman(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataPengalaman/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	public function DataPendapatan(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataPendapatan/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
	}
	
	public function DataDokumenBorrower(){
        
		$client = new Client();
		$request = $client->get(config('app.apilink')."/borrower-admin/client-side/DataDokumenBorrower/");
		$response = $request->getBody()->getContents();
    
		return response($response);
        
    }
	
	/**************************** END DATA *****************************************/
	

  
}
