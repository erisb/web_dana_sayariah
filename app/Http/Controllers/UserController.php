<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Investor;
use App\DetilInvestor;
use App\RekeningInvestor;
use App\PendanaanAktif;
use App\Proyek;
use App\Subscribe;
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
use App\Http\Middleware\UserCheck;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Cart;
use Storage;
use App\LogPendanaan;
use App\LogRekening;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessEmail;
use Validator;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;
use App\PenarikanDana;
use App\DetilImbalUser;
use App\ListImbalUser;
use Image;
use App\Log_Imbal_User;
use App\Http\Middleware\StatusProyek;
use GuzzleHttp\Client;
use App\Jobs\InvestorVerif;
use App\BniEnc;
use App\TeksNotifikasi;
use App\ThresholdKontrak;
use App\LogAkadDigiSignInvestor;
use App\Http\Controllers\DigiSignController;
use App\AuditTrail;
use App\TmpSelectedProyek;
use App\CheckUserSign;
use App\LogGenerateVaRdl;
use App\Http\Controllers\RDLController;
use App\Http\Controllers\RekeningController;
use App\Http\Middleware\CheckInvestorSession;

class UserController extends Controller
{
    /**
     * Make request global.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    //development
    // private const CLIENT_ID = '805';
    // private const KEY = '34e64c3fe14335eb64f5c1b2d6e75508';
    // private const API_URL = 'https://apibeta.bni-ecollection.com/';


    //production
    private const CLIENT_ID = '757';
    private const KEY = '9f918ff65dc67027fc5670b7b7a7e89f';
    private const API_URL = 'https://api.bni-ecollection.com/';

    public function __construct(Request $request){
        $this->request = $request;

        $this->middleware('auth')->except(['emailConfirm']);
        $this->middleware(CheckInvestorSession::class)->except(['emailConfirm']);
        $this->middleware(UserCheck::class)->except(['cekRegDigiSign','emailConfirm', 'updateProfileReject', 'upload', 'firstUpdateProfile','get_kota', 'checkPhone','getTableDetil', 'new_registration_upload1', 'new_registration_upload2', 'new_registration_upload3','otpCode','cekOTP']);
        //$this->middleware(UserCheck::class)->except(['emailConfirm', 'updateProfile', 'updateProfileReject', 'upload', 'firstUpdateProfile','get_kota','get_aktif_dana']);

        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');

        $this->middleware(StatusProyek::class);
    }

    public function showDashboard() {
        if (Auth::user())
        {
            $user = Auth::user();
            // $imbal_total = log_payout_user::where('investor_id',$user->id)->sum('imbal_payout');
            // echo $imbal_total;die;

            $pendanaan_aktif = PendanaanAktif::where('pendanaan_aktif.investor_id', $user->id)
                                            ->where('pendanaan_aktif.status', 1)
                                            ->whereNotIn('pendanaan_aktif.proyek_id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$user->id.' group by proyek_id')])
                                            ->whereIn('pendanaan_aktif.proyek_id',[\DB::raw('select id from proyek where proyek_id = pendanaan_aktif.proyek_id and status in (1,2,3) group by proyek_id')])
                                            ->orderBy('pendanaan_aktif.id','desc')->limit(5)
                                            ->get();

            $pendanaan_aktif_past = PendanaanAktif::where('investor_id', $user->id)
                                            ->where('status', 1)
                                            ->whereIn('proyek_id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$user->id.' group by proyek_id')])
                                            ->groupBy('proyek_id')
                                            ->get([
                                                    DB::raw('sum(nominal_awal) as jumlah_pendanaan'),
                                                    'proyek_id',
                                                    'tanggal_invest'
                                            ]);

           

            // $payout = ListImbalUser::where('investor_id',$user->id)->whereRaw('status_payout BETWEEN 0 AND 4')->sum('imbal_payout');
            $payout = Log_Imbal_User::where('investor_id',$user->id)->whereNotIn('keterangan',['Dana Pokok'])->sum('nominal');
            $rekening = RekeningInvestor::where('investor_id', $user->id)->first();
            $penarikan_dana = PenarikanDana::where('investor_id',$user->id)
                                            ->where('accepted',1)
                                            ->sum('jumlah');
            $total_investation_query = PendanaanAktif::selectRaw('pendanaan_aktif.investor_id, pendanaan_aktif.proyek_id, SUM(pendanaan_aktif.total_dana) AS total_dana')
            ->join('proyek', 'proyek.id', '=', 'pendanaan_aktif.proyek_id')
            ->where('pendanaan_aktif.investor_id','=',$user->id)
            ->where('pendanaan_aktif.status', 1)
            // ->whereIn('proyek.status', [1,2,3])
            ->whereNotIn('pendanaan_aktif.proyek_id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$user->id.' group by proyek_id')])
            ->groupBy('pendanaan_aktif.investor_id')
            ->first();

            $dana_teralokasi = !empty($total_investation_query) ? number_format($total_investation_query->total_dana,0,'','') : 0;
        }
        $dataRegDigiSign = CheckUserSign::where('investor_id',Auth::user()->id)->first();
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

        // $dataLogAkad = LogAkadDigiSignInvestor::where('investor_id',Auth::user()->id)
        //                                     ->where(\DB::raw('substr(document_id, 1, 15)'), '=' , 'investorKontrak')
        //                                     ->orderBy('id_log_akad_investor','desc')
        //                                     ->first();

        // $dataLogAkad = LogAkadDigiSignInvestor::where('investor_id',Auth::user()->id)
        //                                    ->orderBy('id_log_akad_investor','desc')
        //                                    ->first();

        $realTotalAset = !empty($rekening) ? number_format($rekening->total_dana,0,'','') : 0;
        // $logTotalAset = !empty($dataLogAkad) ? number_format($dataLogAkad->total_aset,0,'','') : 0;
        // $logStatus = !empty($dataLogAkad) ? $dataLogAkad->status : '';

        // if ($logStatus == 'kirim')
        // {
        //     $showKontrak = 'ttd_akhir';
        // }
        
        // else
        // {
        //     if ($realTotalAset != 0)
        //     {
        //         if ($logTotalAset != 0)
        //         {
        //             if ($realTotalAset != $logTotalAset)
        //             {
        //                 $showKontrak = 'ttd_awal';
        //             }
        //             else
        //             {
        //                 $showKontrak = 'unduh';
        //             }
        //         }
        //         else
        //         {
        //             $showKontrak = 'buka';
        //         }
        //     }
        //     else
        //     {
        //         $showKontrak = 'tutup';
        //     }
        // }

        // if (!empty($realTotalAset))
        // {
        //     if (!empty($logTotalAset))
        //     {
        //         if ($realTotalAset != $logTotalAset)
        //         {
        //             $showKontrak = 'buka';
        //         }
        //         else
        //         {
        //             $showKontrak = 'tutup';
        //         }
        //     }
        //     else
        //     {
        //         $showKontrak = 'buka';
        //     }
            
        // }
        // else
        // {
        //     $showKontrak = 'tutup';
        // }

        if ($realTotalAset != 0)
        {
            $showKontrak = 'buka';
        }
        else
        {
            $showKontrak = 'tutup';
        }

        return view('pages.user.dashboard',compact('rekening','pendanaan_aktif','pendanaan_aktif_past','penarikan_dana','payout','showKontrak','teks','cekRegDigiSign', 'dana_teralokasi'));
    
    }
    
    // request OJK
    
    
    public function cekRegDigiSign($id_user){

        $dataRegDigiSign = CheckUserSign::where('investor_id',$id_user)->first();

        $cekRegDigiSign = !empty($dataRegDigiSign->tgl_aktifasi) ? $dataRegDigiSign->tgl_aktifasi : "belum_aktivasi";
        
        return response()->json(['cekRegDigiSign' => $cekRegDigiSign]);
        
    }
    
    public function get_kota($id_provinsi)
    {
        $kota = MasterProvinsi::where('kode_provinsi',$id_provinsi)
                                ->orderBy('kode_kota','asc')
                                ->get(['kode_kota','nama_kota']);

        return response()->json(['kota' => $kota]);
    }
    
    
    

    public function checkPhone($no_hp)
    {
        if (DetilInvestor::where('phone_investor', $no_hp)->first()) {
            return response()->json(['error'=> 'Nomer Telpon Sudah Pernah Terdaftar']);
        }else{
        return response()->json(['success' => $no_hp]);
        }
    }
    

    public function get_aktif_dana($id){
        // echo $id;die;
        $user = Auth::user();

        $gettglpayout = ListImbalUser::where('pendanaan_id', $id)->orderby('tanggal_payout')->get();
        $jmlpayout = count($gettglpayout);

        // $item = DetilImbalUser::where('pendanaan_id',$id)->first();

        $item = DB::table('detil_imbal_user')
        ->join('pendanaan_aktif', 'detil_imbal_user.pendanaan_id', '=', 'pendanaan_aktif.id')
        ->select('detil_imbal_user.*','pendanaan_aktif.nominal_awal')
        ->where('detil_imbal_user.pendanaan_id', $id)
        ->first();
        // var_dump($item);die();
        $idpro = $item->proyek_id;
        $getpro = Proyek::where('id',$idpro)->first()->tenor_waktu;
        $getuser = DetilImbalUser::where('pendanaan_id', $id)->first();
            $lastpayout = $jmlpayout-1;
            $tgl_pyt = $gettglpayout[$lastpayout]->tanggal_payout;
            $tglplustujuh = date('Y-m-d', strtotime($tgl_pyt. ' + 7 days'));
        // var_dump($getuser);
        // die();
        if($getpro == $jmlpayout){
            $list_imbal = new ListImbalUser;
            $list_imbal->proyek_id = $getuser->proyek_id;
            $list_imbal->pendanaan_id = $getuser->pendanaan_id;
            $list_imbal->investor_id = $getuser->investor_id;
            $list_imbal->tanggal_payout = $tglplustujuh;
            $list_imbal->imbal_payout = $getuser->sisa_imbal;
            $list_imbal->total_dana = $getuser->total_dana;
            $list_imbal->status_payout = 5;
            $list_imbal->status_update = NULL;
            $list_imbal->tgl_update = NULL;
            $list_imbal->keterangan = '';
            $list_imbal->status_libur = NULL;
            $list_imbal->keterangan_libur = '';
            $list_imbal->ket_weekend = '';
            $list_imbal->save();

            $list_imbal1 = new ListImbalUser;
            $list_imbal1->proyek_id = $getuser->proyek_id;
            $list_imbal1->pendanaan_id = $getuser->pendanaan_id;
            $list_imbal1->investor_id = $getuser->investor_id;
            $list_imbal1->tanggal_payout = $tglplustujuh;
            $list_imbal1->imbal_payout = $getuser->total_dana;
            $list_imbal1->total_dana = $getuser->total_dana;
            $list_imbal1->status_payout = 5;
            $list_imbal1->status_update = NULL;
            $list_imbal1->tgl_update = NULL;
            $list_imbal1->keterangan = '';
            $list_imbal1->status_libur = NULL;
            $list_imbal1->keterangan_libur = '';
            $list_imbal1->ket_weekend = '';
            $list_imbal1->save();            
        }
        
        // $datasum = DetilPayoutUser::where('pendanaan_id',);
        $get_data = ListImbalUser::where('list_imbal_user.pendanaan_id',$id)
                                //   ->where('list_imbal_user.status_payout',2)
                                  ->leftJoin('pendanaan_aktif','pendanaan_aktif.id','=','list_imbal_user.pendanaan_id');
                                //   ->groupBy('list_imbal_user.tanggal_payout');
                                //   ->get();
        // var_dump($get_data);die;
        // var_dump($item);die;
        return response()->json(['data' => $get_data->get(), 'item'=>$item, 'prop'=>$get_data->first()]);
    }

    public function getTableDetil()
    {
      $user = Auth::user();
      
      // $getdata = DB::raw("(SELECT nominal, sum(nominal) AS total FROM log_imbal_user GROUP BY proyek_id) as total_proyek");
      // $proyeks = Log_Imbal_User::leftJoin($getdata,'investor_id', '=', $user->id)->get();

      // dd($proyek);die;

      $dataTable = Log_Imbal_User::where('log_imbal_user.investor_id',$user->id)
                                 ->leftJoin('proyek','proyek.id','=','log_imbal_user.proyek_id')
                                 ->leftJoin('pendanaan_aktif','pendanaan_aktif.id','=','log_imbal_user.pendanaan_id')
                                 ->select(DB::raw('SUM(nominal) as total'),'proyek.nama','proyek.tgl_mulai','pendanaan_aktif.tanggal_invest','pendanaan_aktif.total_dana')
                                 ->whereNotIn('log_imbal_user.keterangan',['Dana Pokok'])
                                 ->groupBy('log_imbal_user.pendanaan_id')
                                 ->orderBy('proyek.id','DESC')
                                 ->get();
      $data = Array();
      $i = 1;

      foreach($dataTable as $item)
      {
        $columns['no'] = (string) $i++;
        $columns['namaProyek'] = (string) $item->nama;
        $columns['tglMulai'] = (string) Carbon::parse($item->tgl_mulai)->format('d-m-Y');
        $columns['tglInvest'] = (string) Carbon::parse($item->tanggal_invest)->format('d-m-Y');
        $columns['totalDana'] = (string) 'Rp. '.number_format($item->total_dana);
        $columns['total'] = (string) 'Rp. '.number_format($item->total); 
        
        $data[] = $columns;
      }

      $parsingJson = ['data' => $data];

      echo json_encode($parsingJson);
    }
    public function manageProfile() {
        $user=Auth::user();
        $detil=DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                            ->where('detil_investor.investor_id', $user->id)
                            ->first();
        $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
        $master_agama = MasterAgama::all();
        $master_asset = MasterAsset::all();
        $master_badan_hukum = MasterBadanHukum::all();
        $master_bank = MasterBank::all();
        $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
        $master_jenis_kelamin = MasterJenisKelamin::all();
        $master_jenis_pengguna = MasterJenisPengguna::all();
        $master_kawin = MasterKawin::all();
        $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
        $master_negara = MasterNegara::all();
        $master_online = MasterOnline::all();
        $master_pekerjaan = MasterPekerjaan::all();
        $master_pendapatan = MasterPendapatan::all();
        $master_pendidikan = MasterPendidikan::all();
        $master_pengalaman_kerja = MasterPengalamanKerja::all();

        return view('pages.user.manage_profile')->with([
                                                    'detil' => $detil,
                                                    'master_provinsi' => $master_provinsi,
                                                    'master_agama' => $master_agama,
                                                    'master_asset' => $master_asset,
                                                    'master_badan_hukum' => $master_badan_hukum,
                                                    'master_bank' => $master_bank,
                                                    'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
                                                    'master_jenis_kelamin' => $master_jenis_kelamin,
                                                    'master_jenis_pengguna' => $master_jenis_pengguna,
                                                    'master_kawin' => $master_kawin,
                                                    'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
                                                    'master_negara' => $master_negara,
                                                    'master_online' => $master_online,
                                                    'master_pekerjaan' => $master_pekerjaan,
                                                    'master_pendapatan' => $master_pendapatan,
                                                    'master_pendidikan' => $master_pendidikan,
                                                    'master_pengalaman_kerja' => $master_pengalaman_kerja,
                                                    'master_provinsi' => $master_provinsi,
                                                ]);
    }

    public function firstUpdateProfile(Request $request) {

        $investor_id=Auth::user()->id;

        // $messages = [
        //     'error_upload'    => 'Tipe file gambar harus jpeg,jpg,bmp,png dan ukuran file gambar max 500 KB',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'pic_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     'pic_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     'pic_user_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        // ]);

        // if ($validator->fails()) {
        //     $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
        //     // $master_agama = MasterAgama::all();
        //     // $master_asset = MasterAsset::all();
        //     // $master_badan_hukum = MasterBadanHukum::all();
        //     $master_bank = MasterBank::all();
        //     // $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
        //     $master_jenis_kelamin = MasterJenisKelamin::all();
        //     // $master_jenis_pengguna = MasterJenisPengguna::all();
        //     // $master_kawin = MasterKawin::all();
        //     // $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
        //     // $master_negara = MasterNegara::all();
        //     // $master_online = MasterOnline::all();
        //     // $master_pekerjaan = MasterPekerjaan::all();
        //     // $master_pendapatan = MasterPendapatan::all();
        //     // $master_pendidikan = MasterPendidikan::all();
        //     // $master_pengalaman_kerja = MasterPengalamanKerja::all();
        //     return redirect()
        //                 ->back()
        //                 ->with(['dataverification' => true,
        //                         'master_provinsi' => $master_provinsi,
        //                         // 'master_agama' => $master_agama,
        //                         // 'master_asset' => $master_asset,
        //                         // 'master_badan_hukum' => $master_badan_hukum,
        //                         'master_bank' => $master_bank,
        //                         // 'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
        //                         'master_jenis_kelamin' => $master_jenis_kelamin,
        //                         // 'master_jenis_pengguna' => $master_jenis_pengguna,
        //                         // 'master_kawin' => $master_kawin,
        //                         // 'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
        //                         // 'master_negara' => $master_negara,
        //                         // 'master_online' => $master_online,
        //                         // 'master_pekerjaan' => $master_pekerjaan,
        //                         // 'master_pendapatan' => $master_pendapatan,
        //                         // 'master_pendidikan' => $master_pendidikan,
        //                         // 'master_pengalaman_kerja' => $master_pengalaman_kerja,
        //                 ])
        //                 ->withErrors($messages)
        //                 ->withInput();
        // }
        // else
        // {

            if (DetilInvestor::where('phone_investor', $request->no_telp)->first()) {
                $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
                // $master_agama = MasterAgama::all();
                // $master_asset = MasterAsset::all();
                // $master_badan_hukum = MasterBadanHukum::all();
                $master_bank = MasterBank::all();
                // $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
                $master_jenis_kelamin = MasterJenisKelamin::all();
                // $master_jenis_pengguna = MasterJenisPengguna::all();
                // $master_kawin = MasterKawin::all();
                // $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
                // $master_negara = MasterNegara::all();
                // $master_online = MasterOnline::all();
                // $master_pekerjaan = MasterPekerjaan::all();
                // $master_pendapatan = MasterPendapatan::all();
                // $master_pendidikan = MasterPendidikan::all();
                // $master_pengalaman_kerja = MasterPengalamanKerja::all();
                return redirect()->back()->with([
                                                'error' => 'Nomer Telpon Sudah Pernah Terdaftar',
                                                'master_provinsi' => $master_provinsi,
                                                // 'master_agama' => $master_agama,
                                                // 'master_asset' => $master_asset,
                                                // 'master_badan_hukum' => $master_badan_hukum,
                                                'master_bank' => $master_bank,
                                                // 'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
                                                'master_jenis_kelamin' => $master_jenis_kelamin,
                                                // 'master_jenis_pengguna' => $master_jenis_pengguna,
                                                // 'master_kawin' => $master_kawin,
                                                // 'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
                                                // 'master_negara' => $master_negara,
                                                // 'master_online' => $master_online,
                                                // 'master_pekerjaan' => $master_pekerjaan,
                                                // 'master_pendapatan' => $master_pendapatan,
                                                // 'master_pendidikan' => $master_pendidikan,
                                                // 'master_pengalaman_kerja' => $master_pengalaman_kerja,
                                                'dataverification' => true,
                                            ])
                                        ->withInput();
            }
            if (DetilInvestor::where('investor_id', Auth::user()->id)->first())
            {
                $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
                // $master_agama = MasterAgama::all();
                // $master_asset = MasterAsset::all();
                // $master_badan_hukum = MasterBadanHukum::all();
                $master_bank = MasterBank::all();
                // $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
                $master_jenis_kelamin = MasterJenisKelamin::all();
                // $master_jenis_pengguna = MasterJenisPengguna::all();
                // $master_kawin = MasterKawin::all();
                // $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
                // $master_negara = MasterNegara::all();
                // $master_online = MasterOnline::all();
                // $master_pekerjaan = MasterPekerjaan::all();
                // $master_pendapatan = MasterPendapatan::all();
                // $master_pendidikan = MasterPendidikan::all();
                // $master_pengalaman_kerja = MasterPengalamanKerja::all();
                return redirect()->back()->with([
                                                'error' => 'Data ini sudah terdaftar',
                                                'master_provinsi' => $master_provinsi,
                                                // 'master_agama' => $master_agama,
                                                // 'master_asset' => $master_asset,
                                                // 'master_badan_hukum' => $master_badan_hukum,
                                                'master_bank' => $master_bank,
                                                // 'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
                                                'master_jenis_kelamin' => $master_jenis_kelamin,
                                                // 'master_jenis_pengguna' => $master_jenis_pengguna,
                                                // 'master_kawin' => $master_kawin,
                                                // 'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
                                                // 'master_negara' => $master_negara,
                                                // 'master_online' => $master_online,
                                                // 'master_pekerjaan' => $master_pekerjaan,
                                                // 'master_pendapatan' => $master_pendapatan,
                                                // 'master_pendidikan' => $master_pendidikan,
                                                // 'master_pengalaman_kerja' => $master_pengalaman_kerja,
                                                'dataverification' => true,
                                            ])
                                        ->withInput();
            }
            $detil = new DetilInvestor;

            // if ($request->tipe_pengguna == 1)
            // {
                
                if($request->hasFile('pic_investor')){
                    /*if(Storage::disk('public')->exists('user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension())){
                        $path_user='user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
                    }else{
                        $path_user=null;
                    }*/

                    $path_user='user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
                    $path = $request->file('pic_investor')->storeAs('public/',$path_user);
                }
                elseif($img_user = $_POST['image_foto'])
                {

                    $image_name_user = explode(";base64,", $img_user);
                    $image_decode_user = base64_decode($image_name_user[1]);
                    $fileName_user = uniqid() . '.png';
                    $path_user = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString().'pic_investor.'.'png';
                    //$path_user = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString().'pic_investor.'.$fileName_user; 
                    $path = Storage::disk('public')->put($path_user, $image_decode_user);
                    //file_put_contents("c:/xampp/htdocs/web_dana_syariah/storage/app/public/".$path_user,$image_base64);
                }else{
                    $path_user=null;
                }

                //var_dump($image_name_user);die();

                if($request->hasFile('pic_ktp_investor')){
                    /*if(Storage::disk('public')->exists('user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension())){
                        $path_ktp='user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();
                    }else{
                        $path_ktp=null;
                    }*/

                    $path_ktp='user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();

                    $path = $request->file('pic_ktp_investor')->storeAs('public/',$path_ktp);
                }
                elseif($img_ktp = $_POST['image_ktp'])
                {
                    $image_name_ktp = explode(";base64,", $img_ktp);
                    $image_decode_ktp = base64_decode($image_name_ktp[1]);
                    $fileName_ktp = uniqid() . '.png';
                    $path_ktp = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.'png';
                    //$path_ktp = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$fileName_ktp;
                    $path = Storage::disk('public')->put($path_ktp, $image_decode_ktp);
                    //file_put_contents("c:/xampp/htdocs/web_dana_syariah/storage/app/public/".$path_ktp,$image_base64);
                }
                else{
                    $path_ktp=null;
                }


                if($request->hasFile('pic_user_ktp_investor')){
                    /*if(Storage::disk('public')->exists('user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension())){
                        $path_user_ktp='user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();
                    }else{
                        $path_user_ktp=null;
                    }*/

                    $path_user_ktp='user/'. Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();

                    $path = $request->file('pic_user_ktp_investor')->storeAs('public/',$path_user_ktp);
                }
                elseif($img_user_ktp = $_POST['image_user_ktp'])
                {
                    $image_name_user_ktp = explode(";base64,", $img_user_ktp);
                    $image_decode_user_ktp = base64_decode($image_name_user_ktp[1]);
                    $fileName_user_ktp = uniqid() . '.png';
                    $path_user_ktp = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.'png';
                    //$path_user_ktp = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$fileName_user_ktp;
                    //file_put_contents("c:/xampp/htdocs/web_dana_syariah/storage/app/public/".$path_user_ktp,$image_base64);
                    $path = Storage::disk('public')->put($path_user_ktp, $image_decode_user_ktp);
                }
                else{
                    $path_user_ktp=null;
                }

                $detil->investor_id = Auth::user()->id;
                $detil->tipe_pengguna = null;
                $detil->nama_investor = $request->nama;
                $detil->no_ktp_investor = $request->no_ktp;
                $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
                $detil->phone_investor = $request->no_telp;
                $detil->alamat_investor = $request->alamat;
                $detil->provinsi_investor = $request->provinsi;
                $detil->kota_investor = $request->kota;
                $detil->kecamatan = $request->kecamatan;
                $detil->kelurahan = $request->kelurahan;
                $detil->kode_pos_investor = $request->kode_pos;
                $detil->tempat_lahir_investor = $request->tempat_lahir;
                $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
                $detil->jenis_kelamin_investor = $request->jenis_kelamin;
                $detil->status_kawin_investor = $request->status_kawin;
                $detil->status_rumah_investor = null;
                $detil->agama_investor = null;
                $detil->pekerjaan_investor = $request->pekerjaan;
                $detil->bidang_pekerjaan = null;
                $detil->online_investor = null;
                $detil->pendapatan_investor = $request->pendapatan;
                $detil->asset_investor = null;
                $detil->pengalaman_investor = null;
                $detil->pendidikan_investor = $request->pendidikan;
                $detil->bank_investor = $request->bank;
                $detil->rekening = $request->rekening;
                $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
                $detil->pic_investor = $path_user;
                $detil->pic_ktp_investor = $path_ktp;
                $detil->pic_user_ktp_investor = $path_user_ktp;
                $detil->jenis_badan_hukum = null;
                $detil->nama_perwakilan = null;
                $detil->no_ktp_perwakilan = null;
                $detil->nama_ibu_kandung = $request->nama_ibu_kandung;

                //echo"<pre>";print_r($detil);echo"</pre>";die();

                // if ($request->kawin == 1)
                // {
                //     $detil->pasangan_investor = $request->nama_pasangan;
                //     $detil->pasangan_email = $request->email_pasangan;
                //     $detil->pasangan_tempat_lhr = $request->tempat_lahir_pasangan;
                //     $detil->pasangan_tgl_lhr = $request->tgl_lahir_pasangan.'-'.$request->bln_lahir_pasangan.'-'.$request->thn_lahir_pasangan;
                //     $detil->pasangan_jenis_kelamin = $request->jenis_kelamin_pasangan;
                //     $detil->pasangan_ktp = $request->no_ktp_pasangan;
                //     $detil->pasangan_npwp = $request->no_npwp_pasangan;
                //     $detil->pasangan_phone = $request->no_telp_pasangan;
                //     $detil->pasangan_alamat = $request->alamat_pasangan;
                //     $detil->pasangan_provinsi = $request->provinsi_pasangan;
                //     $detil->pasangan_kota = $request->kota_pasangan;
                //     $detil->pasangan_kode_pos = $request->kode_pos_pasangan;
                //     $detil->pasangan_agama = $request->agama_pasangan;
                //     $detil->pasangan_pekerjaan = $request->pekerjaan_pasangan;
                //     $detil->pasangan_bidang_pekerjaan = $request->bidang_pekerjaan_pasangan;
                //     $detil->pasangan_online = $request->pekerjaan_online_pasangan;
                //     $detil->pasangan_pendapatan = $request->pendapatan_pasangan;
                //     $detil->pasangan_pengalaman = $request->pengalaman_pasangan;
                //     $detil->pasangan_pendidikan = $request->pendidikan_pasangan;
                // }
                // else
                // {
                //     $detil->pasangan_investor = null;
                //     $detil->pasangan_email = null;
                //     $detil->pasangan_tempat_lhr = null;
                //     $detil->pasangan_tgl_lhr = null;
                //     $detil->pasangan_jenis_kelamin = null;
                //     $detil->pasangan_ktp = null;
                //     $detil->pasangan_npwp = null;
                //     $detil->pasangan_phone = null;
                //     $detil->pasangan_alamat = null;
                //     $detil->pasangan_provinsi = null;
                //     $detil->pasangan_kota = null;
                //     $detil->pasangan_kode_pos = null;
                //     $detil->pasangan_agama = null;
                //     $detil->pasangan_pekerjaan = null;
                //     $detil->pasangan_bidang_pekerjaan = null;
                //     $detil->pasangan_online = null;
                //     $detil->pasangan_pendapatan = null;
                //     $detil->pasangan_pengalaman = null;
                //     $detil->pasangan_pendidikan = null;
                // }
                // $detil->bank = $request->bank;
                // $detil->save();
                // $hasil = $this->generateVA($request->username);
            // }
            // else
            // {
            //     $detil->investor_id = Auth::user()->id;
            //     $detil->tipe_pengguna = $request->tipe_pengguna;
            //     $detil->nama_investor = $request->nama;
            //     $detil->no_ktp_investor = null;
            //     $detil->no_npwp_investor = $request->no_npwp;
            //     $detil->phone_investor = $request->no_telp;
            //     $detil->alamat_investor = $request->alamat;
            //     $detil->provinsi_investor = $request->provinsi;
            //     $detil->kota_investor = $request->kota;
            //     $detil->kode_pos_investor = $request->kode_pos;
            //     $detil->tempat_lahir_investor = null;
            //     $detil->tgl_lahir_investor = null;
            //     $detil->jenis_kelamin_investor = null;
            //     $detil->status_kawin_investor = null;
            //     $detil->status_rumah_investor = null;
            //     $detil->agama_investor = null;
            //     $detil->pekerjaan_investor = null;
            //     $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
            //     $detil->online_investor = $request->pekerjaan_online;
            //     $detil->pendapatan_investor = $request->pendapatan;
            //     $detil->asset_investor = $request->asset;
            //     $detil->pengalaman_investor = null;
            //     $detil->pendidikan_investor = null;
            //     $detil->bank_investor = $request->bank;
            //     $detil->rekening = $request->rekening;

            //     $detil->pasangan_investor = null;
            //     $detil->pasangan_email = null;
            //     $detil->pasangan_tempat_lhr = null;
            //     $detil->pasangan_tgl_lhr = null;
            //     $detil->pasangan_jenis_kelamin = null;
            //     $detil->pasangan_ktp = null;
            //     $detil->pasangan_npwp = null;
            //     $detil->pasangan_phone = null;
            //     $detil->pasangan_alamat = null;
            //     $detil->pasangan_provinsi = null;
            //     $detil->pasangan_kota = null;
            //     $detil->pasangan_kode_pos = null;
            //     $detil->pasangan_agama = null;
            //     $detil->pasangan_pekerjaan = null;
            //     $detil->pasangan_bidang_pekerjaan = null;
            //     $detil->pasangan_online = null;
            //     $detil->pasangan_pendapatan = null;
            //     $detil->pasangan_pengalaman = null;
            //     $detil->pasangan_pendidikan = null;
            //     // $detil->job_investor = $request->job_investor;
            //     $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
            //     $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
            //     $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);
            //     $detil->jenis_badan_hukum = $request->jenis_badan_hukum;
            //     $detil->nama_perwakilan = $request->nama_perwakilan;
            //     $detil->no_ktp_perwakilan = $request->no_ktp_perwakilan;

            //     // $detil->save();
            //     // $hasil = $this->generateVA($request->username);
            // }

            $detil->save();

        //$RekeningInvestor = new RekeningInvestor;
        //$RekeningInvestor->investor_id = Auth::user()->id;
        //$RekeningInvestor->va_number = null;
        //$RekeningInvestor->total_dana = null;
        //$RekeningInvestor->unallocated = null;
            //$RekeningInvestor->save();    

            if (Auth::user()->status === 'notfilled') {
                $user = Investor::where('id', Auth::user()->id)->first();
                $user->status = 'active';
                $user->save();
            }

            $rdl_controller      = new RDLController;
            $rekening_controller = new RekeningController;
            $log_generate        = new logGenerateVaRdl;

            $data_investor = Investor::where('id', Auth::user()->id)->first(); 
            // REQUEST OJK
            $hasil = $rekening_controller->generateVA();
            if(!$hasil){
                return redirect()->back()->with([ 'error' => 'Akun anda sudah Aktif tetapi pembuatan VA gagal, harap menghubungi Customer Service kami untuk pembuatan nomor VA agar bisa melakukan Top Up Dana'])->withInput(); 
            }else{
                return redirect('/user/dashboard');              
            }
            //else{
                
               // dispatch(new InvestorVerif($data_investor, 1));
                #pesan verifikasi
                // $kirimverifikasi = $this->verificationCode($investor_id);

                // if($kirimverifikasi===5){
                //     return redirect('/user/dashboard');
                // }else{
                //     return redirect('/user/dashboard');
                // }

                return redirect('/user/dashboard');
            //}
        // }
    }

    //Generate VA for user
    public function generateVA($username){
        $date = \Carbon\Carbon::now()->addYear(4);
        $user = Investor::where('username', $username)->first();
        $data = [
            'type' => 'createbilling',
            'client_id' => self::CLIENT_ID,
            'trx_id' => $user->id,
            'trx_amount' => '0',
            'customer_name' => $user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '8'.self::CLIENT_ID.$user->detilInvestor->getVa(),
            'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            'billing_type' => 'o',
        ];

    
        $encrypted = BniEnc::encrypt($data,self::CLIENT_ID,self::KEY);

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(self::API_URL, [
            'json' => [
                'client_id' => self::CLIENT_ID,
                'data' => $encrypted,
            ]
        ]);

        $result = json_decode($result->getBody()->getContents());
        if($result->status !== '000'){
            return false;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,self::CLIENT_ID,self::KEY);
            //return json_encode($decrypted);
            $user->RekeningInvestor()->create([
                'investor_id' => $user->id,
                'total_dana' => 0,
                'va_number' => $decrypted['virtual_account'],
                'unallocated' => 0,
            ]);
            
            return true;
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }
    
    //Generate VA for user REQUEST OJK
    public function generateVA_new($username,$proyek_id ,$amount){
        
        $now = Carbon::now();
        $now->addHours(24); // set 24 jam
        $datenow = date("Y-m-d H:i:s");
        
        $user = Investor::where('username', $username)->first();
        $data = [
            'type' => 'createbilling',
            'client_id' => self::CLIENT_ID,
            'trx_id' => $datenow,
            //'trx_id' => $user->id,
            'trx_amount' => $amount,
            'customer_name' => $user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '8'.self::CLIENT_ID.$user->detilInvestor->getVa(),
            'datetime_expired' => $now->format('Y-m-d').'T'.$now->format('H:i:sP'),
            'billing_type' => 'c',
        ];
        
        $encrypted = BniEnc::encrypt($data,self::CLIENT_ID,self::KEY);

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(self::API_URL, [
            'json' => [
                'client_id' => self::CLIENT_ID,
                'data' => $encrypted,
            ]
        ]);

           $result = json_decode($result->getBody()->getContents());
           
           syslog(0, 'respon = '.$result->getBody()->getContents());

        if($result->status !== '000'){
            return False;
        }
        else{
            $updateVa = TmpSelectedProyek::where('investor_id', $user->id)
                ->where('proyek_id', $user->id)->update(['no_va' => $decrypted['virtual_account']]);
            //$decrypted = BniEnc::decrypt($result->data,self::CLIENT_ID,self::KEY);
            //return json_encode($decrypted);
            // $user->RekeningInvestor()->create([
                // 'investor_id' => $user->id,
                // 'total_dana' => 0,
                // 'va_number' => $decrypted['virtual_account'],
                // 'unallocated' => 0,
            // ]);
            
            return response()->json(['status'=>"sukses",'no_va'=>$decrypted['virtual_account']]);
            
            //return true;
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }

    public function verificationCode($investor_id){
        
        $rekening = RekeningInvestor::join('detil_investor', 'detil_investor.investor_id', '=', 'rekening_investor.investor_id')->join('investor', 'investor.id','=','rekening_investor.investor_id')
                    ->select('rekening_investor.va_number', 'detil_investor.nama_investor', 'detil_investor.phone_investor', 'investor.username')
                    ->where('rekening_investor.investor_id', $investor_id)->first();
        $to =  $rekening->phone_investor;
        //$to = "0895363168426";
        $text =  'Terima kasih, akun '.$rekening->username.' telah berhasil diverifikasi dengan nomor Virtual Account: '.$rekening->va_number.' atas nama '.$rekening->nama_investor.' . Silahkan lakukan Top Up dana Anda ke nomor virtual account tersebut.';
        // die();
        $pecah              = explode(",",$to);
        $jumlah             = count($pecah);
        $from               = "DANASYARIAH"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
        $username           = "danasyariahpremium"; //your smsviro username
        $password           = "Dsi701@2019"; //your smsviro password
        $postUrl            = "http://107.20.199.106/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS
        
        for($i=0; $i<$jumlah; $i++){
            if(substr($pecah[$i],0,2) == "62" || substr($pecah[$i],0,3) == "+62"){
                $pecah = $pecah;
            }elseif(substr($pecah[$i],0,1) == "0"){
                $pecah[$i][0] = "X";
                $pecah = str_replace("X", "62", $pecah);
            }else{
                echo "Invalid mobile number format";
            }
            $destination = array("to" => $pecah[$i]);
            $message     = array("from" => $from,
                                 "destinations" => $destination,
                                 "text" => $text,
                                 "smsCount" => 20);
            $postData           = array("messages" => array($message));
            $postDataJson       = json_encode($postData);
            $ch                 = curl_init();
            $header             = array("Content-Type:application/json", "Accept:application/json");
            
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // $responseBody = json_decode($response);
            $responseBody = json_decode($response, true);
            curl_close($ch);
        }   

        $group_id = $responseBody['messages'][0]['status']['groupId'];

        if($response){
            // return response()->json(['success'=>$text]);
            return $group_id;
        }else{
            // return response()->json(['success'=>'gagal']);
            return $group_id;
        }
    }

    public function otpCode(Request $req){
        $to = $req->hp;
        $otp = rand(100000, 999999);
        $text =  'Kode OTP : '.$otp.' Silahkan masukan kode ini untuk melanjutkan proses melengkapi data anda.';

        //send to db
        $Investor = Investor::where('id', Auth::user()->id)->update(['otp' => $otp]);

        $pecah              = explode(",",$to);
        $jumlah             = count($pecah);
        // $from               = "SMSVIRO"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
        // $username           = "smsvirodemo";
        // $password           = "qwerty@123";
        $from               = "DANASYARIAH";
        $username           = "danasyariahpremium"; //your smsviro username
        $password           = "Dsi701@2019"; //your smsviro password
        $postUrl            = "http://107.20.199.106/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS
        
        for($i=0; $i<$jumlah; $i++){
            if(substr($pecah[$i],0,2) == "62" || substr($pecah[$i],0,3) == "+62"){
                $pecah = $pecah;
            }elseif(substr($pecah[$i],0,1) == "0"){
                $pecah[$i][0] = "X";
                $pecah = str_replace("X", "62", $pecah);
            }else{
                echo "Invalid mobile number format";
            }
            $destination = array("to" => $pecah[$i]);
            $message     = array("from" => $from,
                                 "destinations" => $destination,
                                 "text" => $text,
                                 "smsCount" => 20);
            $postData           = array("messages" => array($message));
            $postDataJson       = json_encode($postData);
            $ch                 = curl_init();
            $header             = array("Content-Type:application/json", "Accept:application/json");
            
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseBody = json_decode($response);
            curl_close($ch);
        }   

        if($Investor){
            $data = ['status' => true, 'message' => 'Silahkan masukan kode ini untuk melanjutkan proses melengkapi data anda.'];
            return response()->json($data);
        }else{
          $data = ['status' => false, 'message' => 'Data Telepon tidak benar.'];
          return response()->json($data);
        }
    }

    public function cekOTP(Request $req)
    {
        $otp = $req->otp;
        $dataOTP = Investor::where('id',Auth::user()->id)->first();
        $otpDB = $dataOTP->otp;
        if ($otp == $otpDB)
        {
            $data = ['status' => '00', 'message' => 'OTP match'];
            return response()->json($data);
        }
        else
        {
            $data = ['status' => '01', 'message' => 'OTP not match'];
            return response()->json($data);
        }
    }

    public function updateProfileReject(Request $request) {

        // $messages = [
        //     'error_upload'    => 'Tipe file gambar harus jpeg,jpg,bmp,png dan ukuran file gambar max 500 KB',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'pic_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     'pic_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     'pic_user_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        // ]);

        // if ($validator->fails()) {
        //     $user = Auth::user();
        //     $detil=DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
        //                         ->where('detil_investor.investor_id', $user->id)
        //                         ->first();
        //     $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
        //     // $master_agama = MasterAgama::all();
        //     // $master_asset = MasterAsset::all();
        //     // $master_badan_hukum = MasterBadanHukum::all();
        //     $master_bank = MasterBank::all();
        //     // $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
        //     $master_jenis_kelamin = MasterJenisKelamin::all();
        //     // $master_jenis_pengguna = MasterJenisPengguna::all();
        //     // $master_kawin = MasterKawin::all();
        //     // $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
        //     // $master_negara = MasterNegara::all();
        //     // $master_online = MasterOnline::all();
        //     // $master_pekerjaan = MasterPekerjaan::all();
        //     // $master_pendapatan = MasterPendapatan::all();
        //     // $master_pendidikan = MasterPendidikan::all();
        //     // $master_pengalaman_kerja = MasterPengalamanKerja::all();
        //     return redirect()
        //                 ->back()
        //                 ->with(['datareject' => true,
        //                         'detil' => $detil,
        //                         'master_provinsi' => $master_provinsi,
        //                         // 'master_agama' => $master_agama,
        //                         // 'master_asset' => $master_asset,
        //                         // 'master_badan_hukum' => $master_badan_hukum,
        //                         'master_bank' => $master_bank,
        //                         // 'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
        //                         'master_jenis_kelamin' => $master_jenis_kelamin,
        //                         // 'master_jenis_pengguna' => $master_jenis_pengguna,
        //                         // 'master_kawin' => $master_kawin,
        //                         // 'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
        //                         // 'master_negara' => $master_negara,
        //                         // 'master_online' => $master_online,
        //                         // 'master_pekerjaan' => $master_pekerjaan,
        //                         // 'master_pendapatan' => $master_pendapatan,
        //                         // 'master_pendidikan' => $master_pendidikan,
        //                         // 'master_pengalaman_kerja' => $master_pengalaman_kerja,
        //                 ])
        //                 ->withErrors($messages);
        //                 // ->withInput();
        // }
        // else
        // {

            $detil = DetilInvestor::where('investor_id', Auth::user()->id)->first();

            // if ($request->tipe_pengguna == 1)
            // {
                $detil->investor_id = Auth::user()->id;
                $detil->tipe_pengguna = null;
                $detil->nama_investor = $request->nama;
                $detil->no_ktp_investor = $request->no_ktp;
                $detil->no_npwp_investor = $request->no_npwp;
                $detil->phone_investor = $request->no_telp;
                $detil->alamat_investor = $request->alamat;
                $detil->provinsi_investor = $request->provinsi;
                $detil->kota_investor = $request->kota;
                $detil->kode_pos_investor = $request->kode_pos;
                $detil->tempat_lahir_investor = $request->tempat_lahir;
                $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
                $detil->jenis_kelamin_investor = $request->jenis_kelamin;
                $detil->status_kawin_investor = null;
                $detil->status_rumah_investor = null;
                $detil->agama_investor = null;
                $detil->pekerjaan_investor = null;
                $detil->bidang_pekerjaan = null;
                $detil->online_investor = null;
                $detil->pendapatan_investor = null;
                $detil->asset_investor = null;
                $detil->pengalaman_investor = null;
                $detil->pendidikan_investor = null;
                $detil->bank_investor = $request->bank;
                $detil->rekening = $request->rekening;
                $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
                // $detil->job_investor = $request->job_investor;
                // $detil->pic_investor = $this->upload('foto_diri', $request, Auth::user()->id);
                // $detil->pic_ktp_investor = $this->upload('foto_ktp', $request, Auth::user()->id);
                // $detil->pic_user_ktp_investor = $this->upload('foto_diri_ktp', $request, Auth::user()->id);
                if ($request->hasFile('pic_investor')) {
                    Storage::disk('public')->delete($detil->pic_investor);
                    $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
                }

                if ($request->hasFile('pic_ktp_investor')) {
                    Storage::disk('public')->delete($detil->pic_ktp_investor);
                    $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
                }

                if ($request->hasFile('pic_user_ktp_investor')) {
                    Storage::disk('public')->delete($detil->pic_user_ktp_investor);
                    $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);
                }

                $detil->jenis_badan_hukum = null;
                $detil->nama_perwakilan = null;
                $detil->no_ktp_perwakilan = null;

                // if ($request->kawin == 1)
                // {
                //     $detil->pasangan_investor = $request->nama_pasangan;
                //     $detil->pasangan_email = $request->email_pasangan;
                //     $detil->pasangan_tempat_lhr = $request->tempat_lahir_pasangan;
                //     $detil->pasangan_tgl_lhr = $request->tgl_lahir_pasangan.'-'.$request->bln_lahir_pasangan.'-'.$request->thn_lahir_pasangan;
                //     $detil->pasangan_jenis_kelamin = $request->jenis_kelamin_pasangan;
                //     $detil->pasangan_ktp = $request->no_ktp_pasangan;
                //     $detil->pasangan_npwp = $request->no_npwp_pasangan;
                //     $detil->pasangan_phone = $request->no_telp_pasangan;
                //     $detil->pasangan_alamat = $request->alamat_pasangan;
                //     $detil->pasangan_provinsi = $request->provinsi_pasangan;
                //     $detil->pasangan_kota = $request->kota_pasangan;
                //     $detil->pasangan_kode_pos = $request->kode_pos_pasangan;
                //     $detil->pasangan_agama = $request->agama_pasangan;
                //     $detil->pasangan_pekerjaan = $request->pekerjaan_pasangan;
                //     $detil->pasangan_bidang_pekerjaan = $request->bidang_pekerjaan_pasangan;
                //     $detil->pasangan_online = $request->pekerjaan_online_pasangan;
                //     $detil->pasangan_pendapatan = $request->pendapatan_pasangan;
                //     $detil->pasangan_pengalaman = $request->pengalaman_pasangan;
                //     $detil->pasangan_pendidikan = $request->pendidikan_pasangan;
                // }
                // else
                // {
                //     $detil->pasangan_investor = null;
                //     $detil->pasangan_email = null;
                //     $detil->pasangan_tempat_lhr = null;
                //     $detil->pasangan_tgl_lhr = null;
                //     $detil->pasangan_jenis_kelamin = null;
                //     $detil->pasangan_ktp = null;
                //     $detil->pasangan_npwp = null;
                //     $detil->pasangan_phone = null;
                //     $detil->pasangan_alamat = null;
                //     $detil->pasangan_provinsi = null;
                //     $detil->pasangan_kota = null;
                //     $detil->pasangan_kode_pos = null;
                //     $detil->pasangan_agama = null;
                //     $detil->pasangan_pekerjaan = null;
                //     $detil->pasangan_bidang_pekerjaan = null;
                //     $detil->pasangan_online = null;
                //     $detil->pasangan_pendapatan = null;
                //     $detil->pasangan_pengalaman = null;
                //     $detil->pasangan_pendidikan = null;
                // }
                // $detil->bank = $request->bank;
                // $detil->save();
                // $hasil = $this->generateVA($request->username);
            // }
            // else
            // {
            //     $detil->investor_id = Auth::user()->id;
            //     $detil->tipe_pengguna = $request->tipe_pengguna;
            //     $detil->nama_investor = $request->nama;
            //     $detil->no_ktp_investor = null;
            //     $detil->no_npwp_investor = $request->no_npwp;
            //     $detil->phone_investor = $request->no_telp;
            //     $detil->alamat_investor = $request->alamat;
            //     $detil->provinsi_investor = $request->provinsi;
            //     $detil->kota_investor = $request->kota;
            //     $detil->kode_pos_investor = $request->kode_pos;
            //     $detil->tempat_lahir_investor = null;
            //     $detil->tgl_lahir_investor = null;
            //     $detil->jenis_kelamin_investor = null;
            //     $detil->status_kawin_investor = null;
            //     $detil->status_rumah_investor = null;
            //     $detil->agama_investor = null;
            //     $detil->pekerjaan_investor = null;
            //     $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
            //     $detil->online_investor = $request->pekerjaan_online;
            //     $detil->pendapatan_investor = $request->pendapatan;
            //     $detil->asset_investor = $request->asset;
            //     $detil->pengalaman_investor = null;
            //     $detil->pendidikan_investor = null;
            //     $detil->bank_investor = $request->bank;
            //     $detil->rekening = $request->rekening;

            //     $detil->pasangan_investor = null;
            //     $detil->pasangan_email = null;
            //     $detil->pasangan_tempat_lhr = null;
            //     $detil->pasangan_tgl_lhr = null;
            //     $detil->pasangan_jenis_kelamin = null;
            //     $detil->pasangan_ktp = null;
            //     $detil->pasangan_npwp = null;
            //     $detil->pasangan_phone = null;
            //     $detil->pasangan_alamat = null;
            //     $detil->pasangan_provinsi = null;
            //     $detil->pasangan_kota = null;
            //     $detil->pasangan_kode_pos = null;
            //     $detil->pasangan_agama = null;
            //     $detil->pasangan_pekerjaan = null;
            //     $detil->pasangan_bidang_pekerjaan = null;
            //     $detil->pasangan_online = null;
            //     $detil->pasangan_pendapatan = null;
            //     $detil->pasangan_pengalaman = null;
            //     $detil->pasangan_pendidikan = null;
            //     // $detil->job_investor = $request->job_investor;
            //     // $detil->pic_investor = $this->upload('foto_diri', $request, Auth::user()->id);
            //     // $detil->pic_ktp_investor = $this->upload('foto_ktp', $request, Auth::user()->id);
            //     // $detil->pic_user_ktp_investor = $this->upload('foto_diri_ktp', $request, Auth::user()->id);
            //     if ($request->hasFile('pic_investor')) {
            //         Storage::disk('public')->delete($detil->pic_investor);
            //         $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
            //     }

            //     if ($request->hasFile('pic_ktp_investor')) {
            //         Storage::disk('public')->delete($detil->pic_ktp_investor);
            //         $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
            //     }

            //     if ($request->hasFile('pic_user_ktp_investor')) {
            //         Storage::disk('public')->delete($detil->pic_user_ktp_investor);
            //         $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);
            //     }
            //     $detil->jenis_badan_hukum = $request->jenis_badan_hukum;
            //     $detil->nama_perwakilan = $request->nama_perwakilan;
            //     $detil->no_ktp_perwakilan = $request->no_ktp_perwakilan;

            //     // $detil->save();
            //     // $hasil = $this->generateVA($request->username);
            // }

            $detil->save();

            $investor = Investor::where('id', Auth::user()->id)->first();
            // echo $investor;die;
            $investor->status = 'pending';
            $investor->save();
            // return redirect()->back()->with('success', "Profile berhasil diupdate");
            return redirect('/user/dashboard');
        // }
    }
    
    public function updateProfile(Request $request) {
        // $messages = [
        //     'error_upload'    => 'Tipe file gambar harus jpeg,jpg,bmp,png dan ukuran file gambar max 500 KB',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'pic_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     // 'pic_ktp_investor' => 'mimes:jpeg,bmp,png|size:10000',
        //     // 'pic_user_ktp_investor' => 'mimes:jpeg,bmp,png|size:10000',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //                 ->back()
        //                 ->withErrors($messages);
        //                 // ->withInput();
        // }
        // else
        // {
            
            if ($request->password)
            {
                $investor = Investor::where('id',Auth::user()->id)->first();

                $investor->password = bcrypt($request->password);

                $investor->save();
            }

            $detil = DetilInvestor::where('investor_id', Auth::user()->id)->first();
            // if ($request->tipe_pengguna == 1)
            // {
                $detil->investor_id = Auth::user()->id;
                $detil->tipe_pengguna = null;
                $detil->nama_investor = $request->nama;
                $detil->no_ktp_investor = $request->no_ktp;
                $detil->no_npwp_investor = $request->no_npwp;
                //$detil->phone_investor = $request->no_telp;
                $detil->alamat_investor = $request->alamat;
                $detil->provinsi_investor = $request->provinsi;
                $detil->kota_investor = $request->kota;
                $detil->kecamatan = $request->kecamatan;
                $detil->kelurahan = $request->kelurahan;
                $detil->kode_pos_investor = $request->kode_pos;
                $detil->tempat_lahir_investor = $request->tempat_lahir;
                $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
                $detil->jenis_kelamin_investor = $request->jenis_kelamin;
                $detil->status_kawin_investor = $request->status_kawin;
                $detil->status_rumah_investor = null;
                $detil->agama_investor = null;
                $detil->pekerjaan_investor = $request->pekerjaan;
                $detil->bidang_pekerjaan = null;
                $detil->online_investor = null;
                $detil->pendapatan_investor = $request->pendapatan;
                $detil->asset_investor = null;
                $detil->pengalaman_investor = null;
                $detil->pendidikan_investor = $request->pendidikan;
                $detil->bank_investor = $request->bank;
                $detil->rekening = $request->rekening;
                $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
                $detil->nama_ibu_kandung= $request->nama_ibu_kandung;
                //echo"<pre>";print_r($detil);echo"</pre>";die();
                if ($request->hasFile('pic_investor'))
                {
                    // Storage::disk('public')->delete($detil->pic_investor);
                    $detil->pic_investor = $this->uploadSave('pic_investor', $request, Auth::user()->id);
                }
                elseif($img_user = $_POST['image_foto_diri'])
                {

                    $image_name_user = explode(";base64,", $img_user);
                    $image_decode_user = base64_decode($image_name_user[1]);
                    $fileName_user = uniqid() . '.png';
                    $path_user = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString().'pic_investor.'.'png';
                    $path = Storage::disk('public')->put($path_user, $image_decode_user);
                    $detil->pic_investor = $path_user;
                }

                if ($request->hasFile('pic_ktp_investor')) {
                    // Storage::disk('public')->delete($detil->pic_ktp_investor);
                    $detil->pic_ktp_investor = $this->uploadSave('pic_ktp_investor', $request, Auth::user()->id);
                }
                elseif($img_ktp = $_POST['image_foto_ktp'])
                {
                    $image_name_ktp = explode(";base64,", $img_ktp);
                    $image_decode_ktp = base64_decode($image_name_ktp[1]);
                    $fileName_ktp = uniqid() . '.png';
                    $path_ktp = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.'png';
                    $path = Storage::disk('public')->put($path_ktp, $image_decode_ktp);
                    $detil->pic_ktp_investor = $path_ktp;
                }
                

                if ($request->hasFile('pic_user_ktp_investor')) {
                    // Storage::disk('public')->delete($detil->pic_user_ktp_investor);
                    $detil->pic_user_ktp_investor = $this->uploadSave('pic_user_ktp_investor', $request, Auth::user()->id);
                }
                elseif($img_user_ktp = $_POST['image_foto_ktp_diri'])
                {
                    $image_name_user_ktp = explode(";base64,", $img_user_ktp);
                    $image_decode_user_ktp = base64_decode($image_name_user_ktp[1]);
                    $fileName_user_ktp = uniqid() . '.png';
                    $path_user_ktp = 'user/'.Auth::user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.'png';
                    $path = Storage::disk('public')->put($path_user_ktp, $image_decode_user_ktp);
                    $detil->pic_user_ktp_investor =  $path_user_ktp;
                }
                
                $detil->jenis_badan_hukum = null;
                $detil->nama_perwakilan = null;
                $detil->no_ktp_perwakilan = null;

                // if ($request->kawin == 1)
                // {
                //     $detil->pasangan_investor = $request->nama_pasangan;
                //     $detil->pasangan_email = $request->email_pasangan;
                //     $detil->pasangan_tempat_lhr = $request->tempat_lahir_pasangan;
                //     $detil->pasangan_tgl_lhr = $request->tgl_lahir_pasangan.'-'.$request->bln_lahir_pasangan.'-'.$request->thn_lahir_pasangan;
                //     $detil->pasangan_jenis_kelamin = $request->jenis_kelamin_pasangan;
                //     $detil->pasangan_ktp = $request->no_ktp_pasangan;
                //     $detil->pasangan_npwp = $request->no_npwp_pasangan;
                //     $detil->pasangan_phone = $request->no_telp_pasangan;
                //     $detil->pasangan_alamat = $request->alamat_pasangan;
                //     $detil->pasangan_provinsi = $request->provinsi_pasangan;
                //     $detil->pasangan_kota = $request->kota_pasangan;
                //     $detil->pasangan_kode_pos = $request->kode_pos_pasangan;
                //     $detil->pasangan_agama = $request->agama_pasangan;
                //     $detil->pasangan_pekerjaan = $request->pekerjaan_pasangan;
                //     $detil->pasangan_bidang_pekerjaan = $request->bidang_pekerjaan_pasangan;
                //     $detil->pasangan_online = $request->pekerjaan_online_pasangan;
                //     $detil->pasangan_pendapatan = $request->pendapatan_pasangan;
                //     $detil->pasangan_pengalaman = $request->pengalaman_pasangan;
                //     $detil->pasangan_pendidikan = $request->pendidikan_pasangan;
                // }
                // else
                // {
                //     $detil->pasangan_investor = null;
                //     $detil->pasangan_email = null;
                //     $detil->pasangan_tempat_lhr = null;
                //     $detil->pasangan_tgl_lhr = null;
                //     $detil->pasangan_jenis_kelamin = null;
                //     $detil->pasangan_ktp = null;
                //     $detil->pasangan_npwp = null;
                //     $detil->pasangan_phone = null;
                //     $detil->pasangan_alamat = null;
                //     $detil->pasangan_provinsi = null;
                //     $detil->pasangan_kota = null;
                //     $detil->pasangan_kode_pos = null;
                //     $detil->pasangan_agama = null;
                //     $detil->pasangan_pekerjaan = null;
                //     $detil->pasangan_bidang_pekerjaan = null;
                //     $detil->pasangan_online = null;
                //     $detil->pasangan_pendapatan = null;
                //     $detil->pasangan_pengalaman = null;
                //     $detil->pasangan_pendidikan = null;
                // }
            // }
            // else
            // {
            //     $detil->investor_id = Auth::user()->id;
            //     $detil->tipe_pengguna = $request->tipe_pengguna;
            //     $detil->nama_investor = $request->nama;
            //     $detil->no_ktp_investor = null;
            //     $detil->no_npwp_investor = $request->no_npwp;
            //     $detil->phone_investor = $request->no_telp;
            //     $detil->alamat_investor = $request->alamat;
            //     $detil->provinsi_investor = $request->provinsi;
            //     $detil->kota_investor = $request->kota;
            //     $detil->kode_pos_investor = $request->kode_pos;
            //     $detil->tempat_lahir_investor = null;
            //     $detil->tgl_lahir_investor = null;
            //     $detil->jenis_kelamin_investor = null;
            //     $detil->status_kawin_investor = null;
            //     $detil->status_rumah_investor = null;
            //     $detil->agama_investor = null;
            //     $detil->pekerjaan_investor = null;
            //     $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
            //     $detil->online_investor = $request->pekerjaan_online;
            //     $detil->pendapatan_investor = $request->pendapatan;
            //     $detil->asset_investor = $request->asset;
            //     $detil->pengalaman_investor = null;
            //     $detil->pendidikan_investor = null;
            //     $detil->bank_investor = $request->bank;
            //     $detil->rekening = $request->rekening;

            //     $detil->pasangan_investor = null;
            //     $detil->pasangan_email = null;
            //     $detil->pasangan_tempat_lhr = null;
            //     $detil->pasangan_tgl_lhr = null;
            //     $detil->pasangan_jenis_kelamin = null;
            //     $detil->pasangan_ktp = null;
            //     $detil->pasangan_npwp = null;
            //     $detil->pasangan_phone = null;
            //     $detil->pasangan_alamat = null;
            //     $detil->pasangan_provinsi = null;
            //     $detil->pasangan_kota = null;
            //     $detil->pasangan_kode_pos = null;
            //     $detil->pasangan_agama = null;
            //     $detil->pasangan_pekerjaan = null;
            //     $detil->pasangan_bidang_pekerjaan = null;
            //     $detil->pasangan_online = null;
            //     $detil->pasangan_pendapatan = null;
            //     $detil->pasangan_pengalaman = null;
            //     $detil->pasangan_pendidikan = null;

            //     if ($request->hasFile('pic_investor')) {
            //         Storage::disk('public')->delete($detil->pic_investor);
            //         $detil->pic_investor = $this->upload('pic_investor', $request, Auth::user()->id);
            //     }

            //     if ($request->hasFile('pic_ktp_investor')) {
            //         Storage::disk('public')->delete($detil->pic_ktp_investor);
            //         $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::user()->id);
            //     }

            //     if ($request->hasFile('pic_user_ktp_investor')) {
            //         Storage::disk('public')->delete($detil->pic_user_ktp_investor);
            //         $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::user()->id);
            //     }
            //     $detil->jenis_badan_hukum = $request->jenis_badan_hukum;
            //     $detil->nama_perwakilan = $request->nama_perwakilan;
            //     $detil->no_ktp_perwakilan = $request->no_ktp_perwakilan;
            // }
            //echo"<pre>";print_r($detil);echo"</pre>";die();
            $detil->save();

            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Ubah data profil";
            $audit->ip_address =  \Request::ip();
            $audit->save();

            return redirect('user/dashboard')->with('success', "Profile berhasil diupdate");
            
        // }
        
    }

    public function new_registration_upload1(Request $request)
    {
        $investor_id = Auth::user()->id;
        
        if ($request->file('file')) {
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor' . '.' . $file->getClientOriginalExtension();
    //            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
    //            save gambar yang di upload di public storage
            
         // Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

        if(Storage::disk('public')->exists('user/'.$investor_id.'/'.$filename)){
            return response()->json([
                'success' => 'Berhasil di upload'
            ]);
        }else{
            return response()->json([
                'failed' => 'File gagal di upload'
            ]);
        }
        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function new_registration_upload2(Request $request)
    {
        $investor_id = Auth::user()->id;
        
        if ($request->file('file')) {
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor' . '.' . $file->getClientOriginalExtension();
    //            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
    //            save gambar yang di upload di public storage
            
        // Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);

        if(Storage::disk('public')->exists('user/'.$investor_id.'/'.$filename)){
            return response()->json([
                'success' => 'Berhasil di upload'
            ]);
        }else{
            return response()->json([
                'failed' => 'File gagal di upload'
            ]);
        }
        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function new_registration_upload3(Request $request)
    {
        $investor_id = Auth::user()->id;
        
        if ($request->file('file')) {
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor' . '.' . $file->getClientOriginalExtension();
    //            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
    //            save gambar yang di upload di public storage

        // Storage::disk('public')->delete('user/'.$investor_id.'/'.$filename);
            
        if(Storage::disk('public')->exists('user/'.$investor_id.'/'.$filename)){
            return response()->json([
                'success' => 'Berhasil di upload'
            ]);
        }else{
            return response()->json([
                'failed' => 'File gagal di upload'
            ]);
        }
        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }



    private function upload($column,Request $request, $investor_id)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . $column . '.' . $file->getClientOriginalExtension();
    //            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
    //            save gambar yang di upload di public storage
            return $path;
        }
        else {
            return null;
        }

    }

    private function uploadSave($column,Request $request, $investor_id)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
            $filename = Carbon::now()->toDateString() . $column . '.' . $file->getClientOriginalExtension();
    //            save nama file berdasarkan tanggal upload+nama file
            $path = 'user/' . $investor_id.'/'.$filename;
    //            save gambar yang di upload di public storage
            return $path;
        }
        else {
            return null;
        }

    }

    public function upload1(Request $request)
    {
        $investor_id = Auth::user()->id;
        
        $file_name = DetilInvestor::where('investor_id',$investor_id)->first();
        if ($file_name->pic_investor)
        {
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpg'))
            {
                $ext1 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext1);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpeg'))
            {
                $ext2 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpeg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext2);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.png'))
            {
                $ext3 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.png', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext3);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.bmp'))
            {
                $ext4 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.bmp', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext4);
            }

            Storage::disk('public')->delete($file_name->pic_investor);
            $file = $request->file('file');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor' . '.' . $file->getClientOriginalExtension();
            // save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage

            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'Sukses' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else
        {
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpg'))
            {
                $ext1 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext1);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpeg'))
            {
                $ext2 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.jpeg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext2);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.png'))
            {
                $ext3 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.png', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext3);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.bmp'))
            {
                $ext4 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_investor.bmp', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_investor.'.$ext4);
            }

            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor' . '.' . $file->getClientOriginalExtension();
            // save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'Sukses' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }

    }

    public function upload2(Request $request)
    {
        $investor_id = Auth::user()->id;
        
        $file_name = DetilInvestor::where('investor_id',$investor_id)->first();
        if ($file_name->pic_ktp_investor)
        {
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpg'))
            {
                $ext1 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext1);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpeg'))
            {
                $ext2 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpeg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext2);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.png'))
            {
                $ext3 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.png', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext3);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.bmp'))
            {
                $ext4 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.bmp', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext4);
            }
            Storage::disk('public')->delete($file_name->pic_ktp_investor);
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor' . '.' . $file->getClientOriginalExtension();
            // save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'Sukses' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
            
        }
        else
        {
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpg'))
            {
                $ext1 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext1);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpeg'))
            {
                $ext2 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.jpeg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext2);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.png'))
            {
                $ext3 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.png', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext3);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.bmp'))
            {
                $ext4 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_ktp_investor.bmp', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.'.$ext4);
            }
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor' . '.' . $file->getClientOriginalExtension();
            // save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'Sukses' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }

        }

    }

    public function upload3(Request $request)
    {
        $investor_id = Auth::user()->id;
        
        $file_name = DetilInvestor::where('investor_id',$investor_id)->first();
        if ($file_name->pic_user_ktp_investor)
        {
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpg'))
            {
                $ext1 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext1);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpeg'))
            {
                $ext2 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpeg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext2);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.png'))
            {
                $ext3 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.png', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext3);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.bmp'))
            {
                $ext4 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.bmp', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext4);
            }
            Storage::disk('public')->delete($file_name->pic_user_ktp_investor);
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor' . '.' . $file->getClientOriginalExtension();
            // save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'Sukses' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }

        }
        else
        {
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpg'))
            {
                $ext1 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext1);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpeg'))
            {
                $ext2 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.jpeg', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext2);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.png'))
            {
                $ext3 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.png', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext3);
            }
            if (Storage::disk('public')->exists('user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.bmp'))
            {
                $ext4 = pathinfo(storage_path().'/user/'.$investor_id.'/'.Carbon::now()->toDateString().'pic_user_ktp_investor.bmp', PATHINFO_EXTENSION);
                Storage::disk('public')->delete('user/' . $investor_id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.'.$ext4);
            }
            $file = $request->file('file');
            $resize = $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor' . '.' . $file->getClientOriginalExtension();
            // save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . $investor_id;
            $path = $file->storeAs($store_path, $filename, 'public');
            // save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete('user/'.Auth::guard('api')->user()->id.'/'.$filename);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'Sukses' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }

    }
    
    public function emailConfirm($code) {
        $user = Investor::where('email_verif', $code)->first();

        if(!$user){
            return "False";
        }
        else{
            if($user->email_verif === $code){
                $detilInvestor = new DetilInvestor;
                $user->status = 'notfilled';
                $user->email_verif = Null;
                $user->save();

                return redirect('/');

            }
            else{
                return redirect('/#loginModalAs');
            }
        }
    }

    public function showUserInvestation() {
        
        $pendanaan = PendanaanAktif::where('investor_id', Auth::user()->id)
                                    ->where('status', 1)
                                    ->whereNotIn('proyek_id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.Auth::user()->id.' group by proyek_id')])
                                    ->get();
        $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        $detil = Auth::user()->detilInvestor;
        $payout = ListImbalUser::where('investor_id',Auth::user()->id)->whereRaw('status_payout BETWEEN 0 AND 4')->sum('imbal_payout');

        $dataRegDigiSign = CheckUserSign::where('investor_id',Auth::user()->id)->first();
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

        // return $pendanaan;
        return view('pages.user.manage_investation')->with('pendanaan',$pendanaan)->with('rekening', $rekening)->with('detil', $detil)->with('payout',$payout)->with('teks',$teks)->with('cekRegDigiSign',$cekRegDigiSign);

        
        
    }

    public function showDetailPackage($id) {
        $proyek = Proyek::find($id);
        $data_pendana = PendanaanAktif::where('proyek_id',$id)->get();
        // return $proyek;
        return view('pages.user.package_detail',compact('proyek','data_pendana'));
    }

    public function changePassword(Request $request) {
        $old = $request->get('old_password');
        if (!(Hash::check($old, Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $new = $request->get('new_password');
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($new);
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function withdrawRequest() {
        return view('pages.user.withdraw_request');
    }

    public function showTambahDana(){

        //SEBELUM OJK
        // $rekening = $user = Auth::user()->rekeningInvestor;

        //BUAT OJK
        $rekening = RekeningInvestor::select('rdl_acount_number.account_number', 'rdl_acount_number.cif_number', 'rekening_investor.va_number')
                                    ->where('rekening_investor.investor_id', Auth::user()->id)
                                    ->leftjoin('rdl_acount_number', 'rdl_acount_number.investor_id', '=', 'rekening_investor.investor_id')->first();

        return view('pages.user.add_funds')->with('rekening', $rekening);
    }

    public function showTambahDanaMidtrans(){

        return view('pages.user.add_funds_midtrans')->with('investor_id', Auth::user()->id);
    }

    public function prosesTambahDana()
    {
        \DB::transaction(function(){
            // echo Auth::user()->id;die;
            // cek data rekening investor
            // $data_rekening_investor = RekeningInvestor::where('investor_id', $this->request->investor_id)->count();
            // if ($data_rekening_investor != 0)
            // {
                // rekening investor
                $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();

                // data investor
                $rekening_midtrans = RekeningInvestor::leftJoin('investor','investor.id','=','rekening_investor.investor_id')
                                                ->leftJoin('detil_investor','detil_investor.investor_id','=','rekening_investor.investor_id')
                                                ->where('rekening_investor.investor_id', Auth::user()->id)
                                                ->first([
                                                    'rekening_investor.id',
                                                    'investor.email',
                                                    'detil_investor.*'
                                                ]);

                // $log_rekening = LogRekening::where('investor_id', Auth::user()->id)->first();

                //save log
                $log_rekening = LogRekening::create([
                                    'investor_id' => Auth::user()->id,
                                    'nominal' => $this->request->total_dana,
                                    'keterangan' => 'Dana Investasi'
                                ]);



                // Buat transaksi ke midtrans kemudian save snap tokennya.
                $payload = [
                    'transaction_details' => [
                        'order_id'      => $log_rekening->id + 1,
                        'gross_amount'  => $this->request->total_dana,
                    ],
                    'customer_details' => [
                        'first_name'    => $rekening_midtrans->nama_investor,
                        'email'         => $rekening_midtrans->email,
                        'phone'         => $rekening_midtrans->phone_investor,
                        'address'       => $rekening_midtrans->alamat_investor,
                    ],
                    'item_details' => [
                        [
                            'id'       => 'Dana Investasi',
                            'price'    => $this->request->total_dana,
                            'quantity' => 1,
                            'name'     => 'Dana Investasi'
                        ]
                    ],
                    // 'enabled_payments' => ['bni_va'],
                    // 'bni_va' => [
                    //     'va_number' => '12345678919876'
                    // ]
                ];
                $rekening->total_dana += $this->request->total_dana;
                $rekening->unallocated += $this->request->total_dana;

                $snapToken = Veritrans_Snap::getSnapToken($payload);
                $rekening->snap_token = $snapToken;
                $rekening->save();

                // Beri response snap token
                $this->response['snap_token'] = $snapToken;
            // }
            // else
            // {
            //     $rekening_midtrans = RekeningInvestor::leftJoin('investor','investor.id','=','rekening_investor.investor_id')
            //                                     ->leftJoin('detil_investor','detil_investor.investor_id','=','rekening_investor.investor_id')
            //                                     ->where('rekening_investor.investor_id', Auth::user()->id)
            //                                     ->first([
            //                                         'rekening_investor.id',
            //                                         'investor.email',
            //                                         'detil_investor.*'
            //                                     ]);
            //     $no_transaksi = 1;
            //     // Buat transaksi ke midtrans kemudian save snap tokennya.
            //     $payload = [
            //         'transaction_details' => [
            //             'order_id'      => $rekening_midtrans->id,
            //             'gross_amount'  => $val,
            //         ],
            //         'customer_details' => [
            //             'first_name'    => $rekening_midtrans->nama_investor,
            //             'email'         => $rekening_midtrans->email,
            //             'phone'         => $rekening_midtrans->phone_investor,
            //             'address'       => $rekening_midtrans->alamat_investor,
            //         ],
            //         'item_details' => [
            //             [
            //                 'id'       => 'Dana Investasi',
            //                 'price'    => $val,
            //                 'quantity' => $total,
            //                 'name'     => 'Dana Investasi'
            //             ]
            //         ]
            //     ];
            //     $snapToken = Veritrans_Snap::getSnapToken($payload);
            //     $rekening->snap_token = $snapToken;
            //     $rekening->save();

            //     // Beri response snap token
            //     $this->response['snap_token'] = $snapToken;
            // }
        });

        return response()->json($this->response);
    }

    public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();
        \DB::transaction(function() use($notif) {

          $transaction = $notif->transaction_status;
          $type = $notif->payment_type;
          $orderId = $notif->order_id;
          $fraud = $notif->fraud_status;
          $log_rekening = LogRekening::where('id', $orderId)->first(['investor_id']);
          $rekening = RekeningInvestor::findOrFail($log_rekening->investor_id);

          error_log("Order ID $notif->order_id: "."transaction status = $transaction, fraud staus = $fraud");

            if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
                if ($type == 'credit_card') {

                    if($fraud == 'challenge') {
                        // TODO set payment status in merchant's database to 'Challenge by FDS'
                        // TODO merchant should decide whether this transaction is authorized or not in MAP
                        // $donation->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                        $rekening->setPending();
                    } else {
                        // TODO set payment status in merchant's database to 'Success'
                        // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                        $rekening->setSuccess();
                    }

                }

            } elseif ($transaction == 'settlement') {

                // TODO set payment status in merchant's database to 'Settlement'
                // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
                $rekening->setSuccess();
                $notif_transaksi = "Transaction order_id: " . $orderId ." successfully transfered using " . $type;

            } elseif($transaction == 'pending'){

                // TODO set payment status in merchant's database to 'Pending'
                // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
                $rekening->setPending();
                $notif_transaksi = "Waiting customer to finish transaction order_id: " . $orderId . " using " . $type;

            } elseif ($transaction == 'deny') {

                // TODO set payment status in merchant's database to 'Failed'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
                $rekening->setFailed();
                $notif_transaksi = "Payment using " . $type . " for transaction order_id: " . $orderId . " is denied.";

            } elseif ($transaction == 'expire') {

                // TODO set payment status in merchant's database to 'expire'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
                $rekening->setExpired();
                $notif_transaksi = "Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.";

            } elseif ($transaction == 'cancel') {

                // TODO set payment status in merchant's database to 'Failed'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
                $rekening->setFailed();
                $notif_transaksi = "Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.";
            }

            return;
        });

        // return "sukses";
    }

    public function chartPendanaan(){
        $user = Auth::user();
        $pendanaan = \App\PendanaanAktif::where('investor_id',$user->id)
                                        ->where('total_dana', '>' ,0)
                                        ->where('status', 1)
                                        ->whereNotIn('proyek_id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$user->id.' group by proyek_id')])
                                        ->with('proyek:id,nama')
                                        ->groupBy('proyek_id')
                                        ->get([
                                                DB::raw('sum(nominal_awal) as jumlah_pendanaan'),
                                                'proyek_id',
                                                'tanggal_invest'
                                        ]);
        $rekening = $user->rekeningInvestor;
        // return $pendanaan;
        return json_encode([ 'pendanaan' => $pendanaan, 'rekening' => $rekening]);
    }

    public function addPendanaanAktif(Request $request) {

        $jumlahPendanaan = PendanaanAktif::where('proyek_id',$request->id_proyek)->sum('total_dana');
        $proyek = Proyek::where('id', $request->id_proyek)->first();
        $selesai = Carbon::parse($proyek->tgl_selesai_penggalangan)->toDateString();
        $sekarang = Carbon::now()->toDateString();

        $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::user()->id)->where('accepted',0)->sum('jumlah');
        $totalDana = ($proyek->harga_paket*$request->qty) + $jumlahPenarikan;
        $jumlahRekening = 0;
        $jumlahRekening += $rekening->unallocated;

        if ($jumlahPendanaan+$proyek->terkumpul < $proyek->total_need && $selesai >= $sekarang)
        {
            if ($totalDana >  $jumlahRekening)
            {
                if ($jumlahPenarikan > 0)
                {
                    return redirect()->back()->with('error', 'Dana Tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana');
                }
                else
                {
                    return redirect()->back()->with('error', 'Dana Tidak Cukup');
                }
            }
            else
            {
                $pendanaan = PendanaanAktif::where('id', $request->id_pendanaan)->first();

                $val = $proyek->harga_paket*$request->qty;

                $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
                if ($rekening->unallocated >= $val && $val > 0) {
                    $rekening->unallocated = $rekening->unallocated - $val;
                    $rekening->save();
                }
                else {
                    return redirect()->back()->with('error', 'Dana tidak cukup');
                }

                if($pendanaan->tanggal_invest->toDateString() == Carbon::now()->toDateString()){
                    $pendanaan->update(['total_dana' => $pendanaan->total_dana+$val , 'nominal_awal'=>$pendanaan->nominal_awal+$val]);
                    
                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaan->id;
                    $log->nominal = $val;
                    $log->tipe = 'add active investation';
                    $log->save();
                    return redirect()->back()->with('success', 'Berhasil Menambah Pendanaan');
                }
                else 
                {
                    $pendanaan = new PendanaanAktif;
                    $pendanaan->investor_id = Auth::user()->id;
                    $pendanaan->proyek_id = $request->id_proyek;
                    $harga_paket = Proyek::find($request->id_proyek)->harga_paket;
                    $pendanaan->total_dana = $harga_paket*$request->qty;
                    $pendanaan->nominal_awal = $harga_paket*$request->qty;
                    $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                    $pendanaan->last_pay = Carbon::now()->toDateString();
                    $pendanaan->save();

                    $user = Auth::user();
                    // default subscribe to monthly payout
                    // $subscribe = Subscribe::create([
                    //     'investor_id' => $user->id,
                    //     'pendanaanAktif_id' => $pendanaan->id,
                    //     'BANK' => $user->detilInvestor->bank,
                    //     'rekening' => $user->detilInvestor->rekening,
                    //     'pemilik_rekening' => $user->detilInvestor->nama_investor,
                    // ]);

                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaan->id;
                    $log->nominal = $pendanaan->nominal_awal;
                    $log->tipe = 'add active investation';
                    $log->save();

                    return redirect()->back()->with('success', 'Berhasil Menambah Pendanaan');
                }
            }
            
        }
        elseif ($jumlahPendanaan+$proyek->terkumpul < $proyek->total_need && $selesai < $sekarang)
        {
            return redirect()->back()->with('error', 'Penggalangan Dana Proyek Sudah Selesai');
        }
        elseif($jumlahPendanaan+$proyek->terkumpul >= $proyek->total_need && $selesai >= $sekarang)
        {
            return redirect()->back()->with('error', 'Proyek Sudah Penuh');
        }
        else
        {
            return redirect()->back()->with('error', 'Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai');
        }
    }

    public function ambilPendanaanAktif(Request $request) {
        $pendanaan = PendanaanAktif::find($request->id);
        $proyek = Proyek::where('id', $pendanaan->proyek_id)->first();
        $total_penarikan = $pendanaan->proyek->harga_paket * $request->qty;


        if ($pendanaan->nominal_awal < $total_penarikan || $total_penarikan <= 0) {
            return redirect()->back()->with('error', 'Jumlah paket yang ingin anda tarik melebihi jumlah yang ada di proyek anda');
        }else {
            
            $pendanaan->nominal_awal = $pendanaan->nominal_awal - $total_penarikan;
            $pendanaan->total_dana = $pendanaan->total_dana - $total_penarikan;
            if ($pendanaan->nominal_awal == 0) {
                $pendanaan->status = 0 ;
                // $subscribe = Subscribe::where('pendanaanAktif_id',$pendanaan->id)->first();
                // $subscribe->delete();
            }
            $pendanaan->save();


            $check_detil_imbal = DetilImbalUser::where('pendanaan_id',$request->id)->first();
            // var_dump($sum);die();
                if(!empty($check_detil_imbal->pendanaan_id))
                {
                    if($proyek->profit_margin <= 12)
                    {
                        $propcal = $proyek->profit_margin/12;
                        $imbalcal1 = ($propcal*$pendanaan->nominal_awal)/100;
                        $total_dana = floor($pendanaan->total_dana/100)*100;
                        $check_detil_imbal->total_dana = $total_dana;
                        $check_detil_imbal->save();


                        $check_list_imbal = ListImbalUser::where('pendanaan_id',$request->id)->orderby('id','DESC')->get();
                        for($x=0;$x < count($check_list_imbal); $x++)
                        {
                            $propcal = $proyek->profit_margin/12;
                            $imbalcal = ($propcal*$pendanaan->total_dana)/100;
                            $check_list_imbal[$x]->imbal_payout;
                            if($check_list_imbal[$x]->status_payout == 5){
                                if($x == 0){
                                    echo $check_list_imbal[$x]->imbal_payout;
                                    echo "kosong";
                                    $check_list_imbal[$x]->imbal_payout = $total_dana;
                                }elseif($x == 1){
                                    echo $check_list_imbal[$x]->imbal_payout;
                                    echo "satu";
                                    $check_list_imbal[$x]->imbal_payout = 0;
                                }else{
                                    $check_list_imbal[$x]->imbal_payout = floor($imbalcal/100)*100;;
                                }
                                $check_list_imbal[$x]->total_dana = floor($pendanaan->total_dana/100)*100;
                                $check_list_imbal[$x]->save();
                            }
                        }
                        // die();
                        $sum = listimbaluser::where('pendanaan_id', $request->id)->sum('imbal_payout');

                        $update_total_dana = DetilImbalUser::where('pendanaan_id',$request->id)->first();

                        $update_total_dana->total_imbal = floor($sum/100)*100;
                        $update_total_dana->save();

                    }
                    elseif($proyek->profit_margin >= 13)
                    {
                        $imbalcal = ($proyek->profit_margin/12)*$proyek->tenor_waktu;
                        $totalimbal = $pendanaan->total_dana/100;
                        $hasilimbal = ($imbalcal-$proyek->tenor_waktu)*$pendanaan->total_dana;
                        $sisaimbal = $hasilimbal/100;
                        
                        $check_list_imbal = ListImbalUser::where('pendanaan_id',$request->id)->where('status_payout',5)->get();
                        for($x=0;$x < count($check_list_imbal);$x++)
                        {
                            //dana pokok
                            if($check_list_imbal[$x]->imbal_payout == $check_list_imbal[$x]->total_dana){
                                $check_list_imbal[$x]->imbal_payout = floor($pendanaan->total_dana/100)*100;
                            }elseif($check_list_imbal[$x]->imbal_payout == $check_detil_imbal->sisa_imbal){
                                $check_list_imbal[$x]->imbal_payout = floor($sisaimbal/100)*100;
                            }else{
                                $check_list_imbal[$x]->imbal_payout = floor($totalimbal/100)*100;
                            }
                            $check_list_imbal[$x]->total_dana = floor($pendanaan->total_dana/100)*100;
                            $check_list_imbal[$x]->status_payout = 5;
                            $check_list_imbal[$x]->save();
                        }
                        
                        $check_detil_imbal->total_dana = floor($pendanaan->total_dana/100)*100;
                        // $check_detil_imbal->total_imbal = floor($sum/100)*100;
                        $check_detil_imbal->sisa_imbal = floor($sisaimbal/100)*100;
                        $check_detil_imbal->save();

                        $sum = listimbaluser::where('pendanaan_id', $request->id)->sum('imbal_payout');

                        $update_total_dana = DetilImbalUser::where('pendanaan_id',$request->id)->first();

                        $update_total_dana->total_imbal = floor($sum/100)*100;
                        $update_total_dana->save();

                    }
                    elseif($pendanaan->status == 0 )
                    {
                        $check_detil_list_status = DetilImbalUser::where('pendanaan_id',$request->id)->first();
                        $check_list_imbal_status = ListImbalUser::where('pendanaan_id',$request->id)->where('status_payout',5)->get();

                        for($x=0;$x < sizeOf($check_list_imbal_status);$x++)
                        {
                            $check_list_imbal_status[$x]->delete();
                        }

                        $check_detil_imbal->delete();
                    }


                }
                    $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
                    $rekening->unallocated = $rekening->unallocated + $total_penarikan;
                    $rekening->save();


                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaan->id;
                    $log->nominal = $total_penarikan;
                    $log->tipe = 'ambil active investation';
                    $log->save();

            return redirect()->back()->with('success', 'Dana anda berhasil ditarik ke DANA TERSEDIA');
        }
    }

    public function cekKonfirmTelp(Request $request)
    {
        $id = $request->investor_id;
        $no_telp = $request->no_telp;
        $tipe = $request->tipe;

        $cekData = DetilInvestor::where('investor_id',$id)
                                ->where('phone_investor',$no_telp)
                                ->first();

        if (isset($cekData) && $tipe == 'profile')
        {
            return redirect('user/manage_profile')->with('no_telp_profile',$cekData->phone_investor);
        }
        if (isset($cekData) && $tipe == 'pass')
        {
            return redirect('user/ubahPassword')->with('no_telp_ubah_password',$cekData->phone_investor);
        }
        else
        {
            return redirect('user/dashboard')->with('error_konfirm','No Telepon Anda Salah.');
        }
    }
    
    public function histori_penarikan_dana(){ // get histori penarikan dana
    //public function histori_penarikan_dana($id){ // get histori penarikan dana
    
        /*
            author  : radi
            desc    : funnction untuk menampilan data histori penarikan dana
        
        */
        
        $historis = DB::table('penarikan_dana')->where('investor_id', Auth::user()->id)->get();
        
        $data = array();
        $no = 1;
        if(!empty($historis)){
            foreach($historis as $histori){
            
                $column['Jumlah Penarikan']     = (string)number_format($histori->jumlah);
                $column['Tanggal Penarikan']    = (string)$histori->created_at;
                $column['No Rekening']  = (string)$histori->no_rekening;
                $column['Bank Tujuan']  = (string)$histori->bank;
                
                $status = "";
                if($histori->accepted == 0){
                    $status = "REQUEST";
                }
                
                else if($histori->accepted == 1){
                    $status = "Disetujui";
                }
                else if($histori->accepted == 2){
                    $status = "Gagal";
                }
                
                $column['Status']   = (string)$status;
                
                $data[] = $column;
                
            }
        }
        $parsingJSON = array(
                        "data" => $data
        );
        
        echo json_encode($parsingJSON);
        
    }
    
    public function list_history_didanai(){
        
        /*
            author  : radi
            desc    : funnction untuk menampilan data proyek yang telah didanai
        
        */
        
        $datadiDanai = DB::table('proyek AS a')
            ->join('pendanaan_aktif AS b', 'a.id', '=', 'b.proyek_id')
            ->select('a.id', 'a.nama', 'a.status', 'b.investor_id', 'b.proyek_id', 'b.nominal_awal', 'b.tanggal_invest')
            ->where('a.status', '=', 4)
            ->where('b.investor_id', '=', Auth::user()->id)
            ->get();
        
        $data = array();
        $no = 1;
        if(!empty($datadiDanai)){
            foreach($datadiDanai as $didanai){
            
                $column['Proyek']   = (string)$didanai->nama;
                $column['Dana Awal']    = (string)number_format($didanai->nominal_awal);
                $column['Tanggal Invest']   = (string)$didanai->tanggal_invest;
                //$column['investor_id']    = (string)$didanai->investor_id;
                
                $data[] = $column;
                
            }
        }
        $parsingJSON = array(
                        "data" => $data
        );
        
        echo json_encode($parsingJSON);
        
    }
    
    
    public function list_data_kelola_paket_investasi(){
        
        /*
            author  : radi
            desc    : funnction untuk menampilan data paket investasi yg sudah terinves
        
        */
        
       $paket_inves = DB::table('proyek AS a')
                    ->join('pendanaan_aktif AS b', 'a.id', '=', 'b.proyek_id')
                    ->select('a.id', 'a.nama','a.harga_paket','a.tgl_selesai','a.tgl_mulai','a.profit_margin','a.tenor_waktu', 'b.status',  'a.status', 'b.id as id_pendanaan','b.investor_id', 'b.proyek_id','b.total_dana', 'b.nominal_awal', 'b.tanggal_invest')
                    ->whereIn('a.status', [1, 2, 3])
                    ->where('b.status', '=', 1)
                    ->where('b.investor_id', '=', Auth::user()->id)
                    ->get();
        // dd($paket_inves);die;
        $data = array();
        $no = 1; 
        if(!empty($paket_inves)){
            foreach($paket_inves as $data_invest){
                $tgl_sekarang = strtotime("Y-m-d");
                $tgl_selesai = strtotime($data_invest->tgl_selesai);
                
                //$days=date_diff($tgl_sekarang,$tgl_selesai, true);
                //echo $diff->format("%R%a days");
                
                //$days = date_diff($tgl_sekarang,$tgl_selesai);
                //$days = (int)date_diff((strtotime($tgl_sekarang) - strtotime($tgl_selesai))/(60*60*24*30));
                
                $date1 = date_create(date('Y-m-d'));
                $date2 = date_create($data_invest->tgl_selesai);

                //difference between two dates
                $diff = date_diff($date1,$date2);

                //count days
                //echo 'Days Count - '.$diff->format("%a");
                
                $column['id_proyek']            = (string)$data_invest->proyek_id;
                $column['id_investor']          = (string)$data_invest->investor_id;
                $column['id_pendanaan']         = (string)$data_invest->id_pendanaan;
                $column['Harga Paket']          = (string)number_format($data_invest->harga_paket);
                $column['Nama Proyek']          = (string)$data_invest->nama;
                $column['Dana Masuk']           = (string)number_format($data_invest->nominal_awal);
                $column['Tanggal Invest']       = (string)Carbon::parse($data_invest->tanggal_invest)->format('d-m-Y');
                $column['Tanggal Mulai']        = (string)Carbon::parse($data_invest->tgl_mulai)->format('d-m-Y');
                $column['Sisa Periode']         =  $diff->format("%a");
                $column['Bagi Hasil Sudah Diterima']    = (string)number_format($data_invest->total_dana-$data_invest->nominal_awal);
                $column['status']               = (string)$data_invest->status;
                $column['profitMargin']                 = (string)number_format($data_invest->profit_margin);
                $column['tenorProyek']              = (string)number_format($data_invest->tenor_waktu);
                
                $data[] = $column;
                
            }
        }
        $parsingJSON = array(
                        "data" => $data
        );
        
        echo json_encode($parsingJSON);
        
    }
    
    public function check_photo(){
        
        /*
            author  : radi
            desc    : funnction untuk mengecek poto jika kosong
        
        */
        
        $query_check_photo = DB::table('detil_investor AS a')
            ->select('a.id', 'a.investor_id','a.pic_investor','a.pic_ktp_investor', 'a.pic_user_ktp_investor')
            ->where('a.investor_id', '=', Auth::user()->id)
            ->get();
        
        return response()->json(['investor_id' => (string)$query_check_photo->first()->investor_id, 'pic_investor' => $query_check_photo->first()->pic_investor, 'pic_ktp_investor' => $query_check_photo->first()->pic_ktp_investor, 'pic_user_ktp_investor' => $query_check_photo->first()->pic_user_ktp_investor]);
    }

    public function logAkadInvestor(Request $req)
    {       
        $digiSign = new DigiSignController;
        $digiSign->createDocInvestor($req->id_user);

        if ($req->id_user)
        {
            $logAkadDigiSign = new LogAkadDigiSignInvestor;
            $logAkadDigiSign->investor_id = $req->id_user;
            $logAkadDigiSign->provider_id = 0;
            $logAkadDigiSign->total_aset = $req->total_aset;
            $logAkadDigiSign->document_id = 0;
            $logAkadDigiSign->status = 'complete';
            $logAkadDigiSign->tgl_sign = date("Y-m-d");

            $logAkadDigiSign->save();

            $response = ['status' => '00', 'link' => Storage::url('akad_investor/'.Auth::user()->id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf')];
        }
        else
        {

            $response = ['status' => '01', 'link' => ''];
        }
        return $response;
    }

    public function list_selected_proyek(){
        $session = Auth::user()->id;
        $data = DB::table('tmp_selected_proyek')
                    ->join('proyek', 'tmp_selected_proyek.proyek_id', '=', 'proyek.id')
                    ->where('investor_id','=',$session)
                    ->select('tmp_selected_proyek.*', 'proyek.nama as nama_proyek')
                    ->get();
        
        $response = ['data' => $data];

        return response()->json($response);
        
    }
	
	public function getSelectedProyek($proyek_id, $investor_id){
		$data = DB::table('tmp_selected_proyek')
			->join('proyek', 'tmp_selected_proyek.proyek_id', '=', 'proyek.id')
			->where('proyek_id','=',$proyek_id)
			->where('investor_id','=',$investor_id)
			->select('tmp_selected_proyek.*', 'proyek.nama as nama_proyek')
			->first();
        
        $response = ['data' => $data];

        return response()->json($response);
	}
    
    public function delete_select_proyek($id_proyek){
        $session = Auth::user()->id;
        $data = DB::table('tmp_selected_proyek')
                    ->where('proyek_id','=',$id_proyek)
                    ->where('investor_id','=',$session)
                    ->delete();
        
        $response = ['status' => "ok"];

        return response()->json($response);
        
    }
    
    public function get_detail_proyek(Request $request)
    {
        $id = $request->id;
        $proyek = $request->proyek;
        $data = DB::table('tmp_selected_proyek as a')
                    ->join('proyek as b', 'a.proyek_id', '=', 'b.id')
                    ->where('b.id', '=', $proyek)
                    ->where('a.id', '=', $id)
                    ->select('a.id as kode','a.*', 'b.*')
                    ->get();
        return response()->json($data);
    }

    public function add_pendanaan_new(Request $request){

        $proyek_id      = $request->id_proyek;
        $investor_id    = $request->investor_id;
        $qty            = $request->qty;
        $user           = Auth::user();

        $proyek     = Proyek::where('id','=', $proyek_id)->first();
        $rekening   = RekeningInvestor::where('investor_id', $investor_id)->first();

        $jumlahPendanaan = PendanaanAktif::where('proyek_id',$proyek_id)->sum('total_dana');
        $selesai    = Carbon::parse($proyek->tgl_selesai_penggalangan)->toDateString();
        $sekarang   = Carbon::now()->toDateString();
        
        $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::user()->id)->where('accepted',0)->sum('jumlah');
        $totalDana = ($proyek->harga_paket*$qty) + $jumlahPenarikan;
        $jumlahRekening = 0;
        $jumlahRekening += $rekening->unallocated;
        
        if ($jumlahPendanaan+$proyek->terkumpul < $proyek->total_need && $selesai >= $sekarang)
        {
            
            if ($totalDana >  $jumlahRekening)
            {
                return response()->json([
                 'status' => 'failed',
                 'keterangan' => "Dana Tersedia anda sebesar Rp ".number_format($jumlahPenarikan,0,"",".")." sedang kami proses di penarikan dana"
                ]);
                // return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi karena dana tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana');
            }
            else
            {
                $pendanaan = new PendanaanAktif;
                $pendanaan->investor_id = Auth::user()->id;
                $pendanaan->proyek_id = $proyek_id;
                $harga_paket = $proyek->harga_paket;
                $pendanaan->total_dana = $harga_paket*$qty;
                $pendanaan->nominal_awal = $harga_paket*$qty;
                $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                $pendanaan->last_pay = Null;
                $pendanaan->save();

                $user = Auth::user();
                $log = new LogPendanaan;
                $log->pendanaanAktif_id = $pendanaan->id;
                $log->nominal = $pendanaan->nominal_awal;
                $log->tipe = 'add new investation';
                $log->save();
                
                $rekening->unallocated = $rekening->unallocated - $harga_paket*$qty;
                $rekening->save();

                $audit = new AuditTrail;
                $username = Auth::guard()->user()->username;
                $audit->fullname = $username;
                $audit->description = "Pendanaan Proyek Berhasil";
                $audit->ip_address =  \Request::ip();
                $audit->save();
                
                return response()->json([
                 'status' => 'success',
                 'keterangan' => "Proses Pendanaan Berhasil"
                ]);
                // return redirect()->back()->with('msg_success', 'Pendanaan Berhasil'); // sukses investasi
            }
            
        }
        elseif ($jumlahPendanaan+$proyek->terkumpul < $proyek->total_need && $selesai < $sekarang)
        {
            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Pendanaan proyek gagal karena penggalangan dana proyek sudah selesai";
            $audit->ip_address =  \Request::ip();
            $audit->save();
            return response()->json([
             'status' => 'failed',
             'keterangan' => "Penggalangan Dana Proyek Sudah Selesai"
            ]);
                
            // return redirect()->back()->with('msg_success', 'Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
        }
        elseif($jumlahPendanaan+$proyek->terkumpul >= $proyek->total_need && $selesai >= $sekarang)
        {
            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh";
            $audit->ip_address =  \Request::ip();
            $audit->save();
            return response()->json([
             'status' => 'failed',
             'keterangan' => "Proyek Sudah Penuh"
            ]);
            
            // return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh'); // error validasi investasi
        }
        else
        {
            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh & penggalangan dana proyek sudah selesai";
            $audit->ip_address =  \Request::ip();
            $audit->save();
            return response()->json([
             'status' => 'failed',
             'keterangan' => "Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai"
            ]);
            
            // return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
        }
    }

    public function unduhAkad(){
        
        return view('pages.user.unduhAkad');

    }

    public function datatables_akad_murobahah($id)
    {
        
        $akad = LogAkadDigiSignInvestor::select('log_akad_digisign_investor.*', 'proyek.nama as nama_proyek')
        ->join('proyek', 'proyek.id', '=', 'log_akad_digisign_investor.proyek_id')
        ->where('log_akad_digisign_investor.document_id', 'like', '%kontrakAll%')
        ->where('log_akad_digisign_investor.status','<>','kirim')
        ->where('log_akad_digisign_investor.investor_id',$id)->get();
        
        $response = ['data' => $akad];

        return response()->json($response);
    }

    public function ubahPassword(){
        
        return view('pages.user.changePassword');

    }

    public function updatePassword(Request $request)
    {
        
        $investor_id = Auth::user()->id;

        $update = Investor::where('id',$investor_id)->first();
        $update->password = bcrypt($request->password);
        $update->save();
        
        return  redirect('/user/dashboard');  
        
    }
    

}
