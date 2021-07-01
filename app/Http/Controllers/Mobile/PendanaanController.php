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
// use App\Subscribe;
use App\ProgressProyek;

class PendanaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
            if ($rekening->unallocated > $val) {
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
 }