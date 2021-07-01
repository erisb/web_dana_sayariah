<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Guzzle
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

// Model
use App\BorrowerTipePendanaan;

// estension custom
use Illuminate\Support\Facades\Config;

//create VA Proyek
use App\Http\Controllers\RekeningController;

use App\LoginBorrower;
// create log
use App\AuditTrail;
use Auth;

class AdminProsessController extends Controller
{
  
  public function __construct()
  {
      // $this->middleware('auth:api', ['except'=>[]]);
  }
  
  // Jenis Pendanaan Prosess Start Here
  public function postNewJenis(Request $request)
  {    
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/postJenisPendanaan",[
      'form_params' =>
      [
        'pendanaanNama' => $request->pendanaanJenis,
        'pendanaanKeterangan' => $request->pendanaanKeterangan,
      ]
    ]);

    $response = $request->getBody()->getContents();

    $audit = new AuditTrail;
    $username = Auth::guard('admin')->user()->firstname;
    $audit->fullname = $username;
    $audit->menu = "Persyaratan Penerima Pendanaan";
    $audit->description = "Tambah Jenis Pendanaan";
    $audit->ip_address =  \Request::ip();
    $audit->save();

    if($response == 'Success')
    {
      return redirect()->back()->with('success','Telah menambahakan jenis Pendanaan');
    }
    else
    {
      return redirect()->back()->with('error','Ada yang error nih.');      
    }

  }

  public function updateJenis(Request $request)
  {
    $id = $request->idPendanaanJenis;
    $jenis = $request->editPendanaanJenis;
    $ket = $request->editPendanaanKeterangan;

    $idList = array();
    $valueList = array();
    $list = array();
    $deleteList = array();

    $idList[] = $request->idList;
    $valueList[] = $request->valueList;
    $list[] = $request->list;
    $deleteList[] = $request->deleteList; 

    // dd($list);



    // dd($response);
    
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/updateTipeJenis",[
      'form_params' =>
      [       
        'pendanaanId' => $id,
        'idList' => $request->idList,
        'listValue' => $request->list,
        'checkBox' => $request->valueList,
        'deleteList' => $request->deleteList,
      ]
    ]);
    $resUpdateTipeJenis = $request->getBody()->getContents();

    
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/updateJenisPendanaan",[
      'form_params' =>
      [
        'pendanaanId' => $id,
        'pendanaanNama' => $jenis,
        'pendanaanKeterangan' => $ket,    
      ]
    ]);
    $response = $request->getBody()->getContents();

    // dd($resUpdateTipeJenis);

     
    $audit = new AuditTrail;
    $username = Auth::guard('admin')->user()->firstname;
    $audit->fullname = $username;
    $audit->menu = "Persyaratan Penerima pendanaan";
    $audit->description = "Edit jenis pendanaan";
    $audit->ip_address =  \Request::ip();
    $audit->save();
    
    if($resUpdateTipeJenis == 'Success')
    {
      return redirect()->back()->with('success','Telah mengupdate jenis Pendanaan');
    }
    else
    {
      return redirect()->back()->with('error','Ada yang error nih.');      
    }
  }

  public function deleteJenis($id)
  {
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/postDeleteJenis",[
      'form_params' =>
      [
        'pendanaanId' => $id,
      ]
    ]);
    $response = $request->getBody()->getContents();

    $audit = new AuditTrail;
    $username = Auth::guard('admin')->user()->firstname;
    $audit->fullname = $username;
    $audit->description = "Hapus jenis pendanaan";
    $audit->ip_address =  \Request::ip();
    $audit->save();
    if($response == 'Success')
    {
      $resData = ['data' => 'sukses'];
      
      return response($resData);
    }
    else
    {

    }
  }
  

  public function getListJenis($id)
  {
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/getListJenis",
                            [
                              'form_params' => 
                              [
                                'tipe_id' => $id,
                              ]
                            ]
                          );
    $response = $request->getBody()->getContents();
    
    return response($response);
    
  }

  
  public function getListJenisA($id)
  {
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/getListJenisA",
                            [
                              'form_params' => 
                              [
                                'tipe_id' => $id,
                              ]
                            ]
                          );
    $response = $request->getBody()->getContents();
    
    return response($response);
    
  }

  
  public function getListJenisB($id)
  {
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/getListJenisB",
                            [
                              'form_params' => 
                              [
                                'tipe_id' => $id,
                              ]
                            ]
                          );
    $response = $request->getBody()->getContents();
    
    return response($response);
    
  }



  public function addJenisList(Request $request)
  {
    $data = [
              'idListNew' => $request->idListNew ,
              'listValue' => $request->addList,
              'addSelected' => $request->addSelect,
              'mandatoryList' => $request->mandatoryList,
            ];
    $dataJson = json_encode($data);
    $client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/newPostTipeJenis",
                            [
                              'form_params' => 
                              [
                                'data' => $dataJson,
                              ]
                            ]
                          );
    $response = $request->getBody()->getContents();

     
    $audit = new AuditTrail;
    $username = Auth::guard('admin')->user()->firstname;
    $audit->fullname = $username;
    $audit->menu = "Persyaratan Penerima Pendanaan";
    $audit->description = "Tambah daftar jenis pendanaan";
    $audit->ip_address =  \Request::ip();
    $audit->save();

    // dd($response);/
    if($response == 'Succcess')
    {
    return redirect()->back()->with('success','Telah menambah jenis Pendanaan');
    }
    else
    {
      return redirect()->back()->with('error','Ada yang error nih.');      
    }

  }


  // Jenis Pendanaan Prosess End



	public function postScorringBorrower(Request $request)
	{
    
		$id = $request->id;
		
		$idPendanaan = $request->idPendanaan;
		$scorePersonal = $request->scorePersonal;
		$scorePendanaan =  $request->scorePendanaan;
		
		$client = new Client();
		$request = $client->post(config('app.apilink')."/borrower-admin/server-side/postTotalScoring",
								[
								  'form_params' => 
								  [
									'idBorrower' => $id,
									'idPendanaan' => $idPendanaan,
									'scorePersonal' => $scorePersonal,
									'scorePendanaan' => $scorePendanaan
								  ]
								]
							  );
		$response = $request->getBody()->getContents();
		$return = json_decode($response);
		
		
		if($return->status == 'Success'){
			$getBorrower = LoginBorrower::where('brw_id', $id)->first();
			$generateVA_proyek = new RekeningController();
			$va = $generateVA_proyek->generateVABNI_Borrower($getBorrower->username, $return->proyek_id);
			
			$data = ['data' => 'ok'];
		}else{
			$data = ['data' => 'no'];
		}

		$audit = new AuditTrail;
		$username = Auth::guard('admin')->user()->firstname;
		$audit->fullname = $username;
		$audit->menu = "skor Penerima Pendanaan";
		$audit->description = "Menyetujui Pendanaan";
		$audit->ip_address =  \Request::ip();
		$audit->save();

		return response($data);
	}



  public function rejectScorringBorrower(Request $request)
  {
		$client = new Client();
    $request = $client->post(config('app.apilink')."/borrower-admin/server-side/rejectScorringBorrower",
                            [
                              'form_params' => 
                              [
                                'idBorrower' => $request->id,
                                'idPendanaan' => $request->idPendanaan,
                              ]
                            ]
                          );
    $response = $request->getBody()->getContents();

    // dd($response);

    $audit = new AuditTrail;
    $username = Auth::guard('admin')->user()->firstname;
    $audit->fullname = $username;
    $audit->menu = "skor Penerima Pendanaan";
    $audit->description = "Menolak Pendanaan";
    $audit->ip_address =  \Request::ip();
    $audit->save();

    if($response == 'Success')
    {
      $data = ['data' => 'ok'];
      return response($data);
    }
    else
    {
      $data = ['data' => 'no'];
      return response($data);
    }
    
  }

}
