<?php

namespace App\Http\Controllers;

use App\Proyek;
use Illuminate\Http\Request;
use Auth;
use Cart;
use App\PenarikanDana;
use App\RekeningInvestor;
use App\PendanaanAktif;
use App\LogPendanaan;
use App\TmpSelectedProyek;
use Carbon\Carbon;
use App\Http\Middleware\UserCheck;
// use App\Subscribe;
use App\Http\Middleware\StatusProyek;
use App\AuditTrail;
use App\Investor;
use App\DetilInvestor;
use App\BniEnc;
use GuzzleHttp\Client;
use App\Http\Controller\UserController;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    //development
    // private const CLIENT_ID = '805';
    // private const KEY = '34e64c3fe14335eb64f5c1b2d6e75508';
    // private const API_URL = 'https://apibeta.bni-ecollection.com/';
    
    //production
    private const CLIENT_ID = '757';
    private const KEY = '9f918ff65dc67027fc5670b7b7a7e89f';
    private const API_URL = 'https://api.bni-ecollection.com/';
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(UserCheck::class);
        $this->middleware(StatusProyek::class);
    }
    
    // public function index()
    // {
    //     //show the shopping cart page
    //     $cart = Cart::content();
    //     $val = 0 ;
    //     foreach ($cart as $item) {
    //         $val = $val + $item->subprice;
    //     };
    //     // return $cart;

    //     $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
    //     if (isset($rekening))
    //     {
    //         if ($rekening->unallocated < $val){
    //         $status = 'Dana tersedia anda tidak mencukupi, silahkan isi dibagian tambah dana';
    //             // return $status;
    //             return view('pages.user.shopping_cart')->with('cart',$cart)->with('total', $val)->with('status', 'Dana tersedia anda tidak mencukupi, silahkan isi dibagian tambah dana')->with('rekening', $rekening);
    //         }
    //         else
    //         {
    //             return view('pages.user.shopping_cart')->with('cart',$cart)->with('total', $val)->with('status', false)->with('rekening', $rekening);
    //         }
    //     }
    //     else
    //     {
    //         return view('pages.user.shopping_cart')->with('cart',$cart)->with('total', $val)->with('status', 'Dana tersedia anda tidak mencukupi, silahkan isi dibagian tambah dana')->with('rekening', $rekening);
    //     }
    // }
    
    /*

    public function cekProyekAvailable($id,$qty)
    {
        $jumlahPendanaan = PendanaanAktif::where('proyek_id',$id)->sum('total_dana');
        $proyek = Proyek::where('id', $id)->get();
        $selesai = Carbon::parse($proyek[0]->tgl_selesai_penggalangan)->toDateString();
        $sekarang = Carbon::now()->toDateString();
        
        if ($jumlahPendanaan+$proyek[0]->terkumpul < $proyek[0]->total_need && $selesai >= $sekarang)
        {
            $add = Cart::add($proyek, $proyek[0]->nama, $qty, $proyek[0]->harga_paket);
            return redirect()->back()->with('success', 'Added to Cart');
        }
        elseif ($jumlahPendanaan+$proyek[0]->terkumpul < $proyek[0]->total_need && $selesai < $sekarang)
        {
            return redirect()->back()->with('error', 'Penggalangan Dana Proyek Sudah Selesai');
        }
        elseif($jumlahPendanaan+$proyek[0]->terkumpul >= $proyek[0]->total_need && $selesai >= $sekarang)
        {
            return redirect()->back()->with('error', 'Proyek Sudah Penuh');
        }
        else
        {
            return redirect()->back()->with('error', 'Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai');
        }
    }
    */

    /**
     * Add to Cart
     */
     
    public function generateVA_new($username, $amount){
        
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
        if($result->status !== '000'){
            return False;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,self::CLIENT_ID,self::KEY);
            //return json_encode($decrypted);
            // $user->RekeningInvestor()->create([
                // 'investor_id' => $user->id,
                // 'total_dana' => 0,
                // 'va_number' => $decrypted['virtual_account'],
                // 'unallocated' => 0,
            // ]);
            
            return $decrypted['virtual_account'];
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }
    
    public function create_invoice(Request $request){
        // create invoice id & update status proyek list
        
        $arr_proyek_id = explode('|', $request->proyek_id);
        $count_arr_proyek_id =  count($arr_proyek_id);
        
        $datenow     = date('Ymd');
        $dateExpired = date('Y-m-d H:i:s');
        $uniq_id     = rand(100, 999);
        $user_id     = Auth::user()->id;
        $username    = Auth::user()->username;
        $invoice_id  = $datenow.$uniq_id.$user_id;
        
        $no_va = $this->generateVA_new($username,$request->total_danai);
        for($i=0; $i<$count_arr_proyek_id; $i++){
            $updateDetails = [
                'status' =>  1,
                'invoice_id' =>  $invoice_id,
                'no_va' =>  $no_va
            ];
            
            TmpSelectedProyek::where('investor_id',$user_id)
                ->where('proyek_id',$arr_proyek_id[$i])
                ->update($updateDetails);
            
        }
        
        return response()->json([
            'status' => 'ok',
            'no_va' => $no_va,
            'expired_date' => $dateExpired
        ]);
        
    }
    
    ///******************************* MASTER ADD PENDANAAN ************************///
     // public function add(Request $r)
    // {
        
        // $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        // $proyek     = Proyek::where('id','=', $r->txt_idProyek)->get();
        
        // if (isset($rekening))
        // {
            // if($rekening->unallocated < $proyek[0]->harga_paket*$r->txt_qty){

                // return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi'); // error validasi investasi
                
            // }else{
                
                // $jumlahPendanaan = PendanaanAktif::where('proyek_id',$r->txt_idProyek)->sum('total_dana');
                // $selesai     = Carbon::parse($proyek[0]->tgl_selesai_penggalangan)->toDateString();
                // $sekarang    = Carbon::now()->toDateString();
                
                // $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::user()->id)->where('accepted',0)->sum('jumlah');
                // $totalDana = ($proyek[0]->harga_paket*$r->txt_qty) + $jumlahPenarikan;
                // $jumlahRekening = 0;
                // $jumlahRekening += $rekening->unallocated;
                
                // if ($jumlahPendanaan+$proyek[0]->terkumpul < $proyek[0]->total_need && $selesai >= $sekarang)
                // {
                    
                    // if ($totalDana >  $jumlahRekening)
                    // {
                        // return redirect()->back()->with('msg_error', 'Dana Tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana');
                    // }
                    // else
                    // {
                        // $pendanaan = new PendanaanAktif;
                        // $pendanaan->investor_id = Auth::user()->id;
                        // $pendanaan->proyek_id = $r->txt_idProyek;
                        // $harga_paket = $proyek[0]->harga_paket;
                        // $pendanaan->total_dana = $harga_paket*$r->txt_qty;
                        // $pendanaan->nominal_awal = $harga_paket*$r->txt_qty;
                        // $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                        // $pendanaan->last_pay = Null;
                        // $pendanaan->save();

                        // $user = Auth::user();
                        // $log = new LogPendanaan;
                        // $log->pendanaanAktif_id = $pendanaan->id;
                        // $log->nominal = $pendanaan->nominal_awal;
                        // $log->tipe = 'add new investation';
                        // $log->save();
                        
                        // $rekening->unallocated = $rekening->unallocated - $harga_paket*$r->txt_qty;
                        // $rekening->save();

                        // $audit = new AuditTrail;
                        // $username = Auth::guard()->user()->username;
                        // $audit->fullname = $username;
                        // $audit->description = "Pendanaan Proyek Berhasil";
                        // $audit->ip_address =  \Request::ip();
                        // $audit->save();
                        
                        // return redirect()->back()->with('msg_success', 'pendanaan Berhasil'); // sukses investasi
                    // }
                    
                // }
                // elseif ($jumlahPendanaan+$proyek[0]->terkumpul < $proyek[0]->total_need && $selesai < $sekarang)
                // {
                    // $audit = new AuditTrail;
                    // $username = Auth::guard()->user()->username;
                    // $audit->fullname = $username;
                    // $audit->description = "Pendanaan proyek gagal karena penggalangan dana proyek sudah selesai";
                    // $audit->ip_address =  \Request::ip();
                    // $audit->save();

                    // return redirect()->back()->with('msg_success', 'Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
                // }
                // elseif($jumlahPendanaan+$proyek[0]->terkumpul >= $proyek[0]->total_need && $selesai >= $sekarang)
                // {
                    // $audit = new AuditTrail;
                    // $username = Auth::guard()->user()->username;
                    // $audit->fullname = $username;
                    // $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh";
                    // $audit->ip_address =  \Request::ip();
                    // $audit->save();

                    // return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh'); // error validasi investasi
                // }
                // else
                // {
                    // $audit = new AuditTrail;
                    // $username = Auth::guard()->user()->username;
                    // $audit->fullname = $username;
                    // $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh & penggalangan dana proyek sudah selesai";
                    // $audit->ip_address =  \Request::ip();
                    // $audit->save();

                    // return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
                // }
            // }
        // }
        // else
        // {
            
            // $audit = new AuditTrail;
            // $username = Auth::guard()->user()->username;
            // $audit->fullname = $username;
            // $audit->description = "Pendanaan proyek gagal karena dana anda tidak mencukupi";
            // $audit->ip_address =  \Request::ip();
            // $audit->save();

            // return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi'); // error validasi investasi
        // }
    // }
    
    /*************************** REQUEST OJK *****************************/
    public function add(Request $r)
    {
        $proyek_id      = $r->txt_idProyek;
        $investor_id    = $r->investor_id;
        $qty            = $r->txt_qty;
        $total          = $r->txt_total_qty;
        $user           = Auth::user();
        // echo $proyek_id;die;
        $rekening   = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        $proyek     = Proyek::where('id','=', $proyek_id)->first();
        $RekeningController = new RekeningController();
        
        if(isset($rekening)){
             
            if($rekening->va_number == "" || $rekening->va_number == null){
                // generate VA
                
                // return response()->json([
                //  'status'        => 'gagal_va',
                //  'keterangan'    => "Sukses Membuat Virtual Account, Silahkan Ulangi Proses Kembali",
                //  'va_number'     => $RekeningController->generateVa()
                // ]);
                $RekeningController->generateVa();
                return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi. Silahkan Top up terlebih dahulu'); // error validasi investasi
                
                
            }elseif(!empty($rekening->va_number)){
                
                if($rekening->unallocated < $proyek->harga_paket*$qty){ 
                    // return response()->json([
                    //  'status' => 'gagal_dana',
                    //  'keterangan' => "Maaf Dana Anda Tidak Cukup"
                    // ]);
                    
                    return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi. Silahkan Top up terlebih dahulu'); // error validasi investasi
                    
                }else{
                    
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
                            // return response()->json([
                            //  'status' => 'gagal_dana_tersedia',
                            //  'keterangan' => "Dana Tersedia anda sebesar Rp ".number_format($jumlahPenarikan,0,"",".")." sedang kami proses di penarikan dana"
                            // ]);
                            return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi karena dana tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana');
                        }
                        else
                        {
                            // tambah kondisi jika ditanggal yang sama 
                            $check = PendanaanAktif::where('investor_id', Auth::user()->id)
                            ->where('tanggal_invest',Carbon::now()->toDateString())
                            ->where('proyek_id', $proyek_id);

                            if($check->count() == 0){
                                $pendanaan = new PendanaanAktif;
                                $pendanaan->investor_id = Auth::user()->id;
                                $pendanaan->proyek_id = $proyek_id;
                                $harga_paket = $proyek->harga_paket;
                                $pendanaan->total_dana = $harga_paket*$qty;
                                $pendanaan->nominal_awal = $harga_paket*$qty;
                                $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                                $pendanaan->last_pay = Null;
                                $pendanaan->save();

                                $log = new LogPendanaan;
                                $log->pendanaanAktif_id = $pendanaan->id;
                                $log->nominal = $pendanaan->nominal_awal;
                                $log->tipe = 'add active investation';
                                $log->save();
                            }else{
                                $harga_paket = $proyek->harga_paket;
                                $val = $harga_paket*$qty;
                                $pendanaanAktif = $check->first();
                                $pendanaanAktif->update(['total_dana' => $pendanaanAktif->total_dana+$val , 'nominal_awal'=>$pendanaanAktif->nominal_awal+$val]);
                    
                                $log = new LogPendanaan;
                                $log->pendanaanAktif_id = $pendanaanAktif->id;
                                $log->nominal = $val;
                                $log->tipe = 'add active investation';
                                $log->save();
                            }
                            
                            $rekening->unallocated = $rekening->unallocated - $harga_paket*$qty;
                            $rekening->save();

                            $audit = new AuditTrail;
                            $username = Auth::guard()->user()->username;
                            $audit->fullname = $username;
                            $audit->description = "Pendanaan Proyek Berhasil";
                            $audit->ip_address =  \Request::ip();
                            $audit->save();
                            
                            // return response()->json([
                            //  'status' => 'sukses_dana',
                            //  'keterangan' => "Proses Pendanaan Berhasil"
                            // ]);
                            return redirect()->back()->with('msg_success', 'Pendanaan Berhasil'); // sukses investasi
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
                        // return response()->json([
                        //  'status' => 'gagal_dana_proyek_selesai',
                        //  'keterangan' => "Penggalangan Dana Proyek Sudah Selesai"
                        // ]);
                            
                        return redirect()->back()->with('msg_success', 'Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
                    }
                    elseif($jumlahPendanaan+$proyek->terkumpul >= $proyek->total_need && $selesai >= $sekarang)
                    {
                        $audit = new AuditTrail;
                        $username = Auth::guard()->user()->username;
                        $audit->fullname = $username;
                        $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh";
                        $audit->ip_address =  \Request::ip();
                        $audit->save();
                        // return response()->json([
                        //  'status' => 'gagal_dana_penuh',
                        //  'keterangan' => "Proyek Sudah Penuh"
                        // ]);
                        
                        return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh'); // error validasi investasi
                    }
                    else
                    {
                        $audit = new AuditTrail;
                        $username = Auth::guard()->user()->username;
                        $audit->fullname = $username;
                        $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh & penggalangan dana proyek sudah selesai";
                        $audit->ip_address =  \Request::ip();
                        $audit->save();
                        // return response()->json([
                        //  'status' => 'gagal_dana_penuh_selesai',
                        //  'keterangan' => "Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai"
                        // ]);
                        
                        return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
                    }
                }
            }
        }
        else{
            
            // return response()->json([
            //  'status'        => 'gagal_va',
            //  'keterangan'    => "Sukses Membuat Virtual Account, Silahkan Ulangi Proses Kembali",
            //  'va_number'     => $RekeningController->generateVa()
            // ]);
            $RekeningController->generateVa();
            return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi. Silahkan Top up terlebih dahulu');
        }
        
    }

    public function addSelected(Request $r)
    {
        
        $selected = new TmpSelectedProyek;
        
        $now = date("Y-m-d H:i:s");
        //$expired_date = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($now))); 
        $proyek     = Proyek::where('id','=', $r->txt_idProyek)->get();
        $investor_id = $proyek[0]->investor_id;
        $harga_paket = $proyek[0]->harga_paket;
        $selected->investor_id = Auth::user()->id;
        $selected->proyek_id = $r->txt_idProyek;
        $harga_paket = $proyek[0]->harga_paket;
        $selected->total_price= $harga_paket*$r->txt_qty;
        $selected->qty = $r->txt_qty;
        //$selected->exp_date = $expired_date;
        //$selected->exp_date = $expired_date;
        $selected->save();

        return redirect()->back()->with('msg_success', 'Proyek berhasil ditambahkan ke proyek dipilih'); // sukses pilih proyek
    }

    public function updateSelectedPaket(Request $request)
    {
       
        $updateDetails = [
            'qty' =>  $request->qty,
            'total_price' =>  $request->totalInvest
        ];
        
        TmpSelectedProyek::where('id',$request->proyekid)->update($updateDetails);

        return redirect()->back()->with('msg_success', 'Paket proyek berhasil diubah'); // sukses pilih proyek
    }

    public function newAdd(Request $r)
    {

        $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        $proyek     = Proyek::where('id','=', $r->txt_idProyek)->get();
        
        if (isset($rekening))
        {
            if($rekening->unallocated < $proyek[0]->harga_paket*$r->txt_qty){

                $id = $r->txt_id;
                //TmpSelectedProyek::where('id', $id)->update(['status'=>'2']);
                return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi. Silahkan anda melakukan topup terlebih dahulu'); // error validasi investasi
                
            }else{
                
                $jumlahPendanaan = PendanaanAktif::where('proyek_id',$r->txt_idProyek)->sum('total_dana');
                $selesai    = Carbon::parse($proyek[0]->tgl_selesai_penggalangan)->toDateString();
                $sekarang   = Carbon::now()->toDateString();
                
                $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::user()->id)->where('accepted',0)->sum('jumlah');
                $totalDana = ($proyek[0]->harga_paket*$r->txt_qty) + $jumlahPenarikan;
                $jumlahRekening = 0;
                $jumlahRekening += $rekening->unallocated;
                
                if ($jumlahPendanaan+$proyek[0]->terkumpul < $proyek[0]->total_need && $selesai >= $sekarang)
                {
                    
                    if ($totalDana >  $jumlahRekening)
                    {
                        return redirect()->back()->with('msg_error', 'Dana Tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana');
                    }
                    else
                    {
                        $pendanaan = new PendanaanAktif;
                        $pendanaan->investor_id = Auth::user()->id;
                        $pendanaan->proyek_id = $r->txt_idProyek;
                        $harga_paket = $proyek[0]->harga_paket;
                        $pendanaan->total_dana = $harga_paket*$r->txt_qty;
                        $pendanaan->nominal_awal = $harga_paket*$r->txt_qty;
                        $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                        $pendanaan->last_pay = Null;
                        $pendanaan->save();

                        $user = Auth::user();
                        $log = new LogPendanaan;
                        $log->pendanaanAktif_id = $pendanaan->id;
                        $log->nominal = $pendanaan->nominal_awal;
                        $log->tipe = 'add new investation';
                        $log->save();
                        
                        $rekening->unallocated = $rekening->unallocated - $harga_paket*$r->txt_qty;
                        $rekening->save();

                        $audit = new AuditTrail;
                        $username = Auth::guard()->user()->username;
                        $audit->fullname = $username;
                        $audit->description = "Pendanaan Proyek Berhasil";
                        $audit->ip_address =  \Request::ip();
                        $audit->save();
                        
                        $id = $r->txt_id;
                        //TmpSelectedProyek::where('id', $id)->update(['status'=>'3']);
                        TmpSelectedProyek::where('id', $id)->delete();
                        
                        return redirect()->back()->with('msg_success', 'pendanaan Berhasil'); // sukses investasi
                    }
                    
                }
                elseif ($jumlahPendanaan+$proyek[0]->terkumpul < $proyek[0]->total_need && $selesai < $sekarang)
                {
                    $audit = new AuditTrail;
                    $username = Auth::guard()->user()->username;
                    $audit->fullname = $username;
                    $audit->description = "Pendanaan proyek gagal karena penggalangan dana proyek sudah selesai";
                    $audit->ip_address =  \Request::ip();
                    $audit->save();

                    return redirect()->back()->with('msg_success', 'Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
                }
                elseif($jumlahPendanaan+$proyek[0]->terkumpul >= $proyek[0]->total_need && $selesai >= $sekarang)
                {
                    $audit = new AuditTrail;
                    $username = Auth::guard()->user()->username;
                    $audit->fullname = $username;
                    $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh";
                    $audit->ip_address =  \Request::ip();
                    $audit->save();

                    return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh'); // error validasi investasi
                }
                else
                {
                    $audit = new AuditTrail;
                    $username = Auth::guard()->user()->username;
                    $audit->fullname = $username;
                    $audit->description = "Pendanaan proyek gagal karena proyek sudah penuh & penggalangan dana proyek sudah selesai";
                    $audit->ip_address =  \Request::ip();
                    $audit->save();

                    return redirect()->back()->with('msg_success', 'Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai'); // error validasi investasi
                }
            }
        }
        else
        {
            
            $audit = new AuditTrail;
            $username = Auth::guard()->user()->username;
            $audit->fullname = $username;
            $audit->description = "Pendanaan proyek gagal karena dana anda tidak mencukupi";
            $audit->ip_address =  \Request::ip();
            $audit->save();

            return redirect()->back()->with('msg_error', 'Maaf Dana Anda Tidak Mencukupi'); // error validasi investasi
        }
        
    }

    // public function reset(Request $r)
    // {
    //     Cart::destroy();
    //     return redirect()->back()->with('success', 'Cart reset success');
    // }
    /*

    public function update(Request $r, $rowId)
    {
        Cart::update($rowId, $r->qty);
        // return Cart::get($rowId);
        // dd($rowId);
        return redirect()->back()->with('success', 'Quantity berhasil dirubah');
    }

    public function checkout(Request $request) {
        $proyek = Proyek::whereIn('id', $request->id_proyek)->get();
        $val = 0;
        $i = 0;
        foreach ($proyek as $item) {
            $val = $val + ($item->harga_paket*$request->qty[$i]);
            $i++;
        };

        $rekening = RekeningInvestor::where('investor_id', Auth::user()->id)->first();
        if ($rekening->unallocated >= $val && $val > 0) {
            $rekening->unallocated = $rekening->unallocated - $val;
            // $proyek_update->terkumpul += $val;
            // $proyek_update->save();
            $rekening->save();
        }
        else {
            return redirect()->back()->with('error', 'Dana tidak cukup');
        }
        $i = 0;
        foreach ($request->id_proyek as $item) {
            $pendanaan = new PendanaanAktif;
            $pendanaan->investor_id = Auth::user()->id;
            $pendanaan->proyek_id = $item;
            $harga_paket = Proyek::find($item)->harga_paket;
            $pendanaan->total_dana = $harga_paket*$request->qty[$i];
            $pendanaan->nominal_awal = $harga_paket*$request->qty[$i];
            $pendanaan->tanggal_invest = Carbon::now()->toDateString();
            $pendanaan->last_pay = Null;
            $pendanaan->save();

            $user = Auth::user();
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
            $log->tipe = 'add new investation';
            $log->save();
            $i++;
        }
        Cart::destroy();

        return redirect()->back()->with('success', 'Anda Berhasil Checkout');
        
    }
    


    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create(Proyek $proyek, $qty)
    // {
    //     // $user = Auth::user();
    //     // check if proyek already exist in cart
    //     // $cart = Cart::where('proyek_id',$proyek)->first();
    //     // if(count($cart)){
    //     //     $this->edit($cart,$qty);
    //     // }
    //     // else{
    //     //     //add new item to the cart
    //     //     $user->activeCart()->create([
    //     //         'qty' => $qty,
    //     //         'proyek_id' => $proyek,
    //     //         'total_price' => $proyek->harga_paket * $qty,
    //     //     ]);
    //     // }

    //     return redirect('user\cart');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Cart  $cart
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Cart $cart)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Cart  $cart
    //  * @param String $qty
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Cart $cart,$qty)
    // {
    //     //
    //     $cart->qty += (int) $qty;
    //     if($cart->qty == 0) $cart->delete();
    //     else {
    //         $cart->total_price = $cart->detilItem->harga_paket * $cart->qty;
    //         $cart->save();
    //     } 
    //     return redirect('user/cart');
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Cart  $cart
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Cart $cart)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Cart  $cart
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Cart $cart)
    // {
    //     //empty the cart
    //     Auth::user()->activeCart()->delete();
    //     return redirect('user/cart');
    // }
}
