<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\RekeningInvestor;
use App\MutasiInvestor;
use App\DetilInvestor;
use App\PenarikanDana;
use App\Events\MutasiInvestorEvent;
use App\MasterBank;
use App\LogSertifikat;
use Terbilang;
use JWTAuth;
use PDF;
use JWTFactory;
use DB;
use Storage;

class NewRekeningController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api',['except' => ['verificationCode', 'sendVerifikasi', 'sertifikat', 'cekSertifikat']]);
    }

    public function listMutasi() {
        $mutasi_user = MutasiInvestor::where('investor_id', Auth::guard('api')->user()->id)
                                        ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                        ->where('perihal', 'not like', '%pengembalian pokok%')
                                        ->where('perihal', 'not like', '%sisa imbal hasil%')
                                        ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                        ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                        //  ->orderBy('created_at', 'ASC')
                                        ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                        ->orderby('id', 'desc')->get();

        $i = 0;
        foreach ($mutasi_user as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        return json_encode($return);
    }

    public function sertifikat(){

        // $id = "52216";
        $id = Auth::guard('api')->user()->id;
        
        $data_rek = RekeningInvestor::where('investor_id', $id)
                    ->first(['total_dana', 'va_number']);


        $data_user = DetilInvestor::where('investor_id',$id)->first();


        

        $iduser = $id;
        // mengambil id untuk generate integer
        $tanggal = $id;

        // mengambil nama investor
        $nama_investor = $data_user['nama_investor'];
        $rek_investor = $data_user['rekening'];
        $bank_investor = $data_user['bank_investor'];
        $alamat_investor = $data_user['alamat_investor'];
        
        // mengambil dana
        $total = $data_rek->total_dana;         
        
        // mengambil VA 
        $nomer_va = $data_rek->va_number;   
        
        // mengambil nama bank 
        $master_bank = MasterBank::where('kode_bank',$bank_investor)->first();
        $bankinvestor = $master_bank['nama_bank'];
        

        // merubah dana menjadi terbilang Words   
        $terbilang = Terbilang::make($total,' rupiah');
        
        // menjadi huruf kapital depannya
        $hasil_bilangan = ucwords($terbilang);

        $title = 'Sertifikat - '.$nama_investor;
        $dana = number_format($total,0,",",".");
        $date = mt_rand($tanggal,99999);
        $random = mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(0,9); 
        
        $all_random = $random.'/ L - '.$iduser.'/'. $date;

        $check_log = LogSertifikat::where('total_dana',$total)->where('investor_id',$id)->limit(1)->first();
        $total_cek = $check_log['total_dana'];


        $data_log = new LogSertifikat;
        $data_log->investor_id = $iduser;
        $data_log->seri_sertifikat = $all_random;
        $data_log->total_dana = $total;


        //}
        $pdf=PDF::loadView('pages.user.e_sertifikat_user',
            [
                // 'iduser'=>$iduser,
                'title' => $title,
                'dana' =>$dana,
                'date'=>$date,
                'all_random'=> $all_random,
                'hasil_bilangan'=> $hasil_bilangan,
                'nomer_va' => $nomer_va,
                'nama_investor' => $nama_investor,
                'rek_investor' => $rek_investor, 
                'bankinvestor' => $bankinvestor,
                'alamat_investor' => $alamat_investor,


            ]
        );
        

        $pdf->setPaper('A4','landscape');
        $path = storage_path('app/public/sertifikat');
        $fileName =  $data_log['title'] . 'Sertifikat - '.$id.'.pdf' ;
        $pdf->save($path . '/' . $fileName);

        $data_log->save();
        $pdf->download($fileName);

        if($pdf){
            return ('success');    
        }else{
            return ('failed');
        }
        

        // $pdf->setEncryption('copy');
        

    }

    public function cekSertifikat(){
        $id = Auth::guard('api')->user()->id;

        $rekening = RekeningInvestor::select('total_dana')->where('investor_id', $id)->orderby('id', 'desc')->first();
        $totaldana = $rekening->total_dana;

        if($rekening){
            if($totaldana >= 1000000){
                if(Storage::disk('public')->exists('sertifikat/'.'Sertifikat - '.$id.'.pdf')){
                    $log_sertifikat = LogSertifikat::select('total_dana')->where('investor_id', $id)->orderby('id', 'desc')->first();        
                    $log_dana = $log_sertifikat->total_dana;
                    if($totaldana == $log_dana){
                        return response()->json([
                            'ada' => 'file sudah ada dan dana sama'
                        ]);
                    }else{
                        $cetak_sertifikat = $this->sertifikat();
                        if($cetak_sertifikat=='success'){
                            return response()->json([
                               'success' => 'file berhasil generate'
                            ]);
                        }else{
                            return response()->json([
                               'gagal_generate' => 'file gagal generate'
                            ]);
                        }
                    }
                }else{
                    $cetak_sertifikat = $this->sertifikat();
                    if($cetak_sertifikat=='success'){
                        return response()->json([
                           'success' => 'file berhasil generate'
                        ]);
                    }else{
                        return response()->json([
                           'gagal_generate' => 'file gagal generate'
                        ]);
                    }
                }
            }else{
                return response()->json([
                    'gagal' => 'total danan kurang dari 1 juta'
                ]);
            }
        }else{
            return response()->json([
                'gagal' => 'dana belum ada'
            ]);
        }

        
    }

    public function showPenarikan() {
        $detil = DetilInvestor::leftJoin('m_bank','m_bank.kode_bank','=','detil_investor.bank_investor')->where('investor_id', Auth::guard('api')->user()->id)->first(['nama_bank','nama_pemilik_rek','rekening', 'phone_investor', 'investor_id']);
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        return [
            'unallocated' => isset($rekening) ? number_format($rekening->unallocated,0,',','.') : 0,
            'total_dana' => isset($rekening) ? number_format($rekening->total_dana,0,',','.') : 0,
            'rekening' => $detil->rekening,
            'bank' => $detil->nama_bank,
            'nama' => $detil->nama_pemilik_rek,
            'phone' => $detil->phone_investor,
            'investor_id' => $detil->investor_id
        ];
    }

    public function requestPenarikan(Request $request) {
        $rekening = Auth::user()->rekeningInvestor;
        $requestAmount = $request->nominal;

        // use laravel collection method SUM()
        $sumAvailable = $rekening->unallocated;

        if($requestAmount<100000){
            return response()->json(['error'=>'Penarikan minimum adalah Rp. 100.000,-']);
        }

        if($requestAmount > $sumAvailable){
            // Throw error, cant  request more than available sum
            return response()->json(['error'=>'Penarikan dana anda lebih dari dana tersedia, silahkan mengambil uang pada pendanaan anda terlebih dahulu']);
        }

        $cekDanaTersedia = RekeningInvestor::where('investor_id',Auth::user()->id)->first();
        $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::user()->id)->where('accepted',0)->sum('jumlah');
        $totalDana = $request->nominal + $jumlahPenarikan;

        if ($totalDana <= $cekDanaTersedia->unallocated)
        {
            // Create new record penarikan dana
            PenarikanDana::create([
                'investor_id' => Auth::user()->id,
                'jumlah' => $request->nominal,
                'no_rekening' => $request->rekening,
                'bank' => $request->bank,
                'accepted' => 0,
                'perihal' => 'Pengajuan Penarikan Dana',
            ]);
            
            // throw event MutasiInvestorEvent
            // event(new MutasiInvestorEvent(Auth::user()->id,'request DEBIT',-$request->nominal,'Penarikan dana sedang diproses'));
            return response()->json(['success'=>'Penarikan anda sedang diproses']);
        }
        else
        {
            return response()->json(['success'=>'Penarikan anda sedang diproses']);
        }
    }

    public function verificationCode(Request $request){
        // $to =  $request->phone;
        $to = '085691116373';
        $investor_id = $request->investor_id;
        $otp = rand(100000, 999999);
        $text =  'Kode OTP : '.$otp.' Silahkan masukan kode ini untuk melanjutkan proses penarikan tunai.';

        //send to db
        $detil = DetilInvestor::where('investor_id', $investor_id)->update(['OTP' => $otp]);

        $pecah              = explode(",",$to);
        $jumlah             = count($pecah);
        $from               = "SMSVIRO"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
        // $username           = "smsvirodemo";
        // $password           = "qwerty@123";
        // $from               = "DANASYARIAH";
        $username           = "danasyariahpremium"; //your smsviro username
        $password           = "Dsi701@2019"; //your smsviro password
        $postUrl            = "http://107.20.199.106/restapi/sms/1/text/advanced"; # DO NOT CHANGE THIS
        
        // for($i=0; $i<$jumlah; $i++){
        //     if(substr($pecah[$i],0,2) == "62" || substr($pecah[$i],0,3) == "+62"){
        //         $pecah = $pecah;
        //     }elseif(substr($pecah[$i],0,1) == "0"){
        //         $pecah[$i][0] = "X";
        //         $pecah = str_replace("X", "62", $pecah);
        //     }else{
        //         echo "Invalid mobile number format";
        //     }
        //     $destination = array("to" => $pecah[$i]);
        //     $message     = array("from" => $from,
        //                          "destinations" => $destination,
        //                          "text" => $text,
        //                          "smsCount" => 20);
        //     $postData           = array("messages" => array($message));
        //     $postDataJson       = json_encode($postData);
        //     $ch                 = curl_init();
        //     $header             = array("Content-Type:application/json", "Accept:application/json");
            
        //     curl_setopt($ch, CURLOPT_URL, $postUrl);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        //     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //     curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        //     curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
        //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //     $response = curl_exec($ch);
        //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //     $responseBody = json_decode($response);
        //     curl_close($ch);
        // }   

        if($detil){
            return response()->json(['success'=>$text]);
        }else{
            return response()->json(['success'=>'gagal']);
        }
    }

    public function sendVerifikasi(Request $request){
        $otp = $request->otp;
        $id = $request->investor_id;

        $cek = DetilInvestor::where('investor_id', $id)->where('OTP', $otp)->count();
        if ($cek == 1){
            $detil = DetilInvestor::where('investor_id', $id)->update(['OTP' => '']);
            return response()->json(['success'=>$otp]);
        }else{
            return response()->json(['gagal'=>'OTP tidak cocok']);        
        }      
        
    }

    public function encrypt(Request $request) {
        //make payload for encryption
        $payload = JWTFactory::make();
        //push data to payload
        $payres = JWTFactory::data($request);
        //encrypt payload
        $encrypt = JWTAuth::encode($payload);
        //decrypt message
        $decrypt = JWTAuth::decode($encrypt);
        //get data
        $result = $decrypt['data'];
        return $result;
    }

    public function checkUploadFoto(){
        
        $check = DetilInvestor::select('pic_investor', 'pic_ktp_investor', 'pic_user_ktp_investor')->where('investor_id', Auth::user()->id)->get();
        
        if($check[0]->pic_investor==null or $check[0]->pic_investor==''){
            return response()->json(['notuploaded'=>'Mohon upload Foto diri anda dahulu']);
        }else if($check[0]->pic_ktp_investor==null or $check[0]->pic_ktp_investor==''){
            return response()->json(['notuploaded'=>'Mohon upload Foto KTP anda dahulu']);
        }else if($check[0]->pic_user_ktp_investor==null or $check[0]->pic_user_ktp_investor==''){
            return response()->json(['notuploaded'=>'Mohon upload Foto Diri pegang KTP']);
        }else{
            return response()->json(['success'=>'Approved']);
        };
    }

    public function historyPenarikanDana(){
        $historis = DB::table('penarikan_dana')->where('investor_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        
        $i=0;
        foreach($historis as $item){
            if($item->accepted == 0){
                $status = "Request";
            }
            else if($item->accepted == 1){
                $status = "Disetujui";
            }
            else if($item->accepted == 2){
                $status = "Gagal";
            }
            $history[$i]=[
                'id'=>$item->id,
                'jumlah_penarikan'=>$item->jumlah,
                'tanggal_penarikan'=>substr($item->created_at, 0, 10),
                'no_rekening'=>$item->no_rekening,
                'bank_tujuan'=>$item->bank,
                'status'=>$status,
            ];
            $i++;
        }
        return ['history'=>isset($history) ? $history : null];
    }
    
}
