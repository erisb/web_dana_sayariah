<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Proyek;
use App\PendanaanAktif;
use App\RekeningInvestor;
use App\LogPendanaan;
use Cart;
// use App\Subscribe;

class ProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    //list all active proyek
    public function proyek() {

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
            $dayLeft = ($item->status == 3 ? 'Fully Funded' : ($item->status == 2 ? 'Closed' : $item->tgl_mulai->diffInDays(Carbon::now()->toDateString())));
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

        $dayLeft = ($detil->status == 3 ? 'Fully Funded' : ($detil->status == 2 ? 'Closed' : $detil->tgl_mulai->diffInDays(Carbon::now()->toDateString())));

        $i = 0;
        return [
            'id' => $detil->id,
            'nama' => $detil->nama,
            // 'deskripsi' => str_replace("&nbsp;", '', strip_tags($detil->deskripsi)),
            // 'deskripsi' => $detil->deskripsi,
            // penambahan baru
            'deskripsi' => $detil->deskripsi,
            'deskripsi_legalitas' => $detil->deskripsi_legalitas,
            'deskripsi_pemilik' => $detil->deskripsi_pemilik,
            'deskripsi_simulasi' => $detil->deskripsi_simulasi,
            // akhir penambahan
            'alamat'=>$detil->alamat,
            'imbal_hasil' => $detil->profit_margin,
            'harga_paket' => $detil->harga_paket+0,
            'interval' => $detil->interval,
            'tenor' => $detil->tenor_waktu,
            'dayleft' => $dayLeft,
            'terkumpul' => $detil->status == 3 || $detil->status == 2 ? 100 : number_format(($detil->terkumpul+$all_dana)/$detil->total_need*100, 2, '.', ''),
            'total_need' => $detil->total_need+0,
            'akad' => $detil->akad == 1 ? 'Murabahah' : 'Mudharabah',
            'image_url' => '/storage/'.$detil->gambar_utama,
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
}
