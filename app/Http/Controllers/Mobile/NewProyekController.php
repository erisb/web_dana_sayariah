<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Proyek;
use App\PendanaanAktif;
use App\RekeningInvestor;
use App\Investor;
use App\LogPendanaan;
use App\GambarProyek;
use App\PenarikanDana;
use App\Pemilik_Proyek;
use App\TmpSelectedProyek;
use App\CheckUserSign;
use App\LogAkadDigiSignInvestor;
use App\BniEnc;
use GuzzleHttp\Client;
use App\Http\Controllers\RekeningController;
use DB;
use Cart;
use DateTime;
// use App\Subscribe;

class NewProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['statusRegDigisign','proyek','proyekAll','detil_proyek','simulationAll', 'getPemilikProyek', 'selectedProject', 'showSelectedProject', 'deleteSelectedProject', 'updatePaket']]);
    }

    public function selectedProject(Request $request){

        // $investor_id = 52258;
        $investor_id=Auth::guard('api')->user()->id;
        $now = date("Y-m-d H:i:s");
        $expired_date = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($now)));
        
        if($request->paket < 1){
            return response()->json(['kurang' => 'Gagal Pilih Pendanaan']);
        }else{
            $cek = TmpSelectedProyek::where('investor_id', $investor_id)->where('proyek_id', $request->id_proyek)->first();
            if($cek){
                return response()->json(['ada' => 'Pendanaan telah dipilih']);
            }else{
                $proyek = Proyek::where('id', $request->id_proyek)->first();
                $total_price = $proyek->harga_paket * $request->paket;

                $query = new TmpSelectedProyek;
                            $query->investor_id = $investor_id;
                            $query->proyek_id = $request->id_proyek;
                            $query->qty = $request->paket;
                            $query->total_price = $total_price;
                            $query->save(); 


                if($query){
                    return response()->json(['success' => 'Berhasil Pilih Pendanaan', 'jumlah_investasi'=>$total_price, 'exp_date' => $expired_date]); 
                }else{
                    return response()->json(['error' => 'Gagal Pilih Pendanaan']);
                }
            }
        }

        
        
    }  

    public function deleteSelectedProject(Request $request){

        // $investor_id = 52287;
        $investor_id=Auth::guard('api')->user()->id;

        $query = TmpSelectedProyek::where('investor_id', $investor_id)->Where('proyek_id', $request->id_proyek)->delete();

        if($query){
            return response()->json(['success' => 'Berhasil Hapus Pendanaan']); 
        }else{
            return response()->json(['error' => 'Gagal Hapus Pendanaan']);
        }
    }

    public function updatePaket(Request $request) {
        // $investor_id = 52324;
        $investor_id=Auth::guard('api')->user()->id;

        $detil = TmpSelectedProyek::where('investor_id', $investor_id)->Where('proyek_id', $request->id_proyek)->first();
            $detil->qty = $request->qty;
            $detil->save();

        if($detil){
            return response()->json(['success' => 'Berhasil Update Pendanaan']);
        }else{
            return response()->json(['error' => 'Gagal Update Pendanaan']);
        }
    }


    public function showSelectedProject(){

        //$investor_id = 52259;
        $investor_id=Auth::guard('api')->user()->id;
        $email=Auth::guard('api')->user()->email;

        $query = TmpSelectedProyek::where('investor_id', $investor_id)
                ->leftJoin('proyek','proyek.id','=','tmp_selected_proyek.proyek_id')
                ->get(); 

        $date = Carbon::now()->format('Y:m:d H:i:s');

        $i = 0;

        foreach($query as $item){
            $expired_date1=$item->exp_date;
            $start_date = new DateTime($expired_date1);
            $since_start = $start_date->diff(new DateTime($date));
            $return[$i]=[
                'investor_id'=>$item->investor_id,
                'proyek_id'=>$item->proyek_id,
                'nama_proyek'=>$item->nama,
                'paket'=>$item->qty,
                'alamat_proyek'=>$item->alamat,
                'tanggal_invest'=>$item->created_at->toDateString(),
                'total_invest'=>$item->total_price+0,
                'harga_paket'=>$item->harga_paket+0,
                'tgl_mulai_proyek'=>$item->tgl_mulai,
                'status_proyek'=>$item->status,
                'gambar'=>'/storage/'.$item->gambar_utama,
                'exp_date'=>$item->exp_date,
                'jam'=>$since_start->h,
                'menit'=>$since_start->i,
                'detik'=>$since_start->s,
                'no_va'=>$item->no_va,
                'email'=>$email
            ];
            $i++;
        }
        return json_encode($return);
    }  

    public function statusRegDigisign(Request $request){
        
        // $investor_id = 52259;
        $investor_id = Auth::guard('api')->user()->id;
        $email=Auth::guard('api')->user()->email;

        $rekening = RekeningInvestor::where('investor_id', $investor_id)
                                    ->first();

        $dataRegDigiSign = CheckUserSign::where('investor_id', $investor_id)->first();                                            
        
        $dataLogAkad = LogAkadDigiSignInvestor::where('investor_id', $investor_id)
                                             ->orderby('id_log_akad_investor', 'desc')
                                             ->first();
        
        $realTotalAset = !empty($rekening) ? number_format($rekening->total_dana,0,'','') : 0;
        $logTotalAset = !empty($dataLogAkad) ? $dataLogAkad->total_aset : 0;
        $logStatus = !empty($dataLogAkad) ? $dataLogAkad->status : '';
        $cekRegDigiSign = !empty($dataRegDigiSign) ? $dataRegDigiSign->tgl_aktifasi : null;

        if($cekRegDigiSign == null){
            $showKontrak = 'buka';
        }else{
            $showKontrak = 'ttd_akhir';
        }

        $data = [
            'cekRegDigiSign' => $cekRegDigiSign,
            'status_button_digisign'=>$showKontrak,
            'email'=>$email
        ];

        return response()->json($data);
    }


    //list all active proyek
    public function proyek_old() {

        // $proyek = Proyek::where('total_need', '>', 'terkumpul')->where('tgl_mulai', '>', Carbon::now()->toDateString())->where('status', 1)->orderBy('id', 'desc')->get();
        $proyek = Proyek::where('status_tampil', '=', '2')->orderBy('id', 'desc')->get();
        
        // $data_pendana = PendanaanAktif::where('proyek_id',$id)->get();
        // $all_dana = 0 ;
        // foreach($data_pendana as $d){
        //     $all_dana += $d['nominal_awal'];
        // }

        $i = 0;
        foreach ($proyek as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : $item->tgl_mulai->diffInDays(Carbon::now()->toDateString())));
            $return[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>$item->harga_paket+0,
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : (($item->terkumpul+$all_dana)/$item->total_need)*100,
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu];
                $i++;
        }

        return json_encode($return);
    }

    public function proyek() {

        $proyekAktif = Proyek::where('status',1)
                                ->limit(3)
                                ->orderBy('proyek.profit_margin', 'desc')->get();
 
        $i = 0;
        foreach ($proyekAktif as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $profit_explode = (explode('.',$item->profit_margin));
            if($profit_explode[1]=='00'){
               $profit_margin=$profit_explode[0];
            }else{
                $profit_margin=$item->profit_margin;
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($item->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));
        
            $dataProyekAktif[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->tenor_waktu,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        $proyekClosed = Proyek::where('status',2)
                                ->limit(3)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekClosed as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($item->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));
        
            $dataProyekClosed[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->tenor_waktu,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        $proyekFull = Proyek::where('status',3)
                                ->limit(3)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekFull as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($item->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));
        
            $dataProyekFull[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->tenor_waktu,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        return response()->json(['dataProyekAktif' => isset($dataProyekAktif) ? $dataProyekAktif : null,'dataProyekFull' => isset($dataProyekFull) ? $dataProyekFull : null,'dataProyekClosed' => isset($dataProyekClosed) ? $dataProyekClosed : null]);
    }

    public function proyekAll() {

        $proyekAktif = Proyek::where('status',1)->orderBy('proyek.profit_margin', 'desc')->get();
        $i = 0;
        foreach ($proyekAktif as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $profit_explode = (explode('.',$item->profit_margin));
            if($profit_explode[1]=='00'){
               $profit_margin=$profit_explode[0];
            }else{
                $profit_margin=$item->profit_margin;
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($item->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));
            

            $dataProyekAktif[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        $proyekClosed = Proyek::where('status',2)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekClosed as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($item->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));
        
            $dataProyekClosed[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        $proyekFull = Proyek::where('status',3)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekFull as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($item->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));
        
            $dataProyekFull[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        return response()->json(['dataProyekAktif' => isset($dataProyekAktif) ? $dataProyekAktif : null,'dataProyekFull' => isset($dataProyekFull) ? $dataProyekFull : null,'dataProyekClosed' => isset($dataProyekClosed) ? $dataProyekClosed : null]);
    }
    
    //detil proyek by id
    public function detil_proyek(Request $request){
        
        $detil = Proyek::where('proyek.id', $request->id_proyek)
                        // tambahan start
                        ->leftJoin('deskripsi_proyeks','deskripsi_proyeks.id','=','proyek.id_deskripsi')
                        ->leftJoin('legalitas_proyeks','legalitas_proyeks.id','=','proyek.id_legalitas')
                        ->leftJoin('pemilik_proyeks','pemilik_proyeks.id','=','proyek.id_pemilik')
                        ->leftJoin('simulasi_proyeks','simulasi_proyeks.id','=','proyek.id_simulasi')
                        // tambahan end
                        ->first([
                            'proyek.*',
                            'deskripsi_proyeks.deskripsi',
                            'legalitas_proyeks.deskripsi_legalitas',
                            'pemilik_proyeks.deskripsi_pemilik',
                            'simulasi_proyeks.deskripsi_simulasi',
                        ]);

        $data_pendana = PendanaanAktif::where('proyek_id',$request->id_proyek)->get();
        $all_dana = 0 ;
        foreach($data_pendana as $d){
            $all_dana += $d['nominal_awal'];
        }

        $profit_explode = (explode('.',$detil->profit_margin));
            if($profit_explode[1]=='00'){
               $profit_margin=$profit_explode[0];
            }else{
                $profit_margin=$detil->profit_margin;
            }

        $dayLeft = ($detil->status == 3 ? 'Full' : ($detil->status == 2 ? 'Closed' : (date_diff(date_create(Carbon::now()->format('Y-m-d')),date_create(Carbon::parse($detil->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1).' hari'));

        $gambarProyek = GambarProyek::where('proyek_id',$request->id_proyek)->get();
        $dataGambarProyek = [];
        foreach ($gambarProyek as $gambar)
        {
            array_push($dataGambarProyek, $gambar['gambar']);
        }

        if(isset(Auth::guard('api')->user()->id))
        {
            $rekeningInvestor = RekeningInvestor::where('investor_id',Auth::guard('api')->user()->id)->first();
        }
        else
        {
            $rekeningInvestor = null;
        }
        

        return [
            'id'=>$detil->id, 
            'nama'=>$detil->nama, 
            'imbal_hasil'=>$profit_margin, 
            'harga_paket'=>number_format($detil->harga_paket,0,',','.'),
            'interval'=>$detil->interval,
            'dayleft'=>$dayLeft,
            'terkumpul'=> $detil->status == 3 || $detil->status == 2 ? 100 : number_format((($detil->terkumpul+$all_dana)/$detil->total_need)*100,2,'.',','),
            'image_url'=>'/storage/'.$detil->gambar_utama,
            // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
            'tenor' => $detil->tenor_waktu,
            'akad' => $detil->akad == 1 ? 'Murabahah' : 'Mudharabah',
            'alamat' => $detil->alamat,
            'butuh' => number_format($detil->total_need,0,',','.'),
            'deskripsi' => $detil->deskripsi,
            'legalitas' => $detil->deskripsi_legalitas,
            'pemilik' => $detil->deskripsi_pemilik,
            'simulasi' => $detil->deskripsi_simulasi,
            'semua_gambar' => $dataGambarProyek,
            'tidak_teralokasi' => $rekeningInvestor != null ? $rekeningInvestor->unallocated : null
        ];
    }

    public function cart() {
        $unallocated = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        return [
            'unallocated'=>$unallocated->unallocated
        ];
    }

    //checkout cart
    public function checkout(Request $request) {
        $user = Auth::guard('api')->user();

        $data = $request->data;
        // return $proyek;
        $checkrekening = 0;
        foreach($data as $item){
            $proyek = Proyek::where('id', $item['proyek_id'])->first();
            $checkrekening = $checkrekening + ($proyek->harga_paket*$item['paket']);
        }

        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        if ($rekening->unallocated < $checkrekening || $checkrekening <= 0) {
            return response()->json(['error' => 'Dana Tidak Cukup']);
        }

        $jmlhDanaTersedia = 0; 
        $dataPenarikanDana = PenarikanDana::where('investor_id',Auth::guard('api')->user()->id)
                                            ->where('accepted',0)->sum('jumlah');

        $totalDana = $checkrekening + $dataPenarikanDana;
        $jmlhDanaTersedia += $rekening->unallocated;
        if ($totalDana <= $jmlhDanaTersedia)
        {
            foreach ($data as $item) {
                $proyek = Proyek::where('id', $item['proyek_id'])->first();
                $pendanaanUser = PendanaanAktif::where('investor_id', Auth::guard('api')->user()->id)->where('proyek_id', $item['proyek_id'])->where('tanggal_invest', Carbon::now()->toDateString())->first();

                if (isset($pendanaanUser)){
                    if ($proyek->status != 1) {
                        return response()->json(['error' => 'Proyek Tutup']);
                    }
                    // return 'eko';
                    $harga_paket = $proyek->harga_paket;
                    $pendanaanUser->total_dana += $item['paket']*$harga_paket;
                    $pendanaanUser->nominal_awal += $item['paket']*$harga_paket;
                    $pendanaanUser->status = 1;
                    $pendanaanUser->save();

                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaanUser->id;
                    $log->nominal = $pendanaanUser->nominal_awal;
                    $log->tipe = 'add existing investation';
                    $log->save();  
                }
                
                else {
                    $pendanaan = new PendanaanAktif;
                    $pendanaan->investor_id =  Auth::guard('api')->user()->id;
                    $pendanaan->proyek_id = $item['proyek_id'];
                    $harga_paket = $proyek->harga_paket;
                    $pendanaan->total_dana = $item['paket']*$harga_paket;
                    $pendanaan->nominal_awal = $item['paket']*$harga_paket;
                    $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                    $pendanaan->last_pay = Null;
                    $pendanaan->save();  

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
                }         
            }

            $rekening->unallocated = $rekening->unallocated - $checkrekening;
            $rekening->save();

            return response()->json(['success' => 'Berhasil Checkout Pendanaan']);
        }
        else
        {
            return response()->json(['error' => 'Dana Tersedia anda sebesar Rp '.number_format($dataPenarikanDana,0,"",".").' sedang kami proses di penarikan dana']);
        }
    
    }

    public function checkout_new(Request $request) {
        
        $user = Auth::guard('api')->user()->id;
        $checkrekening = 0; 
        $proyek = Proyek::where('id', $request->id_proyek)->first();
        $checkrekening = $checkrekening + ($proyek->harga_paket*$request->paket);

        $total_investation = $proyek->harga_paket*$request->paket;

        $rekening = RekeningInvestor::where('investor_id', $user)->first();
        if($rekening === null){
            return response()->json(['error' => 'Anda belum Memiliki nomor Virtual Account']);
        }
        else if ($rekening->unallocated < $checkrekening || $checkrekening <= 0) {
            return response()->json(['error' => 'Dana Tidak Cukup']);
        }

        $jmlhDanaTersedia = 0; 
        $dataPenarikanDana = PenarikanDana::where('investor_id',$user)
                                            ->where('accepted',0)->sum('jumlah');

        $totalDana = $checkrekening + $dataPenarikanDana;
        $jmlhDanaTersedia += $rekening->unallocated;
        if ($totalDana <= $jmlhDanaTersedia)
        {
                $proyek = Proyek::where('id', $request->id_proyek)->first();
                $pendanaanUser = PendanaanAktif::where('investor_id', $user)->where('proyek_id', $request->id_proyek)->where('tanggal_invest', Carbon::now()->toDateString())->first();

                if (isset($pendanaanUser)){
                    if ($proyek->status != 1) {
                        return response()->json(['error' => 'Proyek Tutup']);
                    }
                    // return 'eko';
                    $harga_paket = $proyek->harga_paket;
                    $pendanaanUser->total_dana += $request->paket*$harga_paket;
                    $pendanaanUser->nominal_awal += $request->paket*$harga_paket;
                    $pendanaanUser->status = 1;
                    $pendanaanUser->save();

                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaanUser->id;
                    $log->nominal = $pendanaanUser->nominal_awal;
                    $log->tipe = 'add existing investation';
                    $log->save();  
                }
                
                else {
                    $pendanaan = new PendanaanAktif;
                    $pendanaan->investor_id =  $user;
                    $pendanaan->proyek_id = $request->id_proyek;
                    $harga_paket = $proyek->harga_paket;
                    $pendanaan->total_dana = $request->paket*$harga_paket;
                    $pendanaan->nominal_awal = $request->paket*$harga_paket;
                    $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                    $pendanaan->last_pay = Null;
                    $pendanaan->save();  

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
                }         

            $rekening->unallocated = $rekening->unallocated - $checkrekening;
            $rekening->save();

            return response()->json(['success' => 'Berhasil Checkout Pendanaan', 'jumlah_investasi'=>$total_investation]);
        }
        else
        {
            return response()->json(['error' => 'Dana Tersedia anda sebesar Rp '.number_format($dataPenarikanDana,0,"",".").' sedang kami proses di penarikan dana']);
        }
    
    }

    public function checkout_new_new(Request $request) {
        
        $user = Auth::guard('api')->user()->id;
        $username = Auth::guard('api')->user()->username;
        $checkrekening = 0; 
        $proyek = Proyek::where('id', $request->id_proyek)->first();
        $checkrekening = $checkrekening + ($proyek->harga_paket*$request->paket);
        $total_investation = $proyek->harga_paket*$request->paket;
        $rekening = RekeningInvestor::where('investor_id', $user)->first();

        $RekeningController = new RekeningController();

        DB::beginTransaction();

        if($rekening === null){
            $hasil = $RekeningController->generateVa();
            if(!$hasil){
                DB::rollback();
                return response()->json(['error'=> 'Pembuatan VA gagal, harap menghubungi Customer Service kami untuk pembuatan No VA anda']);
            }
            else{
                DB::commit();
                return response()->json(['error' => "Dana Tidak Cukup, Silahkan lakukan top up dahulu ke nomor VA.' $hasil'"]);
            }
        }
        else if ($rekening->unallocated < $checkrekening || $checkrekening <= 0) {
            return response()->json(['error' => 'Maaf, dana tersedia anda tidak cukup untuk melakukan pendanaan ini']);
        }

        $jmlhDanaTersedia = 0; 
        $dataPenarikanDana = PenarikanDana::where('investor_id',$user)
                                            ->where('accepted',0)->sum('jumlah');

        $totalDana = $checkrekening + $dataPenarikanDana;
        $jmlhDanaTersedia += $rekening->unallocated;
        if ($totalDana <= $jmlhDanaTersedia)
        {
                $proyek = Proyek::where('id', $request->id_proyek)->first();
                $pendanaanUser = PendanaanAktif::where('investor_id', $user)->where('proyek_id', $request->id_proyek)->where('tanggal_invest', Carbon::now()->toDateString())->first();

            try{
                if (isset($pendanaanUser)){
                    if ($proyek->status != 1) {
                        return response()->json(['error' => 'Proyek Tutup']);
                    }

                    $harga_paket = $proyek->harga_paket;
                    $pendanaanUser->total_dana += $request->paket*$harga_paket;
                    $pendanaanUser->nominal_awal += $request->paket*$harga_paket;
                    $pendanaanUser->status = 1;
                    $pendanaanUser->save();

                    $log = new LogPendanaan;
                    $log->pendanaanAktif_id = $pendanaanUser->id;
                    $log->nominal = $pendanaanUser->nominal_awal;
                    $log->tipe = 'add existing investation';
                    $log->save();  
                }
                
                else {
                    $pendanaan = new PendanaanAktif;
                    $pendanaan->investor_id =  $user;
                    $pendanaan->proyek_id = $request->id_proyek;
                    $harga_paket = $proyek->harga_paket;
                    $pendanaan->total_dana = $request->paket*$harga_paket;
                    $pendanaan->nominal_awal = $request->paket*$harga_paket;
                    $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                    $pendanaan->last_pay = Null;
                    $pendanaan->save();  

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
                }         

                $rekening->unallocated = $rekening->unallocated - $checkrekening;
                $rekening->save();

                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return response()->json(['error'=> 'Data gagal disimpan silahkan coba beberapa saat lagi']);
            }
            DB::commit();
            return response()->json(['success' => 'Berhasil Checkout Pendanaan', 'jumlah_investasi'=>$total_investation]);
        }
        else
        {
            DB::commit();
            return response()->json(['error' =>'Maaf Dana Anda Tidak Mencukupi karena dana tersedia anda sebesar Rp '.number_format($dataPenarikanDana,0,"",".").' sedang kami proses di penarikan dana']);
        }
    }

    //Generate VA for user
    public function generateVA($username){
        $date = \Carbon\Carbon::now()->addYear(4);
        $user = Investor::where('username', $username)->first();
        $data = [
            'type' => 'createbilling',
            'client_id' => config('app.bni_id'),
            'trx_id' => $user->id,
            'trx_amount' => '0',
            'customer_name' => $user->detilInvestor->nama_investor,
            'customer_email' => $user->email,
            'virtual_account' => '8'.config('app.bni_id').$user->detilInvestor->getVa(),
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
            return false;
        }
        else{
            $decrypted = BniEnc::decrypt($result->data,config('app.bni_id'),config('app.bni_key'));
            //return json_encode($decrypted);
            $user->RekeningInvestor()->create([
                'investor_id' => $user->id,
                'total_dana' => 0,
                'va_number' => $decrypted['virtual_account'],
                'unallocated' => 0,
            ]);
            
            return $decrypted['virtual_account'];
            // return view('pages.user.add_funds')->with('message','VA Generate Success!');
         }
    }
    
    public function simulationAll() {

        $proyekAktif = Proyek::where('status',1)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekAktif as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            // perhitungan dayLeft
            if($item->status == 3){
                $dayleft = 'Full';
            }elseif($item->status == 2){
                $dayLeft = 'Closed';
            }else{
                $penggalanganselesai = strtotime($item->tgl_selesai_penggalangan);
                $hariini = time();
                $date3 = $penggalanganselesai-$hariini;
                $dayLeft = floor($date3 / (60 * 60 * 24)) + 2;
            }
            // pengali margin bulanan
            $profitmargin = $item->profit_margin;
            $pmb = $profitmargin/12;
            ($pmb>1)?$pmarginbulanan=intval($pmb):$pmarginbulanan=$pmb;

            // pengali sisa margin
            $tenor = intval($item->tenor_waktu);
            $xps = ($pmb*$tenor)-(1*$tenor);
            ($xps<0)?$psm=0:$psm=$xps;
            
            // pengali proposional
            $bagitigapuluh = $pmarginbulanan/30; 
            $ppm = ($bagitigapuluh*intval($dayLeft))/100;
           
            $dataProyekAktif[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'profitmargin'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $tenor,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.'),
                'pmarginbulanan' => $pmarginbulanan/100,
                'psisamargin' => number_format($psm/100,4,'.',','),
                'pengaliprop' => $ppm,

            ];
                $i++;
        }

        $proyekClosed = Proyek::where('status',2)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekClosed as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (Carbon::now()->parse($item->tgl_selesai_penggalangan)->diffInDays()+1).' hari'));
        
            $dataProyekClosed[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        $proyekFull = Proyek::where('status',3)
                                ->orderBy('proyek.id', 'desc')->get();
 
        $i = 0;
        foreach ($proyekFull as $item){
            $data_pendana = PendanaanAktif::where('proyek_id',$item->id)->get();
            $all_dana = 0 ;
            foreach($data_pendana as $d){
                $all_dana += $d['nominal_awal'];
            }
            $dayLeft = ($item->status == 3 ? 'Full' : ($item->status == 2 ? 'Closed' : (Carbon::now()->parse($item->tgl_selesai_penggalangan)->diffInDays()+1).' hari'));
        
            $dataProyekFull[$i] = [
                'id'=>$item->id, 
                'nama'=>$item->nama, 
                'imbal_hasil'=>$item->profit_margin, 
                'harga_paket'=>number_format($item->harga_paket,0,',','.'),
                'interval'=>$item->interval,
                'dayleft'=>$dayLeft,
                'terkumpul'=> $item->status == 3 || $item->status == 2 ? 100 : number_format((($item->terkumpul+$all_dana)/$item->total_need)*100,2,'.',','),
                'image_url'=>'/storage/'.$item->gambar_utama,
                // 'tenor'=>$item->tgl_mulai->diffInMonths($item->tgl_selesai)];
                'tenor' => $item->tenor_waktu,
                'akad' => $item->akad == 1 ? 'Murabahah' : 'Mudharabah',
                'alamat' => $item->alamat,
                'butuh' => number_format($item->total_need,0,',','.')
            ];
                $i++;
        }

        return response()->json(['dataProyekAktif' => isset($dataProyekAktif) ? $dataProyekAktif : null,'dataProyekFull' => isset($dataProyekFull) ? $dataProyekFull : null,'dataProyekClosed' => isset($dataProyekClosed) ? $dataProyekClosed : null]);
    }

    public function totalPenarikan()
    {
        $penarikan_dana = PenarikanDana::where('investor_id',Auth::guard('api')->user()->id)
                                        ->where('accepted',1)
                                        ->sum('jumlah');

        return response()->json(['total_penarikan' => isset($penarikan_dana) ? number_format($penarikan_dana,0,',','.') : 0]);
    }
}