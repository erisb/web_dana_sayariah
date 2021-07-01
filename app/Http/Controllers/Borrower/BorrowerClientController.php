<?php
namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Borrower;
use App\Proyek;
use App\MasterProvinsi;
use Illuminate\Support\Facades\Auth;
use DB;
//use App\Http\Middleware\UserCheck;

class BorrowerClientController extends Controller
{
    /*public function __construct(){
        $this->middleware(UserCheck::class)->except(['lengkapi_profile']);
    }
	*/
	
	// /public function __construct()
    // {
    //     $this->middleware('auth:api', ['except'=>['DataProvinsi', 'DataKota', 'DataPekerjaan', 'DataBidangPekerjaan', 'DataPengalamanPekerjaan', 'DataPendapatan','DataPendidikan', 'CheckNIK', 'CheckNIKBH', 'TipePendanaan', 'PersyaratanPendanaan']]);
    // }
	public function action_lengkapi_profile(Request $request){
		$type_borrower = $request->type_borrower;
		
		if($type_borrower == 1){
			$client = new Client();
			$tgl_lahir = $request->txt_hari_pribadi.'-'.$request->txt_bulan_pribadi.'-'.$request->txt_tahun_pribadi;
			//$tgl_lahir = $request->txt_tahun_pribadi.'-'.$request->txt_bulan_pribadi.'-'.$request->txt_hari_pribadi;
			
			$request = $client->post(config('app.apilink')."/borrower/proses_lengkapi_profile",[
				'form_params' =>
				[
					"brw_id"			=> Auth::guard('borrower')->user()->brw_id,
					"type_borrower"			=> $request->type_borrower,
					"txt_nm_pengguna_pribadi" =>  $request->txt_nm_pengguna_pribadi,
					"txt_nm_ibu_pribadi" =>  $request->txt_nm_ibu_pribadi,
					"txt_pendidikanT_pribadi" =>  $request->txt_pendidikanT_pribadi,
					"txt_no_ktp_pribadi" =>  $request->txt_no_ktp_pribadi,
					"txt_npwp_pribadi" =>  $request->txt_npwp_pribadi,
					"txt_notlp_pribadi" =>  $request->txt_notlp_pribadi,
					"txt_tmpt_lahir_pribadi" =>  $request->txt_tmpt_lahir_pribadi,
					"txt_tgl_lahir" =>  $tgl_lahir,
					"txt_jns_kelamin" =>  $request->txt_jns_kelamin,
					"txt_alamat_aw_pribadi" =>  $request->txt_alamat_aw_pribadi,
					"txt_agama" =>  $request->txt_agama,
					"txt_sts_nikah_pribadi" =>  $request->txt_sts_nikah_pribadi,
					// aw
					"txt_nm_aw_pribadi" =>  $request->txt_nm_aw_pribadi,
					"txt_nik_aw_pribadi" =>  $request->txt_nik_aw_pribadi,
					"txt_notlp_aw_pribadi" =>  $request->txt_notlp_aw_pribadi,
					"txt_email_aw_pribadi" =>  $request->txt_email_aw_pribadi,
					"txt_provinsi_aw_pribadi" =>  $request->txt_provinsi_aw_pribadi,
					"txt_kota_aw_pribadi" =>  $request->txt_kota_aw_pribadi,
					"txt_kecamatan_aw_pribadi" =>  $request->txt_kecamatan_aw_pribadi,
					"txt_kelurahan_aw_pribadi" =>  $request->txt_kelurahan_aw_pribadi,
					"txt_kode_pos_aw_pribadi" =>  $request->txt_kode_pos_aw_pribadi,
					
					"txt_provinsi_pribadi" =>  $request->txt_provinsi_pribadi,
					"txt_kota_pribadi" =>  $request->txt_kota_pribadi,
					"txt_kd_pos_pribadi" =>  $request->txt_kd_pos_pribadi,
					"txt_alamat_pribadi" =>  $request->txt_alamat_pribadi,
					"txt_kecamatan_pribadi" =>  $request->txt_kecamatan_pribadi,
					"txt_kelurahan_pribadi" => $request->txt_kelurahan_pribadi,
					
					//domisili
					"txt_alamat_domisili_pribadi" =>  $request->txt_alamat_domisili_pribadi,
					"txt_provinsi_domisili_pribadi" =>  $request->txt_provinsi_domisili_pribadi,
					"txt_kota_domisili_pribadi" =>  $request->txt_kota_domisili_pribadi,
					"txt_kecamatan_domisili_pribadi" =>  $request->txt_kecamatan_domisili_pribadi,
					"txt_kelurahan_domisili_pribadi" =>  $request->txt_kelurahan_domisili_pribadi,
					"txt_kd_pos_domisili_pribadi" =>  $request->txt_kd_pos_domisili_pribadi,
					
					"txt_sts_rmh_pribadi" =>  $request->txt_sts_rmh_pribadi,
					"txt_pekerjaan_pribadi" =>  $request->txt_pekerjaan_pribadi,
					"txt_bd_pekerjaan_pribadi" =>  $request->txt_bd_pekerjaan_pribadi,
					"txt_bd_pekerjaanO_pribadi" =>  $request->txt_bd_pekerjaanO_pribadi,
					"txt_pengalaman_kerja_pribadi" =>  $request->txt_pengalaman_kerja_pribadi,
					"txt_pendapatan_bulanan_pribadi" =>  $request->txt_pendapatan_bulanan_pribadi,
					
					// foto
					"url_pic_brw" =>  $request->url_pic_brw,
					"url_pic_brw_ktp" =>  $request->url_pic_brw_ktp,
					"url_pic_brw_dengan_ktp" =>  $request->url_pic_brw_dengan_ktp,
					"url_pic_brw_npwp" =>  $request->url_pic_brw_npwp,
					// bank
					"txt_nm_pemilik" =>  $request->txt_nm_pemilik,
					"txt_no_rekening" =>  $request->txt_no_rekening,
					"txt_bank" =>  $request->txt_bank,
					// pendanaan
					"txt_nm_pendanaan" =>  $request->txt_nm_pendanaan,
					"txt_jenis_akad_pendanaan" =>  $request->txt_jenis_akad_pendanaan,
					"txt_dana_pendanaan" =>  $request->txt_dana_pendanaan,
					"txt_estimasi_proyek" =>  $request->txt_estimasi_proyek,
					"txt_durasi_pendanaan" =>  $request->txt_durasi_pendanaan,
					"txt_pembayaran_pendanaan" =>  $request->txt_pembayaran_pendanaan,
					"txt_metode_pembayaran_pendanaan" => $request->txt_metode_pembayaran_pendanaan,
					"txt_detail_pendanaan" =>  $request->txt_detail_pendanaan,
					"type_pendanaan_select" =>  $request->type_pendanaan_select,
					// jenis jaminan	
					"jaminan" => $request->jaminan, 
					// persyaratan
					"persyaratan_arr"=>$request->persyaratan_arr,
					"persyaratan_non_arr"=>$request->persyaratan_non_arr
					
					
			  ]
			]);

			$response = json_decode($request->getBody()->getContents());
		
			//dd($response);
			echo $request->getBody();
		}
		
		if($type_borrower == 2){
			
			$client = new Client();
			$request = $client->post(config('app.apilink')."/borrower/proses_lengkapi_profile",[
				'form_params' =>
				[
					"brw_id"			=> Auth::guard('borrower')->user()->brw_id,
					"type_borrower"			=> $request->type_borrower,
					"txt_nm_bdn_hukum" =>  $request->txt_nm_bdn_hukum,
					"txt_npwp_bdn_hukum" =>  $request->txt_npwp_bdn_hukum,
					"txt_nm_anda_bdn_hukum" =>  $request->txt_nm_anda_bdn_hukum,
					"txt_nik_anda_bdn_hukum" =>  $request->txt_nik_anda_bdn_hukum,
					"txt_notlp_anda_bdn_hukum" =>  $request->txt_notlp_anda_bdn_hukum,
					"txt_alamat_bdn_hukum" =>  $request->txt_alamat_bdn_hukum,
					"txt_jabatan_anda_bdn_hukum" =>  $request->txt_jabatan_anda_bdn_hukum,
					"txt_nm_pengurus_bdn_hukum" =>  $request->txt_nm_pengurus_bdn_hukum,
					"txt_nik_pengurus_bdn_hukum" =>  $request->txt_nik_pengurus_bdn_hukum,
					"txt_notlp_pengurus_bdn_hukum" =>  $request->txt_notlp_pengurus_bdn_hukum,
					"txt_jabatan_pengurus_bdn_hukum" =>  $request->txt_jabatan_pengurus_bdn_hukum,
					
					"txt_provinsi_bdn_hukum" =>  $request->txt_provinsi_bdn_hukum,
					"txt_kota_bdn_hukum" =>  $request->txt_kota_bdn_hukum,
					"txt_kecamatan_bdn_hukum" =>  $request->txt_kecamatan_bdn_hukum,
					"txt_kelurahan_bdn_hukum" =>  $request->txt_kelurahan_bdn_hukum,
					"txt_kd_pos_bdn_hukum" =>  $request->txt_kd_pos_bdn_hukum,
					
					"txt_bd_pekerjaan_bdn_hukum" =>  $request->txt_bd_pekerjaan_bdn_hukum,
					"txt_revenueB_bdn_hukum" =>  $request->txt_revenueB_bdn_hukum,
					"txt_bpo_bdn_hukum" =>  $request->txt_bpo_bdn_hukum,
					"txt_asset_bdn_hukum" =>  $request->txt_asset_bdn_hukum,
					
					// foto
					"url_pic_brw_bdn_hukum" =>  $request->url_pic_brw_bdn_hukum,
					"url_pic_brw_ktp_bdn_hukum" =>  $request->url_pic_brw_ktp_bdn_hukum,
					"url_pic_brw_dengan_ktp_bdn_hukum" =>  $request->url_pic_brw_dengan_ktp_bdn_hukum,
					"url_pic_brw_npwp_bdn_hukum" =>  $request->url_pic_brw_npwp_bdn_hukum,
					// bank
					"txt_nm_pemilik_rekening_bdn_hukum" =>  $request->txt_nm_pemilik_rekening_bdn_hukum,
					"txt_no_rekening_bdn_hukum" =>  $request->txt_no_rekening_bdn_hukum,
					"txt_bank_bdn_hukum" =>  $request->txt_bank_bdn_hukum,
					// pendanaan
					"type_pendanaan_select_bdn_hukum" =>  $request->type_pendanaan_select_bdn_hukum,
					"txt_nm_pendanaan" =>  $request->txt_nm_pendanaan,
					"txt_jenis_akad_pendanaan" =>  $request->txt_jenis_akad_pendanaan,
					"txt_dana_pendanaan" =>  $request->txt_dana_pendanaan,
					"txt_estimasi_proyek" =>  $request->txt_estimasi_proyek,
					"txt_durasi_pendanaan" =>  $request->txt_durasi_pendanaan,
					"txt_pembayaran_pendanaan" =>  $request->txt_pembayaran_pendanaan,
					"txt_metode_pembayaran_pendanaan" => $request->txt_metode_pembayaran_pendanaan,
					"txt_detail_pendanaan" =>  $request->txt_detail_pendanaan,
					// jenis jaminan	
					"jaminan" => $request->jaminan, 
					// persyaratan
					"persyaratan_arr"=>$request->persyaratan_arr,
					"persyaratan_non_arr"=>$request->persyaratan_non_arr
					
			  ]
			]);

			$response = json_decode($request->getBody()->getContents());
		
			//dd($response);
			echo $request->getBody();
			
		}
		
		if($type_borrower == 3){
			$client = new Client();
			$tgl_lahir = $request->txt_tahun_pribadi.'-'.$request->txt_bulan_pribadi.'-'.$request->txt_hari_pribadi;
			$request = $client->post(config('app.apilink')."/borrower/proses_lengkapi_profile",[
				'form_params' =>
				[
					"brw_id"			=> Auth::guard('borrower')->user()->brw_id,
					"type_borrower"			=> $request->type_borrower,
					"txt_nm_pengguna_pribadi" =>  $request->txt_nm_pengguna_pribadi,
					"txt_nm_ibu_pribadi" =>  $request->txt_nm_ibu_pribadi,
					"txt_pendidikanT_pribadi" =>  $request->txt_pendidikanT_pribadi,
					"txt_no_ktp_pribadi" =>  $request->txt_no_ktp_pribadi,
					"txt_npwp_pribadi" =>  $request->txt_npwp_pribadi,
					"txt_notlp_pribadi" =>  $request->txt_notlp_pribadi,
					"txt_tmpt_lahir_pribadi" =>  $request->txt_tmpt_lahir_pribadi,
					"txt_tgl_lahir" =>  $tgl_lahir,
					"txt_jns_kelamin" =>  $request->txt_jns_kelamin,
					"txt_alamat_aw_pribadi" =>  $request->txt_alamat_aw_pribadi,
					"txt_agama" =>  $request->txt_agama,
					"txt_sts_nikah_pribadi" =>  $request->txt_sts_nikah_pribadi,
					// aw
					"txt_nm_aw_pribadi" =>  $request->txt_nm_aw_pribadi,
					"txt_nik_aw_pribadi" =>  $request->txt_nik_aw_pribadi,
					"txt_notlp_aw_pribadi" =>  $request->txt_notlp_aw_pribadi,
					"txt_email_aw_pribadi" =>  $request->txt_email_aw_pribadi,
					"txt_provinsi_aw_pribadi" =>  $request->txt_provinsi_aw_pribadi,
					"txt_kota_aw_pribadi" =>  $request->txt_kota_aw_pribadi,
					"txt_kecamatan_aw_pribadi" =>  $request->txt_kecamatan_aw_pribadi,
					"txt_kelurahan_aw_pribadi" =>  $request->txt_kelurahan_aw_pribadi,
					
					"txt_provinsi_pribadi" =>  $request->txt_provinsi_pribadi,
					"txt_kota_pribadi" =>  $request->txt_kota_pribadi,
					"txt_kd_pos_pribadi" =>  $request->txt_kd_pos_pribadi,
					"txt_alamat_pribadi" =>  $request->txt_alamat_pribadi,
					"txt_kecamatan_pribadi" =>  $request->txt_kecamatan_pribadi,
					"txt_kelurahan_pribadi" => $request->txt_kelurahan_pribadi,

					"txt_alamat_domisili_pribadi" =>  $request->txt_alamat_domisili_pribadi,
					"txt_provinsi_domisili_pribadi" =>  $request->txt_provinsi_domisili_pribadi,
					"txt_kota_domisili_pribadi" =>  $request->txt_kota_domisili_pribadi,
					"txt_kecamatan_domisili_pribadi" =>  $request->txt_kecamatan_domisili_pribadi,
					"txt_kelurahan_domisili_pribadi" =>  $request->txt_kelurahan_domisili_pribadi,
					"txt_kd_pos_domisili_pribadi" =>  $request->txt_kd_pos_domisili_pribadi,

					"txt_sts_rmh_pribadi" =>  $request->txt_sts_rmh_pribadi,
					"txt_pekerjaan_pribadi" =>  $request->txt_pekerjaan_pribadi,
					"txt_bd_pekerjaan_pribadi" =>  $request->txt_bd_pekerjaan_pribadi,
					"txt_bd_pekerjaanO_pribadi" =>  $request->txt_bd_pekerjaanO_pribadi,
					"txt_pengalaman_kerja_pribadi" =>  $request->txt_pengalaman_kerja_pribadi,
					"txt_pendapatan_bulanan_pribadi" =>  $request->txt_pendapatan_bulanan_pribadi,
					
					// foto
					"url_pic_brw" =>  $request->url_pic_brw,
					"url_pic_brw_ktp" =>  $request->url_pic_brw_ktp,
					"url_pic_brw_dengan_ktp" =>  $request->url_pic_brw_dengan_ktp,
					"url_pic_brw_npwp" =>  $request->url_pic_brw_npwp,
					// bank
					"txt_nm_pemilik" =>  $request->txt_nm_pemilik,
					"txt_no_rekening" =>  $request->txt_no_rekening,
					"txt_bank" =>  $request->txt_bank,
					// pendanaan
					"txt_nm_pendanaan" =>  $request->txt_nm_pendanaan,
					"txt_jenis_akad_pendanaan" =>  $request->txt_jenis_akad_pendanaan,
					"txt_dana_pendanaan" =>  $request->txt_dana_pendanaan,
					"txt_estimasi_proyek" =>  $request->txt_estimasi_proyek,
					"txt_durasi_pendanaan" =>  $request->txt_durasi_pendanaan,
					"txt_pembayaran_pendanaan" =>  $request->txt_pembayaran_pendanaan,
					"txt_metode_pembayaran_pendanaan" => $request->txt_metode_pembayaran_pendanaan,
					"txt_detail_pendanaan" =>  $request->txt_detail_pendanaan,
					"type_pendanaan_select" =>  $request->type_pendanaan_select,
					// jenis jaminan	
					"jaminan" => $request->jaminan, 
					// persyaratan
					"persyaratan_arr"=>$request->persyaratan_arr,
					"persyaratan_non_arr"=>$request->persyaratan_non_arr
					
					
			  ]
			  //'form_params' => $param
			]);

			$response = json_decode($request->getBody()->getContents());
		
			//dd($response);
			echo $request->getBody();
		}
	}
	
	public function action_pendanaan(Request $request){
		// dd($request->jaminan);
		$type_borrower = $request->type_borrower;
		if($type_borrower == 1){
			
			$client = new Client();
			$request = $client->post(config('app.apilink')."/borrower/proses_pendanaan",[
				'form_params' =>
				[
					"brw_id"			=> Auth::guard('borrower')->user()->brw_id,
					// pendanaan
					"txt_nm_pendanaan" =>  $request->txt_nm_pendanaan,
					"txt_jenis_akad_pendanaan" =>  $request->txt_jenis_akad_pendanaan,
					"txt_dana_pendanaan" =>  $request->txt_dana_pendanaan,
					"txt_estimasi_proyek" =>  $request->txt_estimasi_proyek,
					"txt_durasi_pendanaan" =>  $request->txt_durasi_pendanaan,
					"txt_pembayaran_pendanaan" =>  $request->txt_pembayaran_pendanaan,
					"txt_metode_pembayaran_pendanaan" => $request->txt_metode_pembayaran_pendanaan,
					"txt_detail_pendanaan" =>  $request->txt_detail_pendanaan,
					"type_pendanaan_select" =>  $request->type_pendanaan_select,
					//jaminan
					"jaminan" => $request->jaminan, 
					// persyaratan
					"persyaratan_arr"=>$request->persyaratan_arr,
					
					
					
			  ]
			]);

			$response = json_decode($request->getBody()->getContents());
		
			//dd($response);
			echo $request->getBody();
		}
		
		if($type_borrower == 2){
			
			$client = new Client();
			$request = $client->post(config('app.apilink')."/borrower/proses_pendanaan",[
				'form_params' =>
				[
					"brw_id"			=> Auth::guard('borrower')->user()->brw_id,
					"type_borrower"			=> $request->type_borrower,
					// pendanaan
					"type_pendanaan_select_bdn_hukum" =>  $request->type_pendanaan_select_bdn_hukum,
					"txt_nm_pendanaan" =>  $request->txt_nm_pendanaan,
					"txt_jenis_akad_pendanaan" =>  $request->txt_jenis_akad_pendanaan,
					"txt_dana_pendanaan" =>  $request->txt_dana_pendanaan,
					"txt_estimasi_proyek" =>  $request->txt_estimasi_proyek,
					"txt_durasi_pendanaan" =>  $request->txt_durasi_pendanaan,
					"txt_pembayaran_pendanaan" =>  $request->txt_pembayaran_pendanaan,
					"txt_metode_pembayaran_pendanaan" => $request->txt_metode_pembayaran_pendanaan,
					"txt_detail_pendanaan" =>  $request->txt_detail_pendanaan,
					//jaminan
					"jaminan" => $request->jaminan, 
					// persyaratan
					"persyaratan_arr"=>$request->persyaratan_arr
					
			  ]
			]);

			$response = json_decode($request->getBody()->getContents());
		
			//dd($response);
			echo $request->getBody();
			
		}
		
		if($type_borrower == 3){
			$client = new Client();
			$tgl_lahir = $request->txt_tahun_pribadi.'-'.$request->txt_bulan_pribadi.'-'.$request->txt_hari_pribadi;
			$request = $client->post(config('app.apilink')."/borrower/proses_pendanaan",[
				'form_params' =>
				[
					"brw_id"			=> Auth::guard('borrower')->user()->brw_id,
					"type_borrower"			=> $request->type_borrower,
					// pendanaan
					"txt_nm_pendanaan" =>  $request->txt_nm_pendanaan,
					"txt_jenis_akad_pendanaan" =>  $request->txt_jenis_akad_pendanaan,
					"txt_dana_pendanaan" =>  $request->txt_dana_pendanaan,
					"txt_estimasi_proyek" =>  $request->txt_estimasi_proyek,
					"txt_durasi_pendanaan" =>  $request->txt_durasi_pendanaan,
					"txt_pembayaran_pendanaan" =>  $request->txt_pembayaran_pendanaan,
					"txt_metode_pembayaran_pendanaan" => $request->txt_metode_pembayaran_pendanaan,
					"txt_detail_pendanaan" =>  $request->txt_detail_pendanaan,
					"type_pendanaan_select" =>  $request->type_pendanaan_select,
					"persyaratan_arr"=>$request->persyaratan_arr,
					//jaminan
					"jaminan" => $request->jaminan, 
					
			  ]
			  //'form_params' => $param
			]);

			$response = json_decode($request->getBody()->getContents());
		
			echo $request->getBody();
			//dd($response);
			// dd($request->getBody());
		}
		
		
	 
    }

   
}  
    
