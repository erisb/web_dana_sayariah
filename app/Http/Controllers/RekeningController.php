<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BniEnc;
use App\Investor;
use App\MutasiInvestor;
use App\Events\MutasiInvestorEvent;
use App\PenarikanDana;
use App\RekeningInvestor;
use App\DetilInvestor;
use App\MasterBank;
use App\PendanaanAktif;
use Storage;
use PDF;
use Terbilang;
use App\LogSertifikat;
use Response;
use App\Jobs\DepositEmail;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\UserCheck;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Middleware\StatusProyek;
use phpDocumentor\Reflection\Types\String_;
use App\AuditTrail;
use App\TmpSelectedProyek;
use App\LoginBorrower;
use App\Proyek;
use App\LogAkadDigiSignInvestor;
use App\BorrowerPembayaran;
use App\BorrowerRekening;
use App\FDCPassword;
use App\BorrowerPendanaan;
use App\RDLAccountNumber;
use App\LogGenerateVaRdl;
use App\Http\Controllers\RDLController;
use DateTime;
use ZipArchive;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use DB;

class RekeningController extends Controller
{
    public function __construct(){
		
        $this->middleware('auth')->except(['bankResponse', 'bankResponseKonven' ,'generateVABNI_Investor_test', 'generateVABNI_Investor', 'generateVABNI_Borrower', 'checkStatusUser', 'checkStatusUserInvest', 'generatePasswordZIP']);
        $this->middleware(UserCheck::class)->only(['tambahDana','mutasiInvestor','generateVA','penarikanDana', 'showPenarikanDana','get_list_mutasi_history','get_params_mutasi_history','verificationCode','sendVerifikasi','cekSertifikat', 'convertCSV_AFPI']);
        $this->middleware(StatusProyek::class);
    
	}

    //Generate VA for user MASTER
    // public function generateVA(){
        // $date = \Carbon\Carbon::now()->addYear(4);
        // $user = Auth::user();
        // $data = [
            // 'type' => 'createbilling',
            // 'client_id' => config('app.bni_id'),
            // 'trx_id' => '999',
            // 'trx_amount' => '0',
            // 'customer_name' => $user->username,
            // 'customer_email' => $user->email,
            // 'virtual_account' => '8'.config('app.bni_id').'000000000999',
            // 'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            // 'billing_type' => 'o',
        // ];
    
        // $encrypted = BniEnc::encrypt($data,config('app.bni_id'),config('app.bni_key'));

        // $client = new Client(); //GuzzleHttp\Client
        // $result = $client->post(config('app.bni_url'), [
            // 'json' => [
                // 'client_id' => config('app.bni_id'),
                // 'data' => $encrypted,
            // ]
        // ]);

        // $result = json_decode($result->getBody()->getContents());
        // if($result->status !== '000'){
            // return $result->message;
        // }
        // else{
            // $decrypted = BniEnc::decrypt($result->data,config('app.bni_id'),config('app.bni_key'));
            // $dana = RekeningInvestor::create([
                // 'investor_id' => $user->id,
                // 'jumlah_dana' => 0,
                // 'va_number' => $decrypted['virtual_account'],
                // 'unallocated' => 0,
            // ]);
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         // }
    // }
	
    public function generateVA(){
        $date = \Carbon\Carbon::now()->addYear(4);
        $user = Auth::user();
        $data_user = Investor::where('username', $user->username)->first();
        $data = [
            'type' => 'createbilling',
            'client_id' => config('app.bni_id'),
            'trx_id' => $data_user->id,
            'trx_amount' => '0',
            'customer_name' => $data_user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '8'.config('app.bni_id').$data_user->detilInvestor->getVa(),
            'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            'billing_type' => 'o',
        ];
        $encrypted = BniEnc::encrypt($data,config('app.bni_id'),config('app.bni_key'));

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(config('app.bni_url'), [
            'json' => [
                'client_id' => config('app.bni_id'),
                'data' => $encrypted,
            ]
        ]);

        $result = json_decode($result->getBody()->getContents());
        if($result->status !== '000'){
            return $result->message;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,config('app.bni_id'),config('app.bni_key'));
            $dana = RekeningInvestor::create([
                'investor_id' => $user->id,
                'jumlah_dana' => 0,
                'va_number' => $decrypted['virtual_account'],
                'unallocated' => 0,
            ]);
            return 'VA Generate Success!';
         }
    }
	
    // Function to show help page for adding cash
    public function tambahDana(){
        $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        return view('pages.user.add_funds')->with('rekening', $rekening);
    }

    // REQUEST OJK 
    public function bankResponse(Request $request){
        
        $data = $request->input('data');
        if($request->input('client_id') != config('app.bni_id')){
            return response()->json([
                'status' => '999',
                'message' => 'Access Denied',
            ]);
        }
        
        $decrypted = BniEnc::decrypt($data,config('app.bni_id'),config('app.bni_key'));
        $va_investor = $decrypted['virtual_account'];
        $payment_ntb = $decrypted['payment_ntb'];
        
        if (strstr( $decrypted['trx_id'],'/')) {
            
            // OJK VERSION
                
            $explodeTRX_id = explode('/', $decrypted['trx_id']);
            $user_id        = $explodeTRX_id[0];
            $proyek_id      = $explodeTRX_id[1];
            $trx_date_va    = $explodeTRX_id[2];

            
            $rekening = RekeningInvestor::where('investor_id', $user_id)->first();
            //$rekening = RekeningInvestor::where('i', $va_investor)->first();
            $payment_ntb_exist = $rekening['payment_ntb'];
            
            

            // $investor_id = $decrypted['trx_id'];
            // $user = Investor::find((int)$investor_id);

            // get the incoming amount
            $amount = (int)$decrypted['payment_amount'];

            if ($payment_ntb != $payment_ntb_exist)
            {
                // update the rekening record
                // $rekening = $user->rekeningInvestor;
                $getTemporer = TmpSelectedProyek::where('no_va', $va_investor)
                    ->where('investor_id', $user_id)
                    ->where('proyek_id', $proyek_id)
                    ->where('amount', $amount)
                    ->where('trx_date_va', $trx_date_va)->first();
                //syslog(0, 'log getTemporerPendanaan'.$getTemporer);
                
                $insert_pendanaan = new \App\PendanaanAktif();  
                $insert_pendanaan->investor_id  = $getTemporer->investor_id;
                $insert_pendanaan->proyek_id    = $getTemporer->proyek_id;
                $insert_pendanaan->total_dana   = $getTemporer->total_price;
                $insert_pendanaan->nominal_awal = $getTemporer->total_price;
                $insert_pendanaan->tanggal_invest = date('Y-m-d');
                $insert_pendanaan->save();
                
                // hapus row table temporer
                TmpSelectedProyek::where('investor_id', $user_id)           
                    ->where('proyek_id', $proyek_id)            
                    ->where('no_va', $va_investor)->delete();   
                //syslog(0, 'Proyek ID / '.$getTemporer->proyek_id.' - Investor ID /'.$getTemporer->investor_id);
                
                // multiple
                // for($i=1; $i<count($getVaTemporer); $i++){
                    
                    // $insert_pendanaan = new \App\PendanaanAktif();  
                    // $insert_pendanaan->investor_id = $getVaTemporer[$i]->investor_id;
                    // $insert_pendanaan->proyek_id = $getVaTemporer[$i]->proyek_id;
                    // $insert_pendanaan->total_dana = $getVaTemporer[$i]->total_price;
                    // $insert_pendanaan->nominal_awal = $getVaTemporer[$i]->total_price;
                    // $insert_pendanaan->tanggal_invest = date('Y-m-d');
                    // $insert_pendanaan->save();
                    
                // }
                
                $rekening->total_dana += $amount;
                $rekening->unallocated += $amount;
                $rekening->payment_ntb = $payment_ntb;
                $rekening->save();
            }
            else
            {
                return response()->json([
                    'status' => '888',
                    'message' => 'Payment NTB double',
                ]);
            }
        
        } else {

                $rekening = RekeningInvestor::where('va_number', $va_investor)->first();
                $amount = (int)$decrypted['payment_amount'];
                $payment_ntb_exist = $rekening['payment_ntb'];

                if ($payment_ntb != $payment_ntb_exist)
                {
                    $rekening->total_dana += $amount;
                    $rekening->unallocated += $amount;
                    $rekening->payment_ntb = $payment_ntb;
                    $rekening->save();
                }
                else
                {
                    return response()->json([
                        'status' => '888',
                        'message' => 'Payment NTB double',
                    ]);
                }
            
        }
        // call event that will log the cash flow
        event(new MutasiInvestorEvent($rekening->investor->id,'CREDIT',$amount,'Transfer Rekening'));

        #pesan verifikasi
        // $data = array(
        //     'amount' => $amount,
        //     'investor_id' => $rekening->investor_id
        // );
        // $this->msgVerification($data);
        #end pesan verifikasi

        // event(new MutasiInvestorEvent($user->id,'CREDIT',$amount,'Transfer Rekening'));     
            
        return response()->json([
            'status' => '000'
        ]);
    }

    // Show mutasi rekening milik investor
    public function mutasiInvestor(){
        $user = Auth::user();
        $rekening = RekeningInvestor::where('investor_id',$user->id)->first();
        $totalDana = (!empty($rekening->total_dana)?$rekening->total_dana:0);
        return view('pages.user.mutation_history',compact('totalDana'));
    }

    public function get_list_mutasi_history()
    {
        $user = Auth::user();
        $date = Carbon::now()->subDays(30);
        // $date_now = Carbon::now();
        // $data_mutasi_awal = MutasiInvestor::where('investor_id', $user->id)
        //                             ->where('created_at', '<', $date)
        //                             ->where('perihal', 'not like', '%pengembalian dana pokok%')
        //                             ->where('perihal', 'not like', '%pengembalian pokok%')
        //                             ->where('perihal', 'not like', '%sisa imbal hasil%')
        //                             ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
        //                             ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
        //                             //  ->orderBy('created_at', 'ASC')
        //                             ->whereIn('tipe', ['CREDIT', 'DEBIT'])
        //                             ->get();

        // $data_mutasi = "";
        $data_mutasi = MutasiInvestor::where('investor_id', $user->id)
                                    //  ->where('created_at','>=', Carbon::now()->subDays(30))
                                     ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                     ->where('perihal', 'not like', '%pengembalian pokok%')
                                     ->where('perihal', 'not like', '%sisa imbal hasil%')
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
        // if(!empty($data_mutasi_awal))
        // {
        //     foreach($data_mutasi_awal as $dt_a)
        //     {
        //         if($dt_a->tipe == "DEBIT")
        //           {
        //             $total_first = $dt_a->nominal - $valuefirst;
        //             $valuesecond =  $total -= $total_first;
        //           }
        //           elseif($dt_a->tipe == "CREDIT")
        //           {
        //             $total_first = $dt_a->nominal + $valuefirst;
        //             $valuesecond =  $total += $total_first;
        //           }
        //     }
        // }
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

        echo json_encode($parsingJSON);

    }

    public function get_params_mutasi_history($startDate,$endDate)
    {
        $user = Auth::user();
        // $date = Carbon::now()->subDays(30);
        $date_now = Carbon::now();
        $data_mutasi_awal = MutasiInvestor::where('investor_id', $user->id)
                                          ->where('created_at', '<', $startDate)
                                          ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                          ->where('perihal', 'not like', '%pengembalian pokok%')
                                          ->where('perihal', 'not like', '%sisa imbal hasil%')
                                          ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                          ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                          //    ->orderBy('created_at', 'ASC')
                                          ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                          ->get();
        $data_mutasi = MutasiInvestor::where('investor_id', $user->id)
                                     ->whereBetween('created_at',[$startDate." 00:00:00", $endDate." 23:59:59"])
                                     ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                     ->where('perihal', 'not like', '%pengembalian pokok%')
                                     ->where('perihal', 'not like', '%sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                     ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                     //  ->orderBy('created_at', 'ASC')
                                     ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                     ->get();
        $data_mutasi_akhir = MutasiInvestor::where('investor_id', $user->id)
                                           ->where('perihal', 'not like', '%pengembalian dana pokok%')
                                           ->where('perihal', 'not like', '%pengembalian pokok%')
                                           ->where('perihal', 'not like', '%sisa imbal hasil%')
                                           ->where('perihal', 'not like', '%pengembalian sisa imbal hasil%')
                                           ->where('perihal', 'not like', '%transfer sisa imbal hasil%')
                                           //    ->orderBy('created_at', 'ASC')
                                           ->whereIn('tipe', ['CREDIT', 'DEBIT'])
                                           ->get();
         // dd($data_mutasi);die;
        
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

    public function cetakulangsertifikat($id)
    {
                                                                                
            $data_rek = RekeningInvestor::where('investor_id',$id)->first();
            $data_user = DetilInvestor::where('investor_id',$id)->first();
            $reprint = LogSertifikat::where('investor_id',$id)->orderBy('id','desc')->limit(1)->first();
            $id_s = $reprint['id'];
            $all_random = $reprint['seri_sertifikat'];
            $total_s = $reprint['total_dana'];
            $dana = number_format($total_s,0,",",".");
            
            // mengambil nama investor
            $nama_investor = $data_user['nama_investor'];
            $rek_investor = $data_user['rekening'];
            $bank_investor = $data_user['bank_investor'];
            $alamat_investor = $data_user['alamat_investor'];
            
            // mengambil dana

            // mengambil VA 
            $nomer_va = $data_rek['va_number'];
            
            // mengambil nama bank 
            $master_bank = MasterBank::where('kode_bank',$bank_investor)->first();
            $bankinvestor = $master_bank['nama_bank'];
            

            // merubah dana menjadi terbilang Words   
            $terbilang = Terbilang::make($total_s,' rupiah');
            
            // menjadi huruf kapital depannya
            $hasil_bilangan = ucwords($terbilang);

            $title = 'Sertifikat - '.$nama_investor;

            $pdf=PDF::loadView('pages.user.e_sertifikat_user',
            [
                // 'iduser'=>$iduser,
                'title' => $title,
                'dana' =>$dana,
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
        // $pdf->setEncryption('copy');
        return $pdf->download('Sertifikat - '.$nama_investor.'.pdf');
    }

    public function printsertifikat($id){
        
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
        $date = mt_rand($tanggal,999999);
        $random = mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(00,99) . mt_rand(0,9); 
        
        $all_random = $random.'/ L - '.$iduser.'/'. $date;

        $check_log = LogSertifikat::where('total_dana',$total)->where('investor_id',$id)->limit(1)->first();
        $total_cek = $check_log['total_dana'];
        /* if($total_cek == $total){
            return redirect()->back()->with('error_log', 'Sertifikat Sudah Dicetak');
        }
        else
        { */

        $data_log = new LogSertifikat;
        $data_log->investor_id = $iduser;
        $data_log->seri_sertifikat = $all_random;
        $data_log->total_dana = $total;

        $data_log->save();
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
        // $pdf->setEncryption('copy');
        $path = storage_path('app/public/sertifikat');
        $fileName =  $data_log['title'] . 'Sertifikat - '.$id.'.pdf' ;
        $pdf->save($path . '/' . $fileName);

        $data_log->save();
        
        if($pdf){
            return ('success');    
        }else{
            return ('failed');
        }
        
        // return $pdf->download('Sertifikat - '.$nama_investor.'.pdf');
    }
    
    public function cekSertifikat($id){

        $rekening = RekeningInvestor::where('investor_id',$id)
                                    ->first();

        $log_sertifikat = LogSertifikat::select('total_dana')->where('investor_id', $id)->orderby('id', 'desc')->first();

        if($log_sertifikat==null){
            $cetak_sertifikat = $this->printsertifikat($id);
            $filename = 'Sertifikat - '.$id.'.pdf';
            $path = storage_path("app/public/sertifikat/Sertifikat - ".$id.'.pdf');

            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }

        $total_dana = (!empty((int)$rekening->total_dana)?(int)$rekening->total_dana:0);
        $log_dana = (!empty((int)$log_sertifikat->total_dana)?(int)$log_sertifikat->total_dana:0);

        if(Storage::disk('public')->exists('sertifikat/'.'Sertifikat - '.$id.'.pdf') && $total_dana == $log_dana){
            $filename = 'Sertifikat - '.$id.'.pdf';
            $path = storage_path("app/public/sertifikat/Sertifikat - ".$id.'.pdf');

            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }else{
            $cetak_sertifikat = $this->printsertifikat($id);
            $filename = 'Sertifikat - '.$id.'.pdf';
            $path = storage_path("app/public/sertifikat/Sertifikat - ".$id.'.pdf');

            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }
    }

    // Show Penarikan dana form
    public function showPenarikanDana(){
        // $rekening = Auth::user()->rekeningInvestor;
        $pendanaan = Auth::user()->pendanaanAktif;
        $unallocated = Auth::user()->rekeningInvestor;
        $nama = Auth::user()->detilInvestor;
        $master_bank = MasterBank::where('kode_bank',$nama->bank_investor)->first(['nama_bank']);

        return view('pages.user.withdraw_request')->with('pendanaan',$pendanaan)->with('unallocated',$unallocated)->with('nama', $nama)->with('master_bank',$master_bank);
    }

    // Process the cash checkout request
    public function penarikanDana(Request $request){
        // $rekening = Auth::user()->rekeningInvestor;
        // $requestAmount = $request->nominal;

        // use laravel collection method SUM()
        // $sumAvailable = $rekening->unallocated;

        // if($requestAmount > $sumAvailable || $requestAmount <= 0){
        //     // Throw error, cant  request more than available sum
        //     return redirect()->back()->with('error','Penarikan dana anda lebih dari dana tersedia, silahkan mengambil uang pada pendanaan anda terlebih dahulu');
        // }
        $cekDanaTersedia = RekeningInvestor::where('investor_id',Auth::user()->id)->first();
        $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::user()->id)->where('accepted',0)->sum('jumlah');
        // dd($jumlahPenarikan);die;
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

            // event(new MutasiInvestorEvent(Auth::user()->id,'request DEBIT',-$request->nominal,'Penarikan dana sedang diproses'));
            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Permohonan penarikan dana";
            $audit->ip_address =  \Request::ip();
            $audit->save();

            return redirect('user/dashboard')->with('success','Penarikan dana anda akan kami proses. Terima kasih');
        }
        else
        {
            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Permohonan penarikan dana";
            $audit->ip_address =  \Request::ip();
            $audit->save();

            return redirect('user/dashboard')->with('success','Penarikan dana anda akan kami proses. Terima kasih');
        }


        
    }

    public function msgVerification($data){
        
        $rekening = RekeningInvestor::join('detil_investor', 'detil_investor.investor_id', '=', 'rekening_investor.investor_id')
                    ->select('detil_investor.nama_investor', 'detil_investor.phone_investor', 'rekening_investor.total_dana')
                    ->where('rekening_investor.investor_id', $data['investor_id'])->first();
        $to =  $rekening->phone_investor;
        $amount = "Rp.".number_format($data['amount'],0,',','.');
        $total_dana = "Rp.".number_format($rekening->total_dana,0,',','.');
        // $to = '081318988499';
        $text =  'Top up dana sebesar '.$amount.' BERHASIL ditambahkan ke Akun '.strtoupper($rekening->nama_investor).'. Total Aset anda saat ini '.$total_dana.'.';
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
            $responseBody = json_decode($response);
            curl_close($ch);
        }   

        if($response){
            return response()->json(['success'=>$text]);
        }else{
            return response()->json(['success'=>'gagal']);
        }
    }

    public function testing(){
        $data = array(
            'amount' => '2000000',
            'investor_id' => '5358'
        );
        $this->msgVerification($data);
    }

    public function penarikanDanaNew($id,$dana){
      // $rekening = Auth::user()->rekeningInvestor;
      // $requestAmount = $request->nominal;

      // use laravel collection method SUM()
      // $sumAvailable = $rekening->unallocated;

      // if($requestAmount > $sumAvailable || $requestAmount <= 0){
      //     // Throw error, cant  request more than available sum
      //     return redirect()->back()->with('error','Penarikan dana anda lebih dari dana tersedia, silahkan mengambil uang pada pendanaan anda terlebih dahulu');
      // }
      $cekDanaTersedia = RekeningInvestor::where('investor_id',$id)->first();
      $data_rekening = DetilInvestor::where('investor_id',$id)->first();
      $jumlahPenarikan = PenarikanDana::where('investor_id',$id)->where('accepted',0)->sum('jumlah');
      // dd($jumlahPenarikan);die;
      $totalDana = $dana + $jumlahPenarikan;
      
      if ($totalDana <= $cekDanaTersedia->unallocated)
      {
          // Create new record penarikan dana
          PenarikanDana::create([
              'investor_id' => $id,
              'jumlah' => $dana,
              'no_rekening' => $data_rekening->rekening,
              'bank' => $data_rekening->bank,
              'accepted' => 0,
              'perihal' => 'Pengajuan Penarikan Dana',
          ]);

          // event(new MutasiInvestorEvent(Auth::user()->id,'request DEBIT',-$request->nominal,'Penarikan dana sedang diproses'));
          return redirect('user/dashboard')->with('success','Penarikan dana anda akan kami proses. Terima kasih');
      }
      else
      {
          return redirect('user/dashboard')->with('success','Penarikan dana anda akan kami proses. Terima kasih');
      }
      
  }

    public function verificationCode($id){

        $phone_get = DetilInvestor::where('investor_id',$id)->first(['phone_investor']);
        // $to =  $phone_get;
        $to = '082213953400';
        $otp = rand(100000, 999999);
        $text =  'Kode OTP : '.$otp.' Silahkan masukan kode ini untuk melanjutkan proses penarikan tunai.';

        //send to db
        $detil = DetilInvestor::where('investor_id', $id)->update(['OTP' => $otp]);

        $pecah              = explode(",",$to);
        $jumlah             = count($pecah);
        $from               = "SMSVIRO"; //Sender ID or SMS Masking Name, if leave blank, it will use default from telco
        // $username           = "smsvirodemo";
        // $password           = "qwerty@123";
        // $from               = "DANASYARIAH";
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

        if($detil){
            $data = ['success' => true, 'message' => 'Silahkan masukan kode ini untuk melanjutkan proses penarikan tunai.'];
            return response()->json($data);
        }else{
          $data = ['success' => false, 'message' => 'Data Telepon tidak benar.'];
          return response()->json($data);
        }
    }

    public function sendVerifikasi($id, $otp, $dana){

        $cek = DetilInvestor::where('investor_id', $id)->where('OTP', $otp)->count();
        if ($cek == 1){
            $detil = DetilInvestor::where('investor_id', $id)->update(['OTP' => '']);
            $this->penarikanDanaNew($id,$dana);
            $data = ['success' => true, 'message' => 'Kode OTP Authtentication.'];
            return response()->json($data);
        }else{
          $data = ['success' => false, 'message' => ' Kode Salah, Masukan Kembali. '];
          return response()->json($data);  
        }      
        
    }

    // public function enkripsi(Request $request){
    //     $username = $request->username;
    //     $date = \Carbon\Carbon::now()->addYear(4);
    //     // $user = Investor::where('username', $username)->first();
    //     $data = [
    //         // 'type' => 'createbilling',
    //         // 'client_id' => self::CLIENT_ID,
    //         // 'trx_id' => $user->id,
    //         // 'trx_amount' => '0',
    //         // 'customer_name' => $user->detilInvestor->nama_investor,
    //         // 'customer_email' => $user->email,
    //         // 'virtual_account' => '8'.self::CLIENT_ID.$user->detilInvestor->getVa(),
    //         // 'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
    //         // 'billing_type' => 'o',

    //         "trx_id" => "1230000001",
    //         "virtual_account" => "8805085123234345",
    //         "customer_name" => "Mr. X",
    //         "trx_amount" => "100000",
    //         "payment_amount" => "100000",
    //         "cumulative_payment_amount" => "100000",
    //         "payment_ntb" => "233171",
    //         "datetime_payment" => "2016-03-01 14:00:00", 
    //         "datetime_payment_iso8601" => "2016-03-01T14:00:00+07:00"
    //     ];

    
    //     $encrypted = BniEnc::encrypt($data,self::CLIENT_ID,self::KEY);

    //     return $encrypted;
    // }

    public function checkStatusUser($id_proyek, $qty){
        $investor_id = Auth::user()->id;
        $username    = Auth::user()->username;

        $log_akad   = LogAkadDigiSignInvestor::where('investor_id', $investor_id)->where('proyek_id', $id_proyek)->whereIn('status', ['waiting', 'complete'])->first();
        if(isset($log_akad)){
            return response()->json([
                'status'        => 'sudah_ttd',
                'keterangan'    => "Sudah TTD Akad, Lanjut ke proses Pendanaan"
             ]);
        }else{
            return response()->json([
                'status'        => 'belum TTD',
                'keterangan'    => "Belum TTD Akad"
             ]);
        }
    }

    public function checkStatusUserInvest($id_proyek, $qty){
        
        // $investor_id = 52257;
        // $username = 'dudu';
        $investor_id = Auth::user()->id;
        $username    = Auth::user()->username;
        $client      = new RDLController;
        $log_generate= new logGenerateVaRdl;

        $rekening   = RekeningInvestor::where('investor_id', $investor_id)->first();
        $rdl        = RDLAccountNumber::where('investor_id', $investor_id)->first();
        $log_akad   = LogAkadDigiSignInvestor::where('investor_id', $investor_id)->where('proyek_id', $id_proyek)->whereIn('status', ['waiting', 'complete'])->first();
        $proyek     = Proyek::where('id','=', $id_proyek)->first();

        //Jika sudah punya rekening
        if(isset($rekening) and isset($rdl)){
            if($rekening->va_number == "" || $rekening->va_number == null){
                // generate VA
                $generate_va = $this->generateVABNI_Investor_test($username);
                
                if(!$generate_va){
                    $generate_cif_number = $client->RegisterInvestor($investor_id, '009');
                    $response_decode = json_decode($generate_cif_number);
                    $cif_number = $response_decode->{'response'}->{'cifNumber'};
                    if($response_decode->{'response'}->{'responseCode'} == "0001"){
                        $generate_account_number = $client->RegisterInvestorAccount($investor_id, $cif_number, '009');
                        $response_decode_account = json_decode($generate_account_number);
                            if($response_decode_account->{'response'}->{'responseCode'} == "0001"){
                                $log_generate->status = 011;
                                $log_generate->investor_id= $investor_id;
                                $log_generate->status_number = 'VA Gagal, CIF Sukses, ACN Sukses';
                                $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                                $log_generate->save();

                                return response()->json([
                                    'status'        => '011',
                                    'status_number' => 'VA Gagal, CIF Sukses, ACN Sukses',
                                    'keterangan'    => "Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA"
                                ]);
                            }else{
                                $log_generate->status = 010;
                                $log_generate->investor_id= $investor_id;
                                $log_generate->status_number = 'VA Gagal, CIF Sukses, ACN Gagal';
                                $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                                $log_generate->save();

                                return response()->json([
                                    'status'        => '010',
                                    'status_number' => 'VA Gagal, CIF Sukses, ACN Gagal',
                                    'keterangan'    => 'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA'
                                ]);
                            }
                    }else{

                        $log_generate->status = 000;
                        $log_generate->investor_id= $investor_id;
                        $log_generate->status_number = 'VA Gagal, CIF Gagal, ACN Gagal';
                        $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                        $log_generate->save();

                        return response()->json([
                            'status'        => '000',
                            'status_number' => 'VA Gagal, CIF Gagal, ACN Gagal',
                            'keterangan'    => "Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA"
                        ]);
                    }
                }else{
                    $generate_cif_number = $client->RegisterInvestor($investor_id, '009');
                    $response_decode = json_decode($generate_cif_number);
                    $cif_number = $response_decode->{'response'}->{'cifNumber'};
                    if($response_decode->{'response'}->{'responseCode'} == "0001"){
                        $generate_account_number = $client->RegisterInvestorAccount($investor_id, $cif_number, '009');
                        $response_decode_account = json_decode($generate_account_number);
                            if($response_decode_account->{'response'}->{'responseCode'} == "0001"){

                                $log_generate->status = 111;
                                $log_generate->investor_id= $investor_id;
                                $log_generate->status_number = 'VA Sukses, CIF Sukses, ACN Sukses';
                                $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                                $log_generate->save();

                                return response()->json([
                                    'status'        => '111',
                                    'status_number' => 'VA Sukses, CIF Sukses, ACN Sukses',
                                    'keterangan'    => "Maaf Dana Anda Tidak Cukup, Silahkan Top Up Dahulu ke Rekening anda"
                                ]);
                            }else{

                                $log_generate->status = 110;
                                $log_generate->investor_id= $investor_id;
                                $log_generate->status_number = 'VA Sukses, CIF Sukses, ACN Gagal';
                                $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                                $log_generate->save();

                                return response()->json([
                                    'status'        => '110',
                                    'status_number' => 'VA Sukses, CIF Sukses, ACN Gagal',
                                    'keterangan'    => "Maaf Pembuatan Akun Number anda gagal, Harap menghubungi Customer Service kami untuk pembuatan Akun Number"
                                ]);
                            }
                    }else{

                        $log_generate->status = 100;
                        $log_generate->investor_id= $investor_id;
                        $log_generate->status_number = 'VA Sukses, CIF Gagal, ACN Gagal';
                        $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                        $log_generate->save();

                        return response()->json([
                            'status'        => '100',
                            'status_number' => 'VA Sukses, CIF Gagal, ACN Gagal',
                            'keterangan'    => "Maaf Pembuatan CIF dan Akun Number anda gagal, Harap menghubungi Customer Service kami untuk pembuatan CIF dan Akun Number"
                            ]);
                    }                    
                }
                // return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi. Silahkan Top up terlebih dahulu'); // error validasi investasi
            }else{
                if($rekening->unallocated < $proyek->harga_paket*$qty){ 
                    return response()->json([
                        'status' => 'gagal_dana',
                        'keterangan' => "Maaf Dana Anda Tidak Cukup, Silahkan Top Up Dahulu ke Rekening anda"
                    ]);
                    // return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi. Silahkan Top up terlebih dahulu'); // error validasi investasi
                }else{
                    return response()->json([
                        'status'        => 'lanjut_pendanaan',
                        'keterangan'    => "Lanjut ke proses Pendanaan"
                     ]);
                }
            }
        }elseif(isset($rekening)){
            $generate_cif_number = $client->RegisterInvestor($investor_id, '009');
            $response_decode = json_decode($generate_cif_number);
            $cif_number = $response_decode->{'response'}->{'cifNumber'};
                if($response_decode->{'response'}->{'responseCode'} == "0001"){
                    $generate_account_number = $client->RegisterInvestorAccount($investor_id, $cif_number, '009');
                    $response_decode_account = json_decode($generate_account_number);
                        if($response_decode_account->{'response'}->{'responseCode'} == "0001"){

                            $log_generate->status = 011;
                            $log_generate->investor_id= $investor_id;
                            $log_generate->status_number = 'VA Gagal, CIF Sukses, ACN Sukses masuk elseif';
                            $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                            $log_generate->save();

                            return response()->json([
                                'status'        => '011',
                                'status_number' => 'VA Gagal, CIF Sukses, ACN Sukses',
                                'keterangan'    => "Maaf Dana Anda Tidak Cukup, Silahkan Top Up Dahulu ke Rekening anda"
                            ]);
                        }else{
                            $log_generate->status = 010;
                            $log_generate->investor_id= $investor_id;
                            $log_generate->status_number = 'VA Gagal, CIF Sukses, ACN Gagal';
                            $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                            $log_generate->save();


                            return response()->json([
                                'status'        => '010',
                                'status_number' => 'VA Gagal, CIF Sukses, ACN Gagal',
                                'keterangan'    => "Maaf Dana Anda Tidak Cukup, Silahkan Top Up Dahulu ke Rekening anda"
                            ]);
                        }
                }else{

                    $log_generate->status = 000;
                    $log_generate->investor_id= $investor_id;
                    $log_generate->status_number = 'VA Gagal, CIF Gagal, ACN Gagal';
                    $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                    $log_generate->save();

                    return response()->json([
                        'status'        => '000',
                        'status_number' => 'VA Gagal, CIF Gagal, ACN Gagal',
                        'keterangan'    => "Maaf Dana Anda Tidak Cukup, Silahkan Top Up Dahulu ke Rekening anda"
                    ]);
                }
        }else{
            $generate_va = $this->generateVABNI_Investor_test($username);
                
            if(!$generate_va){
                $generate_cif_number = $client->RegisterInvestor($investor_id, '009');
                $response_decode = json_decode($generate_cif_number);
                $cif_number = $response_decode->{'response'}->{'cifNumber'};
                if($response_decode->{'response'}->{'responseCode'} == "0001"){
                    $generate_account_number = $client->RegisterInvestorAccount($investor_id, $cif_number, '009');
                    $response_decode_account = json_decode($generate_account_number);
                        if($response_decode_account->{'response'}->{'responseCode'} == "0001"){

                            $log_generate->status = 011;
                            $log_generate->investor_id= $investor_id;
                            $log_generate->status_number = 'VA Gagal, CIF Sukses, ACN Sukses masuk else';
                            $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                            $log_generate->save();

                            return response()->json([
                                'status'        => '011',
                                'status_number' => 'VA Gagal, CIF Sukses, ACN Sukses',
                                'keterangan'    => "Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA"
                            ]);
                        }else{

                            $log_generate->status = 010;
                            $log_generate->investor_id= $investor_id;
                            $log_generate->status_number = 'VA Gagal, CIF Sukses, ACN Sukses';
                            $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                            $log_generate->save();

                            return response()->json([
                                'status'        => '010',
                                'status_number' => 'VA Gagal, CIF Sukses, ACN Sukses',
                                'keterangan'    => "Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA"
                            ]);
                        }
                }else{

                    $log_generate->status = 000;
                    $log_generate->investor_id= $investor_id;
                    $log_generate->status_number = 'VA Gagal, CIF Gagal, ACN Gagal';
                    $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                    $log_generate->save();

                    return response()->json([
                        'status'        => '000',
                        'status_number' => 'VA Gagal, CIF Gagal, ACN Gagal',
                        'keterangan'    => "Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA"
                    ]);
                }
            }else{
                $generate_cif_number = $client->RegisterInvestor($investor_id, '009');
                $response_decode = json_decode($generate_cif_number);
                $cif_number = $response_decode->{'response'}->{'cifNumber'};
                if($response_decode->{'response'}->{'responseCode'} == "0001"){
                    $generate_account_number = $client->RegisterInvestorAccount($investor_id, $cif_number, '009');
                    $response_decode_account = json_decode($generate_account_number);
                        if($response_decode_account->{'response'}->{'responseCode'} == "0001"){

                            $log_generate->status = 111;
                            $log_generate->investor_id= $investor_id;
                            $log_generate->status_number = 'VA Sukses, CIF Sukses, ACN Sukses';
                            $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                            $log_generate->save();

                            return response()->json([
                                'status'        => '111',
                                'status_number' => 'VA Sukses, CIF Sukses, ACN Sukses',
                                'keterangan'    => "Maaf Dana Anda Tidak Cukup, Silahkan Top Up Dahulu ke Rekening anda"
                            ]);
                        }else{

                            $log_generate->status = 110;
                            $log_generate->investor_id= $investor_id;
                            $log_generate->status_number = 'VA Sukses, CIF Sukses, ACN Gagal';
                            $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                            $log_generate->save();

                            return response()->json([
                                'status'        => '110',
                                'status_number' => 'VA Sukses, CIF Sukses, ACN Gagal',
                                'keterangan'    => "Maaf Pembuatan Akun Number anda gagal, Harap menghubungi Customer Service kami untuk pembuatan Akun Number"
                            ]);
                        }
                }else{

                    $log_generate->status = 100;
                    $log_generate->investor_id= $investor_id;
                    $log_generate->status_number = 'VA Sukses, CIF Gagal, ACN Gagal';
                    $log_generate->keterangan =  'Maaf Pembuatan VA anda gagal, Harap menghubungi Customer Service kami untuk pembuatan VA';
                    $log_generate->save();

                    return response()->json([
                        'status'        => '100',
                        'status_number' => 'VA Sukses, CIF Gagal, ACN Gagal',
                        'keterangan'    => "Maaf Pembuatan CIF dan Akun Number anda gagal, Harap menghubungi Customer Service kami untuk pembuatan CIF dan Akun Number"
                    ]);
                }                    
            }
        }
    }


    //GENERATE VA BNI KONVENSIONAL
    public function generateVABNI_Investor($username){
        $user = Investor::where('username', $username)->first();
        $date = \Carbon\Carbon::now()->addYear(4);
        
        echo '8'.config('app.bnik_id').$user->detilInvestor->getVa();die;
        
        $data = [
            'type' => 'createbilling',
            'client_id' => config('app.bnik_id'),
            'trx_id' => $user->id,
            'trx_amount' => '0',
            'customer_name' => $user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '8'.config('app.bnik_id').$user->detilInvestor->getVa(),
            'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            'billing_type' => 'o',
        ];

    
        $encrypted = BniEnc::encrypt($data,config('app.bnik_id'),config('app.bnik_key'));

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(config('app.bnik_url'), [
            'json' => [
                'client_id' => config('app.bnik_id'),
                'data' => $encrypted,
            ]
        ]);

        $result = json_decode($result->getBody()->getContents());
        print_r($result);die;
        if($result->status !== '000'){
            return false;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,config('app.bnik_id'),config('app.bnik_key'));
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

	// generate va proyek
    public function generateVABNI_Borrower($username, $id_proyek){
        
        $date = \Carbon\Carbon::now()->addYear(4);
        $data_proyek = Proyek::select('tgl_mulai', 'id')->where('id', $id_proyek)->first();
        $year =  substr($data_proyek->tgl_mulai,2,2);
        $last_digit = sprintf("%04d", $data_proyek->id);
        

        $user = LoginBorrower::where('username', $username)->first();
        $data = [
            'type' => 'createbilling',
            'client_id' => config('app.bnik_id'),
            'trx_id' => $id_proyek,
            'trx_amount' => '0',
            'customer_name' => $user->username,
            'customer_email' => $user->email,
            'virtual_account' => '988'.config('app.bnik_id').'02'.$year.$last_digit,
            'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            'billing_type' => 'o',
        ];
    
        $encrypted = BniEnc::encrypt($data,config('app.bnik_id'),config('app.bnik_key'));

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(config('app.bnik_url'), [
            'json' => [
                'client_id' => config('app.bnik_id'),
                'data' => $encrypted,
            ]
        ]);

        $result = json_decode($result->getBody()->getContents());
        //print_r($result);
		
        if($result->status !== '000'){
            print_r($result);
        }
		
        else{
			
            $decrypted = BniEnc::decrypt($result->data,config('app.bnik_id'),config('app.bnik_key'));
            //return json_encode($decrypted);
            $updateDetails = [
                'va_number' =>  $decrypted['virtual_account']
            ];
			$updateVaNumberProyek = [
                'va_number' =>  $decrypted['virtual_account']
            ];
            
			
            // BorrowerRekening::where('brw_id',$user->brw_id)
                // ->update($updateDetails);
			
			// 
			
			BorrowerPendanaan::where('id_proyek',$id_proyek)
                ->update($updateVaNumberProyek);
				
			
            
            return $decrypted['virtual_account'];
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }

    //GENERATE VA BNI FOR TESTING
    public function generateVABNI_Investor_test($username){

        $log_generate= new logGenerateVaRdl;

        $user = Investor::where('username', $username)->first();
        $date = \Carbon\Carbon::now()->addYear(4);

        $data = [
            'type' => 'createbilling',
            'client_id' => config('app.bnik_id'),
            'trx_id' => $user->id,
            'trx_amount' => '0',
            'customer_name' => $user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '988'.config('app.bnik_id').$user->detilInvestor->getVA_konv(),
            'datetime_expired' => $date->format('Y-m-d').'T'.$date->format('H:i:sP'),
            'billing_type' => 'o',
        ];

        $encrypted = BniEnc::encrypt($data,config('app.bnik_id'),config('app.bnik_key'));

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(config('app.bnik_url'), [
            'json' => [
                'client_id' => config('app.bnik_id'),
                'data' => $encrypted,
            ]
        ]);

        $result = json_decode($result->getBody()->getContents());
        
        if($result->status !== '000'){
            $log_generate->status = 010;
            $log_generate->status_number = $username;
            $log_generate->keterangan =  $result->message;
            $log_generate->save();

            return false;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,config('app.bnik_id'),config('app.bnik_key'));
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

    public function bankResponseKonven(Request $request){

        $data = $request->input('data');
        if($request->input('client_id') != config('app.bnik_id')){
            return response()->json([
                'status' => '999',
                'message' => 'Access Denied',
            ]);
        }
        
        $decrypted 		= BniEnc::decrypt($data,config('app.bnik_id'),config('app.bnik_key'));
        $va_investor 	= $decrypted['virtual_account'];
        $payment_ntb 	= $decrypted['payment_ntb'];

        $rekening 		= RekeningInvestor::where('va_number', $va_investor)->first();
        $amount 		= (int)$decrypted['payment_amount'];
        $payment_ntb_exist = $rekening['payment_ntb'];

        $type_user = substr($va_investor, 8, 2);

        if ($payment_ntb != $payment_ntb_exist)
        {
            if($type_user == 01){
                $rekening->total_dana += $amount;
                $rekening->unallocated += $amount;
                $rekening->payment_ntb = $payment_ntb;
                $rekening->save();
            }
			
			else{
				
				$BorrowerPendanaan 	= BorrowerPendanaan::where('va_number', $va_investor)->first();
				$BorrowerRekening 	= BorrowerRekening::where('brw_id', $BorrowerPendanaan->brw_id)->first();
				$BorrowerRekening->total_sisa += $amount;
				$BorrowerRekening->total_terpakai -= $amount;
                $BorrowerRekening->save();
				
            }
        }
        else
        {
            return response()->json([
                'status' => '888',
                'message' => 'Payment NTB double',
            ]);
        }

    }
	
	public function convertCSV_AFPI(){
		
		$tanggal = date('Ymd');
        //BIKIN FILE CSV SIMPEN KE STORAGE
        $records = [
            [1, 2, 3],
            ['foo', 'bar', 'baz'],
            ['john', 'doe', 'john.doe@example.com'],
        ];
		
		
		$filename = config('app.sft_id').'20200328'.'SIK'.'01';
        $writer = Writer::createFromPath(storage_path('app/public/fdc/'.$filename.'.csv'), 'w+');
        $writer->setDelimiter('|');
        $writer->insertAll($records); //using an array

        //$path_ktp = storage_path('app/public/fdc/'.$filename.'.csv');
        $path = Storage::disk('public')->put('app/public/fdc/'.$filename.'.csv', $writer);
        //FINISH CREATE CSV


        //AMBIL FILE CSV YG UDAH DIBIKIN DIATAS, DIMASUKIN KE ZIP BUAT PASSWORD
        $zip = new ZipArchive;
        if ($zip->open($filename.'.zip', ZipArchive::CREATE) === TRUE)
        {
            
			
			$zip->setPassword($this->GeneratepasswordZIP()); // set password
            $path_ktp = 'user/88887777/'.Carbon::now()->toDateString() . 'mihihi.'.'csv';
            $zip->addFile(storage_path('app/public/fdc/'.$filename.'.csv'));
            //$zip->addFile(storage_path('app/public/fdc/'.$filename.'.csv'), 'test.csv');
            $zip->setEncryptionName('app/public/fdc/'.$filename.'.csv', ZipArchive::EM_AES_256); //Add file name and password dynamically
        
            // All files are added, so close the zip file.
            $zip->close();
			
        }

        //SELESAI ZIP

        // $path_ktp = 'user/88887777/'.Carbon::now()->toDateString() . 'mahaha.'.'zip';
        // $path = Storage::disk('public')->put($path_ktp, $zip);

        $path_afpi = 'in/'.Carbon::now()->toDateString() . 'testing.'.'csv';
        $path = Storage::disk('ftp')->put($path_afpi, $writer);

        if($path){
            echo 'sukses';
        }else{
            echo 'gagal';
        }
    }
	
	// consume inquiry fdc
	public function inquiry_fdc(){
		
		
        $date    = date('dmY');
        $client = new Client();
		$res = $client->request('GET', config('app.sftp_host').'/api/v1/Inquiry', [
			'headers' => [
               'Content-Type'    => 'application/json'
            ],
			'auth' => [config('app.sftp_account_username'), config('app.sftp_account_password')],
			'query' => 
               [
				"id"		=> "3172032803910005", 
				"reason"	=> "1", 
				"reffid"	=> ""
			   ]
		]);
		
		$response = $res->getBody();
        $response_decode = json_decode($response);
		return $response;
		
	}
	
	// consume password fdc
	public function passwordZIP(){
		
		$client = new Client();
		$credentials = base64_encode(config('app.sftp_account_username').':'.config('app.sftp_account_password'));
		
        $request       = $client->post(config('app.sftp_host').'/api/v1/ZipPassword',[
            'headers' => [
               'Content-Type'    => 'application/json',
			   //'Authorization' => 'Basic ' . (string)config('app.sftp_account_username').':'.config('app.sftp_account_password'),
            ],
			'auth' => [config('app.sftp_account_username'), config('app.sftp_account_password')],
            'body' => json_encode(
               ["zipPwd"=> $this->GeneratepasswordZIP()]
            )
            
        ]);
		
		$response = $request->getBody();
        $response_decode = json_decode($response);
		return $response;
		
	}
	
	
	// generate password zip
	function GeneratepasswordZIP() {
		
		$getMonth = date('m'); // get bulan
		
		// select password in table
		$passwordZip = DB::table('fdc_zip_password')
		->orderBy('tanggal', 'asc')
		->first();
		
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		
		$password = implode($pass); // set password
		
		$getMonthPass = explode('-',$passwordZip->tanggal); // get bulan
		
		if($passwordZip){
			if($getMonth == $getMonthPass[1]){
				
				return $passwordZip->password; //turn the array into a string
				
			}else{
				
				$updatePassword = FDCPassword::where('id',1)->update(['tanggal' => date('Y-m-d'), 'password' => $password]);
				
				return $updatePassword->password; //turn the array into a string
			}
		}else{
			
			$fdc_passsword = new \App\FDCPassword();
			$fdc_passsword->tanggal    	= date('Y-m-d');
			$fdc_passsword->password    = $password;
			$insert_pendanaan->save();
			
			return $password; //turn the array into a string
		}
		
	}
	
	


}
