<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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
use App\Investor;
use App\Marketer;
use App\HariLibur;
use App\AuditTrail;
use DateTime;
use DatePeriod;
use DateInterval;

use App\IhPendanaanAktif;
use App\IhListImbalUser;


use Excel;
use App\Exports\MutasiInvestorProyek;
use App\Exports\DetilByProyek;
use App\Exports\DetilProyekExport;
use App\Exports\DetilByDate;
use App\Exports\PayoutExport;
use App\Exports\IhListImbalUserExport;
// use Maatwebsite\Excel\Facades\Excel;

use App\PemilikPaket;
use App\RekeningInvestor;
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
use App\Jobs\KembaliDana;
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

class ImbalHasilAdminController extends Controller{

    public function __construct(){
        $this->middleware('auth:admin')->only(['dashboard_generate','cetak_payout']);
    }

    public function dashboard_generate(){
        return view('pages.admin.imbalhasil_dashboard_generate');
    }

    public function imbalhasil_DaftarProyekReady(){
        $proyeks = DB::SELECT("select * from `proyek` left join (SELECT proyek_id, count(*) AS total FROM pendanaan_aktif WHERE status = 1 GROUP BY proyek_id) as total_proyek on `proyek_id` = `id` where `proyek`.`status` in (2, 3, 4) and `proyek`.`tgl_selesai` >= DATE_ADD(DATE(NOW()), INTERVAL -7 DAY) order by `proyek`.`id` DESC");
        
        $response = ['data' => $proyeks];
        return response()->json($response);
    }

    public function generateImbalHasil($id){
        DB::select("CALL proc_imbalhasil($id)");
        $getdata = 1;
        $response = ['data' => $getdata];
        return response()->json($response);
    }

    // public function admin_detil_payout($id){
    public function detil_daftarpayout($id){
        $imbalhasil = DB::SELECT("SELECT a.id,a.tanggal_payout, a.ket_libur, a.status_payout,a.keterangan_payout FROM ih_list_imbal_user a LEFT JOIN ih_detil_imbal_user b ON a.detilimbaluser_id = b.id WHERE b.proyek_id = $id AND keterangan_payout IN (1,2,3) GROUP BY a.keterangan_payout, a.tanggal_payout ORDER BY a.id");
          
        $getbulan1 = DB::SELECT("SELECT a.tanggal_payout FROM ih_list_imbal_user a LEFT JOIN ih_detil_imbal_user b ON a.detilimbaluser_id = b.id WHERE b.proyek_id = $id AND keterangan_payout = 1 GROUP BY a.tanggal_payout ORDER BY a.id limit 1");
        
        $bulan1 = $getbulan1[0]->tanggal_payout;

        $response = ['data_payout' => $imbalhasil, 'bulan1' => $bulan1];
        return response()->json($response);
    }

    // public function detil_month_payout(Request $request)
    public function list_payout_pendana(Request $request)
    {
       $data = IhListImbalUser::where('ih_detil_imbal_user.proyek_id',$request->data_id)
                               ->where('ih_list_imbal_user.tanggal_payout',$request->date_id)
                               ->where('ih_list_imbal_user.keterangan_payout',$request->flag_id)
                               ->leftJoin('ih_detil_imbal_user','ih_detil_imbal_user.id','=','ih_list_imbal_user.detilimbaluser_id')
                               ->leftJoin('ih_pendanaan_aktif','ih_pendanaan_aktif.id','=','ih_detil_imbal_user.pendanaan_id')
                               ->leftJoin('detil_investor','detil_investor.investor_id','=','ih_pendanaan_aktif.investor_id')
                               ->orderby('ih_detil_imbal_user.id','ASC')
                               ->select([
                                   'ih_detil_imbal_user.pendanaan_id',
                                   'detil_investor.nama_investor',
                                   'ih_list_imbal_user.tanggal_payout',
                                   'ih_list_imbal_user.imbal_payout',
                                   'ih_detil_imbal_user.proposional',
                                   'ih_detil_imbal_user.sisa_imbal',
                                   'ih_pendanaan_aktif.total_dana',
                                   'ih_list_imbal_user.keterangan',
                                   'ih_list_imbal_user.status_payout',
                               ])->get();
        
        $jmlpendana = count($data); 
        //    dd($data);
        //    die();
        $response = ['data' => $data,'jmlpendana' => $jmlpendana];
        return response()->json($response);
    }

    public function kirim_imbal_hasil(Request $request)
    {
        if($request->jmlpendana == count($request->status_id)){
            $status = implode("|",$request->status_id);
            // echo "CALL proc_kirimimbal(".'$status'.",".$request->data_id.",".'$request->date_id'.",".$request->flag_id.")";
            DB::select("CALL proc_kirimimbal('$status',$request->data_id,'$request->date_id',$request->flag_id)");
            $status = 1;
        }else{
            $status = 0; //gagal
        }
        
        $data = ['sukses' => $status];
        return response()->json($data);
    }

    public function update_imbal_hasil(Request $request)
    {
        if($request->jmlpendana == count($request->status_id)){
            $status = implode("|",$request->status_id);
            // echo "CALL proc_updateimbal(".$status.",".$request->data_id.",".$request->date_id.",".$request->flag_id.")";
            DB::select("CALL proc_updateimbal('$status',$request->data_id,'$request->date_id',$request->flag_id)");
            $status = 1;
        }else{
            $status = 0; //gagal
        }
        $data = ['sukses' => $status];
        return response()->json($data);
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
        // $payoutseven = DB::select("SELECT proyek.nama, ih_list_imbal_user.tanggal_payout, datediff(ih_list_imbal_user.tanggal_payout,'$today') AS sisa_tanggal FROM proyek INNER JOIN ih_list_imbal_user ON proyek.id = ih_list_imbal_user.proyek_id WHERE tanggal_payout = '$date' GROUP BY proyek.nama ORDER BY ih_list_imbal_user.tanggal_payout ASC");
        $payoutseven = DB::select("SELECT proyek.nama, ih_list_imbal_user.tanggal_payout, datediff(ih_list_imbal_user.tanggal_payout,'$today') AS sisa_tanggal FROM proyek INNER JOIN ih_detil_imbal_user ON proyek.id = ih_detil_imbal_user.proyek_id INNER JOIN ih_list_imbal_user ON ih_detil_imbal_user.id = ih_list_imbal_user.detilimbaluser_id WHERE ih_list_imbal_user.tanggal_payout = '$date' AND ih_list_imbal_user.keterangan_payout IN (1,2) GROUP BY proyek.nama ORDER BY ih_list_imbal_user.tanggal_payout ASC");
        $response = ['payoutseven' => $payoutseven];
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

    public function cetak_data_payout(Request $request)
    {
        $LIU_id = $request->id;
        $getid_proyek = DB::select("SELECT a.proyek_id, c.nama FROM ih_detil_imbal_user a JOIN ih_list_imbal_user b ON a.id = b.detilimbaluser_id JOIN proyek c ON a.proyek_id = c.id WHERE b.id = $LIU_id");
        $id_proyek = $getid_proyek[0]->proyek_id;
        $nama = $getid_proyek[0]->nama;
        $getnonama = explode("/",$nama);
        $nonama =trim($getnonama[0],".,-");
        // echo $id_proyek;die();

        return Excel::download(new IhListImbalUserExport($id_proyek), 'ImbalHasilUser-'.$nonama.'.xlsx');
    }

    public function cetak_payout(Request $request)
    {
        $proyekid = $request->id;
        $proyek = DB::select("SELECT nama from proyek where id=$proyekid ");
        $id_proyek = $request->id;
        $nama = $proyek[0]->nama;
        $getnonama = explode("/",$nama);
        $nonama =trim($getnonama[0],".,-");

        return Excel::download(new IhListImbalUserExport($proyekid), 'ImbalHasilUser-'.$nonama.'.xlsx');
    }
    
}