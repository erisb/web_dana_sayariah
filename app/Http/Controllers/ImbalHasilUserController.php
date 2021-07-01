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
use App\IhListImbalUser;
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

class ImbalHasilUserController extends Controller
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
        // $this->middleware(UserCheck::class)->except(['cekRegDigiSign','emailConfirm', 'updateProfileReject', 'upload', 'firstUpdateProfile','get_kota', 'checkPhone','getTableDetil', 'new_registration_upload1', 'new_registration_upload2', 'new_registration_upload3','otpCode','cekOTP']);

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

        $realTotalAset = !empty($rekening) ? number_format($rekening->total_dana,0,'','') : 0;

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
        return view('pages.user.ihmanage_investation')->with('pendanaan',$pendanaan)->with('rekening', $rekening)->with('detil', $detil)->with('payout',$payout)->with('teks',$teks)->with('cekRegDigiSign',$cekRegDigiSign);

        
        
    }

    public function get_aktif_dana($id){
        // echo $id;die;
        $user = Auth::user();
        #backup
        //$gettglpayout = ListImbalUser::where('pendanaan_id', $id)->orderby('tanggal_payout')->get();
        #endbackup
        $gettglpayout = IhListImbalUser::where('ih_detil_imbal_user.pendanaan_id', $id)->orderby('tanggal_payout')
                                        ->join('ih_detil_imbal_user','ih_detil_imbal_user.id','=','ih_list_imbal_user.detilimbaluser_id')
                                        ->get();

        $jmlpayout = count($gettglpayout);

        // $item = DetilImbalUser::where('pendanaan_id',$id)->first();
        #backup
        // $item = DB::table('detil_imbal_user')
        // ->join('pendanaan_aktif', 'detil_imbal_user.pendanaan_id', '=', 'pendanaan_aktif.id')
        // ->select('detil_imbal_user.*','pendanaan_aktif.nominal_awal')
        // ->where('detil_imbal_user.pendanaan_id', $id)
        // ->first();
        #endbackup
        $item = DB::table('ih_detil_imbal_user')
        ->join('ih_pendanaan_aktif', 'ih_detil_imbal_user.pendanaan_id', '=', 'ih_pendanaan_aktif.id')
        ->select('ih_detil_imbal_user.*','ih_pendanaan_aktif.nominal_awal')
        ->where('ih_detil_imbal_user.pendanaan_id', $id)
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
        #backup
        // if($getpro == $jmlpayout){
        //     $list_imbal = new ListImbalUser;
        //     $list_imbal->proyek_id = $getuser->proyek_id;
        //     $list_imbal->pendanaan_id = $getuser->pendanaan_id;
        //     $list_imbal->investor_id = $getuser->investor_id;
        //     $list_imbal->tanggal_payout = $tglplustujuh;
        //     $list_imbal->imbal_payout = $getuser->sisa_imbal;
        //     $list_imbal->total_dana = $getuser->total_dana;
        //     $list_imbal->status_payout = 5;
        //     $list_imbal->status_update = NULL;
        //     $list_imbal->tgl_update = NULL;
        //     $list_imbal->keterangan = '';
        //     $list_imbal->status_libur = NULL;
        //     $list_imbal->keterangan_libur = '';
        //     $list_imbal->ket_weekend = '';
        //     $list_imbal->save();

        //     $list_imbal1 = new ListImbalUser;
        //     $list_imbal1->proyek_id = $getuser->proyek_id;
        //     $list_imbal1->pendanaan_id = $getuser->pendanaan_id;
        //     $list_imbal1->investor_id = $getuser->investor_id;
        //     $list_imbal1->tanggal_payout = $tglplustujuh;
        //     $list_imbal1->imbal_payout = $getuser->total_dana;
        //     $list_imbal1->total_dana = $getuser->total_dana;
        //     $list_imbal1->status_payout = 5;
        //     $list_imbal1->status_update = NULL;
        //     $list_imbal1->tgl_update = NULL;
        //     $list_imbal1->keterangan = '';
        //     $list_imbal1->status_libur = NULL;
        //     $list_imbal1->keterangan_libur = '';
        //     $list_imbal1->ket_weekend = '';
        //     $list_imbal1->save();            
        // }
        #endbackup
        // $datasum = DetilPayoutUser::where('pendanaan_id',);
        #backup
        // $get_data = ListImbalUser::where('list_imbal_user.pendanaan_id',$id)
        //                           ->leftJoin('pendanaan_aktif','pendanaan_aktif.id','=','list_imbal_user.pendanaan_id');
        #endbackup
        $get_data = IhListImbalUser::where('ih_detil_imbal_user.pendanaan_id',$id)
                                  ->leftJoin('ih_detil_imbal_user','ih_detil_imbal_user.id','=','ih_list_imbal_user.detilimbaluser_id')
                                  ->leftJoin('ih_pendanaan_aktif','ih_pendanaan_aktif.id','=','ih_detil_imbal_user.pendanaan_id');
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
        #backup
    //   $dataTable = Log_Imbal_User::where('log_imbal_user.investor_id',$user->id)
    //                              ->leftJoin('proyek','proyek.id','=','log_imbal_user.proyek_id')
    //                              ->leftJoin('pendanaan_aktif','pendanaan_aktif.id','=','log_imbal_user.pendanaan_id')
    //                              ->select(DB::raw('SUM(nominal) as total'),'proyek.nama','proyek.tgl_mulai','pendanaan_aktif.tanggal_invest','pendanaan_aktif.total_dana')
    //                              ->whereNotIn('log_imbal_user.keterangan',['Dana Pokok'])
    //                              ->groupBy('log_imbal_user.pendanaan_id')
    //                              ->orderBy('proyek.id','DESC')
    //                              ->get();
        #endbackup
      $dataTable = IhlistIMbalUser::where('ih_pendanaan_aktif.investor_id',$user->id)
                                    ->join('ih_detil_imbal_user','ih_detil_imbal_user.id','=','ih_list_imbal_user.detilimbaluser_id')
                                    ->join('ih_pendanaan_aktif','ih_pendanaan_aktif.id','=','ih_detil_imbal_user.pendanaan_id')
                                    ->join('proyek','proyek.id','=','ih_detil_imbal_user.proyek_id')
                                    ->select(DB::raw('SUM(imbal_payout) as total'),'proyek.nama','proyek.tgl_mulai','ih_pendanaan_aktif.tanggal_invest','ih_pendanaan_aktif.total_dana')
                                    ->whereNotIn('ih_list_imbal_user.keterangan_payout',[3])
                                    ->whereNotIn('ih_list_imbal_user.status_payout',[1])
                                    ->groupBy('ih_list_imbal_user.detilimbaluser_id')
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

}
