<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;
use App\Jobs\ProcessEmail;
use App\Http\Middleware\UserCheck;
use App\Investor;
use App\Proyek;
use App\ManagePenghargaan;
use App\ManageKhazanah;
use App\News;
use GuzzleHttp\Client;
use Auth;
use App\BorrowerDetails;
use App\BorrowerAhliWaris;
use App\BorrowerRekening;
use App\BorrowerPengurus;

class BorrowerDashboardController extends Controller
{
    /*
	public function welcome() {
        return view('pages.borrower.welcome');
    } 
    public function dashboard() {
        return view('pages.borrower.dashboard');
    }
    public function all_pendanaan() {
        return view('pages.borrower.all_pendanaan');
    }
    public function detail_pendanaan() {
        return view('pages.borrower.detail_pendanaan');
    }
    public function add_pendanaan() {
        return view('pages.borrower.add_pendanaan');
    }
    public function all_riwayat_mutasi() {
        return view('pages.borrower.all_riwayat_mutasi');
    }
    public function edit_profile() {
        return view('pages.borrower.edit_profile');
    }
    public function notifikasi() {
        return view('pages.borrower.notifikasi');
    }
    public function log() {
        return view('pages.borrower.log');
    }
    public function faq() {
        return view('pages.borrower.faq');
    }
    public function lock() {
        return view('pages.borrower.lockscreen');
    }
	*/
	
	public function __construct(){
        //$this->middleware('auth:borrower');
        // $this->middleware(UserCheck::class)->except(['lengkapi_profile']);  
        //$this->middleware(UserCheck::class)->only(['lengkapi_profile']);
		
    }
    
	
	/************** Halaman Berhasil Registrasi **************/
    public function welcome() {
        return view('pages.borrower.welcome');
    }
	
	/************** Halaman Lengkapi Data **************/
    public function lengkapi_profile() {
        return view('pages.borrower.lengkapi_profile');
    }
	
	
	/************** Halaman Dashboard **************/
    public function dashboard() {
        return view('pages.borrower.dashboard');
    }
	
	
	/************** Halaman Tambah Pendanaan **************/
    public function add_pendanaan() {
        return view('pages.borrower.add_pendanaan');
    }
	
	
	/************** Halaman Ubah Profile **************/
    public function edit_profile() {
        $id = Auth::guard('borrower')->user()->brw_id;
        $client = new client();
        
        $response_getProfileBrw = $client->request('GET', config('app.apilink')."/borrower/getProfileBrw/".$id);
        $body_getProfileBrw = json_decode($response_getProfileBrw->getBody()->getContents());

        return view('pages.borrower.edit_profile',[
            'id' => $id,
            "brw_id"=> 1,
            "nama"=> $body_getProfileBrw->data->nama,
            "nm_bdn_hukum"=> $body_getProfileBrw->data->nm_bdn_hukum,
            "jabatan"=> $body_getProfileBrw->data->jabatan,
            "brw_type"=> $body_getProfileBrw->data->brw_type,
            "nm_ibu"=> $body_getProfileBrw->data->nm_ibu,
            "ktp"=> $body_getProfileBrw->data->ktp,
            "npwp"=> $body_getProfileBrw->data->npwp,
            "tgl_lahir" => $body_getProfileBrw->data->tgl_lahir,
            "no_tlp"=> $body_getProfileBrw->data->no_tlp,
            "jns_kelamin"=> $body_getProfileBrw->data->jns_kelamin,
            "status_kawin"=> $body_getProfileBrw->data->status_kawin,
            "status_rumah"=> $body_getProfileBrw->data->status_rumah,
            "alamat"=> $body_getProfileBrw->data->alamat,
            "domisili_alamat"=> $body_getProfileBrw->data->domisili_alamat,
            "domisili_provinsi"=> $body_getProfileBrw->data->domisili_provinsi,
            "domisili_kota"=> $body_getProfileBrw->data->domisili_kota,
            "domisili_kecamatan"=> $body_getProfileBrw->data->domisili_kecamatan,
            "domisili_kelurahan"=> $body_getProfileBrw->data->domisili_kelurahan,
            "domisili_kd_pos"=> $body_getProfileBrw->data->domisili_kd_pos,
            "provinsi"=> $body_getProfileBrw->data->provinsi,
            "kota"=> $body_getProfileBrw->data->kota,
            "kecamatan"=> $body_getProfileBrw->data->kecamatan,
            "kelurahan"=> $body_getProfileBrw->data->kelurahan,
            "kode_pos"=> $body_getProfileBrw->data->kode_pos,
            "agama"=> $body_getProfileBrw->data->agama,
            "tempat_lahir"=> $body_getProfileBrw->data->tempat_lahir,
            "pendidikan_terakhir"=> $body_getProfileBrw->data->pendidikan_terakhir,
            "pekerjaan"=> $body_getProfileBrw->data->pekerjaan,
            "bidang_perusahaan"=> $body_getProfileBrw->data->bidang_perusahaan,
            "bidang_pekerjaan"=> $body_getProfileBrw->data->bidang_pekerjaan,
            "bidang_online"=> $body_getProfileBrw->data->bidang_online,
            "pengalaman_pekerjaan"=> $body_getProfileBrw->data->pengalaman_pekerjaan,
            "pendapatan"=> $body_getProfileBrw->data->pendapatan,
            "total_aset"=> $body_getProfileBrw->data->total_aset,
            "kewarganegaraan"=> $body_getProfileBrw->data->kewarganegaraan,
            "brw_online"=> $body_getProfileBrw->data->brw_online,
            "brw_pic"=> $body_getProfileBrw->data->brw_pic,
            "brw_pic_ktp"=> $body_getProfileBrw->data->brw_pic_ktp,
            "brw_pic_user_ktp"=> $body_getProfileBrw->data->brw_pic_user_ktp,
            "brw_pic_npwp"=> $body_getProfileBrw->data->brw_pic_npwp,

            //ahliwaris
            "nama_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->nama_ahli_waris,
            "nik_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->nik,
            "no_tlp_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->no_tlp,
            "email_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->email,
            "provinsi_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->provinsi,
            "kota_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->kota,
            "kecamatan_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->kecamatan,
            "kelurahan_ahli_waris" => $body_getProfileBrw->data_ahliwaris=== null ? null : $body_getProfileBrw->data_ahliwaris->kelurahan,
            "kd_pos_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->kd_pos,
            "alamat_ahli_waris" => $body_getProfileBrw->data_ahliwaris === null ? null : $body_getProfileBrw->data_ahliwaris->alamat,

            //informasi rekening
            "brw_norek" => $body_getProfileBrw->data_rekening === null ? null : $body_getProfileBrw->data_rekening->brw_norek,
            "brw_nm_pemilik" => $body_getProfileBrw->data_rekening === null ? null : $body_getProfileBrw->data_rekening->brw_nm_pemilik,
            "brw_kd_bank" => $body_getProfileBrw->data_rekening === null ? null : $body_getProfileBrw->data_rekening->brw_kd_bank,

            //pengurus
            'nm_pengurus' => $body_getProfileBrw->data_pengurus === null ? null : $body_getProfileBrw->data_pengurus->nm_pengurus,
            'nik_pengurus' => $body_getProfileBrw->data_pengurus === null ? null : $body_getProfileBrw->data_pengurus->nik_pengurus,
            'no_tlppengurus' => $body_getProfileBrw->data_pengurus === null ? null : $body_getProfileBrw->data_pengurus->no_tlp,
            'jabatanpengurus' => $body_getProfileBrw->data_pengurus === null ? null : $body_getProfileBrw->data_pengurus->jabatan,
        ]);
    }

    public function change_password(){
        return view('pages.borrower.change_password');
    }

    public function cek_password(Request $request){
        $aidi = base64_encode($request->id."*dsi*".$request->matchvalue);
    
        $client = new client();
        //cek_password
        $response_cekpassword = $client->request('GET', config('app.apilink')."/borrower/cek_password/".$aidi);
        $body_cekpassword = json_decode($response_cekpassword->getBody()->getContents());
        
        return response()->json(['status' => $body_cekpassword->status]);
    }
	
	public function ubah_password(Request $request){
        $client = new client();
        $req = $client->post(config('app.apilink')."/borrower/resetPasswordProses",[
            'form_params' =>
                [
                    "aidi"			    => $request->id,
                    "password"			=> $request->newpwd,
                ]
            ]);
        $response = json_decode($req ->getBody()->getContents());
        return response()->json(['status' => $response->status]);
    }

    public function proses_updateprofile(Request $brw_users){
		// dd($brw_users);
		if($brw_users->type_borrower == 2){
            // proses badan hukum
				$Borrower = BorrowerDetails::where('brw_id',$brw_users->brw_id)->first();  
                $Borrower->nama = $brw_users->nama_pendaftar;
                $Borrower->nm_bdn_hukum = $brw_users->nm_bdn_hukum; 
                $Borrower->jabatan = $brw_users->jabatanPendaftar; 
                $Borrower->brw_type = $brw_users->type_borrower;
                $Borrower->ktp = $brw_users->nikPendaftar;
                $Borrower->npwp = $brw_users->npwp_bdn_hukum;
                $Borrower->no_tlp = $brw_users->hpPendaftar; 

                $Borrower->alamat = $brw_users->alamat_bdn_hukum;
                $Borrower->provinsi = $brw_users->provinsi_bdn_hukum;
                $Borrower->kota = $brw_users->kota_bdn_hukum;
                $Borrower->kecamatan = $brw_users->kecamatan_bdn_hukum;
                $Borrower->kelurahan = $brw_users->kelurahan_bdn_hukum;
                $Borrower->kode_pos = $brw_users->kodepos_bdn_hukum;

                $Borrower->bidang_perusahaan = $brw_users->bidang_pekerjaan_bdn_hukum;
                $Borrower->bidang_online = $brw_users->bidang_online_bdn_hukum;
                $Borrower->pendapatan = $brw_users->pendapatan_bdn_hukum; 
                $Borrower->total_aset = $brw_users->total_aset; 

                $Borrower->brw_pic = $brw_users->url_pic_brw; 
                $Borrower->brw_pic_ktp = $brw_users->url_pic_brw_ktp; 
                $Borrower->brw_pic_user_ktp = $brw_users->url_pic_brw_dengan_ktp; 
                $Borrower->brw_pic_npwp = $brw_users->url_pic_brw_npwp; 

                //echo"<pre>";print_r($Borrower);echo"</pre>";die();
                
                $Borrower->update();

                // insert data pengurus
                $ahliWaris = BorrowerPengurus::where('brw_id',$brw_users->brw_id)->first();  
                $ahliWaris->nm_pengurus = $brw_users->namapengurus; 
                $ahliWaris->nik_pengurus = $brw_users->nikpengurus; 
                $ahliWaris->no_tlp = $brw_users->teleponpengurus; 
                $ahliWaris->jabatan = $brw_users->jabatanpengurus;
                $ahliWaris->update();
                 
                // insert data Rekening
                $ahliWaris =  BorrowerRekening::where('brw_id',$brw_users->brw_id)->first();  
                $ahliWaris->brw_norek = $brw_users->norekening_bdnhkm; 
                $ahliWaris->brw_nm_pemilik = $brw_users->namapemilikrekening_bdnhkm; 
                $ahliWaris->brw_kd_bank = $brw_users->bank_bdnhkm; 
                $ahliWaris->update();
				
				echo "sukses";
        }else{
			// proses individu
			$Borrower = BorrowerDetails::where('brw_id',$brw_users->brw_id)->first();

            $Borrower->nama = $brw_users->nama;
            $Borrower->nm_ibu = $brw_users->ibukandung;
            $Borrower->ktp = $brw_users->ktp;
            $Borrower->npwp = $brw_users->npwp;
            $Borrower->tgl_lahir = $brw_users->tgl_lahir_hari.'-'.$brw_users->tgl_lahir_bulan.'-'.$brw_users->tgl_lahir_tahun;
            //$Borrower->tgl_lahir = $brw_users->tgl_lahir_tahun.'-'.$brw_users->tgl_lahir_bulan.'-'.$brw_users->tgl_lahir_hari;
            $Borrower->no_tlp = $brw_users->no_tlp; 
            $Borrower->jns_kelamin = $brw_users->jns_kelamin;
            $Borrower->status_kawin = $brw_users->status_kawin;
            $Borrower->alamat = $brw_users->alamat;
            $Borrower->tempat_lahir = $brw_users->tempat_lahir;

            $Borrower->provinsi = $brw_users->provinsi;
            $Borrower->kota = $brw_users->kota;
            $Borrower->kecamatan = $brw_users->kecamatan; 
            $Borrower->kelurahan = $brw_users->kelurahan;
            $Borrower->kode_pos = $brw_users->kode_pos;
            $Borrower->status_rumah = $brw_users->status_rumah;

            $Borrower->agama = $brw_users->agama;
            $Borrower->pendidikan_terakhir = $brw_users->pendidikan_terakhir; 
            $Borrower->pekerjaan = $brw_users->pekerjaan;
            $Borrower->bidang_pekerjaan = $brw_users->bidang_pekerjaan;
            $Borrower->bidang_online = $brw_users->bidang_online;
            $Borrower->pengalaman_pekerjaan = $brw_users->pengalaman_kerja; 
            $Borrower->pendapatan = $brw_users->pendapatan_bulanan; 

            $Borrower->domisili_kota = $brw_users->domisili_kota; 
            $Borrower->domisili_provinsi = $brw_users->domisili_provinsi; 
            $Borrower->domisili_kecamatan = $brw_users->domisili_kecamatan; 
            $Borrower->domisili_kelurahan = $brw_users->domisili_kelurahan; 
            $Borrower->domisili_kd_pos = $brw_users->domisili_kd_pos; 
            $Borrower->domisili_alamat = $brw_users->domisili_alamat; 

            $Borrower->brw_pic = $brw_users->url_pic_brw; 
            $Borrower->brw_pic_ktp = $brw_users->url_pic_brw_ktp; 
            $Borrower->brw_pic_user_ktp = $brw_users->url_pic_brw_dengan_ktp; 
            $Borrower->brw_pic_npwp = $brw_users->url_pic_brw_npwp; 
            
            //echo"<pre>";print_r($Borrower);echo"</pre>";die();
            
            $Borrower->update();

            // insert data Ahli Waris
			$BorrowerAW = BorrowerAhliWaris::where('brw_id',$brw_users->brw_id)->first();
            $BorrowerAW->nama_ahli_waris = $brw_users->namaahliwaris; 
            $BorrowerAW->nik = $brw_users->nikahliwaris; 
            $BorrowerAW->no_tlp = $brw_users->nohpahliwaris; 
            $BorrowerAW->email = $brw_users->emailahliwaris;
            $BorrowerAW->alamat = $brw_users->alamatahliwaris;  
            $BorrowerAW->provinsi = $brw_users->provinsiahliwaris;
            $BorrowerAW->kota = $brw_users->kotaahliwaris;
            $BorrowerAW->kecamatan = $brw_users->kecamatanahliwaris;
            $BorrowerAW->kelurahan = $brw_users->kelurahanahliwaris;
            $BorrowerAW->kd_pos = $brw_users->kodeposahliwaris;
            $BorrowerAW->update(); 
            
            //insert data REkening
            $BorrowerRek = BorrowerRekening::where('brw_id',$brw_users->brw_id)->first();  
            $BorrowerRek->brw_norek = $brw_users->norekening; 
            $BorrowerRek->brw_nm_pemilik = $brw_users->namapemilikrekening; 
            $BorrowerRek->brw_kd_bank = $brw_users->bank; 
            $BorrowerRek->update();
			
			echo "sukses";
			
        }
        // else{
			
			
		// }
		
	}

}

