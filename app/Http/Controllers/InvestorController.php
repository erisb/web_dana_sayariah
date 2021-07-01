<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investor;
use App\PenarikanDana;
use App\DetilInvestor;
use App\BniEnc;
use App\MutasiInvestor;
use App\Events\MutasiInvestorEvent;
use App\RekeningInvestor;
use App\Proyek;
use App\PendanaanAktif;
use App\LogPendanaan;
use App\LogPengembalianDana;
use App\LogSuspend;
use App\AuditTrail;
// use App\Subscribe;
use Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
//use App\Jobs\AdminAddPendanaan;

use App\Exports\DetilInvestorExport;
use App\Exports\DanaInvestorProyek;
use Excel;

use GuzzleHttp\Client;
use App\Jobs\InvestorVerif;
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
use DB;
use Validator;
use Image;
use App\Http\Middleware\NotifikasiProyek;
use App\Http\Middleware\StatusProyek;
use App\Mail\AdminAddPendanaanEmail;
use Mail;

class InvestorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    //development
    // private const CLIENT_ID = '805';
    // private const KEY = '34e64c3fe14335eb64f5c1b2d6e75508';
    // private const API_URL = 'https://apibeta.bni-ecollection.com/';


    //production
    private const CLIENT_ID = '757';
    private const KEY = '9f918ff65dc67027fc5670b7b7a7e89f';
    private const API_URL = 'https://api.bni-ecollection.com/';

    public function __construct()
    {
        // $this->middleware('auth:admin',['except' => ['verificationCode']]);
        $this->middleware('auth:admin');
        // $this->middleware(NotifikasiProyek::class);
        $this->middleware(StatusProyek::class);
        
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function admin_verif(){
        
        // $userverif = Investor::where('status', 'pending')->get();
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

        return view('pages.admin.investor_verifikasi',[
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
                    ])/*->with('userverif', $userverif)*/;
    }

    public function get_verifikasi_datatables()
    {
        $verifikasi = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                                ->where('investor.status','pending')
                                ->orderBy('investor.id','desc')
                                ->get([
                                        'investor.id',
                                        'investor.username',
                                        'investor.email',
                                        'investor.password',
                                        'investor.status',
                                        'detil_investor.nama_investor'
                                ]);
        // var_dump($verifikasi);die;
        $response = ['data' => $verifikasi];

        return response()->json($response);
    }

    public function get_mutasi_datatables(Request $request)
    {
        $user = Auth::user();
        if ($request->unallocated == 'yes')
        {
            $mutasi = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                            ->leftJoin('pendanaan_aktif','pendanaan_aktif.investor_id','=','investor.id')
                            ->where('rekening_investor.unallocated','>',0)
                            ->groupBy([
                                'investor.id',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                'rekening_investor.unallocated',
                                ])
                            ->get([
                                'investor.id AS idInvestor',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                DB::raw('(select count(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as total'),
                                DB::raw('(select count(log_pengembalian_dana.proyek_id) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as total_log'),
                                DB::raw('(select sum(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as jumlah_nominal'),
                                DB::raw('(select sum(log_pengembalian_dana.nominal) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as jumlah_nominal_log'),
                                'rekening_investor.unallocated',
                            ]);
        }
        else if ($request->unallocated == 'no')
        {
            $mutasi = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                            ->leftJoin('pendanaan_aktif','pendanaan_aktif.investor_id','=','investor.id')
                            ->where('rekening_investor.unallocated','=',0)
                            ->groupBy([
                                'investor.id',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                
                                'rekening_investor.unallocated',
                                ])
                            ->get([
                                'investor.id AS idInvestor',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                DB::raw('(select count(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as total'),
                                DB::raw('(select count(log_pengembalian_dana.proyek_id) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as total_log'),
                                DB::raw('(select sum(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as jumlah_nominal'),
                                DB::raw('(select sum(log_pengembalian_dana.nominal) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as jumlah_nominal_log'),
                                'rekening_investor.unallocated',
                            ]);
        }
        else if ($request->name != '')
        {
            $mutasi = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                            ->leftJoin('pendanaan_aktif','pendanaan_aktif.investor_id','=','investor.id')
                            ->where('detil_investor.nama_investor','=',$request->name)
                            ->groupBy([
                                'investor.id',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                'rekening_investor.unallocated'
                                ])
                            ->get([
                                'investor.id AS idInvestor',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                DB::raw('(select count(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as total'),
                                DB::raw('(select count(log_pengembalian_dana.proyek_id) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as total_log'),
                                DB::raw('(select sum(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as jumlah_nominal'),
                                DB::raw('(select sum(log_pengembalian_dana.nominal) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as jumlah_nominal_log'),
                                'rekening_investor.unallocated',
                            ]);
        }
        else if ($request->username != '')
        {
            $mutasi = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                            ->leftJoin('pendanaan_aktif','pendanaan_aktif.investor_id','=','investor.id')
                            ->where('investor.username','like','%'.$request->username.'%')
                            ->groupBy([
                                'investor.id',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                'rekening_investor.unallocated',
                                ])
                            ->get([
                                'investor.id AS idInvestor',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                DB::raw('(select count(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as total'),
                                DB::raw('(select count(log_pengembalian_dana.proyek_id) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as total_log'),
                                DB::raw('(select sum(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as jumlah_nominal'),
                                DB::raw('(select sum(log_pengembalian_dana.nominal) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as jumlah_nominal_log'),
                                'rekening_investor.unallocated',
                            ]);
        }
        else if ($request->search_email != '')
        {
            $mutasi = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                            ->leftJoin('pendanaan_aktif','pendanaan_aktif.investor_id','=','investor.id')
                            ->where('investor.email','like','%'.$request->search_email.'%')
                            ->groupBy([
                                'investor.id',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                'rekening_investor.unallocated',
                                ])
                            ->get([
                                'investor.id AS idInvestor',
                                'investor.email',
                                'investor.username',
                                'investor.status',
                                'detil_investor.nama_investor',
                                DB::raw('(select count(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as total'),
                                DB::raw('(select count(log_pengembalian_dana.proyek_id) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as total_log'),
                                DB::raw('(select sum(pendanaan_aktif.nominal_awal) from pendanaan_aktif where investor_id = investor.id and status = 1) as jumlah_nominal'),
                                DB::raw('(select sum(log_pengembalian_dana.nominal) from log_pengembalian_dana where log_pengembalian_dana.investor_id = investor.id group by log_pengembalian_dana.investor_id) as jumlah_nominal_log'),
                                'rekening_investor.unallocated',
                            ]);
        }

        // var_dump($mutasi);die;

        $response = ['data' => $mutasi];

        return response()->json($response);
    }

    public function get_mutasi_proyek(Request $request)
    {
        $id =  $request->id;

        $mutasiproyek = DB::select("SELECT proyek.nama, proyek.alamat, DATE_FORMAT(proyek.tgl_mulai, '%d %M %Y') AS tgl_mulai, DATE_FORMAT(pendanaan_aktif.tanggal_invest, '%d %M %Y') AS tanggal_invest, DATE_FORMAT(proyek.tgl_selesai, '%d %M %Y') AS tgl_selesai,pendanaan_aktif.id AS pendanaanAktifId FROM pendanaan_aktif INNER JOIN proyek ON proyek.id = pendanaan_aktif.proyek_id WHERE investor_id = '$id' GROUP BY proyek_id ASC");

        $response = ['data' => $mutasiproyek];
        return response()->json($response);
    }

    public function get_detil_mutasi_proyek(Request $request)
    {
        $id =  $request->id;

        $detilmutasiproyek = DB::select("SELECT log_pendanaan.tipe, format( log_pendanaan.nominal, 0) AS nominal,  DATE_FORMAT(log_pendanaan.created_at, '%d %M %Y') AS created_at, proyek.nama  FROM log_pendanaan INNER JOIN pendanaan_aktif ON pendanaan_aktif.id = log_pendanaan.pendanaanAktif_id INNER JOIN proyek ON pendanaan_aktif.proyek_id = proyek.id WHERE pendanaanAktif_id = '$id'");

        $response = ['datadetil' => $detilmutasiproyek];
        return response()->json($response);
    }

    public function get_detil_investor($id)
    {
       
        $detil_investor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                                        ->leftJoin('marketer','marketer.ref_code','=','investor.ref_number')
                                        ->leftJoin('detil_marketer','detil_marketer.marketer_id','=','marketer.id')
                                        ->leftJoin('rekening_investor','rekening_investor.investor_id','=','investor.id')
                                        ->where('detil_investor.investor_id',$id)
                                        ->first([
                                            'detil_investor.*',
                                            'investor.keterangan as keteranganSuspend',
                                            'investor.suspended_by as namaSuspended',
                                            'investor.actived_by as namaActived',
                                            "investor.updated_at as tanggalSuspend",
                                            'marketer.ref_code',
                                            'detil_marketer.nama_lengkap as nama_marketer',
                                            'rekening_investor.va_number'
                                        ]);
        $response = ['detil_investor' => $detil_investor];

        return response()->json($response);
    }

    public function get_riwayat_mutasi($id)
    {
        
        $date = Carbon::now()->subDays(30);

        // $data_mutasi_awal = MutasiInvestor::where('investor_id', $id)
        //                                   // ->where('created_at', '<', $date)
        //                                   ->where('perihal', 'not like', '%pengembalian dana pokok%')
        //                                   ->where('perihal', 'not like', '%pengembalian pokok%')
        //                                   ->where('perihal', 'not like', '%sisa imbal hasil%')
        //                                   ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
        //                                   ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
        //                                   ->whereIn('tipe', ['CREDIT', 'DEBIT'])
        //                                   ->get();

        // $data_mutasi = "";
        $data_mutasi = MutasiInvestor::where('investor_id', $id)
                                    //  ->where('created_at','>=', Carbon::now()->subDays(30))
                                     ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                     ->where('perihal', 'not like', '%pengembalian pokok%')
                                     ->where('perihal', 'not like', '%DANA POKOK%')
                                     ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%Akumulasi Keseluruhan Imbal Hasil%')
                                     ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                     ->limit(10)
                                     ->get();
        // dd($data_mutasi);die;
        // dd($data_mutasi);die;
        
        $valuefirst = 0;
        $valuesecond = 0;
        $total = 0;
        $nul = 0;
        $i=0;
        if(!empty($data_mutasi_awal))
        {
            foreach($data_mutasi_awal as $dt_a)
            {
                if($dt_a->tipe == "DEBIT")
                  {
                    $total_first = $dt_a->nominal - $valuefirst;
                    $valuesecond =  $total -= $total_first;
                  }
                  elseif($dt_a->tipe == "CREDIT")
                  {
                    $total_first = $dt_a->nominal + $valuefirst;
                    $valuesecond =  $total += $total_first;
                  }
            }
        }
        if(!empty($data_mutasi))
        {
            $data = array();
            foreach($data_mutasi as $dt)
            {

                $i++;
                $column['Keterangan'] = (string) $dt->perihal;
                $column['Tanggal'] = (string) Carbon::parse($dt->created_at)->format('d-m-Y');
                  if($dt->tipe == "DEBIT")
                  {
                    $total_first = $dt->nominal - $valuefirst;
                    $valuesecond =  $total -= $total_first;

                    $column['Debit'] = (string) number_format($dt->nominal) ;
                    $column['Kredit'] = (string) $nul;                   
                  }
                  elseif($dt->tipe == "CREDIT")
                  {
                    $total_first = $dt->nominal + $valuefirst;
                    $valuesecond =  $total += $total_first;
                    
                    $column['Debit'] = (string) $nul; 
                    $column['Kredit'] = (string) number_format($dt->nominal) ;
                  }
                $column['Saldo'] = (string) number_format($valuesecond) ;

                $data[] = $column;   
            }
        }
        
        $parsingJSON = array("data" => $data);

        // dd($parsingJSON);die;

        echo json_encode($parsingJSON);
    }

    public function get_riwayat_mutasi_date($id, $startDate, $endDate)
    {
        
        $data_mutasi_awal = MutasiInvestor::where('investor_id', $id)
                                          ->where('created_at', '<', $startDate)
                                          ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                          ->where('perihal', 'not like', '%pengembalian pokok%')
                                          ->where('perihal', 'not like', '%sisa imbal hasil%')
                                          ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                          ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                          //    ->orderBy('created_at', 'ASC')
                                          ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                          ->get();
        $data_mutasi = MutasiInvestor::where('investor_id', $id)
                                     ->whereBetween('created_at',[$startDate." 00:00:00", $endDate." 23:59:59"])
                                    //  ->where('created_at', '>=', $startDate)
                                    //  ->where('created_at', '<=',$endDate)
                                     ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                     ->where('perihal', 'not like', '%pengembalian pokok%')
                                     ->where('perihal', 'not like', '%sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%Akumulasi Keseluruhan Imbal Hasil%')
                                     //  ->orderBy('created_at', 'ASC')
                                     ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                     ->get();
        
        $valuefirst = 0;
        $valuesecond = 0;
        $valueLast =0;
        $total = 0;
        $nul = 0;
        $i=0;
         if(!empty($data_mutasi_awal))
         {
             foreach($data_mutasi_awal as $dt_a)
             {
                 if($dt_a->tipe == "DEBIT")
                   {
                     $total_first = $dt_a->nominal - $valuefirst;
                     $valuesecond =  $total -= $total_first;
                   }
                   elseif($dt_a->tipe == "CREDIT")
                   {
                     $total_first = $dt_a->nominal + $valuefirst;
                     $valuesecond =  $total += $total_first;
                   }
             }
         }
        if(!empty($data_mutasi))
        {
            $data = array();
            foreach($data_mutasi as $dt)
            {

                $i++;
                $column['Keterangan'] = (string) $dt->perihal;
                $column['Tanggal'] = (string) Carbon::parse($dt->created_at)->format('d-m-Y');
                  if($dt->tipe == "DEBIT")
                  {
                    $total_first = $dt->nominal - $valuefirst;
                    $valuesecond =  $total -= $total_first;

                    $column['Debit'] = (string) number_format($dt->nominal) ;
                    $column['Kredit'] = (string) $nul;                   
                  }
                  elseif($dt->tipe == "CREDIT")
                  {
                    $total_first = $dt->nominal + $valuefirst;
                    $valuesecond =  $total += $total_first;
                    
                    $column['Debit'] = (string) $nul; 
                    $column['Kredit'] = (string) number_format($dt->nominal) ;
                  }
                $column['Saldo'] = (string) number_format($valuesecond) ;

                $data[] = $column;   
            }
        }
        $parsingJSON = array("data" => $data);

        // dd($parsingJSON);die;

        echo json_encode($parsingJSON);
    }

    public function get_detil_pendanaan($id)
    {
        $detil_pendanaan = Proyek::leftJoin('pendanaan_aktif','pendanaan_aktif.proyek_id','=','proyek.id')
                           ->leftJoin('log_pendanaan','log_pendanaan.pendanaanAktif_id','=','pendanaan_aktif.id')
                           ->where('pendanaan_aktif.investor_id', $id)
                           ->where('pendanaan_aktif.status','=',1)
                           ->whereNotIn('proyek.id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$id.' group by proyek_id')])
                           ->groupBy('pendanaan_aktif.id')
                           ->orderBy('pendanaan_aktif.id','desc')
                           ->get([
                                'proyek.nama',
                                'proyek.tgl_mulai',
                                'pendanaan_aktif.id',
                                'pendanaan_aktif.total_dana',
                                DB::raw('(case when log_pendanaan.tipe = "add new investation" then "investor" when log_pendanaan.tipe = "add active investation" then "investor" when log_pendanaan.tipe = "add active investation by admin" then "admin" else "" end) as tipe_user'),
                                'pendanaan_aktif.tanggal_invest'
                           ]);

        $proyek_selesai = Proyek::leftJoin('log_pengembalian_dana','log_pengembalian_dana.proyek_id','=','proyek.id')
                                ->leftJoin('pendanaan_aktif','pendanaan_aktif.proyek_id','=','log_pengembalian_dana.proyek_id')
                                ->leftJoin('log_pendanaan','log_pendanaan.pendanaanAktif_id','=','pendanaan_aktif.id')
                                ->where('log_pengembalian_dana.investor_id',$id)
                                ->groupBy('log_pengembalian_dana.id')
                                ->orderBy('log_pengembalian_dana.id','desc')
                                ->get([
                                    'proyek.nama',
                                    'proyek.tgl_selesai',
                                    'log_pengembalian_dana.id',
                                    'log_pengembalian_dana.nominal',
                                    // DB::raw('(case when log_pendanaan.tipe = "add new investation" then "investor" when log_pendanaan.tipe = "add active investation by admin" then "admin" else "" end) as tipe_user'),
                                    // 'pendanaan_aktif.tanggal_invest'
                                ]);

        $response = ['data' => $detil_pendanaan,'data_selesai' => $proyek_selesai];

        return response()->json($response);
    }

    public function admin_mutasi(){
        // $investor = Investor::whereIn('status', ['active', 'suspend'])->with('rekeningInvestor')->with('pendanaanAktif')->with('detilInvestor')->with('mutasiInvestor')->get();
        // $proyek = Proyek::where('status', 1)->get();
        
        // return $investor;

        return view('pages.admin.investor_mutasi')/*->with('investor', $investor)->with('proyek', $proyek)*/;
    }

    public function get_nama_autocomplete(Request $request)
    {
        // echo $request->get('query');die;
        if ($request->get('query') != '')
        {
            $query = $request->get('query');
            $data = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->where('detil_investor.nama_investor','LIKE',"%{$query}%")
                            ->orderBy('investor.id','desc')
                            ->get();
            $output = '<ul class="dropdown-menu" style="display:block;position:relative;">';
            foreach($data as $row)
            {
                $output .= '<li>&nbsp;<a href="#">'.$row->nama_investor.'</a>&nbsp;</li>';
            }
            $output .= '</ul>';

            echo $output;
        }
        else
        {
            $output = '';
            echo $output;
        }
    }

    public function data_investor(Request $request)
    {

        if ($request->unallocated == 'yes')
        {
            $cek_data = RekeningInvestor::where('unallocated','>',0)
                                ->orderBy('investor_id','desc')
                                ->count();
        }
        else if ($request->unallocated == 'no')
        {
            $cek_data = RekeningInvestor::where('unallocated','=',0)
                                ->orderBy('investor_id','desc')
                                ->count();
        }
        else if ($request->name != null)
        {
            $cek_data = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->where('detil_investor.nama_investor','=',$request->name)
                            ->orderBy('investor.id','desc')
                            ->count();
        }
        else if ($request->username != null)
        {
            $cek_data = Investor::where('username','like','%'.$request->username.'%')
                            ->orderBy('id','desc')
                            ->count();   
        }
        // else if ($request->name_email != null)
        // {
        //     $cek_data = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
        //                     ->where('detil_investor.nama_investor','like','%'.$request->name_email.'%')
        //                     ->orderBy('investor.id','desc')
        //                     ->count();
        // }
        else if ($request->search_email != null)
        {
            $cek_data = Investor::where('email','like','%'.$request->search_email.'%')
                            ->orderBy('id','desc')
                            ->count();   
        }
        // echo $cek_data;die;

        if ($cek_data != 0)
        {
            $response = ['status' => 'Ada'];
        }
        else
        {
            $response = ['status' => 'Kosong'];   
        }
        
        return response()->json($response);
    }

    public function get_investor_datatables($nama)
    {
        $investor = Investor::leftJoin('detil_investor','detil_investor.investor_id','=','investor.id')
                            ->where('detil_investor.nama_investor','=',$nama)
                            ->orderBy('investor.id','desc')
                            ->get([
                                'investor.id',
                                'investor.username',
                                'investor.email',
                                'investor.status',
                                'detil_investor.nama_investor',
                                'detil_investor.no_ktp_investor',
                                'detil_investor.no_npwp_investor',
                                'detil_investor.pic_investor',
                                'detil_investor.pic_ktp_investor',
                                'detil_investor.pic_user_ktp_investor',
                                'detil_investor.phone_investor',
                                'detil_investor.pasangan_investor',
                                'detil_investor.pasangan_phone',
                                'detil_investor.job_investor',
                                'detil_investor.alamat_investor',
                                'detil_investor.rekening',
                                'detil_investor.bank',
                                'detil_investor.nama_investor',
                            ]);
        $response = ['data' => $investor];

        return response()->json($response);
    }

    public function admin_manage(){
        // $investor = Investor::all();
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

        return view('pages.admin.investor_manage',[
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
                    ])/*->with('investor', $investor)*/;
    }   

    public function admin_requestwithdraw(){
        // $requestwithdraw = PenarikanDana::where('accepted', 0)->get(); 

        return view('pages.admin.investor_withdraw')/*->with('requestwithdraw', $requestwithdraw)*/;
    }

    public function get_req_penarikan_dana_datatables()
    {
        $req = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                            ->leftJoin('detil_investor','detil_investor.investor_id','=','penarikan_dana.investor_id')
                            ->leftJoin('rekening_investor','rekening_investor.investor_id','=','penarikan_dana.investor_id')
                            // ->leftJoin('e_coll_bni','e_coll_bni.no_va','=','rekening_investor.va_number')
                            ->leftJoin(DB::raw("(select * from e_coll_bni group by no_va) data_e_coll"),'data_e_coll.no_va','=','rekening_investor.va_number')
                            ->where('penarikan_dana.accepted', 0)
                            ->orderBy('penarikan_dana.id','desc')
                            ->get([
                                'penarikan_dana.*',
                                'investor.username',
                                'detil_investor.nama_investor',
                                'detil_investor.nama_pemilik_rek',
                                'detil_investor.phone_investor',
                                'rekening_investor.va_number',
                                'data_e_coll.nama'
                            ]);
        
        $response = ['data_req' => $req];

        return response()->json($response);
    }

    public function get_paid_penarikan_dana_datatables(Request $request)
    {
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');
        
        $countPaid = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                ->where('penarikan_dana.accepted', 1)
                                ->orderBy('penarikan_dana.id','desc')
                                ->count();

        if(empty($search))
        {
            $paid = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                        ->where('penarikan_dana.accepted', 1)
                                        ->orderBy('penarikan_dana.id','desc')
                                        ->offset($start)
                                        ->limit($limit) 
                                        ->get([
                                            'penarikan_dana.*',
                                            'investor.username',
                                            'investor.email',
                                        ]);

            $totalFiltered = $countPaid;
        }
        else
        {
            
            $paid = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                            ->where('penarikan_dana.accepted', 1)
                                            ->where('investor.username','LIKE',"%{$search}%")
                                            ->orWhere('investor.email', 'LIKE',"%{$search}%")
                                            ->orderBy('penarikan_dana.id','desc')
                                            ->offset($start)
                                            ->limit($limit)
                                            ->get([
                                                    'penarikan_dana.*',
                                                    'investor.username',
                                                    'investor.email',
                                            ]);
            
            $totalFiltered = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                        ->where('penarikan_dana.accepted', 1)
                                        ->where('investor.username','LIKE',"%{$search}%")
                                        ->orWhere('investor.email', 'LIKE',"%{$search}%")
                                        ->orderBy('penarikan_dana.id','desc')
                                        ->count();
        }

        $array_paid = array();
        for ($i=0;$i<count($paid);$i++)
        {
            $array_paid [$i]['jumlah'] = number_format($paid[$i]['jumlah'], 0, '', '.');
            $array_paid [$i]['no_rekening'] = $paid[$i]['no_rekening'];
            $array_paid [$i]['bank'] = $paid[$i]['bank'];
            $array_paid [$i]['updated_at'] = (string)$paid[$i]['updated_at'];
            $array_paid [$i]['perihal'] = $paid[$i]['perihal'];
            $array_paid [$i]['username'] = $paid[$i]['username'];
            $array_paid [$i]['email'] = $paid[$i]['email'];
        }
        
        $response = ['data_paid' => $array_paid, 'recordsTotal' => intval($countPaid), 'recordsFiltered' => intval($totalFiltered)];

        return response()->json($response);
    }

    public function get_fail_penarikan_dana_datatables(Request $request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');

        $countFail = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                ->where('penarikan_dana.accepted', 2)
                                ->orderBy('penarikan_dana.id','desc')
                                ->count();

        if(empty($search))
        {
            $fail = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                ->where('penarikan_dana.accepted', 2)
                                ->orderBy('penarikan_dana.id','desc')
                                ->offset($start)
                                ->limit($limit) 
                                ->get([
                                    'penarikan_dana.*',
                                    'investor.username',
                                    'investor.email',
                                ]);

            $totalFiltered = $countFail;
        }
        else
        {
            $fail = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                            ->where('penarikan_dana.accepted', 2)
                                            ->where('investor.username','LIKE',"%{$search}%")
                                            ->orWhere('investor.email', 'LIKE',"%{$search}%")
                                            ->orderBy('penarikan_dana.id','desc')
                                            ->offset($start)
                                            ->limit($limit)
                                            ->get([
                                                    'penarikan_dana.*',
                                                    'investor.username',
                                                    'investor.email',
                                            ]);
            
            $totalFiltered = PenarikanDana::leftJoin('investor','investor.id','=','penarikan_dana.investor_id')
                                        ->where('penarikan_dana.accepted', 2)
                                        ->where('investor.username','LIKE',"%{$search}%")
                                        ->orWhere('investor.email', 'LIKE',"%{$search}%")
                                        ->orderBy('penarikan_dana.id','desc')
                                        ->count();
        }

        $array_fail = array();
        for ($i=0;$i<count($fail);$i++)
        {
            $array_fail [$i]['jumlah'] = number_format($fail[$i]['jumlah'], 0, '', '.');
            $array_fail [$i]['no_rekening'] = $fail[$i]['no_rekening'];
            $array_fail [$i]['bank'] = $fail[$i]['bank'];
            $array_fail [$i]['updated_at'] = (string)$fail[$i]['updated_at'];
            $array_fail [$i]['perihal'] = $fail[$i]['perihal'];
            $array_fail [$i]['username'] = $fail[$i]['username'];
            $array_fail [$i]['email'] = $fail[$i]['email'];
        }
        // var_dump($array_fail);die;
        $response = ['data_fail' => $array_fail, 'recordsTotal' => intval($countFail), 'recordsFiltered' => intval($totalFiltered)];

        return response()->json($response);
    }

    public function admin_paidwithdraw(){
        // $requestwithdraw = PenarikanDana::where('accepted', 1)->get(); 

        return view('pages.admin.investor_withdraw_paid');
    }

    public function admin_failedwithdraw(){
        // $requestwithdraw = PenarikanDana::where('accepted', 2)->get();

        return view('pages.admin.investor_withdraw_failed');
    }

    public function admin_verif_ok(Request $request){
        $user = Investor::where('username', $request->username)->first();        
        $hasil = $this->generateVA($request->username);
        if(!$hasil) return redirect()->back()->with('verif_failed', 'Pembuatan VA gagal');

        Investor::where('username', $request->username)->update(['status'=>'active']);
        dispatch(new InvestorVerif($user, 1));
        #pesan verifikasi
        // $kirimverifikasi = $this->verificationCode($user);
        #end pesan verifikasi
        // if($kirimverifikasi) return redirect()->back()->with('verif_ok', 'Verifikasi telah berhasil');
        return redirect()->back()->with('verif_ok', 'Verifikasi telah berhasil');
    }

    public function admin_verif_fail(Request $request){
        $investor = Investor::where('username', $request->username)->first();
        // DetilInvestor::where('investor_id', $investor->id)
        //                 ->delete();

        Investor::where('username', $request->username)
                    ->update(['status'=>'reject']);

        $user = Investor::where('username', $request->username)->first();
        dispatch(new InvestorVerif($user, 0));

        return redirect()->back()->with('verif_failed', 'Verifikasi telah ditolak');
    }

    public function admin_withdraw_ok(Request $request){

        $rekening = RekeningInvestor::where('investor_id', $request->investor_id)->first();
        $rekening->total_dana -= $request->nominal;
        $rekening->unallocated -= $request->nominal;
        $rekening->save();

        PenarikanDana::where('id', $request->id)
                        ->update(['accepted'=> 1]);

        event(new MutasiInvestorEvent($request->investor_id,'DEBIT',$request->nominal,'Penarikan dana selesai'));
         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->menu= "Penarikan Dana";
        $audit->fullname = $username;
        $audit->description = "Konfirmasi permohonan penarikan dana";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.investor.requestwithdraw')->with('withdraw_ok', 'Anda telah melakukan konfirmasi pembayaran ');;
    }

    public function admin_withdraw_fail(Request $request){

        PenarikanDana::where('id', $request->id)
                        ->update(['accepted'=> 2]);

        // event(new MutasiInvestorEvent($request->investor_id,'GAGAL',$request->nominal,'Penarikan dana gagal'));

         
        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu= "Penarikan Dana";
        $audit->description = "Permohonan penarikan dana ditolak";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->route('admin.investor.requestwithdraw')->with('withdraw_fail', 'Anda telah menolak pembayaran ');;
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
            return False;
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
            
            return True;
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }
    
    public function generateVA_new($username){
        
        $now = Carbon::now();
        echo $now->addHours(2);  
        
        // $user = Investor::where('username', $username)->first();
        // $data = [
            // 'type' => 'createbilling',
            // 'client_id' => self::CLIENT_ID,
            // 'trx_id' => $user->id,
            // 'trx_amount' => '0',
            // 'customer_name' => $user->detilInvestor->nama_investor,
            // 'customer_email' => $user->email,
            // 'virtual_account' => '8'.self::CLIENT_ID.$user->detilInvestor->getVa(),
            // 'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            // 'billing_type' => 'o',
        // ];

    
        // $encrypted = BniEnc::encrypt($data,self::CLIENT_ID,self::KEY);

        // $client = new Client(); //GuzzleHttp\Client
        // $result = $client->post(self::API_URL, [
            // 'json' => [
                // 'client_id' => self::CLIENT_ID,
                // 'data' => $encrypted,
            // ]
        // ]);

        // $result = json_decode($result->getBody()->getContents());
        // if($result->status !== '000'){
            // return False;
        // }
        // else{
            // $decrypted = BniEnc::decrypt($result->data,self::CLIENT_ID,self::KEY);
            // //return json_encode($decrypted);
            // $user->RekeningInvestor()->create([
                // 'investor_id' => $user->id,
                // 'total_dana' => 0,
                // 'va_number' => $decrypted['virtual_account'],
                // 'unallocated' => 0,
            // ]);
            
            // return True;
            // // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         // }
    }

    public function admin_create_investor(Request $request) {

        $messages = [
            'error_upload'    => 'Tipe file gambar harus jpeg,jpg,bmp,png dan ukuran file gambar max 500 KB',
        ];

        $validator = Validator::make($request->all(), [
            'pic_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
            'pic_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
            'pic_user_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($messages);
                        // ->withInput();
        }
        else
        {
            if(Investor::where('email', $request->email)->exists() || Investor::where('username', $request->username)->exists()){
                return redirect()->back()->with('exist', "Username or Email already exist");
            }
            $user = Investor::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verif' => null,
                'status'=>'active',
            ]);   
            
            $detil = new DetilInvestor;
            if ($request->tipe_pengguna == 1)
            {
                $detil->investor_id = $user->id;
                $detil->tipe_pengguna = $request->tipe_pengguna;
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
                $detil->status_kawin_investor = $request->kawin;
                $detil->status_rumah_investor = $request->pemilik_rumah;
                $detil->agama_investor = $request->agama;
                $detil->pekerjaan_investor = $request->pekerjaan;
                $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
                $detil->online_investor = $request->pekerjaan_online;
                $detil->pendapatan_investor = $request->pendapatan;
                $detil->asset_investor = null;
                $detil->pengalaman_investor = $request->pengalaman;
                $detil->pendidikan_investor = $request->pendidikan;
                $detil->bank_investor = $request->bank;
                $detil->rekening = $request->rekening;
                // $detil->job_investor = $request->job_investor;     
                $detil->pic_investor = $this->upload('pic_investor', $request, $user->id);
                $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, $user->id);
                $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, $user->id);
                $detil->jenis_badan_hukum = null;
                $detil->nama_perwakilan = null;
                $detil->no_ktp_perwakilan = null;

                if ($request->kawin == 1)
                {
                    $detil->pasangan_investor = $request->nama_pasangan;
                    $detil->pasangan_email = $request->email_pasangan;
                    $detil->pasangan_tempat_lhr = $request->tempat_lahir_pasangan;
                    $detil->pasangan_tgl_lhr = $request->tgl_lahir_pasangan.'-'.$request->bln_lahir_pasangan.'-'.$request->thn_lahir_pasangan;
                    $detil->pasangan_jenis_kelamin = $request->jenis_kelamin_pasangan;
                    $detil->pasangan_ktp = $request->no_ktp_pasangan;
                    $detil->pasangan_npwp = $request->no_npwp_pasangan;
                    $detil->pasangan_phone = $request->no_telp_pasangan;
                    $detil->pasangan_alamat = $request->alamat_pasangan;
                    $detil->pasangan_provinsi = $request->provinsi_pasangan;
                    $detil->pasangan_kota = $request->kota_pasangan;
                    $detil->pasangan_kode_pos = $request->kode_pos_pasangan;
                    $detil->pasangan_agama = $request->agama_pasangan;
                    $detil->pasangan_pekerjaan = $request->pekerjaan_pasangan;
                    $detil->pasangan_bidang_pekerjaan = $request->bidang_pekerjaan_pasangan;
                    $detil->pasangan_online = $request->pekerjaan_online_pasangan;
                    $detil->pasangan_pendapatan = $request->pendapatan_pasangan;
                    $detil->pasangan_pengalaman = $request->pengalaman_pasangan;
                    $detil->pasangan_pendidikan = $request->pendidikan_pasangan;
                }
                else
                {
                    $detil->pasangan_investor = null;
                    $detil->pasangan_email = null;
                    $detil->pasangan_tempat_lhr = null;
                    $detil->pasangan_tgl_lhr = null;
                    $detil->pasangan_jenis_kelamin = null;
                    $detil->pasangan_ktp = null;
                    $detil->pasangan_npwp = null;
                    $detil->pasangan_phone = null;
                    $detil->pasangan_alamat = null;
                    $detil->pasangan_provinsi = null;
                    $detil->pasangan_kota = null;
                    $detil->pasangan_kode_pos = null;
                    $detil->pasangan_agama = null;
                    $detil->pasangan_pekerjaan = null;
                    $detil->pasangan_bidang_pekerjaan = null;
                    $detil->pasangan_online = null;
                    $detil->pasangan_pendapatan = null;
                    $detil->pasangan_pengalaman = null;
                    $detil->pasangan_pendidikan = null;
                }
                // $detil->bank = $request->bank;
                $detil->save();
                $hasil = $this->generateVA($request->username);
            }
            else
            {
                $detil->investor_id = $user->id;
                $detil->tipe_pengguna = $request->tipe_pengguna;
                $detil->nama_investor = $request->nama;
                $detil->no_ktp_investor = null;
                $detil->no_npwp_investor = $request->no_npwp;
                $detil->phone_investor = $request->no_telp;
                $detil->alamat_investor = $request->alamat;
                $detil->provinsi_investor = $request->provinsi;
                $detil->kota_investor = $request->kota;
                $detil->kode_pos_investor = $request->kode_pos;
                $detil->tempat_lahir_investor = null;
                $detil->tgl_lahir_investor = null;
                $detil->jenis_kelamin_investor = null;
                $detil->status_kawin_investor = null;
                $detil->status_rumah_investor = null;
                $detil->agama_investor = null;
                $detil->pekerjaan_investor = null;
                $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
                $detil->online_investor = $request->pekerjaan_online;
                $detil->pendapatan_investor = $request->pendapatan;
                $detil->asset_investor = $request->asset;
                $detil->pengalaman_investor = null;
                $detil->pendidikan_investor = null;
                $detil->bank_investor = $request->bank;
                $detil->rekening = $request->rekening;

                $detil->pasangan_investor = null;
                $detil->pasangan_email = null;
                $detil->pasangan_tempat_lhr = null;
                $detil->pasangan_tgl_lhr = null;
                $detil->pasangan_jenis_kelamin = null;
                $detil->pasangan_ktp = null;
                $detil->pasangan_npwp = null;
                $detil->pasangan_phone = null;
                $detil->pasangan_alamat = null;
                $detil->pasangan_provinsi = null;
                $detil->pasangan_kota = null;
                $detil->pasangan_kode_pos = null;
                $detil->pasangan_agama = null;
                $detil->pasangan_pekerjaan = null;
                $detil->pasangan_bidang_pekerjaan = null;
                $detil->pasangan_online = null;
                $detil->pasangan_pendapatan = null;
                $detil->pasangan_pengalaman = null;
                $detil->pasangan_pendidikan = null;
                // $detil->job_investor = $request->job_investor;     
                $detil->pic_investor = $this->upload('pic_investor', $request, $user->id);
                $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, $user->id);
                $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, $user->id);
                $detil->jenis_badan_hukum = $request->jenis_badan_hukum;
                $detil->nama_perwakilan = $request->nama_perwakilan;
                $detil->no_ktp_perwakilan = $request->no_ktp_perwakilan;

                $detil->save();
                $hasil = $this->generateVA($request->username);
            }
            
            if(!$hasil) {
                Investor::where('id', $detil->investor_id)->update(['status'=>'pending']);
                return redirect()->back()->with('error', 'Pembuatan VA gagal');
            }
            return redirect()->back()->with('success', 'Create Success');
        }
    }

    public function admin_update_investor(Request $request){

        // $messages = [
        //     'error_upload'    => 'Tipe file gambar harus jpeg,jpg,bmp,png dan ukuran file gambar max 500 KB',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'pic_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     'pic_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        //     'pic_user_ktp_investor' => 'mimes:jpeg,jpg,bmp,png|max:500',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //                 ->back()
        //                 ->withErrors($messages);
        //                 // ->withInput();
        // }
        // else
        // {

            if ($request->tipe_proses == 'baru')
            {
                $investor = Investor::where('id',$request->investor_id)->first();

                if ($investor->username != $request->username)
                {
                    if(Investor::where('username', $request->username)->exists()){
                        return redirect()->back()->with('exist', "Username or Email already exist");
                    }
                }
                if($investor->email != $request->email)
                {
                    if(Investor::where('email', $request->email)->exists()){
                        return redirect()->back()->with('exist', "Username or Email already exist");
                    }
                }
                // else if ($investor->email != $request->email)
                // {
                //     if(Investor::where('email', $request->email)->exists()){
                //         return redirect()->back()->with('exist', "Username or Email already exist");
                //     }
                // }
                // else
                // {
                //     if(Investor::where('email', $request->email)->exists() || Investor::where('username', $request->username)->exists()){
                //         return redirect()->back()->with('exist', "Username or Email already exist");
                //     }
                // }
                
                $investor->username = $request->username;
                $investor->email = $request->email;
                $investor->status = 'active';
                $investor->ref_number = $request->kode_ref;
                
                $investor->save();

                $detil_insert = new DetilInvestor;
                
                // if ($request->tipe_pengguna == 1)
                // {
                    $detil_insert->investor_id = $request->investor_id;
                    $detil_insert->tipe_pengguna = null;
                    $detil_insert->nama_investor = $request->nama;
                    $detil_insert->no_ktp_investor = $request->no_ktp;
                    $detil_insert->no_npwp_investor = $request->no_npwp;
                    $detil_insert->phone_investor = $request->no_telp;
                    $detil_insert->alamat_investor = $request->alamat;
                    $detil_insert->provinsi_investor = $request->provinsi;
                    $detil_insert->kota_investor = $request->kota;
                    $detil_insert->kode_pos_investor = $request->kode_pos;
                    $detil_insert->tempat_lahir_investor = $request->tempat_lahir;
                    $detil_insert->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
                    $detil_insert->jenis_kelamin_investor = $request->jenis_kelamin;
                    $detil_insert->status_kawin_investor = null;
                    $detil_insert->status_rumah_investor = null;
                    $detil_insert->agama_investor = null;
                    $detil_insert->pekerjaan_investor = null;
                    $detil_insert->bidang_pekerjaan = null;
                    $detil_insert->online_investor = null;
                    $detil_insert->pendapatan_investor = null;
                    $detil_insert->asset_investor = null;
                    $detil_insert->pengalaman_investor = null;
                    $detil_insert->pendidikan_investor = null;
                    $detil_insert->bank_investor = $request->bank;
                    $detil_insert->rekening = $request->rekening;
                    $detil_insert->nama_pemilik_rek = $request->nama_pemilik_rek;
                    // $detil->job_investor = $request->job_investor;     
                    // $detil->pic_investor = $this->upload('foto_diri', $request, $user->id);
                    // $detil->pic_ktp_investor = $this->upload('foto_ktp', $request, $user->id);
                    // $detil->pic_user_ktp_investor = $this->upload('foto_diri_ktp', $request, $user->id);
                    $detil_insert->jenis_badan_hukum = null;
                    $detil_insert->nama_perwakilan = null;
                    $detil_insert->no_ktp_perwakilan = null;

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
                    // $detil->investor_id = $user->id;
                    // $detil->tipe_pengguna = $request->tipe_pengguna;
                    // $detil->nama_investor = $request->nama;
                    // $detil->no_ktp_investor = null;
                    // $detil->no_npwp_investor = $request->no_npwp;
                    // $detil->phone_investor = $request->no_telp;
                    // $detil->alamat_investor = $request->alamat;
                    // $detil->provinsi_investor = $request->provinsi;
                    // $detil->kota_investor = $request->kota;
                    // $detil->kode_pos_investor = $request->kode_pos;
                    // $detil->tempat_lahir_investor = null;
                    // $detil->tgl_lahir_investor = null;
                    // $detil->jenis_kelamin_investor = null;
                    // $detil->status_kawin_investor = null;
                    // $detil->status_rumah_investor = null;
                    // $detil->agama_investor = null;
                    // $detil->pekerjaan_investor = null;
                    // $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
                    // $detil->online_investor = $request->pekerjaan_online;
                    // $detil->pendapatan_investor = $request->pendapatan;
                    // $detil->asset_investor = $request->asset;
                    // $detil->pengalaman_investor = null;
                    // $detil->pendidikan_investor = null;
                    // $detil->bank_investor = $request->bank;
                    // $detil->rekening = $request->rekening;

                    // $detil->pasangan_investor = null;
                    // $detil->pasangan_email = null;
                    // $detil->pasangan_tempat_lhr = null;
                    // $detil->pasangan_tgl_lhr = null;
                    // $detil->pasangan_jenis_kelamin = null;
                    // $detil->pasangan_ktp = null;
                    // $detil->pasangan_npwp = null;
                    // $detil->pasangan_phone = null;
                    // $detil->pasangan_alamat = null;
                    // $detil->pasangan_provinsi = null;
                    // $detil->pasangan_kota = null;
                    // $detil->pasangan_kode_pos = null;
                    // $detil->pasangan_agama = null;
                    // $detil->pasangan_pekerjaan = null;
                    // $detil->pasangan_bidang_pekerjaan = null;
                    // $detil->pasangan_online = null;
                    // $detil->pasangan_pendapatan = null;
                    // $detil->pasangan_pengalaman = null;
                    // $detil->pasangan_pendidikan = null;
                    // $detil->job_investor = $request->job_investor;     
                    // $detil->pic_investor = $this->upload('foto_diri', $request, $user->id);
                    // $detil->pic_ktp_investor = $this->upload('foto_ktp', $request, $user->id);
                    // $detil->pic_user_ktp_investor = $this->upload('foto_diri_ktp', $request, $user->id);
                    // $detil->jenis_badan_hukum = $request->jenis_badan_hukum;
                    // $detil->nama_perwakilan = $request->nama_perwakilan;
                    // $detil->no_ktp_perwakilan = $request->no_ktp_perwakilan;

                    // $detil->save();
                    // $hasil = $this->generateVA($request->username);
                // }

                if ($request->hasFile('pic_investor')) {
                    Storage::disk('public')->delete($detil_insert->pic_investor);
                    $detil_insert->pic_investor = $this->upload('pic_investor', $request, $request->investor_id);
                }

                if ($request->hasFile('pic_ktp_investor')) {
                    Storage::disk('public')->delete($detil_insert->pic_ktp_investor);
                    $detil_insert->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, $request->investor_id);
                }

                if ($request->hasFile('pic_user_ktp_investor')) {
                    Storage::disk('public')->delete($detil_insert->pic_user_ktp_investor);
                    $detil_insert->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, $request->investor_id);
                }

                $detil_insert->save();

                $data_investor = Investor::where('id', $request->investor_id)->first(); 
                $hasil = $this->generateVA($data_investor->username);
                if(!$hasil){
                    return redirect()->back()->with([
                        'error' => 'Akun anda sudah Aktif tetapi pembuatan VA gagal, harap menghubungi Customer Service kami untuk pembuatan nomor VA agar bisa melakukan Top Up Dana',
                    ])
                ->withInput();
                }
                else{
                    // $investor_id=Auth::user()->id;
                    dispatch(new InvestorVerif($data_investor, 1));
                    #pesan verifikasi
                    $kirimverifikasi = $this->verificationCode($request->investor_id);

                    if($kirimverifikasi===5){
                        return redirect()->back()->with('updated', "Insert user Success");
                    }else{
                        return redirect()->back()->with('updated', "Insert user Success");
                    }

                    // return redirect()->back()->with('updated', "Insert user Success");
                }

                // return redirect()->back()->with('updated', "Insert user Success");
            }
            else
            {
                $investor = Investor::where('id',$request->investor_id)->first();

                if ($investor->username != $request->username)
                {
                    if(Investor::where('username', $request->username)->exists()){
                        return redirect()->back()->with('exist', "Username or Email already exist");
                    }
                }
                if($investor->email != $request->email)
                {
                    if(Investor::where('email', $request->email)->exists()){
                        return redirect()->back()->with('exist', "Username or Email already exist");
                    }
                }
                // else if ($investor->email != $request->email)
                // {
                //     if(Investor::where('email', $request->email)->exists()){
                //         return redirect()->back()->with('exist', "Username or Email already exist");
                //     }
                // }
                // else
                // {
                //     if(Investor::where('email', $request->email)->exists() || Investor::where('username', $request->username)->exists()){
                //         return redirect()->back()->with('exist', "Username or Email already exist");
                //     }
                // }
                
                $investor->username = $request->username;
                $investor->email = $request->email;
                $investor->ref_number = $request->kode_ref;
                
                $investor->save();

                $detil = DetilInvestor::where('investor_id', $request->investor_id)->first();
                
                // if ($request->tipe_pengguna == 1)
                // {
                    // $detil->investor_id = $user->id;
                    $detil->tipe_pengguna = null;
                    $detil->nama_investor = $request->nama;
                    $detil->no_ktp_investor = $request->no_ktp;
                    $detil->no_npwp_investor = $request->no_npwp;
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
                    $detil->nama_ibu_kandung = $request->nama_ibu_kandung;
                    // $detil->job_investor = $request->job_investor;     
                    // $detil->pic_investor = $this->upload('foto_diri', $request, $user->id);
                    // $detil->pic_ktp_investor = $this->upload('foto_ktp', $request, $user->id);
                    // $detil->pic_user_ktp_investor = $this->upload('foto_diri_ktp', $request, $user->id);
                    $detil->jenis_badan_hukum = null;
                    $detil->nama_perwakilan = null;
                    $detil->no_ktp_perwakilan = null;

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
                    // $detil->investor_id = $user->id;
                    // $detil->tipe_pengguna = $request->tipe_pengguna;
                    // $detil->nama_investor = $request->nama;
                    // $detil->no_ktp_investor = null;
                    // $detil->no_npwp_investor = $request->no_npwp;
                    // $detil->phone_investor = $request->no_telp;
                    // $detil->alamat_investor = $request->alamat;
                    // $detil->provinsi_investor = $request->provinsi;
                    // $detil->kota_investor = $request->kota;
                    // $detil->kode_pos_investor = $request->kode_pos;
                    // $detil->tempat_lahir_investor = null;
                    // $detil->tgl_lahir_investor = null;
                    // $detil->jenis_kelamin_investor = null;
                    // $detil->status_kawin_investor = null;
                    // $detil->status_rumah_investor = null;
                    // $detil->agama_investor = null;
                    // $detil->pekerjaan_investor = null;
                    // $detil->bidang_pekerjaan = $request->bidang_pekerjaan;
                    // $detil->online_investor = $request->pekerjaan_online;
                    // $detil->pendapatan_investor = $request->pendapatan;
                    // $detil->asset_investor = $request->asset;
                    // $detil->pengalaman_investor = null;
                    // $detil->pendidikan_investor = null;
                    // $detil->bank_investor = $request->bank;
                    // $detil->rekening = $request->rekening;

                    // $detil->pasangan_investor = null;
                    // $detil->pasangan_email = null;
                    // $detil->pasangan_tempat_lhr = null;
                    // $detil->pasangan_tgl_lhr = null;
                    // $detil->pasangan_jenis_kelamin = null;
                    // $detil->pasangan_ktp = null;
                    // $detil->pasangan_npwp = null;
                    // $detil->pasangan_phone = null;
                    // $detil->pasangan_alamat = null;
                    // $detil->pasangan_provinsi = null;
                    // $detil->pasangan_kota = null;
                    // $detil->pasangan_kode_pos = null;
                    // $detil->pasangan_agama = null;
                    // $detil->pasangan_pekerjaan = null;
                    // $detil->pasangan_bidang_pekerjaan = null;
                    // $detil->pasangan_online = null;
                    // $detil->pasangan_pendapatan = null;
                    // $detil->pasangan_pengalaman = null;
                    // $detil->pasangan_pendidikan = null;
                    // $detil->job_investor = $request->job_investor;     
                    // $detil->pic_investor = $this->upload('foto_diri', $request, $user->id);
                    // $detil->pic_ktp_investor = $this->upload('foto_ktp', $request, $user->id);
                    // $detil->pic_user_ktp_investor = $this->upload('foto_diri_ktp', $request, $user->id);
                    // $detil->jenis_badan_hukum = $request->jenis_badan_hukum;
                    // $detil->nama_perwakilan = $request->nama_perwakilan;
                    // $detil->no_ktp_perwakilan = $request->no_ktp_perwakilan;

                    // $detil->save();
                    // $hasil = $this->generateVA($request->username);
                // }
              
                if($request->status == 'suspend'){
                    $suspended_by = Auth::guard('admin')->user()->firstname;
                    $investor = Investor::where('id',$request->investor_id)->first();
                    $investor->status = $request->status;
                    $investor->keterangan = $request->alasan_suspend;
                    $investor->suspended_by = $suspended_by;
                    $investor->save();

                    $Log = new LogSuspend;
                    $Log->keterangan = $request->alasan_suspend;
                    $Log->suspended_by = $suspended_by;
                    $Log->save();
                }
                elseif ($request->status == 'active'){
                    $actived_by = Auth::guard('admin')->user()->firstname;
                    $investor = Investor::where('id',$request->investor_id)->first();
                    $investor->status = $request->status;
                    $investor->keterangan = $request->alasan_active;
                    $investor->actived_by = $actived_by;
                    $investor->save();
                }

                if ($request->hasFile('pic_investor')) {
                    Storage::disk('public')->delete($detil->pic_investor);
                    $detil->pic_investor = $this->upload('pic_investor', $request, $request->investor_id);
                }

                if ($request->hasFile('pic_ktp_investor')) {
                    Storage::disk('public')->delete($detil->pic_ktp_investor);
                    $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, $request->investor_id);
                }

                if ($request->hasFile('pic_user_ktp_investor')) {
                    Storage::disk('public')->delete($detil->pic_user_ktp_investor);
                    $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, $request->investor_id);
                }

                $detil->save();

                $rekening = RekeningInvestor::where('investor_id',$request->investor_id)->first();
                if ($rekening == null)
                {
                    if ($request->va_number)
                    {
                        RekeningInvestor::create([
                            'investor_id' => $request->investor_id,
                            'va_number' => $request->va_number,
                            'total_dana' => 0,
                            'unallocated' => 0,
                        ]);
                    }
                }
                else
                {
                    if ($request->va_number !== $rekening->va_number)
                    {
                        $rekening->va_number = $request->va_number;
                        $rekening->save();
                    }
                }

                $audit = new AuditTrail;
                $username = Auth::guard('admin')->user()->firstname;
                $audit->fullname = $username;
                $audit->menu= "Kelola Pendana";
                $audit->description = "Ubah data profil Pendana";
                $audit->ip_address =  \Request::ip();
                $audit->save();

                return redirect()->back()->with('updated', "Update user Success");
            }
            
        // }

    }

    public function admin_changepass_investor(Request $request)
    {
        $investor = Investor::where('id', $request->investor_id)
                    ->update(['password'=>bcrypt($request->newpassword)]);

        $audit = new AuditTrail;
        $username = Auth::guard('admin')->user()->firstname;
        $audit->fullname = $username;
        $audit->menu= "Kelola Pendana";
        $audit->description = "Ubah password Pendana";
        $audit->ip_address =  \Request::ip();
        $audit->save();

        return redirect()->back()->with('changepass', "Change password user success");           

    }

    public function admin_changestatus_investor(Request $request){
        $investor = Investor::where('id', $request->investor_id)
                    ->update(['status'=>'notfilled']);

        return redirect()->back()->with('changepass', "Kata sandi pengguna berhasil diubah");           
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

    public function admin_add_pendanaan(Request $request) {
        $rekening = RekeningInvestor::where('investor_id', $request->investor_id)->first();
        $proyek = Proyek::where('id', $request->proyek_id)->first();
        $user = Investor::find($request->investor_id);
        $nominal = $request->jumlah_paket*$proyek->harga_paket;

        $jumlahPendanaan = PendanaanAktif::where('proyek_id',$request->proyek_id)->sum('total_dana');
        $selesai = Carbon::parse($proyek->tgl_selesai_penggalangan)->toDateString();
        $sekarang = Carbon::now()->toDateString();
        // echo $jumlahPendanaan+$proyek->terkumpul.','.$proyek->total_need;die;

        $jumlahPenarikan = PenarikanDana::where('investor_id',$request->investor_id)->where('accepted',0)->sum('jumlah');
        // echo $jumlahPenarikan;die;
        $totalDana = ($proyek->harga_paket*$request->jumlah_paket) + $jumlahPenarikan;
        $jumlahRekening = 0;
        $jumlahRekening += $rekening->unallocated;
        if ($jumlahPendanaan+$proyek->terkumpul < $proyek->total_need && $selesai >= $sekarang)
        {
            if ($totalDana > $jumlahRekening)
            {
                if ($jumlahPenarikan > 0)
                {
                    return redirect()->back()->with('error', 'Dana Tidak Cukup karena Dana Tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana');
                }
                else
                {
                    return redirect()->back()->with('error', 'Dana Tidak Cukup');
                }
            }
            else
            {
                $pendanaan = PendanaanAktif::where('investor_id', $request->investor_id)
                                            ->where('proyek_id', $request->proyek_id)
                                            ->orderBy('id','desc')
                                            ->first();
                
                $val = $proyek->harga_paket*$request->jumlah_paket;

                $rekening = RekeningInvestor::where('investor_id', $request->investor_id)->first();
                if ($rekening->unallocated >= $val && $val > 0) {
                    $rekening->unallocated = $rekening->unallocated - $val;
                    $rekening->save();
                }
                else {
                    return redirect()->back()->with('error', 'Dana tidak cukup');
                }

                if ($pendanaan !== NULL && $pendanaan->tanggal_invest->toDateString() == Carbon::now()->toDateString()){
                    $pendanaan->update(['total_dana' => $pendanaan->total_dana+$val , 'nominal_awal'=>$pendanaan->nominal_awal+$val]);

                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaan->id;
                    $log->nominal = $proyek->harga_paket*$request->jumlah_paket;
                    $log->tipe = 'add active investation by admin';
                    $log->save();

                    $audit = new AuditTrail;
                    $username = Auth::guard('admin')->user()->firstname;
                    $audit->fullname = $username;
                    $audit->menu= "Kelola Pendana";
                    $audit->description = "Tambah Pendanaan Proyek";
                    $audit->ip_address =  \Request::ip();
                    $audit->save();
                    
                    //dispatch(new AdminAddPendanaan($pendanaan, $rekening, $user));
                    $email = new AdminAddPendanaanEmail($pendanaan, $rekening, $user);
                    Mail::to($user->email)->send($email);
                    
                    return redirect()->back()->with('success', 'Berhasil Menambah Pendanaan');
                }
                else 
                {

                    $pendanaan = new PendanaanAktif;
                    $pendanaan->investor_id = $request->investor_id;
                    $pendanaan->proyek_id = $request->proyek_id;
                    $harga_paket = Proyek::find($request->proyek_id)->harga_paket;
                    $pendanaan->total_dana = $harga_paket*$request->jumlah_paket;
                    $pendanaan->nominal_awal = $harga_paket*$request->jumlah_paket;
                    $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                    $pendanaan->last_pay = Carbon::now()->toDateString();
                    $pendanaan->save();

                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaan->id;
                    $log->nominal = $pendanaan->nominal_awal;
                    $log->tipe = 'add active investation by admin';
                    $log->save();

                    $audit = new AuditTrail;
                    $username = Auth::guard('admin')->user()->firstname;
                    $audit->fullname = $username;
                    $audit->menu= "Kelola Pendana";
                    $audit->description = "Tambah Pendanaan Proyek";
                    $audit->ip_address =  \Request::ip();
                    $audit->save();

                    //dispatch(new AdminAddPendanaan($pendanaan, $rekening, $user));
                    $email = new AdminAddPendanaanEmail($pendanaan, $rekening, $user);
                    Mail::to($user->email)->send($email);

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

    public function admin_add_va (Request $request) {
        $rekening = RekeningInvestor::where('investor_id', $request->investor_id)->first();

        if(preg_match("/^[0-9,]+$/", $request->nominal)){
            $request->nominal = str_replace(',', '', $request->nominal);
        } 
        $rekening->unallocated += $request->nominal;
        $rekening->total_dana += $request->nominal; 
        $rekening->save();

        event(new MutasiInvestorEvent($request->investor_id,'CREDIT',$request->nominal,$request->perihal));

        // $log = new MutasiInvestor;
        // $log->investor_id = $request->investor_id;
        // $log->nominal = $request->nominal;
        // $log->tipe = 'CREDIT';
        // $log->perihal = 'add dana VA oleh admin';
        // $log->save();

        return redirect()->back()->with('success', 'Berhasil menambah dana investor');
    }

    public function admin_minus_dana (Request $request) {
        $rekening = RekeningInvestor::where('investor_id', $request->investor_id)->first();

        if(preg_match("/^[0-9,]+$/", $request->nominal)){
            $request->nominal = str_replace(',', '', $request->nominal);
        } 
        $rekening->unallocated -= $request->nominal;
        $rekening->total_dana -= $request->nominal; 
        $rekening->save();

        event(new MutasiInvestorEvent($request->investor_id,'DEBIT',$request->nominal,$request->perihal));

        // $log = new MutasiInvestor;
        // $log->investor_id = $request->investor_id;
        // $log->nominal = $request->nominal;
        // $log->tipe = 'CREDIT';
        // $log->perihal = 'add dana VA oleh admin';
        // $log->save();

        return redirect()->back()->with('success', 'Berhasil mengurangi dana investor');
    }

    public function admin_hapus_pendanaan (Request $request) {
        $pendanaan = PendanaanAktif::find($request->pendanaan_id);
        
        $rekening = RekeningInvestor::where('investor_id',$request->investor_id)->first();
        $rekening->unallocated += $pendanaan->nominal_awal;
        $rekening->save();
        
        $pendanaan->status = 0;
        $pendanaan->total_dana -= $pendanaan->nominal_awal;
        $pendanaan->nominal_awal = 0;
        $pendanaan->save();

        $log = new LogPendanaan;
        $log->pendanaanAktif_id = $pendanaan->id;
        $log->nominal = $pendanaan->nominal_awal;
        $log->tipe = 'ambil active investation by admin';
        $log->save();


        return redirect()->back()->with('success', 'Pendanaan Berhasil Dihapus');
    }

    public function get_proyek_datatables($id){
        $proyek = Proyek::whereRaw('terkumpul < total_need')->where('status', '=', '1')->orderBy('id', 'desc')->get();
        $total = RekeningInvestor::where('investor_id', $id)->first();
        // $data_total = !empty($total) ? number_format($total->unallocated,2, '.', ',') : '0';
        
        $response = ['data_proyek' => $proyek, 'data_total' => $total];

        return response()->json($response);
    }

    public function export_pendanaan_aktif(){

        $date = Carbon::now()->toDateString();
        return Excel::download(new DanaInvestorProyek, 'export_pendanaan_aktif-'.$date.'.xlsx');
    }

    public function admin_edit_nominal_pendanaan (Request $request) {
        $pendanaan = PendanaanAktif::where('id', $request->pendanaan_id)->first();

        $pendanaan->total_dana = str_replace(',','',$request->nominal);
        $pendanaan->nominal_awal = str_replace(',','',$request->nominal); 
        $pendanaan->save();

        return redirect()->back()->with('success', 'Berhasil mengubah nominal pendanaan investor');
    }

    public function admin_edit_nominal_pendanaan_selesai (Request $request) {
        $pendanaan_selesai = LogPengembalianDana::where('id', $request->pendanaan_selesai_id)->first();

        $pendanaan_selesai->nominal = str_replace(',','',$request->nominal_selesai);
        $pendanaan_selesai->save();

        return redirect()->back()->with('success', 'Berhasil mengubah nominal pendanaan selesai investor');
    }

    public function verificationCode($investor_id){
        
        $rekening = RekeningInvestor::join('detil_investor', 'detil_investor.investor_id', '=', 'rekening_investor.investor_id')
                    ->select('rekening_investor.va_number', 'detil_investor.nama_investor', 'detil_investor.phone_investor')
                    ->where('rekening_investor.investor_id', $investor_id)->first();
        $to =  $rekening->phone_investor;
        // $to = '081318988499';
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
    
}