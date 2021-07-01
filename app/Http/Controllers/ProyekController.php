<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Proyek;
use App\GambarProyek;

use App\DetilImbalUser;
use App\ListImbalUser;
use App\Log_Imbal_User;
use App\deskripsi_proyek;
use App\legalitas_proyek;
use App\pemilik_proyek;
use App\simulasi_proyek;
use App\PendanaanAktif;
use App\Investor;
use App\Marketer;
use App\HariLibur;
use App\AuditTrail;
use DateTime;
use DatePeriod;
use DateInterval;


use Excel;
use App\Exports\MutasiInvestorProyek;
use App\Exports\DetilByProyek;
use App\Exports\DetilProyekExport;
use App\Exports\DetilByDate;
use App\Exports\PayoutExport;
// use Maatwebsite\Excel\Facades\Excel;

use App\PemilikPaket;
use App\RekeningInvestor;
use App\Tindikator;
use App\Http\Middleware\UserCheck;
use App\ProgressProyek;
use App\ManageCarousel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use function GuzzleHttp\json_encode;
use Cart;
use Auth;
use App;
use DB;
use App\LogPengembalianDana;
use App\MutasiInvestor;
use App\Events\MutasiInvestorEvent;
// use App\Jobs\KembaliDana;
use App\eListimbalhasil;
use App\News;
use App\Exports\PayoutDate;
use App\Exports\ProyekAllData;
use App\Exports\ListImbalUserExport;
use App\Http\Middleware\NotifikasiProyek;
use App\Http\Middleware\StatusProyek;
use App\TmpSelectedProyek;
use App\TermCondition;
use App\TestimoniPendana;
use App\Mail\KembaliDanaEmail;
use Mail;


class ProyekController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['userfeed']);
        $this->middleware(UserCheck::class)->only(['userfeed']);
        $this->middleware('auth:admin')->only(['admin_create', 'admin_manage','download_all', 'admin_mutasi', 'admin_update_post','manage_payout','admin_create_post', 'admin_progress_post','admin_detil_manage','admin_detil_payout','proyek_eksport_view','get_eksport_data','admin_proyek_finish','get_data_list_investor','dana_kembali','get_export_by_proyek','kirim_imbal_hasil','update_imbal_hasil','change_status_return','detil_month_payout','manage_payout_data','detil_payout','detil_payout_user','keterangan_libur','cetak_data_payout','hari_libur']);
        // $this->middleware(NotifikasiProyek::class);
        $this->middleware(StatusProyek::class);
    }

    public function index(){
        $carousel = ManageCarousel::all();
        if (!empty($carousel[0]->gambar)){$carousel_pertama = $carousel[0]->gambar;} else {$carousel_pertama = 0;}
        if (!empty($carousel[1]->gambar)){$carousel_kedua = $carousel[1]->gambar;} else {$carousel_kedua = 0;}
        if (!empty($carousel[2]->gambar)){$carousel_ketiga = $carousel[2]->gambar;} else {$carousel_ketiga = 0;}

        if(Tindikator::count() == 0){
            DB::select("CALL proc_tindikator()");
        }
            $data = Tindikator::orderby('id','DESC')->first();
            $jumlah_investor        = $data->jumlah_investor;
            $dana_crowd             = $data->dana_crowd;
            $jumlah_marketer        = $data->jumlah_marketer;
            $jumlah_proyek_aktif    = $data->jumlah_proyek_aktif;
            $dana_pinjaman          = $data->dana_pinjaman;
            $dana_pinjaman_2        = $data->dana_pinjaman_2;
            $dana_crowd_2           = $data->dana_crowd_2;
            $dana_pinjaman_3        = $data->dana_pinjaman_3;
            $dana_crowd_3           = $data->dana_crowd_3;
            $proyek_borrower        = $data->proyek_borrower;
            $proyek_borrower_aktif  = $data->proyek_borrower_aktif;
            $total_biaya            = $data->total_biaya;
            $proyek_selesai         = $data->proyek_selesai;
            $dana_proyek_selesai    = $data->dana_proyek_selesai;
            $total_imbal_hasil      = $data->total_imbal_hasil;
        

        $proyek = Proyek::where('status','!=',4)
                        ->limit(6)
                        ->orderBy('status','asc')
                        ->orderBy('profit_margin','desc')->get(
                          [
                            'proyek.*',
                          ]
                        );

        // news
        $news = News::orderBy('id','desc')->limit(3)->get();
        if (\Request::ajax()) {
            return response()->json(view('includes.news')->with(['news'=>$news])->render());
        }
        // end news

        $getskinvestor = TermCondition::where('typesyarat','1')->first();
        $getskborrower = TermCondition::where('typesyarat','2')->first();
        if($getskinvestor == NULL || $getskborrower == NULL){
            $skinvestor = "-";
            $skborrower = "-";
        }else{
            $skinvestor = $getskinvestor->deskripsi;
            $skborrower = $getskborrower->deskripsi;
        }

        $testimoni = TestimoniPendana::all()->where('type','==',1);
        return view('pages.guest.welcome')->with(['proyek' => $proyek, 'carousel_pertama' => $carousel_pertama, 'carousel_kedua' => $carousel_kedua, 'carousel_ketiga' => $carousel_ketiga,'jumlah_investor'=>$jumlah_investor,'dana_crowd'=>$dana_crowd,'jumlah_marketer'=>$jumlah_marketer,'jumlah_proyek_aktif'=>$jumlah_proyek_aktif,'dana_pinjaman'=>$dana_pinjaman,'dana_pinjaman_2'=>$dana_pinjaman_2,'dana_crowd_2'=>$dana_crowd_2,'dana_pinjaman_3'=>$dana_pinjaman_3,'dana_crowd_3'=>$dana_crowd_3,'borrower_all'=>$proyek_borrower,'borrower_aktif'=>$proyek_borrower_aktif,'total_biaya'=>$total_biaya,'proyek_selesai'=>$proyek_selesai,'dana_proyek_selesai'=>$dana_proyek_selesai,'total_imbal_hasil'=>$total_imbal_hasil,'news'=>$news, 'skinvestor'=>$skinvestor, 'skborrower'=>$skborrower,'testimoni' => $testimoni]);
    }

    public function multiLang($locale){
        // dd($locale);
        session(['locale' => $locale]);

        return redirect()->back();
    }

    // private function update_status($id){

    //     $data_proyek = Proyek::where('id',$id)->first();
    //     $dana = $data_proyek['total_need'];
    //     $terkumpul = $data_proyek['terkumpul'];
    //     $status = $data_proyek['status'];
    //     // $tanggal = $data_proyek['tgl_mulai'];
    //     $tanggal_p = Carbon::parse($data_proyek['tgl_selesai_penggalangan'])->format('Y-m-d 23:59:59');

    //     // echo $tanggal_p;die;

    //     $data_pendana = PendanaanAktif::where('proyek_id',$id)->sum('nominal_awal');
    //     // $all_dana_2;die;
    //     $dana_all = $data_pendana + $terkumpul;
    //     $time = Carbon::now()->format('Y-m-d H:i:s');
    //     // echo $time;die;
    //     // echo 'dana semua = '.$dana_all. 'dana = '.$dana;die;

    //         // if($status == 2 && $status == 3)
    //         // {

    //         // }
    //         // else
    //         // {

    //             if($time > $tanggal_p){
    //                 $data_proyek->status = 2;
    //                 // echo $data_proyek->status;die;
    //                 $data_proyek->save();
    //             }
    //             elseif($dana_all == $dana || $dana_all > $dana ){
    //                 $data_proyek->status = 3;
    //                 // echo $data_proyek->status;die;
    //                 $data_proyek->save();

    //             }
    //             elseif($dana_all > 0){
    //                 $data_proyek->status = 1;
    //                 // echo $data_proyek->status;die;
    //                 $data_proyek->save();
    //             }
    //             else{
    //                 $data_proyek->status = 1;
    //                 // echo $data_proyek->status;die;
    //                 $data_proyek->save();

    //             }

    //         // }
    // }

    public function detil($id){
        $detil = Proyek::where('proyek.id', $id)
                        ->leftJoin('deskripsi_proyeks','deskripsi_proyeks.id','=','proyek.id_deskripsi')
                        ->leftJoin('legalitas_proyeks','legalitas_proyeks.id','=','proyek.id_legalitas')
                        ->leftJoin('pemilik_proyeks','pemilik_proyeks.id','=','proyek.id_pemilik')
                        ->leftJoin('simulasi_proyeks','simulasi_proyeks.id','=','proyek.id_simulasi')
                        ->first();
        $terkumpul = $detil['terkumpul'];
        $total = $detil['total_need'];
        // echo $total;die;
        $data_pendana = PendanaanAktif::where('proyek_id',$id)->get();
        $all_aktif = 0 ;
        foreach($data_pendana as $d){
            $all_aktif += $d['nominal_awal'];
        }
        // echo $all_dana;die;

        $semua = $all_aktif + $terkumpul;

        // echo $great;die;
        $images = GambarProyek::where('proyek_id','=',$id)->get();
        $data = ProgressProyek::where('proyek_id','=',$id)->get();

        return view('pages.guest.detail_project',compact('detil','data','images','semua','data_pendana'));
    }

    public function showall(){
        $proyeks = Proyek::whereRaw('status = 1')->orderBy('id','DESC')->paginate(6);

        return view('pages.guest.penggalanganBerlangsung')->with('proyeks', $proyeks);
    }

    public function showallFull(){
        $proyeks = Proyek::whereRaw('status = 3')->orderBy('id', 'desc')->paginate(6);

        return view('pages.guest.penggalanganFull')->with('proyeks', $proyeks);
    }

    public function showallClosed(){
        $proyeks = Proyek::whereRaw('status = 2')->orderBy('id', 'desc')->paginate(6);

        return view('pages.guest.penggalanganClosed')->with('proyeks', $proyeks);
    }

    public function userfeed(){
        $proyek = Proyek::where('status',1)->orderBy('profit_margin', 'desc')->get();

        $total = RekeningInvestor::where('investor_id', Auth::user()->id)->first();

        return view('pages.user.investation_feed')->with('proyek', $proyek)->with('total', $total);
    }

    public function userSelectedProyek(){
        
        return view('pages.user.selected_proyek');

    }

    public function admin_create(){
        return view('pages.admin.proyek_create');

    }
    public function admin_manage(){


        return view('pages.admin.proyek_manage');

    }

    public function download_all()
    {
        $date = Carbon::now()->format('d-m-Y');
        return Excel::download(new ProyekAllData, 'Proyek All Data -'.$date.'.xlsx');        
    }

    public function admin_detil_proyek($id){

        $data = Proyek::where('id',$id);
        // var_dump($data);die;
        return response()->json($data);

    }

    public function admin_mutasi(){
        $proyeks = Proyek::all();


        return view('pages.admin.proyek_mutasi')->with('proyeks', $proyeks);

    }

    public function admin_get_manage(){
        $getdata = DB::raw("(SELECT proyek_id, count(*) AS total FROM pendanaan_aktif WHERE status = 1 GROUP BY proyek_id) as total_proyek");
        $proyeks = Proyek::leftJoin($getdata,'proyek_id', '=', 'id')->get();
        // $id = $proyeks['id'];
        $response = ['data' => $proyeks];
        // var_dump($response);die;
        return response()->json($response);
    }

    public function admin_detil_manage($id){
        // proyek get
        $proyeks = Proyek::leftJoin('deskripsi_proyeks','deskripsi_proyeks.id','=','proyek.id_deskripsi')
                            ->leftJoin('legalitas_proyeks','legalitas_proyeks.id','=','proyek.id_legalitas')
                            ->leftJoin('pemilik_proyeks','pemilik_proyeks.id','=','proyek.id_pemilik')
                            ->leftJoin('simulasi_proyeks','simulasi_proyeks.id','=','proyek.id_simulasi')
                            ->leftJoin('pemilik_paket','pemilik_paket.proyek_id','=','proyek.id')
                            ->where('proyek.id','=',$id)
                            ->first([
                                'proyek.id',
                                'proyek.nama',
                                'proyek.alamat',
                                'proyek.geocode',
                                'proyek.profit_margin',
                                'proyek.total_need',
                                'proyek.harga_paket',
                                'proyek.akad',
                                'proyek.tgl_mulai',
                                'proyek.tgl_selesai',
                                'proyek.tgl_mulai_penggalangan',
                                'proyek.tgl_selesai_penggalangan',
                                'proyek.terkumpul',
                                'proyek.status',
                                'proyek.status_tampil',
                                'proyek.waktu_bagi',
                                'proyek.tenor_waktu',
                                'proyek.embed_picture',
                                'proyek.id_deskripsi',
                                'deskripsi_proyeks.deskripsi',
                                'legalitas_proyeks.deskripsi_legalitas',
                                'pemilik_proyeks.deskripsi_pemilik',
                                'simulasi_proyeks.deskripsi_simulasi',
                                'pemilik_paket.nama_pemilik',
                                'pemilik_paket.email_pemilik',
                                'pemilik_paket.phone_pemilik']);
        // echo $proyeks;die;
        // gambar get
        $gambars = GambarProyek::where('proyek_id',$id)
                                ->get();


        $response = ['data_proyek' => $proyeks , 'data_gambar' => $gambars ];

        return response()->json($response);
    }

    public function admin_progres_manage($id){
        // progres get
        $progress = ProgressProyek::where('proyek_id',$id)
                                ->get();

        $response = ['data_progress' => $progress];

        return response()->json($response);
    }
    public function admin_get_manage_imbal(){
        // $getdata = DB::raw("(SELECT proyek_id, count(*) AS total FROM pendanaan_aktif WHERE status = 1 GROUP BY proyek_id) as total_proyek");
        // $datetampil = "DATE_ADD(DATE(NOW()), INTERVAL -7 DAY)";
        // $proyeks = Proyek::orderBy('proyek.id','DESC')->leftJoin($getdata,'proyek_id', '=', 'id')->whereIn('proyek.status',[2,3,4])->where('proyek.tgl_selesai','>=',$datetampil)->get();
        $proyeks = DB::SELECT("select * from `proyek` left join (SELECT proyek_id, count(*) AS total FROM pendanaan_aktif WHERE status = 1 GROUP BY proyek_id) as total_proyek on `proyek_id` = `id` where `proyek`.`status` in (2, 3, 4) and `proyek`.`tgl_selesai` >= DATE_ADD(DATE(NOW()), INTERVAL -7 DAY) order by `proyek`.`id` DESC");
        // $id = $proyeks['id']; ->where('proyek.tgl_mulai','<=', Carbon::now()->toDateString())
        // $proyeks = Proyek::orderBy('proyek.id','DESC')->leftJoin($getdata,'proyek_id', '=', 'id')->get();

        // ->whereIn('status',[2,3])

        // $id = $proyeks['id']; ->where('proyek.tgl_mulai','<', Carbon::now()->toDateString())
        $response = ['data' => $proyeks];
        // var_dump($response);die;
        return response()->json($response);
    }

    public function manage_payout_data(){
        return view('pages.admin.proyek_payout');
    }

    public function detil_payout($id)
    {
        $ceck_data = PendanaanAktif::where('pendanaan_aktif.proyek_id',$id)
                                 ->where('pendanaan_aktif.status', '1')
                                 ->get();
        // var_dump($ceck_data);
        foreach($ceck_data as $item)
        {
            $this->manage_payout($item['proyek_id']);

        }
        $getdata = PendanaanAktif::where('pendanaan_aktif.proyek_id',$id)
                                 ->leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                                 ->leftjoin('m_bank', function ($join) {
                                    $join->on('detil_investor.bank_investor', '=', 'm_bank.kode_bank')
                                         ->select('nama_bank');
                                 })
                                 ->where('pendanaan_aktif.status', '1')
                                 ->groupBy('pendanaan_aktif.id')
                                 ->orderBy('detil_investor.nama_investor', 'ASC')
                                 ->select([
                                     'pendanaan_aktif.id',
                                     'pendanaan_aktif.investor_id',
                                     'detil_investor.nama_investor',
                                     'detil_investor.nama_pemilik_rek',
                                     'm_bank.nama_bank',
                                     'detil_investor.rekening',
                                     'pendanaan_aktif.tanggal_invest',
                                     'pendanaan_aktif.total_dana'
                                 ])
                                 ->get();
        $response = ['data' => $getdata];

        return response()->json($response);
    }

    public function detil_payout_user($id)
    {
        $data = DetilImbalUser::where('pendanaan_id',$id)
                               ->select(
                                   'investor_id',
                                   'total_imbal',
                                   'total_dana',
                                   'proposional',
                                   'sisa_imbal'
                               )
                               ->first();
        $sum = ListImbalUser::where('pendanaan_id',$id)->sum('imbal_payout');
        // echo $sum;die;
        $response = [
               'data' => $data,
               'sum' => $sum,
        ];

        return response()->json($response);
    }

    public function admin_detil_payout($id){
        $gettenor = Proyek::where('id', $id)->first()->tenor_waktu;
        $getuser = PendanaanAktif::where('proyek_id', $id)->get();
        $jmlpayoutuser = count($getuser);
        if(count($getuser) > 0 ){
            for($gtu = 0;$gtu<$jmlpayoutuser;$gtu++){
                // cek apakah sih dan dp exist
                $querycek = ListImbalUser::where('proyek_id',$id)->where('pendanaan_id', $getuser[$gtu]->id)->where('total_dana','>=',1000000)->groupBy('tanggal_payout')->orderBy('id', 'DESC'); 
                $nominal = DetilImbalUser::where('proyek_id',$id)->where('pendanaan_id', $getuser[$gtu]->id)->first();
                // var_dump($nominal);
                $cek = $querycek->get();
                $lastpay = $querycek->first();
                $lastpaid = $lastpay['tanggal_payout'];
                $tglplustujuh = date('Y-m-d', strtotime($lastpaid. ' + 7 days'));
                // echo count($cek);echo "#";
                if(count($cek) == $gettenor){
                    //artinya masih data lama tidak punya row sih dan dana pokok
                    // echo "sama";
                    $list_imbal = new ListImbalUser;
                    $list_imbal->proyek_id = $getuser[$gtu]->proyek_id;
                    $list_imbal->pendanaan_id = $getuser[$gtu]->id;
                    $list_imbal->investor_id = $getuser[$gtu]->investor_id;
                    $list_imbal->tanggal_payout = $tglplustujuh;
                    $list_imbal->imbal_payout = $nominal['sisa_imbal'];
                    $list_imbal->total_dana = $nominal['total_dana'];
                    $list_imbal->status_payout = 5;
                    $list_imbal->status_update = NULL;
                    $list_imbal->tgl_update = NULL;
                    $list_imbal->keterangan = '';
                    $list_imbal->status_libur = NULL;
                    $list_imbal->keterangan_libur = '';
                    $list_imbal->ket_weekend = '';
                    $list_imbal->save();

                    $list_imbal1 = new ListImbalUser;
                    $list_imbal1->proyek_id = $getuser[$gtu]->proyek_id;
                    $list_imbal1->pendanaan_id = $getuser[$gtu]->id;
                    $list_imbal1->investor_id = $getuser[$gtu]->investor_id;
                    $list_imbal1->tanggal_payout = $tglplustujuh;
                    $list_imbal1->imbal_payout = $nominal['total_dana'];
                    $list_imbal1->total_dana = $nominal['total_dana'];
                    $list_imbal1->status_payout = 5;
                    $list_imbal1->status_update = NULL;
                    $list_imbal1->tgl_update = NULL;
                    $list_imbal1->keterangan = '';
                    $list_imbal1->status_libur = NULL;
                    $list_imbal1->keterangan_libur = '';
                    $list_imbal1->ket_weekend = '';
                    $list_imbal1->save();
                }elseif(count($cek) > $gettenor){
                    // sudah data baru
                    // echo "beda";
                }
            }
        }
        // echo count($getuser);die();
        // $proyeks = ListImbalUser::where('proyek_id',$id)
        //                           ->where('total_dana','>=',1000000)
        //                           ->groupBy('tanggal_payout')
        //                           ->get();
        // // $proyeks = DB::select("SELECT * FROM `list_imbal_user` WHERE `proyek_id` = 254 AND `total_dana` >= 1000000 AND `imbal_payout` != 0 GROUP BY `tanggal_payout` ");
        // // count($proyeks);var_dump($proyeks->tanggal_payout);die();
        // if(count($proyeks) > 0){
        //     $gettenor = Proyek::where('id', $id)->first()->tenor_waktu;
        //     $getuser = PendanaanAktif::where('proyek_id', $id)->get(); //echo count($getuser);die();
        //     $jmlpayout = count($proyeks);
        //     $jmlpayoutuser = count($getuser);
        //     $lastpayout = $jmlpayout-1;
        //     $tgl_pyt = $proyeks[$lastpayout]->tanggal_payout;
        //     $tglplustujuh = date('Y-m-d', strtotime($tgl_pyt. ' + 7 days'));
        //     if($jmlpayout == $gettenor){
        //         // echo "belum lengkap";
        //         for($gu=0;$gu<$jmlpayoutuser;$gu++){
        //             $list_imbal = new ListImbalUser;
        //             $list_imbal->proyek_id = $getuser[$gu]->proyek_id;
        //             $list_imbal->pendanaan_id = $getuser[$gu]->pendanaan_id;
        //             $list_imbal->investor_id = $getuser[$gu]->investor_id;
        //             $list_imbal->tanggal_payout = $tglplustujuh;
        //             $list_imbal->imbal_payout = $getuser[$gu]->sisa_imbal;
        //             $list_imbal->total_dana = $getuser[$gu]->total_dana;
        //             $list_imbal->status_payout = 5;
        //             $list_imbal->status_update = NULL;
        //             $list_imbal->tgl_update = NULL;
        //             $list_imbal->keterangan = '';
        //             $list_imbal->status_libur = NULL;
        //             $list_imbal->keterangan_libur = '';
        //             $list_imbal->ket_weekend = '';
        //             $list_imbal->save();

        //             $list_imbal1 = new ListImbalUser;
        //             $list_imbal1->proyek_id = $getuser[$gu]->proyek_id;
        //             $list_imbal1->pendanaan_id = $getuser[$gu]->pendanaan_id;
        //             $list_imbal1->investor_id = $getuser[$gu]->investor_id;
        //             $list_imbal1->tanggal_payout = $tglplustujuh;
        //             $list_imbal1->imbal_payout = $getuser[$gu]->total_dana;
        //             $list_imbal1->total_dana = $getuser[$gu]->total_dana;
        //             $list_imbal1->status_payout = 5;
        //             $list_imbal1->status_update = NULL;
        //             $list_imbal1->tgl_update = NULL;
        //             $list_imbal1->keterangan = '';
        //             $list_imbal1->status_libur = NULL;
        //             $list_imbal1->keterangan_libur = '';
        //             $list_imbal1->ket_weekend = '';
        //             $list_imbal1->save();
        //             // echo $gu;
        //         }
        //     }
        // }
        $proyeks_baru = ListImbalUser::where('proyek_id',$id)
                                //   ->where('total_dana','>=',1000000)
                                  ->groupBy('tanggal_payout')
                                  ->get();
        if(count($proyeks_baru) > 0){
            //get row baru
            $getlastid = count($proyeks_baru)-1;
            $getlastidadd = $proyeks_baru[$getlastid]->id;
            $pendanaanid = $proyeks_baru[$getlastid]->pendanaan_id;
            $idadd = $getlastidadd + 1;
            $lastrow = ListImbalUser::where('id',$idadd)->where('pendanaan_id', $pendanaanid)->first();
            
            //tambahkan array
            $proyeks_baru[] = $lastrow;
        }
        // dd($proyeks_baru);
        // echo count($proyeks_baru);
        // dd($lastrow);
        // die();
                            
        $response = ['data_payout' => $proyeks_baru];
        return response()->json($response);
    }

    // public function round_down($value, $decimal_places) {
    //     if ($decimal_places < 0) return ($value);
    //     $pos = strpos($value, '.');
    //     if ($pos === FALSE) return $pos;
    //     return $decimal_places ? substr($value, 0, $pos + $decimal_places + 1) : substr($value, 0, $pos);
    //   }

    public function cek_hari_libur($hari_libur){

        $jumlah_harilibur = HariLibur::select('tgl_harilibur')->get();

        $arr_harilibur = array();
        foreach($jumlah_harilibur as $item){
            $arr_harilibur[]= $item['tgl_harilibur'];
        }

        $hari_tidak_libur = $hari_libur;
        while (in_array($hari_tidak_libur ,$arr_harilibur)) {
            $hari_tidak_libur = date('Y-m-d', strtotime($hari_tidak_libur. ' + 1 days'));
        }

        $hari_tidak_libur_ = strtotime($hari_tidak_libur);
        $nama_hari = date('D', $hari_tidak_libur_);
        $deskripsi_ = HariLibur::select('deskripsi')->where('m_harilibur.tgl_harilibur','=',$hari_libur)->first();
        $deskripsi = $deskripsi_['deskripsi'];

        return $hari_tidak_libur.'^'.$nama_hari.'^'.$deskripsi;
    }

    public function manage_payout($id){

        $data_proyek = Proyek::where('id', $id)->first();
        // var_dump($data_proyek);die();
        $id_proyek = $data_proyek['id'];
        $nm_proyek = $data_proyek['nama'];
        $t_proyek = $data_proyek['tenor_waktu'];
        $s_penggalangan = $data_proyek['tgl_selesai_penggalangan'];
        $margin = $data_proyek['profit_margin'];
        $m_proyek = $data_proyek['tgl_mulai']->toDateString();
        $s_proyek = $data_proyek['tgl_selesai']->toDateString();

        // dd($nm_proyek);
        $period = new DatePeriod(
            new DateTime($m_proyek),
            new DateInterval('P1D'),
            new DateTime($s_proyek)
        );

        // memformate date ke array
        $format = "Y-m-d";
        $formatD = "D";

        // tenor untuk tanggal akhir
        $tenor  = $t_proyek + 1;
        // $Dm_proyek = new DateTime($m_proyek);
        $begin = new DateTime(date('Y-m-d', strtotime($m_proyek. ' + 1 month')));
        $end = new DateTime(date('Y-m-d', strtotime($m_proyek. ' + '.$tenor.' month')));
        $interval = new DateInterval('P1M');
        $dateRange = new DatePeriod($begin, $interval, $end);

        

        $Mrange = array();
        $range = array();
        $ket = array();

        foreach ($dateRange as $date) {
            $Mrange[] = $date->format($format);
            $day[] = $date->format($formatD);
        }
        
        // menambah tanggal payout untuk sisa imbal hasil dan dana pokok
        $lastKey = array_key_last($Mrange);
        $paySisaImbal = date('Y-m-d', strtotime($Mrange[$lastKey]. ' + 7 days'));
        for($das=1;$das<=2;$das++){
            $Mrange[] = $paySisaImbal;
            $day[] = date('D', strtotime($paySisaImbal));
        }
        
        // var_dump($day);var_dump($Mrange);die();

        // melewati hari sabtu dan minggu
        for($b = 0; $b<count($Mrange);$b++){

            $jumlah_harilibur = HariLibur::where('m_harilibur.tgl_harilibur','=',$Mrange[$b])->count();
            if($jumlah_harilibur>0){
                $function_cek_harilibur = $this->cek_hari_libur($Mrange[$b]);
                $harilibur = explode('^', $function_cek_harilibur);
            }

            if($day[$b] == 'Sat'){
                $Mket[$b] = "<font color='red'>Hari sebelumnya bertepatan dengan hari Sabtu</font>";
                $hl =  date('Y-m-d', strtotime($Mrange[$b]. ' + 2 days'));
                $jumlah_harilibur = HariLibur::where('m_harilibur.tgl_harilibur','=',$hl)->count();
                    if($jumlah_harilibur>0){
                        $function_cek_harilibur = $this->cek_hari_libur($hl);
                        $harilibur = explode('^', $function_cek_harilibur);
                        $Mrange[$b] = $harilibur[0];
                    }else{
                        $Mrange[$b] = $hl;
                    }
            }elseif($day[$b] == 'Sun'){
                $Mket[$b] = "<font color='red'>Hari sebelumnya bertepatan dengan hari Minggu</font>";
                $hl = date('Y-m-d', strtotime($Mrange[$b]. ' + 1 days'));
                $jumlah_harilibur = HariLibur::where('m_harilibur.tgl_harilibur','=',$hl)->count();
                    if($jumlah_harilibur>0){
                        $function_cek_harilibur = $this->cek_hari_libur($hl);
                        $harilibur = explode('^', $function_cek_harilibur);
                        $Mrange[$b] = $harilibur[0];
                    }else{
                        $Mrange[$b] = $hl;
                    }
            }elseif($jumlah_harilibur>0 and $harilibur[1] == 'Sat'){
                $Mket[$b] = "<font color='red'>Hari sebelumnya bertepatan dengan hari libur $harilibur[2]</font>";
                $Mrange[$b] = date('Y-m-d', strtotime($harilibur[0]. ' + 2 days'));
            }elseif($jumlah_harilibur>0 and $harilibur[1] == 'Sun'){
                $Mket[$b] = "<font color='red'>Hari sebelumnya bertepatan dengan hari libur $harilibur[2]</font>";
                $Mrange[$b] = date('Y-m-d', strtotime($harilibur[0]. ' + 1 days'));
            }elseif($jumlah_harilibur>0){
                $Mket[$b] = "<font color='red'>Hari sebelumnya bertepatan dengan hari libur $harilibur[2]</font>";
                $Mrange[$b] = $harilibur[0];
            }else{
                $Mrange[$b];
                $Mket[$b] = "";
            }
            $range[] = $Mrange[$b];
            $ket[] = $Mket[$b];
        }

        $delete = PendanaanAktif::where('proyek_id', $id)->where('status',0)->get();

        for($xx=0; $xx < count($delete);$xx++)
        {
            $delete_item = ListImbalUser::where('proyek_id',$delete[$xx]->proyek_id)->where('investor_id',$delete[$xx]->investor_id)->where('status_payout',5)->get();

            for($ax=0;$ax < count($delete_item);$ax++)
            {
                $delete_item[$ax]->delete();
            }

            $delete[$xx]->delete();
        }

        // mengambil data pendana id
        $data = PendanaanAktif::where('proyek_id', $id)->where('status',1)->get();


        $log = ListImbalUser::where('proyek_id',$id)->get();
        $log_check = ListImbalUser::where('proyek_id',$id)
                                    ->groupBy('list_imbal_user.investor_id')
                                    ->get();

        $arrm = array();
        $arrdata = array();
        foreach($data as $item)
        {
            $arrm[] = $item['id'];
            $arrdata[] = $item['total_dana'];
        }
        $arrlog = array();

        foreach($log as $item)
        {
            $arrlog[] = $item['total_dana'];
        }

        $arrs = array();
        foreach($log_check as $item)
        {
            $arrs[] = $item['pendanaan_id'];
        }


        for($x=0; $x < count($data);$x++)
        {
            if(array_diff($arrlog,$arrdata))
            {
                $dana_get = PendanaanAktif::where('investor_id',$data[$x]->investor_id)
                                            ->where('proyek_id',$id_proyek)
                                            ->where('status',1)
                                            ->get();

                for($a=0;$a < count($dana_get);$a++)
                {

                    $update_detil = DetilImbalUser::where('pendanaan_id',$dana_get[$a]->id)
                                                        ->get();

                    if($margin <= 12)
                    {

                            for($c=0;$c < sizeOf($update_detil);$c++)
                            {
                                $date1 = Carbon::parse($s_penggalangan);
                                $date2 = Carbon::parse($data[$x]->tanggal_invest);
                                $resultdate[$a] = $date2->diffInDays($date1);
                                $resulttime[$x] = $resultdate[$a] + 1;

                                // $effektifcal[$x] = (1/30)*$resulttime[$x];

                                // hitung jumlah margin %
                                $propcal[$x] = $margin/12;

                                // hitungjumlah proposional
                                $effektifcal[$x] = ($propcal[$x]/30)*$resulttime[$x];

                                // hitung jumlah perbuan yg didapat
                                $imbalcal[$x] = ($propcal[$x]*$data[$x]->total_dana)/100;

                                // jumlah proposional yg didapat
                                $propres[$x] = ($effektifcal[$x]*$data[$x]->total_dana)/100;



                                $update_detil[$c]->total_dana = floor($dana_get[$a]->total_dana/100)*100;
                                $update_detil[$c]->sisa_imbal = 0;
                                $update_detil[$c]->save();


                            }



                            for($k=0;$k < count($dana_get);$k++)
                            {
                                $log_get = ListImbalUser::where('pendanaan_id',$dana_get[$k]->id)
                                                            ->where('investor_id',$dana_get[$k]->investor_id)
                                                            ->where('status_payout',5)
                                                            ->get();


                                for($i=0;$i < sizeof($log_get);$i++)
                                {

                                    $date1 = Carbon::parse($s_penggalangan);
                                    $date2 = Carbon::parse($dana_get[$k]->tanggal_invest);
                                    $resultdate[$k] = $date2->diffInDays($date1);
                                    $resulttime[$k] = $resultdate[$k]+ 1;

                                    $effektifcal[$k] = (1/30)*$resulttime[$k];
                                    $propcal[$k] = $margin/12;
                                    $imbalcal[$k] = ($propcal[$k]*$dana_get[$k]->total_dana)/100;

                                    $propres[$k] = $effektifcal[$k]*$imbalcal[$k];
                                    // $log_get[$i]->imbal_payout = $y[$k];
                                    $log_get[$i]->imbal_payout = floor($imbalcal[$k]/100)*100;
                                    $log_get[$i]->total_dana = floor($dana_get[$k]->total_dana/100)*100;
                                    $log_get[$i]->status_payout = 5;
                                    $log_get[$i]->keterangan = '';
                                    $log_get[$i]->save();
                                }
                            }

                            $sum[$a] = listimbaluser::where('pendanaan_id',$dana_get[$a]->id)->sum('imbal_payout');

                            $update_total_dana = DetilImbalUser::where('pendanaan_id',$dana_get[$a]->id)->get();

                            for($o=0; $o < sizeOf($update_total_dana);$o++)
                            {
                                $update_total_dana[$o]->total_imbal = floor($sum[$a]/100)*100;
                                $update_total_dana[$o]->save();

                            }

                    }
                    else
                    {

                            for($c=0;$c < sizeOf($update_detil);$c++)
                            {
                                $date1 = Carbon::parse($s_penggalangan);
                                $date2 = Carbon::parse($data[$x]->tanggal_invest);
                                $resultdate[$a] = $date2->diffInDays($date1);
                                $resulttime[$a] = $resultdate[$a]+ 1;
                                $hasil[$a] = (1/30)*$resulttime[$a];
                                $z[$a] = $hasil[$a]*$dana_get[$a]->total_dana/100;
                                $y[$a] =  $dana_get[$a]->total_dana/100;
                                $w[$a] = ($margin/12)*$t_proyek;
                                $q[$a] = ($w[$a]-$t_proyek)*$dana_get[$a]->total_dana;
                                $r[$a] = $q[$a]/100;
                                $update_detil[$c]->total_dana = floor($dana_get[$a]->total_dana/100)*100;
                                $update_detil[$c]->sisa_imbal = floor($r[$a]/100)*100;
                                $update_detil[$c]->save();
                            }



                        for($k=0;$k < count($dana_get);$k++)
                        {
                            $log_get = ListImbalUser::where('pendanaan_id',$dana_get[$k]->id)
                                                        ->where('investor_id',$dana_get[$k]->investor_id)
                                                        ->where('status_payout',5)
                                                        ->get();


                            for($i=0;$i < sizeof($log_get);$i++)
                            {

                                $date1 = Carbon::parse($s_penggalangan);
                                $date2 = Carbon::parse($dana_get[$k]->tanggal_invest);
                                $resultdate[$k] = $date2->diffInDays($date1);
                                $resulttime[$k] = $resultdate[$k]+ 1;
                                $hasil[$k] = (1/30)*$resulttime[$k];
                                $z[$k] = $hasil[$k]*$dana_get[$k]->total_dana/100;
                                $y[$k] =  $dana_get[$k]->total_dana/100;

                                // $log_get[$i]->imbal_payout = $y[$k];
                                $log_get[$i]->imbal_payout = floor($y[$k]/100)*100;
                                $log_get[$i]->total_dana = $dana_get[$k]->total_dana;
                                $log_get[$i]->status_payout = 5;
                                $log_get[$i]->keterangan = '';
                                $log_get[$i]->save();
                            }
                        }

                        $sum[$a] = listimbaluser::where('pendanaan_id',$dana_get[$a]->id)->sum('imbal_payout');

                        $update_total_dana = DetilImbalUser::where('pendanaan_id',$dana_get[$a]->id)->get();

                        for($o=0; $o < sizeOf($update_total_dana);$o++)
                        {
                            $update_total_dana[$o]->total_imbal = floor($sum[$a]/100)*100;
                            $update_total_dana[$o]->save();

                        }


                    // $getProposional = DetilImbalUser::where('pendanaan_id',$data[$x]->id)->first();
                    // // for($gp=0;$gp < sizeOf($getProposional);$gp++)
                    // // {
                    //     $date_prop = $range[0];
                    //     $addProposional = ListImbalUser::where('pendanaan_id',$data[$x]->id)->where('tanggal_payout',$date_prop)->first();

                    //         // for($ap=0; $ap < $addProposional;$ap++)
                    //         // {
                    //             $addProposional->imbal_payout += $getProposional->proposional;
                    //             $addProposional->save();

                    //         // }

                    // // }
                    }
                }
            }
            elseif(array_intersect($arrm,$arrs))
            {

            }
            else
            {

                if( $margin <= 12)
                {

                    $detil_payout = new DetilImbalUser;
                    $date1 = Carbon::parse($s_penggalangan);
                    $date2 = Carbon::parse($data[$x]->tanggal_invest);
                    $resultdate[$x] = $date2->diffIndays($date1);
                    $resulttime[$x] = $resultdate[$x] + 1;

                    // $effektifcal[$x] = (1/30)*$resulttime[$x];

                    // hitung jumlah margin %
                    $propcal[$x] = $margin/12;

                    // hitungjumlah proposional
                    $effektifcal[$x] = ($propcal[$x]/30)*$resulttime[$x];

                    // hitung jumlah perbuan yg didapat
                    $imbalcal[$x] = ($propcal[$x]*$data[$x]->total_dana)/100;

                    // jumlah proposional yg didapat
                    $propres[$x] = ($effektifcal[$x]*$data[$x]->total_dana)/100;


                    $detil_payout->investor_id = $data[$x]->investor_id;
                    $detil_payout->proyek_id = $data[$x]->proyek_id;
                    $detil_payout->pendanaan_id = $data[$x]->id;
                    $detil_payout->total_dana = $data[$x]->total_dana;
                    $detil_payout->total_imbal = floor(($imbalcal[$x]*$t_proyek)/100)*100;
                    $detil_payout->sisa_imbal = '0';
                    $detil_payout->proposional = floor($propres[$x]/100)*100;
                    $detil_payout->save();

                    $lastindex = count($range) - 2;
                        for($a=0;$a < sizeof($range);$a++)
                        {
                            $date1 = Carbon::parse($s_penggalangan);
                            $date2 = Carbon::parse($data[$x]->tanggal_invest);
                            $resultdate[$x] = $date2->diffInDays($date1);
                            $resulttime[$x] = $resultdate[$x] + 1;

                            // $effektifcal[$x] = (1/30)*$resulttime[$x];

                            // hitung jumlah margin %
                            $propcal[$x] = $margin/12;

                            // hitungjumlah proposional
                            $effektifcal[$x] = ($propcal[$x]/30)*$resulttime[$x];

                            // hitung jumlah perbuan yg didapat
                            $imbalcal[$x] = ($propcal[$x]*$data[$x]->total_dana)/100;

                            // jumlah proposional yg didapat
                            $propres[$x] = ($effektifcal[$x]*$data[$x]->total_dana)/100;

                            $payout_new = new ListImbalUser;
                            $payout_new->proyek_id = $id_proyek;
                            $payout_new->pendanaan_id = $data[$x]->id;
                            $payout_new->investor_id =  $data[$x]->investor_id;
                            $payout_new->tanggal_payout = $range[$a];
                            if($a == $lastindex){
                                $payout_new->imbal_payout = '0';
                            }elseif($a == $lastindex+1){
                                $payout_new->imbal_payout = floor($data[$x]->total_dana/100)*100;
                            }else{
                                $payout_new->imbal_payout = floor($imbalcal[$x]/100)*100;
                            }
                            $payout_new->total_dana = floor($data[$x]->total_dana/100)*100;
                            $payout_new->status_payout = 5;
                            $payout_new->keterangan = '';
                            $payout_new->ket_weekend = $ket[$a];
                            $payout_new->save();
                        }


                    $getProposional = DetilImbalUser::where('pendanaan_id',$data[$x]->id)->first();
                    // for($gp=0;$gp < sizeOf($getProposional);$gp++)
                    // {
                        $date_prop = $range[0];
                        $addProposional = ListImbalUser::where('pendanaan_id',$data[$x]->id)->where('tanggal_payout',$date_prop)->first();

                            // for($ap=0; $ap < $addProposional;$ap++)
                            // {
                                // $addProposional->imbal_payout += $getProposional->proposional;
                                $addProposional->save();

                            // }

                    // }



                }
                else
                {

                    $detil_payout = new DetilImbalUser;
                    $date1 = Carbon::parse($s_penggalangan);
                    $date2 = Carbon::parse($data[$x]->tanggal_invest);
                    $resultdate[$x] = $date2->diffInDays($date1);
                    $resulttime[$x] = $resultdate[$x] + 1;
                    $hasil[$x] = (1/30)*$resulttime[$x];
                    $z[$x] = ($hasil[$x]*$data[$x]->total_dana)/100;
                    $y[$x] =  $data[$x]->total_dana/100;

                    $w[$x] = ($margin/12)*$t_proyek;
                    // echo $w[$x];die;
                    $q[$x] = ($w[$x]-$t_proyek)*$data[$x]->total_dana;
                    $r[$x] = $q[$x]/100;

                    $detil_payout->investor_id = $data[$x]->investor_id;
                    $detil_payout->proyek_id = $data[$x]->proyek_id;
                    $detil_payout->pendanaan_id = $data[$x]->id;
                    $detil_payout->total_dana = $data[$x]->total_dana;
                    $detil_payout->total_imbal = floor(($y[$x]*$t_proyek)/100)*100;
                    $si = floor($r[$x]/100)*100;
                    $detil_payout->sisa_imbal = $si;
                    $detil_payout->proposional = floor($z[$x]/100)*100;
                    $detil_payout->save();
                    
                    $lastindex = count($range) - 2;
                    //    var_dump($range);die();
                        for($a=0;$a < sizeof($range);$a++)
                        {
                            $date1 = Carbon::parse($s_penggalangan);
                            $date2 = Carbon::parse($data[$x]->tanggal_invest);
                            $resultdate[$x] = $date2->diffInDays($date1);
                            $resulttime[$x] = $resultdate[$x]+ 1;
                            $hasil[$x] = (1/30)*$resulttime[$x];
                            $z[$x] = ($hasil[$x]*$data[$x]->total_dana)/100;
                            $y[$x] =  $data[$x]->total_dana/100;
                            $r[$x] = $z[$x]+$y[$x];

                            $payout_new = new ListImbalUser;
                            $payout_new->proyek_id = $id_proyek;
                            $payout_new->pendanaan_id = $data[$x]->id;
                            $payout_new->investor_id =  $data[$x]->investor_id;
                            $payout_new->tanggal_payout = $range[$a];
                                if($a == $lastindex){
                                    $payout_new->imbal_payout = $si;
                                }elseif($a == $lastindex+1){
                                    $payout_new->imbal_payout = floor($data[$x]->total_dana/100)*100;
                                }else{
                                    $payout_new->imbal_payout = floor(($y[$x])/100)*100;
                                }
                            $payout_new->total_dana = floor($data[$x]->total_dana/100)*100;
                            $payout_new->status_payout = 5;
                            $payout_new->keterangan = '';
                            $payout_new->ket_weekend = $ket[$a];
                            $payout_new->save();
                        }
                    $getProposional = DetilImbalUser::where('pendanaan_id',$data[$x]->id)->first();
                        // for($gp=0;$gp < sizeOf($getProposional);$gp++)
                        // {
                            $date_prop = $range[0];
                            $addProposional = ListImbalUser::where('pendanaan_id',$data[$x]->id)->where('tanggal_payout',$date_prop)->first();

                                // for($ap=0; $ap < $addProposional;$ap++)
                                // {
                                    // $addProposional->imbal_payout += $getProposional->proposional;
                                    $addProposional->save();

                                // }

                        // }

                }



                }

            }

    }



    public function detil_month_payout(Request $request)
    {
        //cek sisaimbalhasil dan danapokok isExist?
        // echo $request->date_id;die();
        
        if($request->flag_id == 'dp'){
            $daftarinvestor = DB::select("select `list_imbal_user`.`pendanaan_id`, `detil_investor`.`nama_investor`, `list_imbal_user`.`tanggal_payout`, `list_imbal_user`.`imbal_payout`, `detil_imbal_user`.`proposional`, `detil_imbal_user`.`sisa_imbal`, `list_imbal_user`.`total_dana`, `list_imbal_user`.`keterangan`, `list_imbal_user`.`status_payout` from `list_imbal_user` left join `detil_investor` on `detil_investor`.`investor_id` = `list_imbal_user`.`investor_id` left join `detil_imbal_user` on `detil_imbal_user`.`pendanaan_id` = `list_imbal_user`.`pendanaan_id` where `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."'");    
            for($i=0;$i<count($daftarinvestor);$i++){
                if(($i % 2) == 1){
                    $data[]=$daftarinvestor[$i];
                }
            }
        }elseif($request->flag_id == 'sih'){
            $daftarinvestor = DB::select("select `list_imbal_user`.`pendanaan_id`, `detil_investor`.`nama_investor`, `list_imbal_user`.`tanggal_payout`, `list_imbal_user`.`imbal_payout`, `detil_imbal_user`.`proposional`, `detil_imbal_user`.`sisa_imbal`, `list_imbal_user`.`total_dana`, `list_imbal_user`.`keterangan`, `list_imbal_user`.`status_payout` from `list_imbal_user` left join `detil_investor` on `detil_investor`.`investor_id` = `list_imbal_user`.`investor_id` left join `detil_imbal_user` on `detil_imbal_user`.`pendanaan_id` = `list_imbal_user`.`pendanaan_id` where `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."'");    
            for($i=0;$i<count($daftarinvestor);$i++){
                if(($i % 2) == 0){
                    $data[]=$daftarinvestor[$i];
                }
            }
        }else{
            $data = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                               ->where('list_imbal_user.tanggal_payout',$request->date_id)
                               ->leftJoin('detil_investor','detil_investor.investor_id','=','list_imbal_user.investor_id')
                               ->leftJoin('detil_imbal_user','detil_imbal_user.pendanaan_id','=','list_imbal_user.pendanaan_id')
                               ->select([
                                   'list_imbal_user.pendanaan_id',
                                   'detil_investor.nama_investor',
                                   'list_imbal_user.tanggal_payout',
                                   'list_imbal_user.imbal_payout',
                                   'detil_imbal_user.proposional',
                                   'detil_imbal_user.sisa_imbal',
                                   'list_imbal_user.total_dana',
                                   'list_imbal_user.keterangan',
                                   'list_imbal_user.status_payout',
                               ])
                               ->get();
        }
        
        // echo count($data); 
                            //    dd($data);
                            //    die();
        $response = ['data' => $data];
        return response()->json($response);
    }

    public function update_imbal_hasil(Request $request)
    {
        // print_r($request->status_id);die;
        if($request->flag_id == 'dp'){
            $getlog = DB::select("SELECT * FROM list_imbal_user WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' AND `list_imbal_user`.`imbal_payout` = `list_imbal_user`.`total_dana`");
        }elseif($request->flag_id == 'sih'){
            $getlog = DB::select("SELECT * FROM list_imbal_user WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' AND `list_imbal_user`.`imbal_payout` <> `list_imbal_user`.`total_dana`");
        }else{
            $getlog = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                    ->where('list_imbal_user.tanggal_payout',$request->date_id)
                    ->get();
        }
        for($i=0; $i < sizeOf($getlog);$i++)
        {
            $change_status = ListImbalUser::where('id',$getlog[$i]->id)->first();

            $change_status->status_payout = $request->status_id[$i];
            $change_status->keterangan = $request->ket_id[$i];
            $change_status->status_libur = '0';
            $change_status->keterangan_libur = '';
            $change_status->update();
        }

        // get new after update
        if($request->flag_id == 'dp'){
            $getnew = DB::select("SELECT `list_imbal_user`.`id`, `list_imbal_user`.`investor_id`, `list_imbal_user`.`proyek_id`, `list_imbal_user`.`pendanaan_id`, `list_imbal_user`.`imbal_payout`, `list_imbal_user`.`status_payout`, `list_imbal_user`.`keterangan`, `proyek`.`nama` FROM `list_imbal_user` LEFT JOIN `proyek` ON `proyek`.`id` = `list_imbal_user`.`proyek_id` WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' AND `list_imbal_user`.`imbal_payout` = `list_imbal_user`.`total_dana`");
            // dd($getnew);
        }elseif($request->flag_id == 'sih'){
            $getnew = DB::select("SELECT `list_imbal_user`.`id`, `list_imbal_user`.`investor_id`, `list_imbal_user`.`proyek_id`, `list_imbal_user`.`pendanaan_id`, `list_imbal_user`.`imbal_payout`, `list_imbal_user`.`status_payout`, `list_imbal_user`.`keterangan`, `proyek`.`nama` FROM `list_imbal_user` LEFT JOIN `proyek` ON `proyek`.`id` = `list_imbal_user`.`proyek_id` WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' AND `list_imbal_user`.`imbal_payout` <> `list_imbal_user`.`total_dana`");
            // dd($getnew);
        }else{
            $getnew = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                                ->where('list_imbal_user.tanggal_payout',$request->date_id)
                                ->leftJoin('proyek','proyek.id','=','list_imbal_user.proyek_id')
                                ->select([
                                'list_imbal_user.id',
                                'list_imbal_user.investor_id',
                                'list_imbal_user.proyek_id',
                                'list_imbal_user.pendanaan_id',
                                'list_imbal_user.imbal_payout',
                                'list_imbal_user.status_payout',
                                'list_imbal_user.keterangan',
                                'proyek.nama'
                                ])
                                ->get();
        }
    
        $cekprop = ListImbalUser::where('proyek_id',$request->data_id)->distinct()
                                ->select(['tanggal_payout'])->first();

// var_dump($cekprop);
// echo $request->date_id;echo $cekprop->tanggal_payout;

    for($x=0;$x < count($getnew);$x++)
    {
        if($request->status_id[$x] == 4)
        {

            $check_data = MutasiInvestor::where('log_payout_id', $getnew[$x]->id)->first();

            if(empty($check_data))
            {
                $addnew = New MutasiInvestor;
                if($cekprop->tanggal_payout === $request->date_id){
                    $nominal = DB::table('detil_imbal_user')
                    ->where('pendanaan_id', $getnew[$x]->pendanaan_id)
                    ->where('proyek_id', $getnew[$x]->proyek_id)
                    ->first();
                    $jumlahnominal = $nominal->proposional + $getnew[$x]->imbal_payout;
                    $addnew->investor_id = $getnew[$x]->investor_id;
                    $addnew->log_payout_id = $getnew[$x]->id;
                    $addnew->nominal = $jumlahnominal;
                    $addnew->perihal = 'Imbal Hasil dan Proposional Disimpan :'. $getnew[$x]->nama;
                    $addnew->tipe = 'CREDIT';
                    $addnew->save();

                    $addrek = RekeningInvestor::where('investor_id',$getnew[$x]->investor_id)->get();
                        for($a=0;$a < sizeof($addrek);$a++)
                        {
                            // $addrek[$a]->total_dana += $jumlahnominal;
                            $addrek[$a]->unallocated += $jumlahnominal;
                            $addrek[$a]->save();
                        }
                    // echo 'cocok';
                }else{
                    $addnew->investor_id = $getnew[$x]->investor_id;
                    $addnew->log_payout_id = $getnew[$x]->id;
                    $addnew->nominal = $getnew[$x]->imbal_payout;
                    $addnew->perihal = 'Imbal Hasil Disimpan :'. $getnew[$x]->nama;
                    $addnew->tipe = 'CREDIT';
                    $addnew->save();

                    $addrek = RekeningInvestor::where('investor_id',$getnew[$x]->investor_id)->get();
                        for($a=0;$a < sizeof($addrek);$a++)
                        {
                            // $addrek[$a]->total_dana += $getnew[$x]->imbal_payout;
                            $addrek[$a]->unallocated += $getnew[$x]->imbal_payout;
                            $addrek[$a]->save();
                        }
                }

            }
            else
            {

            }
            // die();
        }
    }
        $data = ['sukses' => 'Sukses'];
        return response()->json($data);

    }

    public function kirim_imbal_hasil(Request $request)
    {
        if($request->flag_id == 'dp'){
            $getlog = DB::select("SELECT * FROM list_imbal_user WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' AND `list_imbal_user`.`imbal_payout` = `list_imbal_user`.`total_dana`");
        }elseif($request->flag_id == 'sih'){
            $getlog = DB::select("SELECT * FROM list_imbal_user WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' AND `list_imbal_user`.`imbal_payout` <> `list_imbal_user`.`total_dana`");
        }else{
            $getlog = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                                 ->where('list_imbal_user.tanggal_payout',$request->date_id)
                                 ->get();
        }
        
        // pengecekan bulan pertama
        $cekprop = ListImbalUser::distinct()->where('proyek_id',$request->data_id)
        ->get(['tanggal_payout'])->first();

            for($i=0; $i < count($getlog);$i++){
                    $pay_status = ListImbalUser::where('id',$getlog[$i]->id)->get();

                    for($x=0;$x < sizeof($pay_status);$x++)
                    {
                            if($request->flag_id == 'dp'){
                                $pay_status[$x]->status_payout =  4;
                            }else{
                                $pay_status[$x]->status_payout =  $request->status_id[$x];
                            }
                            $pay_status[$x]->keterangan = $request->ket_id[$x];
                            $pay_status[$x]->status_libur = 0;
                            $pay_status[$x]->keterangan_libur = '';
                            $pay_status[$x]->update();
                    }
                    $log_imbal = New Log_Imbal_User;
                    if($cekprop->tanggal_payout == $request->date_id){

                        $nominal = DB::table('detil_imbal_user')
                        ->where('pendanaan_id', $getlog[$i]->pendanaan_id)
                        ->where('proyek_id', $getlog[$i]->proyek_id)
                        ->first();
                        $log_imbal->investor_id = $getlog[$i]->investor_id;
                        $log_imbal->proyek_id = $getlog[$i]->proyek_id;
                        $log_imbal->pendanaan_id = $getlog[$i]->pendanaan_id;
                        $log_imbal->nominal = $nominal->proposional + $getlog[$i]->imbal_payout;
                        $log_imbal->id_listimbaluser = $getlog[$i]->id;
                        $log_imbal->keterangan = 'imbal hasil + proposional';
                    }else{
                        $log_imbal->investor_id = $getlog[$i]->investor_id;
                        $log_imbal->proyek_id = $getlog[$i]->proyek_id;
                        $log_imbal->pendanaan_id = $getlog[$i]->pendanaan_id;
                        $log_imbal->nominal = $getlog[$i]->imbal_payout;
                        $log_imbal->id_listimbaluser = $getlog[$i]->id;
                        if($request->flag_id == 'dp'){
                            $log_imbal->keterangan = 'Dana Pokok';
                        }elseif($request->flag_id == 'sih'){
                            $log_imbal->keterangan = 'imbal hasil sisa';
                        }else{
                            $log_imbal->keterangan = 'imbal hasil';
                        }
                    }
                    $log_imbal->save();
            }

            // update data asset
            if($request->flag_id == 'dp'){
                $getnew = DB::select("SELECT `list_imbal_user`.`id`, `list_imbal_user`.`investor_id`, `list_imbal_user`.`proyek_id`, `list_imbal_user`.`pendanaan_id`, `list_imbal_user`.`imbal_payout`, `list_imbal_user`.`status_payout`, `list_imbal_user`.`keterangan`, `proyek`.`nama` FROM `list_imbal_user` LEFT JOIN `proyek` ON `proyek`.`id` = `list_imbal_user`.`proyek_id` WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' and `list_imbal_user`.`imbal_payout` = `list_imbal_user`.`total_dana`");
            }elseif($request->flag_id == 'sih'){
                $getnew = DB::select("SELECT `list_imbal_user`.`id`, `list_imbal_user`.`investor_id`, `list_imbal_user`.`proyek_id`, `list_imbal_user`.`pendanaan_id`, `list_imbal_user`.`imbal_payout`, `list_imbal_user`.`status_payout`, `list_imbal_user`.`keterangan`, `proyek`.`nama` FROM `list_imbal_user` LEFT JOIN `proyek` ON `proyek`.`id` = `list_imbal_user`.`proyek_id` WHERE `list_imbal_user`.`proyek_id` = ".$request->data_id." and `list_imbal_user`.`tanggal_payout` = '".$request->date_id."' and `list_imbal_user`.`imbal_payout` <> `list_imbal_user`.`total_dana`");
            }else{
                $getnew = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                                ->where('list_imbal_user.tanggal_payout',$request->date_id)
                                ->leftJoin('proyek','proyek.id','=','list_imbal_user.proyek_id')
                                ->select([
                                'list_imbal_user.id',
                                'list_imbal_user.investor_id',
                                'list_imbal_user.proyek_id',
                                'list_imbal_user.pendanaan_id',
                                'list_imbal_user.imbal_payout',
                                'list_imbal_user.status_payout',
                                'list_imbal_user.keterangan',
                                'proyek.nama'
                                ])
                                ->get();
            }
            
            for($x=0;$x < count($getnew);$x++)
            {
                if($getnew[$x]->status_payout == 4)
                {
                    $check_data = MutasiInvestor::where('log_payout_id', $getnew[$x]->id)->first();

                    if(empty($check_data))
                    {
                        $addnew = New MutasiInvestor;
                        if($cekprop->tanggal_payout === $request->date_id){
                            $nominal = DB::table('detil_imbal_user')
                            ->where('pendanaan_id', $getnew[$x]->pendanaan_id)
                            ->where('proyek_id', $getnew[$x]->proyek_id)
                            ->first();
                            $jumlahnominal = $nominal->proposional + $getnew[$x]->imbal_payout;
                            $addnew->investor_id = $getnew[$x]->investor_id;
                            $addnew->log_payout_id = $getnew[$x]->id;
                            $addnew->nominal = $jumlahnominal;
                            $addnew->perihal = 'Imbal Hasil dan Proposional Disimpan :'. $getnew[$x]->nama;
                            $addnew->tipe = 'CREDIT';
                            $addnew->save();

                            $addrek = RekeningInvestor::where('investor_id',$getnew[$x]->investor_id)->get();
                                for($a=0;$a < sizeof($addrek);$a++)
                                {
                                    // $addrek[$a]->total_dana += $jumlahnominal;
                                    $addrek[$a]->unallocated += $jumlahnominal;
                                    $addrek[$a]->save();
                                }
                            // echo 'cocok';
                        }else{
                            $addnew->investor_id = $getnew[$x]->investor_id;
                            $addnew->log_payout_id = $getnew[$x]->id;
                            $addnew->nominal = $getnew[$x]->imbal_payout;
                            if($request->flag_id == 'dp'){
                                $addnew->perihal = 'Dana Pokok Disimpan'. $getnew[$x]->nama;
                            }else{
                                $addnew->perihal = 'Imbal Hasil Disimpan :'. $getnew[$x]->nama;
                            }
                            $addnew->tipe = 'CREDIT';
                            $addnew->save();

                            $addrek = RekeningInvestor::where('investor_id',$getnew[$x]->investor_id)->get();
                                for($a=0;$a < sizeof($addrek);$a++)
                                {
                                    // $addrek[$a]->total_dana += $getnew[$x]->imbal_payout;
                                    $addrek[$a]->unallocated += $getnew[$x]->imbal_payout;
                                    $addrek[$a]->save();
                                }
                        }

                    }
                    else
                    {

                    }
                    // die();
                }
            }
        $data = ['sukses' => 'Sukses'];
        return response()->json($data);
    }

    public function change_status_return(Request $request)
    {
        $getlog = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                                 ->where('list_imbal_user.tanggal_payout',$request->date_id)
                                 ->get();
        // dd($getlog);

        for($i=0; $i < count($getlog);$i++)
        {
            $pay_status = ListImbalUser::where('proyek_id',$getlog[$i]->proyek_id)
                                         ->where('tanggal_payout',$getlog[$i]->tanggal_payout)
                                         ->get();
            for($x=0;$x < sizeof($pay_status);$x++)
            {
                $pay_status[$x]->status_payout = 5;
                $pay_status[$x]->keterangan = '';
                $pay_status[$x]->save();
            }
        }

        $getnew = ListImbalUser::where('list_imbal_user.proyek_id',$request->data_id)
                                 ->where('list_imbal_user.tanggal_payout',$request->date_id)
                                 ->get();
        for($x=0;$x < count($getnew);$x++)
        {
            $addnew = MutasiInvestor::where('log_payout_id',$getnew[$x]->id);
            $addnew->delete();
        }

        // for($v=0;$v < count($getnew);$v++)
        // {
        //     $getrek = RekeningInvestor::where('investor_id',$getnew[$v]->investor_id)->get();
        //     for($a=0;$a < count($getrek);$a++)
        //     {

        //         $updaterek = RekeningInvestor::where('investor_id',$getrek[$a]->investor_id)->get();

        //         for($y=0;$y < count($updaterek);$y++)
        //         {
        //             $updaterek[$y]->total_dana = $getrek[$a]->total_dana-$getnew[$v]->imbal_payout;
        //             $updaterek[$y]->unallocated = $getrek[$a]->unallocated-$getnew[$v]->imbal_payout;
        //             $updaterek[$y]->save();
        //         }
        //     }
        // }



        $data = ['sukses' => 'Sukses'];

        return response()->json($data);
    }

    public function exportImbalhasil()
    {
        $nama_file = 'laporan_imbal_'.date('Y-m-d').'xlsx';
        return Excel::download(new PayoutDate, $nama_file);
    }

    public function keterangan_libur(Request $request)
    {
        $data = ListImbalUser::where('list_imbal_user.proyek_id',$request->id)
                             ->where('list_imbal_user.tanggal_payout',$request->date_ket)
                             ->get();

        for($x=0;$x < sizeof($data);$x++)
        {
            $update = ListImbalUser::where('list_imbal_user.proyek_id',$data[$x]->proyek_id)
                                   ->where('list_imbal_user.tanggal_payout',$data[$x]->tanggal_payout)
                                   ->get();

            for($i=0;$i < count($update);$i++)
            {
                $update[$i]->status_libur = 1;
                $update[$i]->keterangan_libur = $request->ket_libur;
                $update[$i]->save();
            }
        }

        $data = ['sukses' => 'Sukses'];
        return response()->json($data);
    }


    public function cetak_data_payout(Request $request)
    {
        $date = $request->date;
        $id_proyek = $request->proyek_id;


        $data_arr = array(
            'id_proyek' => $id_proyek,
            'date' => $date,
        );


        return Excel::download(new ListImbalUserExport($data_arr), 'ImbalHasilUser-'.$date.'.xlsx');
        // return Excel::download(new ListImbalUserExport, 'test.xlsx');
    }

    #exportlistimbaluser
    public function list_imbal_user_export(Request $request)
    {
        echo $request->date;
        echo $request->proyek_id;
        // return Excel::download(new ListImbalUserExport, 'test.xlsx');
    }

    public function admin_create_post(Request $request){

        $deskripsi_proyek = new  Deskripsi_Proyek;
        $deskripsi_proyek->deskripsi = $request->deskripsi;
        $deskripsi_proyek->save();


        $legalitas_proyek = new Legalitas_Proyek;
        $legalitas_proyek->deskripsi_legalitas = $request->legalitas;
        $legalitas_proyek->save();

        $pemilik_deskrip = new Pemilik_Proyek;
        $pemilik_deskrip->deskripsi_pemilik = $request->pemilik_projec;
        $pemilik_deskrip->save();

        $simulasi_proyek = new Simulasi_Proyek;
        $simulasi_proyek->deskripsi_simulasi = $request->simulasi;
        $simulasi_proyek->save();



        $proyek = new Proyek;

        $proyek->nama = $request->nama;
        $proyek->alamat = $request->alamat;
        $proyek->profit_margin = $request->profit_margin;
        $proyek->geocode = $request->geocode;
        $proyek->akad = $request->akad;
        $proyek->total_need = $request->total_need;
        $proyek->harga_paket =  $request->harga_paket;
        $proyek->tgl_mulai = $request->tgl_mulai;
        $proyek->tgl_selesai = $request->tgl_selesai;

        $proyek->tgl_mulai_penggalangan = $request->tgl_mulai_penggalangan;
        $proyek->tgl_selesai_penggalangan = $request->tgl_selesai_penggalangan;

        $proyek->interval = 1;
        $proyek->terkumpul = $request->terkumpul;
        $proyek->status = 1;

        $proyek->status_tampil = $request->status_tampil;
        $proyek->waktu_bagi = $request->waktu_bagi;
        $proyek->tenor_waktu = $request->tenor_waktu;
        $proyek->embed_picture = $request->embed_picture;


        $proyek->id_deskripsi = $deskripsi_proyek->id;
        $proyek->id_legalitas = $legalitas_proyek->id;
        $proyek->id_pemilik = $pemilik_deskrip->id;
        // $proyek->id_simulasi = $simulasi_proyek->id;

        $proyek->save();

        $gambar_utama_path = 'proyek/' . $proyek->id .'/projectpic350x233';
        $proyek->gambar_utama = $this->upload('gambar_utama', $request->gambar_utama, $gambar_utama_path);

        $proyek->save();



        // $pemilik_proyek = new PemilikPaket;

        // $pemilik_proyek->proyek_id = $proyek->id;
        // $pemilik_proyek->nama_pemilik = $request->namapemilik;
        // $pemilik_proyek->email_pemilik = $request->emailpemilik;
        // $pemilik_proyek->phone_pemilik = $request->phonepemilik;
        // $pemilik_proyek->dokumen_terkait = $this->upload('dokumen_terkait',$request->dokumen_terkait_pemilik, 'proyek/' .$proyek->id .'/dokumenterkait' );
        // $pemilik_proyek->save();


        $gambarpath = 'proyek/' . $proyek->id . '/projectpic730x486';
        $i = 1;
        foreach($request->gambar as $gambar){

            $proyek->gambarProyek()->create([
                'gambar' => $this->upload('gambar'.$i ,   $gambar, $gambarpath)
            ]);
            $i = $i+1;
        }

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Proyek";
        $audit->description = "Tambah proyek baru";
        $audit->ip_address =  \Request::ip();
        $audit->save();
        
        return redirect()->route('admin.proyek.manage')->with('createdone', 'Create Proyek success');;
    }

    public function admin_update_post(Request $request){

        if($request->id_deskripsi == 0 || $request->id_deskripsi == null || $request->id_deskripsi == " "){
            $deskripsi_proyek = new  Deskripsi_Proyek;
            $deskripsi_proyek->deskripsi = $request->deskripsi;
            $deskripsi_proyek->save();
        }
        else{
            $deskripsi_proyek = Deskripsi_Proyek::where('id','=',$request->id_deskripsi)->first();
            $deskripsi_proyek->deskripsi = $request->deskripsi;
            $deskripsi_proyek->save();
        }

        if($request->id_legalitas == 0 || $request->id_legalitas == null){
            $legalitas_proyek = new Legalitas_Proyek;
            $legalitas_proyek->deskripsi_legalitas = $request->legalitas;
            $legalitas_proyek->save();
        }else{
            $legalitas_proyek = Legalitas_Proyek::where('id','=',$request->id_legalitas)->first();
            $legalitas_proyek->deskripsi_legalitas = $request->legalitas;
            $legalitas_proyek->save();
        }

        if($request->id_pemilik == 0 || $request->id_pemilik == null){
            $pemilik_deskrip = new Pemilik_Proyek;
            $pemilik_deskrip->deskripsi_pemilik = $request->pemilik_projec;
            $pemilik_deskrip->save();
        }else{
            $pemilik_deskrip = Pemilik_Proyek::where('id','=',$request->id_pemilik)->first();
            $pemilik_deskrip->deskripsi_pemilik = $request->pemilik_projec;
            $pemilik_deskrip->save();
        }
        // if($request->id_simulasi == 0 || $request->id_simulasi == null){
        //     $simulasi_proyek = new Simulasi_Proyek;
        //     $simulasi_proyek->deskripsi_simulasi = $request->simulasi;
        //     $simulasi_proyek->save();
        // }else{
        //     $simulasi_proyek = Simulasi_Proyek::where('id','=',$request->id_simulasi)->first();
        //     $simulasi_proyek->deskripsi_simulasi = $request->simulasi;
        //     $simulasi_proyek->save();

        // }

        $proyek = Proyek::where('id',$request->id)->first();
        // echo $proyek;die;
        $proyek->nama = $request->nama;
        $proyek->alamat = $request->alamat;
        $proyek->profit_margin = $request->profit_margin;
        $proyek->geocode = $request->geocode;
        $proyek->akad = $request->akad;
        $proyek->total_need = $request->total_need;
        $proyek->harga_paket =  $request->harga_paket;
        $proyek->tgl_mulai = $request->tgl_mulai;
        $proyek->tgl_selesai = $request->tgl_selesai;
        $proyek->terkumpul = $request->terkumpul;

        // echo $proyek->terkumpul;die;
        $proyek->status = $request->status_id;
        $proyek->tgl_mulai_penggalangan = $request->tgl_mulai_penggalangan;
        $proyek->tgl_selesai_penggalangan = $request->tgl_selesai_penggalangan;

        $proyek->status_tampil = $request->status_tampil;
        $proyek->waktu_bagi = $request->waktu_bagi;
        $proyek->tenor_waktu = $request->tenor_waktu;
        $proyek->embed_picture = $request->embed_picture;

        $proyek->id_deskripsi = $deskripsi_proyek->id;
        $proyek->id_legalitas = $legalitas_proyek->id;
        $proyek->id_pemilik = $pemilik_deskrip->id;
        // $proyek->id_simulasi = $simulasi_proyek->id;
        $proyek->save();

        // var_dump($proyek->save());die;
        // echo $proyek->gambar_utama;die;

        if(!empty($request->gambar_utama))
        {
          Storage::disk('public')->delete( $proyek->gambar_utama);
          $gambar_utama_path = 'proyek/' . $proyek->id .'/projectpic350x233';
          $proyek->gambar_utama = $this->upload('gambar_utama', $request->gambar_utama, $gambar_utama_path);
          $proyek->save();
        }
        else
        {

        }



        // $pemilik_proyek = PemilikPaket::where('proyek_id',$request->id)->first();

        // $pemilik_proyek->nama_pemilik = $request->namapemilik;
        // $pemilik_proyek->email_pemilik = $request->emailpemilik;
        // $pemilik_proyek->phone_pemilik = $request->phonepemilik;
        // if($request->hasFile('dokumen_terkait_pemilik')){
        //     Storage::disk('public')->delete( $pemilik_proyek->dokumen_terkait);
        //     $pemilik_proyek->dokumen_terkait = $this->upload('dokumen_terkait',$request->dokumen_terkait_pemilik, 'proyek/' .$proyek->id .'/dokumenterkait' );

        // }
        // $pemilik_proyek->save();


        $gambar_proyek = $proyek->gambarProyek;
        if($request->hasFile('gambar')){
            $gambarpath = 'proyek/' . $proyek->id . '/projectpic730x486';
            $i = count($gambar_proyek) + 1;
            foreach($request->gambar as $gambar){
                //
                $proyek->gambarProyek()->create([
                    'gambar' => $this->upload('gambar'.$i ,   $gambar, $gambarpath)
                ]);
                $i += 1;
            }
        }

        
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu = "Kelola Proyek";
        $audit->description = "Ubah proyek";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('updatedone', 'Update Proyek success');
    }

    public function admin_delete_gambarProyek(GambarProyek $id){
        Storage::disk('public')->delete($id);
        $id->delete();

        return redirect()->back();
    }

    public function admin_progress_post(Request $request){
        
        $progress = new ProgressProyek;
        $progress->proyek_id = $request->id_proyek_progress;
        $progress->tanggal = $request->tanggal_progress;
        $progress->deskripsi = $request->progress_textarea;

        $gambar_progress_path = 'proyek/' . $request->id_proyek_progress .'/progress';
        $progress->pic = $this->upload('gambar', $request->gambar_progress, $gambar_progress_path);
        $progress->save();

        return redirect()->route('admin.proyek.manage')->with('progressadd', 'Progress proyek berhasil ditambahkan');

    }

    private function upload($column, $request, $store_path)
    {
            $file = $request;
            $filename = Carbon::now()->toDateString() . $column . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            return $path;


    }

    public function proyek_eksport_view()
    {
        $data = Proyek::all('id','nama');
        // echo $data;die;
        return view('pages.admin.proyek_eksport_manage',compact('data'));
    }

    public function get_export_by_proyek(Request $request)
    {


        $id = $request->id_proyek;
        $tgl_m =$request->tgl_mulai;
        $tgl_s =$request->tgl_selsai;
        // var_dump($data);die;
        $data_arr = array(
            'id' => $id,
            'tgl_m' => $tgl_m,
            'tgl_s' => $tgl_s,
        );
        $date = Carbon::now()->toDateString();

        if($id != null){

            return Excel::download(new DetilByProyek($data_arr), 'Proyek-Export-By-Proyek-'.$id.'-'.$date.'.xlsx');
        }
            elseif($tgl_m != null && $tgl_s != null)
                {
                    return Excel::download(new DetilByDate($data_arr), 'Proyek-By-Date-'.$id.'-'.$date.'.xlsx');
                }
                    else
                    {
                        return Excel::download(new DetilProyekExport, 'Proyek-Export-All-Data-'.$id.'-'.$date.'.xlsx');
                    }

    }




    public function mutasi_investor_proyek(Request $request, $id)
    {
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu= "Kelola Pendana";
        $audit->description = "Unduh Mutasi Proyek";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return Excel::download(new MutasiInvestorProyek($id), 'mutasi_proyek.xlsx');
    }

    public function admin_proyek_finish(){
        return view('pages.admin.proyek_finish');
    }

    public function get_data_finish_proyek(){
        // echo Carbon::now()->format('Y-m-d');die;
        $proyeks = Proyek::leftJoin('pendanaan_aktif','pendanaan_aktif.proyek_id','=','proyek.id')
                    ->where('proyek.tgl_selesai','<=',Carbon::now()->format('Y-m-d'))
                    ->groupBy('proyek.id')
                    ->orderBY('proyek.id')
                    ->get([
                        'proyek.*',
                        DB::raw('count(pendanaan_aktif.investor_id) as jumlah_investor')
                    ]);
        // print_r($proyeks);die;
        $response = ['data_proyek' => $proyeks];

        return response()->json($response);
    }

    public function get_data_list_investor($id){
        $investor = PendanaanAktif::leftJoin('detil_investor','detil_investor.investor_id','=','pendanaan_aktif.investor_id')
                    ->where('pendanaan_aktif.proyek_id',$id)
                    ->where('pendanaan_aktif.status',1)
                    ->orderBy('pendanaan_aktif.id','desc')
                    ->get([
                        'pendanaan_aktif.*',
                        'detil_investor.nama_investor'
                    ]);

        $log_pengembalian = LogPengembalianDana::where('proyek_id',$id)->count();
        $response = ['data_investor' => $investor, 'log_kembali_dana' => $log_pengembalian];

        return response()->json($response);
    }

    public function dana_kembali(Request $request){
        // var_dump($request->investor);die;
        // echo(sizeof($request->investor));die;
        
        for($x = 0;$x < sizeof($request->investor);$x++)
        {

            $user = Investor::where('id',$request->investor[$x])->first();
            $rekening = RekeningInvestor::where('investor_id',$request->investor[$x])->first();
            $rekening->unallocated += $request->dana[$x];

            $rekening->save();

            $log_pengembalian = new LogPengembalianDana();
            $log_pengembalian->proyek_id = $request->id_proyek;
            $log_pengembalian->investor_id = $request->investor[$x];
            $log_pengembalian->nominal = $request->dana[$x];

            $log_pengembalian->save();

            $proyek = Proyek::where('id',$request->id_proyek)->first(['nama']);

            // $mutasi_investor = new MutasiInvestor();
            // $mutasi_investor->investor_id = $request->investor[$x];
            // $mutasi_investor->nominal = $request->dana[$x];
            // $mutasi_investor->perihal = 'Pengembalian Dana Pokok Oleh Admin dari proyek '.$proyek->nama;
            // $mutasi_investor->tipe = 'DEBIT';

            // $mutasi_investor->save();

            $data_email = PendanaanAktif::where('investor_id',$request->investor[$x])->where('proyek_id',$request->id_proyek)->first();
            // dispatch(new KembaliDana($data_email));

            $email = new KembaliDanaEmail($data_email);
            Mail::to($user->email)->send($email);

        }

        $response = ['status' => 'Success'];

        return response()->json($response);
    }

    public function hari_libur(Request $request){

        $delete = HariLibur::truncate();
        

        $API_CEK = 'https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json';

        $client = new Client();
        $res = $client->request('GET', $API_CEK);

        $hari_libur = json_decode($res->getBody());
        $array = json_decode(json_encode($hari_libur), true);

        $data = array();
        foreach ($array as $index => $datas)
        {
            $data[] = ["tgl" => $index,
                       "detail" =>$datas];
        }
        array_pop($data);

        //DIWALI-DEEPAVALI DAN MALAM TAHUN BARU TIDAK MASUK LIBUR NASIONAL
        foreach($data as $key => $datas){

            if($datas['detail']['deskripsi']=='Diwali/Deepavali' or $datas['detail']['deskripsi']=='Malam Tahun Baru'){
                unset($data[$key]);
                $izero = array_values($data);
            }
        }

        for($i=0; $i<sizeof($izero); $i++){

            $hari_libur_save = new HariLibur();
            $thn = substr($izero[$i]['tgl'],0,4);
            $bln = substr($izero[$i]['tgl'],4,2);
            $tgl = substr($izero[$i]['tgl'],6,2);
            $hari_libur_save->tgl_harilibur = $thn.'-'.$bln.'-'.$tgl;
            $hari_libur_save->deskripsi = $izero[$i]['detail']['deskripsi'];
            $hari_libur_save->save();

        }
        
        // DB::select('exec my_stored_procedure("2020-03-01","2020-03-31")');
        $year = date("Y");
        DB::select("CALL generate_sabtuminggu('$year')");
        $data = ['status' => 'Sukses'];
        return response()->json($data);
    }

    // investation_sukuk
    public function registrasisukuk(){
        return view('pages.user.registrasi_sukuk');
    }
    // investation_sukuk_konfirmasi
    public function registrasisukuk_konfirmasi(){
        return view('pages.user.registrasi_sukuk_konfirmasi');
    }
    // investation_sukuk_konfirmasisukses
    public function registrasisukukkonfirmasi_sukses(){
        return view('pages.user.registrasi_sukuk_konfirmasi_sukses');
    }

    // list Sukuk
    public function listsukuk(){
      return view('pages.user.list_sukuk');
    }

    // Early Redemption Sukuk
    public function search_early_redemption_sukuk(){
        return view('pages.user.early_redemption.early_redemption_sukuk');
      }

      // Early Redemption Konfirmasi
    public function search_early_redemption_konfirmasi(){
        return view('pages.user.early_redemption.early_redemption_konfirmasi');
      }
      // Early Redemption Sukses
    public function search_early_redemption_sukses(){
        return view('pages.user.early_redemption.early_redemption_sukses');
      }

    // Sukuk History
    public function history_sukuk(){
    return view('pages.user.sukuk_history.history');
    }

    // Sukuk Portfolio
    public function portfolio_sukuk(){
        return view('pages.user.sukuk_portfolio.portfolio');
        }

    // sukuk landingpage
    public function sukuk(){
      return view('pages.sukuk.st003');
    }

    public function redirect_sukuk(){
      return view('pages.sukuk.index_coming_soon');
    }

    // pesan sukuk
    public function pesansukuk(){
      return view('pages.user.pesan_sukuk');
    }
    // verifikasi pesan sukuk
    public function verifikasipesansukuk(){
      return view('pages.user.verifikasi_pesan_sukuk');
    }
    // payment sukuk
    public function paymentsukuk(){
      return view('pages.user.payment_sukuk');
    }
    public function getOverView_proyek($id){
        //$deskripsi = new 
        //$deskripsi = Deskripsi_proyek::where('id', '=', $id)->get();
        $deskripsi = DB::table('deskripsi_proyeks')->where('id', '=', $id)->get();
        return $deskripsi;
    }
    
    public function getLegalitas_proyek($id){
        $legalitas = DB::table('legalitas_proyeks')->where('id', '=', $id)->get();
        return $legalitas;
    }
    
    public function getPemilik_proyek($id){
        $pemilik = DB::table('pemilik_proyeks')->where('id', '=', $id)->get();
        return $pemilik;
    }

    public function payout7harikedepan($id){
        $today = date("Y-m-d");
        switch ($id) {
            case "0":
                $date = $today;
                break;
            case "1":
                $date = (new DateTime('+1 day'))->format('Y-m-d');
                break;
            case "2":
                $date = (new DateTime('+2 day'))->format('Y-m-d');
                break;
            case "3":
                $date = (new DateTime('+3 day'))->format('Y-m-d');
                break;
            case "4":
                $date = (new DateTime('+4 day'))->format('Y-m-d');
                break;
            case "5":
                $date = (new DateTime('+5 day'))->format('Y-m-d');
                break;
            case "6":
                $date = (new DateTime('+6 day'))->format('Y-m-d');
                break;
            case "7":
                $date = (new DateTime('+7 day'))->format('Y-m-d');
                break;        
            default:
                echo "gagal Men";
        }
        // echo $date;die();
        $payoutseven = DB::select("SELECT proyek.nama, list_imbal_user.tanggal_payout, datediff(list_imbal_user.tanggal_payout,'$today') AS sisa_tanggal FROM proyek INNER JOIN list_imbal_user ON proyek.id = list_imbal_user.proyek_id WHERE tanggal_payout = '$date' GROUP BY proyek.nama ORDER BY list_imbal_user.tanggal_payout ASC");
        $response = ['payoutseven' => $payoutseven];
        return response()->json($response);
    }

    public function finish7harikedepan($id){
        $today = date("Y-m-d");
        switch ($id) {
            case "0":
                $date = (new DateTime('-1 day'))->format('Y-m-d');
                break;
            case "1":
                $date = $today;
                break;
            case "2":
                $date = (new DateTime('+1 day'))->format('Y-m-d');
                break;
            case "3":
                $date = (new DateTime('+2 day'))->format('Y-m-d');
                break;
            case "4":
                $date = (new DateTime('+3 day'))->format('Y-m-d');
                break;
            case "5":
                $date = (new DateTime('+4 day'))->format('Y-m-d');
                break;
            case "6":
                $date = (new DateTime('+5 day'))->format('Y-m-d');
                break;
            case "7":
                $date = (new DateTime('+6 day'))->format('Y-m-d');
                break;        
            default:
                echo "gagal Men";
        }
        $status = array(2,3,4);
        $finishseven = DB::select("SELECT nama, tgl_selesai, datediff(tgl_selesai,'$today') AS sisa_tanggal FROM proyek WHERE status IN ('2', '3', '4') AND tgl_selesai = '$date' ORDER BY id ASC");
        $response = ['finishseven' => $finishseven];
        return response()->json($response);
    }

    public function cetak_payout_mingguan(Request $request){
        $today = date("Y-m-d");
        switch ($request->id) {
            case "0":
                $date = $today;
                break;
            case "1":
                $date = (new DateTime('+1 day'))->format('Y-m-d');
                break;
            case "2":
                $date = (new DateTime('+2 day'))->format('Y-m-d');
                break;
            case "3":
                $date = (new DateTime('+3 day'))->format('Y-m-d');
                break;
            case "4":
                $date = (new DateTime('+4 day'))->format('Y-m-d');
                break;
            case "5":
                $date = (new DateTime('+5 day'))->format('Y-m-d');
                break;
            case "6":
                $date = (new DateTime('+6 day'))->format('Y-m-d');
                break;
            case "7":
                $date = (new DateTime('+7 day'))->format('Y-m-d');
                break;        
            default:
                echo "gagal Men";
        }
        return Excel::download(new PayoutExport($date), 'payoutexport.xlsx');
    }
   
}
