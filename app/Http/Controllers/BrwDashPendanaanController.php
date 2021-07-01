<?php

namespace App\Http\Controllers;

use App\Borrower;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\brwCheck;
use App\Http\Middleware\Check;
use App\Http\Middleware\StatusPendanaan;
use App\PendanaanAktif;
use Illuminate\Http\Request;
use Lang;
use Auth;
use GuzzleHttp\Client;
use App\LogAkadDigiSignBorrower;
use App\BorrowerRekening;
use App\BorrowerPendanaan;
use App\Proyek;
use App\TeksNotifikasi;
use App\CheckUserSign;
use App\LogSP3Borrower;


class BrwDashPendanaanController extends Controller
{	
	public function __construct(){
		
		
		$getPendanaan = BorrowerPendanaan::where('id_proyek', '!=', 0)->get();
		if($getPendanaan){
			foreach($getPendanaan as $Pendanaans){
				$getStatus = Proyek::where('id', $Pendanaans->id_proyek)->first();
				if(empty($getStatus)){
					$status =0;
				}else{
					$status = $getStatus->status;
				}
				//cek
				if($status == 2 && $Pendanaans->status == 1 || $status == 3 && $Pendanaans->status == 1){
					//echo $Pendanaans->id_proyek;die;
					//echo $status;die;
					BorrowerPendanaan::where('id_proyek', $Pendanaans->id_proyek)->update(['status' => 6]);
					//BorrowerPendanaan::where('id_proyek', $Pendanaans->id_proyek)->update(['status' => $status]);
					//return $update;
					//$this->updatePendanaan($Pendanaans->pendanaan_id,6);
					
				}
				
				
			}
		}
		
		
		
		
		$this->middleware('auth:borrower');
		$this->middleware(CheckUserSessionBorrower::class)->only(['dashboard']);
		// $this->middleware(brwCheck::class);
        // $this->middleware(UserCheck::class)->except(['lengkapi_profile','view_status_reject']);
		
		// $this->middleware(StatusPendanaan::class)->only(['dashboard','detilProyek','pendanaanPage','getProyekbyId']);

    }
	
    public function dashBoard(Request $request){
    	$client = new client();

		// $id = Session::get('brw_id');
		$id = Auth::guard('borrower')->user()->brw_id;
		
    	//total keseluruhan
    	$response_brwByid = $client->request('GET', config('app.apilink')."/borrower/brwByid/".$id);
    	$body_BrwByid = json_decode($response_brwByid->getBody()->getContents());
    	
    	//pendanaan berjalan
    	$response_brwBerjalanByid = $client->request('GET', config('app.apilink')."/borrower/brwBerjalanById/".$id);
    	$body_BrwBerjalanByid = json_decode($response_brwBerjalanByid->getBody()->getContents());

    	//pengajuan
    	$response_pengajuan = $client->request('GET', config('app.apilink')."/borrower/brwPengajuanById/".$id);
    	$body_pengajuan = json_decode($response_pengajuan->getBody()->getContents());

    	//finish
    	$response_selesai = $client->request('GET', config('app.apilink')."/borrower/brwSelesaiById/".$id);
    	$body_selesai = json_decode($response_selesai->getBody()->getContents());

    	//detailtotalkeseluruhan
    	$response_listPro = $client->request('GET', config('app.apilink')."/borrower/listPro/".$id);
    	$body_listPro = json_decode($response_listPro->getBody()->getContents());

    	//plafon
    	$response_plafon = $client->request('GET', config('app.apilink')."/borrower/plaf/".$id);
    	$body_plafon = json_decode($response_plafon->getBody()->getContents());
		
		//danaditerima
    	$response_danaDiterima = $client->request('GET', config('app.apilink')."/borrower/danatbProyekTerkumpul/".$id);
    	$body_danaDiterima = json_decode($response_danaDiterima->getBody()->getContents());
		
		//totalImbalHasil
		$response_totalImbalHasil = $client->request('GET', config('app.apilink')."/borrower/totalImbalHasil/".$id);
		$body_danaTerkumpul = json_decode($response_totalImbalHasil->getBody()->getContents());
		
		
    	// var_dump($selesai);
    	$totalKeseluruhan = count($body_BrwByid);
    	$totalBerjalan = count($body_BrwBerjalanByid);
    	$totalPengajuan = count($body_pengajuan);
		$totalselesai = count($body_selesai);
		$danaDiterima = "Rp. ".number_format($body_danaDiterima->danaDiterima);
		$dataPersen = round($body_danaDiterima->dataPersen,1);
		$danaImbalHasil = "Rp. ".number_format($body_danaTerkumpul->danaImbalHasil);
		$dataPersenImbalHasil = round($body_danaTerkumpul->dataPersenImbalHasil,1);

		//plafon
		if(empty($body_plafon)){
			$plafonseluruh = $body_plafon->total_plafon;
			$plafonterpakai = $body_plafon->total_terpakai;
    		$plafontersedia = $body_plafon->total_sisa;
		}else{
			$plafonseluruh = "";
			$plafonterpakai = "";
			$plafontersedia = "";
		}
    	
    	

		$hasil = ['totalKeseluruhan' => $totalKeseluruhan,'totalBerjalan' => $totalBerjalan ,'totalPengajuan' => $totalPengajuan, 'totalselesai'=>$totalselesai, 'detailKeseluruhan' => $body_listPro, 
					'plafonseluruh' => $plafonseluruh, 'plafonterpakai' => $plafonterpakai, 'plafontersedia' => $plafontersedia,
					'danaditerima' => $danaDiterima,'dataPersen'=>$dataPersen,
					'danaImbalHasil' => $danaImbalHasil,'dataPersenImbalHasil'=>$dataPersenImbalHasil
				 ];

			return view('pages.borrower.dashboard')->with($hasil);   
    }

    public function detilProyek(Request $request){
    	$client = new client();
    	$id =  $request->id;

    	//detail proyek
    	$response_pykid = $client->request('GET', config('app.apilink')."/borrower/pykid/".$id);
    	$body_pykid = json_decode($response_pykid->getBody()->getContents());

    	//gambar proyek
    	$response_pykGambar = $client->request('GET', config('app.apilink')."/borrower/pykGambar/".$id);
    	$body_pykGambar = json_decode($response_pykGambar->getBody()->getContents());

    	//deskripsi proyek
    	$response_pykdesk = $client->request('GET', config('app.apilink')."/borrower/pykDesk/".$id);
		$body_pykdesk = json_decode($response_pykdesk->getBody()->getContents());
		
		//danaTerkumpul
		$response_danaTerkumpul = $client->request('GET', config('app.apilink')."/borrower/danaTerkumpul/".$id);
		$body_danaTerkumpul = json_decode($response_danaTerkumpul->getBody()->getContents());
		
		$brwId = Auth::guard('borrower')->user()->brw_id;
		
    	if(!empty($body_pykid->nama)){
    		$namaproyek = $body_pykid->nama;
    		$danadibutuhkan = $body_pykid->total_need;
    		$durasiproyek = $body_pykid->tenor_waktu;
			$modepembayaran = $body_pykid->mode_pembayaran;
			$metodepembayaran = $body_pykid->metode_pembayaran;
			$danadicairkan = $body_pykid->dana_dicairkan;
    		$hargapaket = $body_pykid->harga_paket;
			$pendanaanakad = $body_pykid->pendanaan_akad;
			$imbalhasil = $body_pykid->profit_margin." %";
			if($body_pykdesk != NULL){
				$deskripsi = preg_replace("/&nbsp;/",'',strip_tags($body_pykdesk));
			}else{
				$deskripsi = "-";
			}
    		
    		// progress bar
    		// $idProyek = $body_pykid->id;
    		$statusproyek = $body_pykid->status;
    		$statusTampil = $body_pykid->status_tampil;
			$status_pendanaan = $body_pykid->status_pendanaan;
			$status_dana = $body_pykid->status_dana;

			$getLogSP3 = LogSP3Borrower::where('id_proyek',$id)->first();
			$statusLogSP3 = !empty($getLogSP3) ? $getLogSP3->status : 0; 

			$pengajuan = "";
			$verifikasi = '';
					$penggalangandana = '';
					$ttd = '';
			        $proyekberjalan = '';
			        $proyekselesai = '';
			        $tc_pengajuan = '';
			        $icon_pengajuan = '';
			        $tc_verifikasi = '';
			        $icon_verifikasi = '';
			        $tc_penggalangandana = '';
					$icon_penggalangandana = '';
					$tc_ttd = '';
					$icon_ttd =  '';
			        $tc_proyekberjalan = '';
			        $icon_proyekberjalan = '';
			        $tc_proyekselesai = '';
			        $icon_proyekselesai = '';
			
			
    		switch (true) {
			    case ($statusproyek == "0"):
			    //pengajuan
			        $pengajuan = 'active';
			        $verifikasi = 'disabled';
					$penggalangandana = 'disabled';
					$ttd = 'disabled';
			        $proyekberjalan = 'disabled';
			        $proyekselesai = 'disabled';
			        $tc_pengajuan = 'text-primary';
			        $icon_pengajuan = 'fa-hourglass-half text-primary';
			        $tc_verifikasi = 'text-dark';
			        $icon_verifikasi = 'fa-times-circle text-secondary';
			        $tc_penggalangandana = 'text-dark';
					$icon_penggalangandana = 'fa-times-circle text-secondary';
					$tc_ttd = 'text-dark';
					$icon_ttd =  'fa-times-circle text-secondary';
			        $tc_proyekberjalan = 'text-dark';
			        $icon_proyekberjalan = 'disabled';
			        $tc_proyekselesai = 'text-dark';
			        $icon_proyekselesai = 'fa-times-circle text-secondary';
			        break;
			    case (($statusproyek == "1" && $statusTampil == null) || ($statusproyek == "1" && $statusTampil == "1") || ($statusproyek == "1" && $statusTampil == "2" && $statusLogSP3 == '0') || ($statusproyek == "1" && $statusTampil == "2" && $statusLogSP3 == '1')):
			    //verifikasi
			        $pengajuan = 'complete';
			        $verifikasi = 'active';
					$penggalangandana = 'disabled';
					$ttd = 'disabled';
			        $proyekberjalan = 'disabled';
			        $proyekselesai = 'disabled';
			        $tc_pengajuan = 'text-primary';
			        $icon_pengajuan = 'fa-hourglass-half text-primary';
			        $tc_verifikasi = 'text-primary';
			        $icon_verifikasi = 'fa-hourglass-half text-primary';
			        $tc_penggalangandana = 'text-dark';
					$icon_penggalangandana = 'fa-times-circle text-secondary';
					$tc_ttd = 'text-dark';
					$icon_ttd = 'fa-times-circle text-secondary';
			        $tc_proyekberjalan = 'text-dark';
			        $icon_proyekberjalan = 'fa-times-circle text-secondary';
			        $tc_proyekselesai = 'text-dark';
			        $icon_proyekselesai = 'fa-times-circle text-secondary';
			        break;
			    case (($statusproyek == "1" && $statusTampil == "2" && $statusLogSP3 == '2') || ($statusproyek == "2" && $statusTampil == "1" && $statusLogSP3 == '2') || ($statusproyek == "3" && $statusTampil == "1" && $statusLogSP3 == '2') || ($status_pendanaan == "6" && $statusTampil == "1" && $statusLogSP3 == '2')):
			    //penggalangandana
			        $pengajuan = 'complete';
			        $verifikasi = 'complete';
					$penggalangandana = 'active';
					$ttd = 'disabled';
			        $proyekberjalan = 'disabled';
			        $proyekselesai = 'disabled';
			        $tc_pengajuan = 'text-primary';
			        $icon_pengajuan = 'fa-check-circle text-primary';
			        $tc_verifikasi = 'text-primary';
			        $icon_verifikasi = 'fa-check-circle text-primary';
			        $tc_penggalangandana = 'text-primary';
					$icon_penggalangandana = 'fa-hourglass-half text-primary';
					$tc_ttd = 'text-dark';
					$icon_ttd = 'fa-times-circle text-secondary';
			        $tc_proyekberjalan = 'text-dark';
			        $icon_proyekberjalan = 'fa-times-circle text-secondary';
			        $tc_proyekselesai = 'text-dark';
			        $icon_proyekselesai = 'fa-times-circle text-secondary';
			        break;
					
			    //case (($statusproyek == "2" && $statusTampil == "2") || ($statusproyek == "3" && $statusTampil == "2") || ($status_pendanaan == "6" && $statusTampil == "2") || ($status_pendanaan == "7" && $statusTampil == "1")):
			    case ($statusproyek == "2" && $status_pendanaan == 6 || $statusproyek == "3" && $status_pendanaan == 6):
			    // ttdProyek
					$pengajuan = 'complete';
			        $verifikasi = 'complete';
					$penggalangandana = 'complete';
					$ttd = 'active';
			        $proyekberjalan = 'disabled';
			        $proyekselesai = 'disabled';
			        $tc_pengajuan = 'text-primary';
			        $icon_pengajuan = 'fa-check-circle text-primary';
			        $tc_verifikasi = 'text-primary';
			        $icon_verifikasi = 'fa-check-circle text-primary';
			        $tc_penggalangandana = 'text-primary';
					$icon_penggalangandana = 'fa-check-circle text-primary';
					$tc_ttd = 'text-primary';
					$icon_ttd = 'fa-check-circle text-primary';
			        $tc_proyekberjalan = 'text-dark';
			        $icon_proyekberjalan = 'fa-times-circle text-secondary';
			        $tc_proyekselesai = 'text-dark';
			        $icon_proyekselesai = 'fa-times-circle text-secondary';
			        break;
			    //case (($status_pendanaan == "7" && $statusTampil == "2") || ($statusproyek == "4" && $statusTampil == "1")):
			    case ($statusproyek == "2" && $status_pendanaan == "7" || $statusproyek == "3" && $status_pendanaan == "7"):
			    //case (($status_pendanaan == "7" && $statusTampil == "2") || ($statusproyek == "2" && $statusTampil == "2") || ($statusproyek == "3" && $statusTampil == "2")):
				// proyek Berjalan
					$pengajuan = 'complete';
					$verifikasi = 'complete';
					$penggalangandana = 'complete';
					$ttd = 'complete';
					$proyekberjalan = 'active';
					$proyekselesai = 'disabled';
					$tc_pengajuan = 'text-primary';
					$icon_pengajuan = 'fa-check-circle text-primary';
					$tc_verifikasi = 'text-primary';
					$icon_verifikasi = 'fa-check-circle text-primary';
					$tc_penggalangandana = 'text-primary';
					$icon_penggalangandana = 'fa-check-circle text-primary';
					$tc_ttd = 'text-primary';
					$icon_ttd = 'fa fa-check-circle text-primary';
					$tc_proyekberjalan = 'text-dark';
					$icon_proyekberjalan = 'fa-hourglass-half text-primary';
					$tc_proyekselesai = 'text-dark';
					$icon_proyekselesai = 'fa-times-circle text-secondary';
					break;
			    //case ($statusproyek == "4" && $statusTampil == "2"):
			case ($statusproyek == "4" && $status_pendanaan == "7"):
			//case (($status_pendanaan == "7" && $statusTampil == "2") || ($statusproyek == "4" && $statusTampil == "2")):
			    // proyekselesai
					$pengajuan = 'complete';
			        $verifikasi = 'complete';
					$penggalangandana = 'complete';
					$ttd = 'complete';
			        $proyekberjalan = 'complete';
			        $proyekselesai = 'complete';
			        $tc_pengajuan = 'text-primary';
			        $icon_pengajuan = 'fa-check-circle text-primary';
			        $tc_verifikasi = 'text-primary';
			        $icon_verifikasi = 'fa-check-circle text-primary';
			        $tc_penggalangandana = 'text-primary';
					$icon_penggalangandana = 'fa-check-circle text-primary';
					$tc_ttd = 'text-primary';
					$icon_ttd = 'fa-check-circle text-primary';
			        $tc_proyekberjalan = 'text-primary';
			        $icon_proyekberjalan = 'fa-check-circle text-primary';
			        $tc_proyekselesai = 'text-primary';
			        $icon_proyekselesai = 'fa-check-circle text-primary';
					break;			
			    default:
			        echo "projek anda di reject !";
			}
		
			// ARL
			// $data_pendana = PendanaanAktif::where('proyek_id',$id)->get();
          	$data_pendana = PendanaanAktif::leftJoin('detil_investor', 'pendanaan_aktif.investor_id', '=', 'detil_investor.investor_id')
          								->leftJoin('log_akad_digisign_borrower','log_akad_digisign_borrower.investor_id','=','pendanaan_aktif.investor_id')
          								->where('pendanaan_aktif.proyek_id', $id)
          								->where(\DB::raw('substr(log_akad_digisign_borrower.document_id, 1, 10)'), '=' , 'kontrakAll')
          								->orderBy('log_akad_digisign_borrower.investor_id','desc')
										->groupBy('pendanaan_aktif.investor_id')
										->get([
          									'pendanaan_aktif.proyek_id',
          									'pendanaan_aktif.investor_id',
          									'detil_investor.nama_investor',
          									'detil_investor.tipe_pengguna',
          									'pendanaan_aktif.total_dana',
          									'log_akad_digisign_borrower.brw_id',
          									'log_akad_digisign_borrower.status as status_log'
          								]);
	
			$hitungpersendana = (($body_pykid->terkumpul+$body_danaTerkumpul->nominal_awal)/$body_pykid->total_need)*100;
			if($hitungpersendana == 100.0){$persendana = "100%";}else{$persendana = round($hitungpersendana,2)."%";}
    		$hasil = ['namaproyek' => $namaproyek, 

			'dataPendana' => $data_pendana,

	    		'gambarProyek' => $body_pykGambar,
	    		'pengajuan' => $pengajuan,
	    		'verifikasi' => $verifikasi,
				'penggalangandana' => $penggalangandana,
				'ttd' => $ttd,
	    		'proyekberjalan' => $proyekberjalan,
	    	    'proyekselesai' => $proyekselesai,
	    	    'tc_pengajuan' =>	$tc_pengajuan,
			    'icon_pengajuan' =>    $icon_pengajuan,
			    'tc_verifikasi' =>    $tc_verifikasi,
			    'icon_verifikasi' =>    $icon_verifikasi,
			    'tc_penggalangandana' =>    $tc_penggalangandana,
				'icon_penggalangandana' =>    $icon_penggalangandana,
				'tc_ttd' =>	$tc_ttd,
				'icon_ttd' =>	$icon_ttd,
			    'tc_proyekberjalan' =>    $tc_proyekberjalan,
			    'icon_proyekberjalan' =>    $icon_proyekberjalan,
			    'tc_proyekselesai' =>    $tc_proyekselesai,
			    'icon_proyekselesai' =>    $icon_proyekselesai,
				'persendana' => $persendana,
				'imbalhasil' => $imbalhasil,
			    'danadibutuhkan' => "Rp. ".number_format($danadibutuhkan,2,",","."),
			    'durasiproyek' => $durasiproyek." Bulan",
				'modepembayaran' => $modepembayaran == 1 ? 'Tiap Bulan':'Akhir Proyek',
				'metodepembayaran' => $metodepembayaran == 1 ? 'Full':'Parsial',
				'danadicairkan' => $danadicairkan,
			    'hargapaket' => "Rp. ".number_format($hargapaket,2,",","."),
			    'pendanaanakad' => $pendanaanakad == 1 ? 'Murabahah':'Mudarabah',
			    'deskripsi' => $deskripsi,
			    'status' => $body_pykid->status_pendanaan
			];

			$dataRegDigiSign = CheckUserSign::where('brw_id', Auth::guard('borrower')->user()->brw_id)->first();
			$cekRegDigiSign = !empty($dataRegDigiSign) ? $dataRegDigiSign->tgl_aktifasi : '';
			
			$dataTeks = '';
			$dataTeks = TeksNotifikasi::where('tipe',1)->first(['teks_notifikasi']);
			if (!empty($dataTeks))
			{
				$teks = $dataTeks->teks_notifikasi;
			}
			else
			{
				$teks = '';
			}
			
			$user = Auth::guard('borrower')->user()->brw_id;
			//$rekening = BorrowerRekening::where('brw_id', $user)->first();
			$dataLogAkad = LogAkadDigiSignBorrower::where('brw_id',$user)
								->where('id_proyek',$id)
								->where(\DB::raw('substr(log_akad_digisign_borrower.document_id, 1, 15)'), '=' , 'borrowerKontrak')
								->orderBy('id_log_akad_borrower','desc')
								->first();

			//$realTotalAset = !empty($rekening) ? number_format($rekening->total_plafon,0,'','') : 0;
			//$logTotalAset = !empty($dataLogAkad) ? $dataLogAkad->total_pendanaan : 0;
			$logStatus = !empty($dataLogAkad) ? $dataLogAkad->status : '';
                        
            if ($logStatus != '')
			{
				if ($logStatus == 'kirim')
				{
					$showKontrak = 'ttd_akhir';
				}
				elseif ($logStatus == 'waiting' || $logStatus == 'complete')
				{
				//	if ($realTotalAset != 0)
				//	{
				//		if ($logTotalAset != 0)
				//		{
				//		if ($realTotalAset != $logTotalAset)
				//		{
				//			$showKontrak = 'ttd_awal';
				//		}
				//		else
				//		{
							$showKontrak = 'unduh';
				//		}
				//	}
				//	else
				//	{
				//		$showKontrak = 'buka';
				//	}
				}
				//else
				//{
				//	$showKontrak = 'tutup';
				//}
			}
			else
			{
				$showKontrak = 'ttd_awal';
			}
		
    		return view('pages.borrower.detail_pendanaan',compact('showKontrak','teks','statusproyek','id','brwId','statusLogSP3','cekRegDigiSign'))->with($hasil); 
    	}else{
   			return redirect()->back();
    	}
    }

    public function pendanaanPage(){
    	$client = new client();

    	$id_user = Auth::guard('borrower')->user()->brw_id;

    	//detailtotalkeseluruhan
    	$response_listPro = $client->request('GET', config('app.apilink')."/borrower/listPro/".$id_user);
    	$body_listPro = json_decode($response_listPro->getBody()->getContents());
		// var_dump($body_listPro);
		// die();
    	// $nama = 'test';
    	$hasil = ['detailKeseluruhan' => $body_listPro];
    	return view('pages.borrower.all_pendanaan')->with($hasil);
    }

    public function getProyekbyId(Request $request){
    	$client = new client();
    	$id = $request->id;

    	//detailtotalkeseluruhan
    	$response_pykid = $client->request('GET', config('app.apilink')."/borrower/pykid/".$id);
		$body_pykid = json_decode($response_pykid->getBody()->getContents());
		
		$response_danaTerkumpul = $client->request('GET', config('app.apilink')."/borrower/danaTerkumpul/".$id);
    	$body_danaTerkumpul = json_decode($response_danaTerkumpul->getBody()->getContents());

    	return response()->json(['data' => $body_pykid, 'danaTerkumpul' => $body_danaTerkumpul]);
	}

	public function getlastproyekapproved (Request $request){
		$client = new client();
    	$id = $request->id;

    	//data
    	$response_glpa = $client->request('GET', config('app.apilink')."/borrower/getlastproyekapp/".$id);
		$body_glpa = json_decode($response_glpa->getBody());
		//$body_glpa = json_decode($response_glpa->getBody()->getContents());
		//echo json_encode($body_glpa);die;
		
		$idpyk = $body_glpa->id_proyek;
		//var_dump($body_glpa);die();

		$response_danaTerkumpul = $client->request('GET', config('app.apilink')."/borrower/danaTerkumpul/".$idpyk);
    	$body_danaTerkumpul = json_decode($response_danaTerkumpul->getBody()->getContents());
		
		return response()->json(['data' => $body_glpa, 'danaTerkumpul' => $body_danaTerkumpul]);
	}
	
	public function add_pendanaan() {
        return view('pages.borrower.add_pendanaan');
    }
	
	public function lengkapi_profile() {
        return view('pages.borrower.lengkapi_profile');
    }
	
	public function view_status_pending() {
        return view('pages.borrower.view_pending_brw');
    }
	
	public function view_status_reject() {
        return view('pages.borrower.view_reject_brw');
    }

    public function otpCode(Request $req){
    	$client = new client();
        $to = $req->hp;

        $request = $client->post(config('app.apilink')."/borrower/proses_otp",[
				'form_params' =>
				[
					"brw_id"		=> Auth::guard('borrower')->user()->brw_id,
					"hp"			=> $to,
					
			  	]
			]);

		$response = json_decode($request->getBody()->getContents());
	
		// dd($response);
		echo $request->getBody();
        
    }

    public function cekOTP(Request $req)
    {
        $client = new client();
        $otp = $req->otp;

        $request = $client->post(config('app.apilink')."/borrower/cek_otp",[
				'form_params' =>
				[
					"brw_id"		=> Auth::guard('borrower')->user()->brw_id,
					"otp"			=> $otp,
					
			  	]
			]);

		$response = json_decode($request->getBody()->getContents());
	
		//dd($response);
		echo $request->getBody();
    }

    public function updateSP3(Request $req)
    {
        $client = new client();
        $proyek_id = $req->proyek_id;

        $request = $client->post(config('app.apilink')."/borrower/updateSP3",[
				'form_params' =>
				[
					"brw_id"		=> Auth::guard('borrower')->user()->brw_id,
					"proyek_id"		=> $proyek_id,
					
			  	]
			]);

		$response = json_decode($request->getBody()->getContents());
	
		// print_r($request->getBody()->getContents());die;
		return response()->json(['jsonFile' => $response]);
    }
	
	public function listInvoice($brw_id, $proyek_id){
		$client = new client();
		$list_invoice = $client->request('GET', config('app.apilink')."/borrower/list_invoice/".$brw_id)."/".$proyek_id;
		$body_list_invoice = json_decode($list_invoice->getBody());
		
		// $response = json_decode($request->getBody()->getContents());
	
		// print_r($request->getBody()->getContents());die;
		return response()->json(['data' => $response]);
	}
}