<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PenarikanDana;
use App\Proyek;
use App\PendanaanAktif;
use App\RekeningInvestor;
use App\LogPendanaan;
use App\DetilImbalUser;
use App\ListImbalUser;
// use App\Subscribe;
use App\ProgressProyek;
use App\CheckUserSign;
use App\LogAkadDigiSignInvestor;


class NewPendanaanController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->middleware('auth:api',['except' => ['cek_reg_digisign']]);
    }

    //detil progress
    public function detilProgress(Request $request){
        $detil= Proyek::where('id', $request->proyek_id)->first();
        $prog = ProgressProyek::where('proyek_id', $request->proyek_id)->get();

        // if ( count($prog) == 0){

        // }

        $i=0; 
        foreach($prog as $item){
            $progress[$i]= [
                'id'=>$item->id,
                'tanggal' => $item->tanggal,
                'progress_image' => '/storage/'.$item->pic,
                'deskripsi'=>$item->deskripsi,
            ];
            $i++;
        }
        

        return [
            'id' => $detil->id,
            'nama' => $detil->nama,
            // 'deskripsi' => str_replace("&nbsp;", '', strip_tags($detil->deskripsi)),
            'imbal_hasil' => $detil->profit_margin,
            'alamat'=>$detil->alamat,
            'harga_paket' => $detil->harga_paket+0,
            'interval' => $detil->interval,
            'tenor' => $detil->tgl_mulai->diffInMonths($detil->tgl_selesai),
            'dayleft' => $detil->tgl_mulai->diffInDays(Carbon::now()->toDateString()),
            'terkumpul' => number_format($detil->terkumpul/$detil->total_need*100, 2, '.', ''),
            'total_need' => $detil->total_need+0,
            'akad' => $detil->akad,
            'image_url' => '/storage/'.$detil->gambar_utama,
            'progress'=> json_encode($progress),
        ];

    }

    //investation feed
    public function showPendanaan(){
        $pendanaan = PendanaanAktif::where('investor_id', Auth::guard('api')->user()->id)->where('status', 1)->get();

        $i = 0;
        foreach($pendanaan as $item){
            $proyek = Proyek::where('id', $item->proyek_id)->first();
            
            $return[$i]=[
                'id'=>$item->id,
                'proyek_id'=>$item->proyek_id,
                'total_dana'=>$item->total_dana+0,
                'nominal_awal'=>$item->nominal_awal+0,
                'tanggal_invest'=>$item->tanggal_invest->toDateString(),
                'nama_proyek'=>$proyek->nama,
                'harga_paket'=>$proyek->harga_paket+0,
                'status_proyek'=>$proyek->status
            ];
            $i++;
        }

        return json_encode($return);
    }

    public function showPendanaanKelolaInvestasi(){
        $pendanaan = PendanaanAktif::where('investor_id', Auth::guard('api')->user()->id)->where('status', 1)->get();

        $i = 0;
        foreach($pendanaan as $item){
            $proyek = Proyek::where('id', $item->proyek_id)->whereIn('status', [1,2,3])->first();
            
            $return[$i]=[
                'id'=>$item->id,
                'proyek_id'=>$item->proyek_id,
                'total_dana'=>$item->total_dana+0,
                'nominal_awal'=>$item->nominal_awal+0,
                'tanggal_invest'=>$item->tanggal_invest->toDateString(),
                'nama_proyek'=>$proyek->nama,
                'harga_paket'=>$proyek->harga_paket+0,
                'status_proyek'=>$proyek->status
            ];
            $i++;
        }

        return json_encode($return);
    }

    public function showPendanaanKelolaInvestasiNew(){
        $pendanaan = PendanaanAktif::join('proyek', 'pendanaan_aktif.proyek_id', '=', 'proyek.id')->
        select('pendanaan_aktif.id', 'pendanaan_aktif.proyek_id', 'pendanaan_aktif.total_dana', 'pendanaan_aktif.nominal_awal', 'pendanaan_aktif.tanggal_invest', 'proyek.nama', 'proyek.harga_paket', 'proyek.status', 'proyek.tgl_mulai', 'proyek.tgl_selesai')->
        where('pendanaan_aktif.investor_id', Auth::guard('api')->user()->id)->where('pendanaan_aktif.status', 1)->whereIn('proyek.status', [1,2,3])->
        orderBy('pendanaan_aktif.created_at', 'desc')->get();

        $i = 0;
        foreach($pendanaan as $item){

            $created = new Carbon($item->tgl_selesai);
            $now = Carbon::now();
            $difference =  $created->diffInDays($now);

            $return[$i]=[
                'id'=>$item->id,
                'proyek_id'=>$item->proyek_id,
                'total_dana'=>$item->total_dana+0,
                'nominal_awal'=>$item->nominal_awal+0,
                'tanggal_invest'=>$item->tanggal_invest->toDateString(),
                'nama_proyek'=>$item->nama,
                'harga_paket'=>$item->harga_paket+0,
                'status_proyek'=>$item->status,
                'tgl_mulai_proyek'=>$item->tgl_mulai,
                'sisa_periode'=>$difference
            ];
            $i++;
        }

        return json_encode($return);
    }

    public function showPendanaanKelolaInvestasiNewNew(){

        $investor_id = Auth::guard('api')->user()->id;
        // $investor_id = 52143;

        $pendanaan = PendanaanAktif::join('proyek', 'pendanaan_aktif.proyek_id', '=', 'proyek.id')->
        select('pendanaan_aktif.id', 'pendanaan_aktif.proyek_id', 'pendanaan_aktif.total_dana', 'pendanaan_aktif.nominal_awal', 'pendanaan_aktif.tanggal_invest', 'proyek.nama', 'proyek.harga_paket', 'proyek.status', 'proyek.tgl_mulai', 'proyek.tgl_selesai')->
        where('pendanaan_aktif.investor_id', $investor_id)->where('pendanaan_aktif.status', 1)->whereIn('proyek.status', [1,2,3])->
        orderBy('pendanaan_aktif.created_at', 'desc')->get();

        $i = 0;

        foreach($pendanaan as $item){

            $created = new Carbon($item->tgl_selesai);
            $now = Carbon::now();
            $difference =  $created->diffInDays($now);

            $return[$i]=[
                'id'=>$item->id,
                'proyek_id'=>$item->proyek_id,
                'total_dana'=>$item->total_dana+0,
                'nominal_awal'=>$item->nominal_awal+0,
                'tanggal_invest'=>$item->tanggal_invest->toDateString(),
                'nama_proyek'=>$item->nama,
                'harga_paket'=>$item->harga_paket+0,
                'status_proyek'=>$item->status,
                'tgl_mulai_proyek'=>$item->tgl_mulai,
                'status_log_akad'=>$item->status_log_akad,
                'sisa_periode'=>$difference,
                'investor_id'=>$investor_id
            ];
            $i++;
        }

        return json_encode($return);
    }
   
    //
    public function tambahPendanaan(Request $request){
        $aktif = PendanaanAktif::where('id', $request->id_pendanaan)->first();
        $proyek = Proyek::where('id', $aktif->proyek_id)->first();
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        $jumlahPenarikan = PenarikanDana::where('investor_id',Auth::guard('api')->user()->id)->where('accepted',0)->sum('jumlah');
        $totalDana = ($proyek->harga_paket*$request->paket) + $jumlahPenarikan;
        $jumlahRekening = 0;
        $jumlahRekening += $rekening->unallocated;

        $val = $proyek->harga_paket*$request->paket;

        if ($totalDana >  $jumlahRekening)
        {
            return response()->json(['error' => 'Dana Tersedia anda sebesar Rp '.number_format($jumlahPenarikan,0,"",".").' sedang kami proses di penarikan dana']);
        }
        else
        {
            if ($rekening->unallocated >= $val) {
                $rekening->unallocated = $rekening->unallocated - $val;
                $rekening->save();
            }
            else {
                return response()->json(['error' => 'Dana tidak cukup']);
            }

            if($aktif->tanggal_invest->toDateString() == Carbon::now()->toDateString()){
                $aktif->update(['total_dana' => $aktif->total_dana+$val , 'nominal_awal'=>$aktif->nominal_awal+$val]);
                return response()->json(['success' => 'Berhasil Menambah Pendanaan (tambah)']);
            }
            else {
                $pendanaan = new PendanaanAktif;
                $pendanaan->investor_id = Auth::guard('api')->user()->id;
                $pendanaan->proyek_id = $aktif->proyek_id;
                $pendanaan->total_dana = $val;
                $pendanaan->nominal_awal = $val;
                $pendanaan->tanggal_invest = Carbon::now()->toDateString();
                $pendanaan->last_pay = Carbon::now()->toDateString();
                $pendanaan->save();

                $log = new LogPendanaan;
                $log->pendanaanAktif_id = $pendanaan->id;
                $log->nominal = $pendanaan->nominal_awal;
                $log->tipe = 'add active investation';
                $log->save();
            
                return response()->json(['success' => 'Berhasil Menambah Pendanaan (baru)']);
            }
        }          
    }

    public function ambilPendanaan(Request $request) {
        $pendanaan = PendanaanAktif::find($request->id_pendanaan);
        $proyek = Proyek::where('id', $pendanaan->proyek_id)->first();
        $total_penarikan = $pendanaan->proyek->harga_paket * $request->paket;


        if ($pendanaan->nominal_awal < $total_penarikan) {
            return response()->json(['error' => 'Jumlah paket yang ingin anda tarik melebihi jumlah yang ada di proyek anda']);
        }
        else {
            $pendanaan->nominal_awal = $pendanaan->nominal_awal - $total_penarikan;
            $pendanaan->total_dana = $pendanaan->total_dana - $total_penarikan;
            if ($pendanaan->nominal_awal == 0) {
                $pendanaan->status = 0 ;
            }
            $pendanaan->save();

            $check_detil_imbal = DetilImbalUser::where('pendanaan_id',$request->id_pendanaan)->first();
            if(!empty($check_detil_imbal->pendanaan_id))
                {
                    if($proyek->profit_margin <= 12)
                    {
                        $propcal = $proyek->profit_margin/12;
                        $imbalcal1 = ($propcal*$pendanaan->nominal_awal)/100;
                        $total_dana = floor($pendanaan->total_dana/100)*100;
                        $check_detil_imbal->total_dana = $total_dana;
                        $check_detil_imbal->save();


                        $check_list_imbal = ListImbalUser::where('pendanaan_id',$request->id_pendanaan)->orderby('id','DESC')->get();
                        for($x=0;$x < count($check_list_imbal); $x++)
                        {
                            $propcal = $proyek->profit_margin/12;
                            $imbalcal = ($propcal*$pendanaan->total_dana)/100;
                            $check_list_imbal[$x]->imbal_payout;
                            if($check_list_imbal[$x]->status_payout == 5){
                                if($x == 0){
                                    $check_list_imbal[$x]->imbal_payout = $total_dana;
                                }elseif($x == 1){
                                    $check_list_imbal[$x]->imbal_payout = 0;
                                }else{
                                    $check_list_imbal[$x]->imbal_payout = floor($imbalcal/100)*100;;
                                }
                                $check_list_imbal[$x]->total_dana = floor($pendanaan->total_dana/100)*100;
                                $check_list_imbal[$x]->save();
                            }
                        }
                        // die();
                        $sum = listimbaluser::where('pendanaan_id', $request->id_pendanaan)->sum('imbal_payout');

                        $update_total_dana = DetilImbalUser::where('pendanaan_id',$request->id_pendanaan)->first();

                        $update_total_dana->total_imbal = floor($sum/100)*100;
                        $update_total_dana->save();

                    }
                    elseif($proyek->profit_margin >= 13)
                    {
                        $imbalcal = ($proyek->profit_margin/12)*$proyek->tenor_waktu;
                        $totalimbal = $pendanaan->total_dana/100;
                        $hasilimbal = ($imbalcal-$proyek->tenor_waktu)*$pendanaan->total_dana;
                        $sisaimbal = $hasilimbal/100;
                        
                        $check_list_imbal = ListImbalUser::where('pendanaan_id',$request->id_pendanaan)->where('status_payout',5)->get();
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

                        $sum = listimbaluser::where('pendanaan_id', $request->id_pendanaan)->sum('imbal_payout');

                        $update_total_dana = DetilImbalUser::where('pendanaan_id',$request->id_pendanaan)->first();

                        $update_total_dana->total_imbal = floor($sum/100)*100;
                        $update_total_dana->save();

                    }
                    elseif($pendanaan->status == 0 )
                    {
                        $check_detil_list_status = DetilImbalUser::where('pendanaan_id',$request->id_pendanaan)->first();
                        $check_list_imbal_status = ListImbalUser::where('pendanaan_id',$request->id_pendanaan)->where('status_payout',5)->get();

                        for($x=0;$x < sizeOf($check_list_imbal_status);$x++)
                        {
                            $check_list_imbal_status[$x]->delete();
                        }

                        $check_detil_imbal->delete();
                    }


                }


            $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
            $rekening->unallocated = $rekening->unallocated + $total_penarikan;
            $rekening->save();

            $log = new LogPendanaan;
            $log->pendanaanAktif_id = $pendanaan->id;
            $log->nominal = $total_penarikan;
            $log->tipe = 'ambil active investation';
            $log->save();

            return response()->json(['success' => 'Dana anda berhasil ditarik ke DANA TERSEDIA']);
        }
    }

    public function checkValidation(Request $request) {

        $pendanaan = Proyek::select('status')->where('id', $request->id_proyek)->get();
        
        if($pendanaan[0]->status==2){
            return response()->json(['error' => 'Pendanaan proyek selesai']);
        }else if($pendanaan[0]->status==3){
            return response()->json(['error' => 'Pendanaan proyek sudah Terpenuhi']);
        }else{  
            return response()->json(['success' => 'Proyek Aktif']);
        }    
    }

    public function cek_akad_murobahah(Request $request){
        $investor_id = Auth::guard('api')->user()->id;

        $log = LogAkadDigiSignInvestor::where('investor_id', $investor_id)->orderby('id_log_akad_investor', 'desc')->first();
        if($log->id_log_akad_investor == $request->id_log && $log->proyek_id == $request->proyek_id){
            if($log->status == 'waiting' || $log->status == 'complete'){
                $response = ['success' => 'TTD Oke'];
            }else{
                $response = ['error' => 'TTD gagal sist'];
            }
        }
        else{
            $response = ['error' => 'TTD gagal bro'];
        }

        return $response;
    }

    public function cek_reg_digisign(){
        $investor_id = Auth::guard('api')->user()->id;

        $log = CheckUserSign::where('investor_id', $investor_id)->first();
        if($log->status == 'Proses Aktivasi Berhasil'){
            $response = ['success' => 'Proses Aktivasi Berhasil'];
        }
        else{
            $response = ['error' => 'Proses Aktivasi gagal'];
        }

        return $response;
    }

 }