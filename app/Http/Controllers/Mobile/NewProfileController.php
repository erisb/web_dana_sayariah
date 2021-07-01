<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CheckUserSign;
use App\DetilInvestor;
use App\PendanaanAktif;
use App\RekeningInvestor;
use App\Investor;
use App\News;
use App\Proyek;
use App\MasterJenisKelamin;
use App\MasterBank;
use App\MasterKawin;
use App\MasterProvinsi;
use App\MasterPendapatan;
use App\MasterPendidikan;
use App\MasterPekerjaan;
use App\MutasiInvestor;
use App\ListImbalUser;
use App\RDLAccountNumber;
use App\Log_Imbal_User;
use App\LogAkadDigiSignInvestor;
use App\ThresholdKontrak;
use App\BorrowerPendanaan;
use App\Http\Controllers\DigiSignController;
use App\Http\Controllers\RDLController;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\DB;
use Validator;
use Image;

class NewProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['convertBase64', 'downloadDigiSignInvestor','newnewallProfileSertifikat','newallProfileSertifikat', 'register_akad','checkToken','home','allMasterBaru', 'updateProfileBaru', 'cek_akad_wakalah', 'newnewallProfileSertifikatBaru']]);
    }

    public function cek_dana_teralokasi(){

        $id = Auth::guard('api')->user()->id;

         $rekening = PendanaanAktif::join('proyek', 'pendanaan_aktif.proyek_id', '=', 'proyek.id')
                     ->where('pendanaan_aktif.investor_id', $id)
                     ->where('pendanaan_aktif.status',1)
                     ->where('proyek.status', '!=' , 4 )
                     ->sum('pendanaan_aktif.total_dana');

        return [
            'dana_teralokasi' => isset($rekening) ? number_format($rekening,0,',','.') : 0,
        ];
    }

    public function home(){
        
        $pendanaan = 0;
        $rekening = 0;
        $bagi_hasil = 0;
        $danaku = 0;
        
        $news = News::limit(3)->orderBy('updated_at', 'desc')->get();

        $x=0;
        if (!isset($news[0])) {
            $newest = null;
        }
        else {
                foreach ($news as $item){
                $newest[$x] = [
                    'id'=>$item->id,
                    'title'=>$item->title,
                    'image'=>'/storage/'.$item->image,
                    'writer'=>$item->writer,
                    'updated_at'=>$item->updated_at->toDateString(),
                ];
                $x++;
            }
        }

        $proyek = Proyek::where('status',1)->orderBy('profit_margin', 'desc')
                        ->limit(10)
                        ->get();
        $i = 0;
        foreach ($proyek as $item){
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
            $proyek_aktif[$i] = [
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

        return [
            'rekening' => [
                'total_aset' => $rekening,
                'dana_tersedia' => $rekening,
                'bagi_hasil' => $bagi_hasil,
                'total_pendanaan' => $pendanaan
            ],
            'pendanaan' => $danaku,
            'news' => $newest,
            'nama' => null,
            'email'=>null,
            'gambar_profil'=>null,
            'proyek_aktif'=> isset($proyek_aktif) ? $proyek_aktif : null
        ];
    }

    public function homeLogin(){
        
        $pendanaan = PendanaanAktif::where('investor_id', Auth::guard('api')->user()->id)->where('status', 1)->get();
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        $i=0;
        if (!isset($pendanaan[0]))
        {
            $danaku = null;
        }
        else
        {
            foreach ($pendanaan as $item) {
                $danaku[$i] = [
                    'id'=>$item->id,
                    'id_proyek' => $item->proyek->id,
                    'nama' => $item->proyek->nama,
                    'gambar' => '/storage/'.$item->proyek->gambar_utama,
                    'harga_paket'=>number_format($item->proyek->harga_paket,0,',','.'),
                ];
                $i++;
            }
        }
        
        $bagi_hasil = $pendanaan->sum('total_dana')-$pendanaan->sum('nominal_awal');
        
        $news = News::limit(3)->orderBy('updated_at', 'desc')->get();

        $proyek = Proyek::where('status',1)->orderBy('profit_margin', 'desc')
                        ->limit(10)
                        ->get();
        $i = 0;
        foreach ($proyek as $item){
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
            $proyek_aktif[$i] = [
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

        $x=0;
        if (!isset($news[0])) {
            $newest = null;
        }
        else {
                foreach ($news as $item){
                $newest[$x] = [
                    'id'=>$item->id,
                    'title'=>$item->title,
                    'image'=>'/storage/'.$item->image,
                    'writer'=>$item->writer,
                    'updated_at'=>$item->updated_at->toDateString(),
                ];
                $x++;
            }
        }

        $investor = Investor::where('id', Auth::guard('api')->user()->id)->first();
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)
                                ->first();

        return [
            'rekening' => [
                'total_aset' => isset($rekening->total_dana) ? number_format($rekening->total_dana,0,',','.') : 0,
                'dana_tersedia' => isset($rekening->unallocated) ? number_format($rekening->unallocated,0,',','.') : 0,
                'bagi_hasil' => isset($bagi_hasil) ? number_format($bagi_hasil,0,',','.') : 0,
                'total_pendanaan' => $pendanaan->sum('total_dana') !== NULL ? $pendanaan->sum('total_dana') : 0
            ],
            'pendanaan' => $danaku != 0 ? $danaku : 0,
            'news' => $newest,
            'nama' => isset($detil) ? $detil->nama_investor : 'NoName',
            'email' => $investor->email,
            'gambar_profil' => isset($detil) ? '/storage/'. $detil->pic_investor : '',
            'proyek_aktif'=> isset($proyek_aktif) ? $proyek_aktif : null
        ];
    }

    public function allProfile(){
        // $id = '52215';
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)
                                    ->first();
        $mutasi3Terakhir = MutasiInvestor::where('investor_id', Auth::guard('api')->user()->id)
                                        ->orderby('id', 'desc')
                                        ->limit(3)
                                        ->get();
        $i = 0;
        foreach ($mutasi3Terakhir as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        $data = [
                    'dana_tersedia' => isset($rekening) ? number_format($rekening->unallocated,0,',','.') : '',
                    'va' => isset($rekening) ? $rekening->va_number : '',
                    'mutasi' => isset($return[0]) ? $return : null
                ];

        return response()->json($data);
    }

    public function allProfileSertifikat(){
        // $id = '52215';
        $id = Auth::guard('api')->user()->id;
        $rekening = RekeningInvestor::where('investor_id', $id)
                                    ->first();
        $mutasi3Terakhir = MutasiInvestor::where('investor_id', $id)
                                        ->orderby('id', 'desc')
                                        ->limit(3)
                                        ->get();
        $i = 0;
        foreach ($mutasi3Terakhir as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        $data = [
                    'dana_tersedia' => isset($rekening) ? number_format($rekening->unallocated,0,',','.') : '',
                    'va' => isset($rekening) ? $rekening->va_number : '',
                    'id' => isset($rekening) ? $rekening->investor_id : '',
                    'mutasi' => isset($return[0]) ? $return : null
                ];

        return response()->json($data);
    }

    public function newallProfileSertifikat(){
        // $id = '52237';
        $id = Auth::guard('api')->user()->id;
        $rekening = RekeningInvestor::where('investor_id', $id)
                                    ->first();
        $mutasi3Terakhir = MutasiInvestor::where('investor_id', $id)
                                        ->orderby('id', 'desc')
                                        ->limit(3)
                                        ->get();

        $log_akad = LogAkadDigiSignInvestor::where('investor_id', $id)
                                             ->orderby('id_log_akad_investor', 'desc')
                                             ->first();

        $query_threshold = ThresholdKontrak::orderby('id_threshold', 'desc')
                                            ->first();


        $total_asset = isset($rekening->total_dana) ? number_format($rekening->total_dana,0,',','.'): 0;
        $total_log_akad = isset($log_akad) ? number_format($log_akad->total_aset,0,',','.'): 0;
        $threshold = isset($query_threshold) ? number_format($query_threshold->threshold_kontrak,0,',','.'): 0;

        if ($total_asset != 0)
        {
            if ($total_log_akad != 0)
            {
                if ($total_asset != $total_log_akad)
                {
                    $status_button_akad = 'buka';
                }
                else
                {
                    $status_button_akad = 'tutup';
                }
            }
            else
            {
                $status_button_akad = 'buka';
            }
        }
        else
        {
            $status_button_akad = 'hilang';
        }

        $i = 0;
        foreach ($mutasi3Terakhir as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        $data = [
                    'dana_tersedia' => isset($rekening) ? number_format($rekening->unallocated,0,',','.') : '',
                    'va' => isset($rekening) ? $rekening->va_number : '',
                    'id' => isset($rekening) ? $rekening->investor_id : '',
                    'mutasi' => isset($return[0]) ? $return : null,
                    'status_button_akad'=> $status_button_akad
                ];

        return response()->json($data);
    }

    public function newnewallProfileSertifikat(){
        // $id = '52237';
        $id = Auth::guard('api')->user()->id;
        $rekening = RekeningInvestor::where('investor_id', $id)
                                    ->first();
        $mutasi3Terakhir = MutasiInvestor::where('investor_id', $id)
                                        ->orderby('id', 'desc')
                                        ->limit(3)
                                        ->get();

        $dataLogAkad = LogAkadDigiSignInvestor::where('investor_id', $id)
                                             ->orderby('id_log_akad_investor', 'desc')
                                             ->first();

        $dataThreshold = ThresholdKontrak::orderby('id_threshold', 'desc')
                                            ->first();

        $dataRegDigiSign = CheckUserSign::where('investor_id', Auth::guard('api')->user()->id)->first();                                            
        
        $cekRegDigiSign = !empty($dataRegDigiSign) ? $dataRegDigiSign->tgl_aktifasi : null;
        $realTotalAset = !empty($rekening) ? number_format($rekening->total_dana,0,'','') : 0;
        $logTotalAset = !empty($dataLogAkad) ? $dataLogAkad->total_aset : 0;
        $logStatus = !empty($dataLogAkad) ? $dataLogAkad->status : '';

        if ($logStatus == 'kirim')
        {
            $showKontrak = 'ttd_akhir';
        }
        else
        {
            if ($realTotalAset != 0)
            {
                if ($logTotalAset != 0)
                {
                    if ($realTotalAset != $logTotalAset)
                    {
                        $showKontrak = 'ttd_awal';
                        // $link = '';
                    }
                    else
                    {
                        $showKontrak = 'unduh';
                        // $link = Storage::url('akad_investor/'.Auth::user()->id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf');
                    }
                }
                else
                {
                    $showKontrak = 'buka';
                    // $link = '';
                }
            }
            else
            {
                $showKontrak = 'tutup';
                // $link = Storage::url('akad_investor/'.Auth::user()->id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf');
            }
        }


        // $realTotalAset = !empty($rekening) ? number_format($rekening->total_dana,0,'','') : 0;
        // $nilaiThreshold = !empty($dataThreshold) ? $dataThreshold->threshold_kontrak : 0;
        // $logTotalAset = !empty($dataLogAkad) ? $dataLogAkad->total_aset : 0;
        

        // if ($total_asset != 0)
        // {
        //     if ($total_log_akad != 0)
        //     {
        //         if ($total_asset != $total_log_akad)
        //         {
        //             $status_button_akad = 'buka';
        //         }
        //         else
        //         {
        //             $status_button_akad = 'tutup';
        //         }
        //     }
        //     else
        //     {
        //         $status_button_akad = 'buka';
        //     }
        // }
        // else
        // {
        //     $status_button_akad = 'hilang';
        // }

        // if (!empty($dataThreshold) && !empty($rekening) && !empty($dataLogAkad))
        // {
        //     if ($realTotalAset >= $nilaiThreshold)
        //     {
        //         if ($realTotalAset !== $logTotalAset)
        //         {
        //             $showKontrak = 'buka';
        //             $statusDigisign = 'lama';
        //         }
        //         else
        //         {
        //             $showKontrak = 'tutup';
        //             $statusDigisign = 'none';
        //         }
        //     }
        //     else
        //     {
        //         $showKontrak = 'tutup';
        //         $statusDigisign = 'none';
        //     }
        // }
        // elseif (!empty($dataThreshold) && !empty($rekening) && empty($dataLogAkad))
        // {
        //     if ($realTotalAset >= $nilaiThreshold)
        //     {
        //         $showKontrak = 'buka';
        //         $statusDigisign = 'baru';
        //     }
        //     else
        //     {
        //         $showKontrak = 'tutup';
        //         $statusDigisign = 'none';
        //     }
        // }
        // else
        // {
        //     $showKontrak = 'tutup';
        //     $statusDigisign = 'none';
        // }

        $i = 0;
        foreach ($mutasi3Terakhir as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        $data = [
                    'dana_tersedia' => isset($rekening) ? number_format($rekening->unallocated,0,',','.') : '',
                    'total_aset' => isset($total_dana) ? number_format($rekening->total_dana,0,',','.') : 0,
                    'real_total_aset' => $realTotalAset,
                    'va' => isset($rekening) ? $rekening->va_number : '',
                    'id' => isset($rekening) ? $rekening->investor_id : '',
                    'mutasi' => isset($return[0]) ? $return : null,
                    'status_button_akad'=> $showKontrak,
                    'email'=>Auth::guard('api')->user()->email,
                    'cekRegDigiSign' => $cekRegDigiSign
                ];

        return response()->json($data);
    }

    public function newnewallProfileSertifikatBaru(){
        $search = 'investorKontrak';
        $id = Auth::guard('api')->user()->id;
        $rekening = RekeningInvestor::where('investor_id', $id)
                                    ->first();
        $mutasi3Terakhir = MutasiInvestor::where('investor_id', $id)
                                        ->orderby('id', 'desc')
                                        ->limit(3)
                                        ->get();

        $dataLogAkad = LogAkadDigiSignInvestor::where('investor_id', $id)
                                            ->where('document_id', 'like', '%'.$search.'%')
                                            ->orderby('id_log_akad_investor', 'desc')
                                            ->first();

        $dataThreshold = ThresholdKontrak::orderby('id_threshold', 'desc')
                                            ->first();

        $dataRDL = RDLAccountNumber::where('investor_id', $id)->first();

        $dataRegDigiSign = CheckUserSign::where('investor_id', $id)->first();                                            
        
        $cekRegDigiSign = !empty($dataRegDigiSign) ? $dataRegDigiSign->tgl_aktifasi : null;
        $realTotalAset = !empty($rekening) ? number_format($rekening->total_dana,0,'','') : 0;
        $logTotalAset = !empty($dataLogAkad) ? $dataLogAkad->total_aset : 0;
        $logStatus = !empty($dataLogAkad) ? $dataLogAkad->status : '';

        if($dataLogAkad){
            if ($logStatus == 'kirim')
            {
                $showKontrak = 'ttd_akhir';
            }
            else
            {
                if ($realTotalAset != 0)
                {
                    if ($logTotalAset != 0)
                    {
                        if ($realTotalAset != $logTotalAset)
                        {
                            $showKontrak = 'ttd_awal';
                            // $link = '';
                        }
                        else
                        {
                            $showKontrak = 'unduh';
                            // $link = Storage::url('akad_investor/'.Auth::user()->id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf');
                        }
                    }
                    else
                    {
                        $showKontrak = 'buka';
                        // $link = '';
                    }
                }
                else
                {
                    $showKontrak = 'tutup';
                    // $link = Storage::url('akad_investor/'.Auth::user()->id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf');
                }
            }
        }else{
            $showKontrak = 'buka';
        }

        $i = 0;
        foreach ($mutasi3Terakhir as $mutasi){
            $return[$i] = [
                'id'=>$mutasi->id,
                'nominal'=> $mutasi->nominal,
                'perihal'=>$mutasi->perihal,
                'tipe'=>$mutasi->tipe,
                'created_at'=>$mutasi->created_at->toDateString(),
            ];
            $i++;
        }

        $data = [
                    'dana_tersedia' => isset($rekening) ? number_format($rekening->unallocated,0,',','.') : '',
                    'total_aset' => isset($total_dana) ? number_format($rekening->total_dana,0,',','.') : 0,
                    'real_total_aset' => $realTotalAset,
                    'va' => isset($rekening) ? $rekening->va_number : '',
                    'id' => isset($rekening) ? $rekening->investor_id : '',
                    'mutasi' => isset($return[0]) ? $return : null,
                    'status_button_akad'=> $showKontrak,
                    'email'=>Auth::guard('api')->user()->email,
                    'cekRegDigiSign' => $cekRegDigiSign,
                    'cif_number' => $dataRDL->cif_number,
                    'account_number' => $dataRDL->account_number
                ];

        return response()->json($data);
    }

    public function showVa(){
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        $detil_investor = DetilInvestor::where('investor_id',Auth::guard('api')->user()->id)->first();
        $va = isset($rekening) ? $rekening->va_number : '';

        return [
            'va' => $va,
            'nama' => $detil_investor->nama_investor,
            'html' => [
                'bni_tf' => '<ol>
                            <li>Masukkan kartu Anda</li>
                            <li>Pilih Bahasa</li>
                            <li>Masukkan PIN ATM Anda</li>
                            <li>Pilih "Menu Lainnya"</li>
                            <li>Pilih "Transfer"</li>
                            <li>Pilih "Rekening Tabungan"</li>
                            <li>Pilih "Ke Rekening BNI"</li>
                            <li>Masukkan nomor virtual account anda ('.$va.')</li>
                            <li>Konfirmasi, apabila telah sesuai, lanjutkan transaksi</li>
                            <li>Transaksi telah selesai</li>
                            </ol>',

                'bni_mobile' => '<ol class="list_add_funds">
                                <li>Akses BNI Mobile Banking kemudian masukkan user ID dan password</li>
                                <li>Pilih menu Transfer</li>
                                <li>Pilih "Antar Rekening BNI" kemudian "Input Rekening Baru"</li>
                                <li>Masukkan Rekening Debit dan nomor Virtual Account Tujuan ('.$va.')</li>
                                <li>Masukkan nominal transfer sesuai keinginan Anda.</li>
                                <li>Konfirmasi transaksi dan masukkan Password Transaksi</li>
                                <li>Transfer Anda Telah Berhasil</li>
                                </ol>',

                'atm_bersama' => '<ol class="list_add_funds">
                                <li>Masukkan kartu ke mesin ATM bersama</li>
                                <li>Pilih "Transaksi Lainnya"</li>
                                <li>Pilih menu "Transfer"</li>
                                <li>Pilih "Transfer ke Bank Lain"</li>
                                <li>Masukkan kode bank BNI (009) dan 16 Digit Nomor VA ('.$va.') </li>
                                <li>Masukkan nominal transfer sesuai keinginan Anda.</li>
                                <li>Konfirmasi rincian akan tampil di layar, cek dan tekan "Ya" untuk melanjutka</li>
                                <li>Transaksi Berhasil</li>
                                </ol>'
            ]
        ];
    }

    public function showProfile() {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)
                                ->first();
        $master_jenis_kelamin = MasterJenisKelamin::all();
        $x=0;
        if (!isset($master_jenis_kelamin[0])) {
            $master_jenis_kelamin = null;
        }
        else {
                foreach ($master_jenis_kelamin as $item){
                $data_jenis_kelamin[$x] = [
                    'id'=>$item->id_jenis_kelamin,
                    'jenis_kelamin'=>$item->jenis_kelamin,
                ];
                $x++;
            }
        }

        $master_bank = MasterBank::all();
        $x=0;
        if (!isset($master_bank[0])) {
            $master_bank = null;
        }
        else {
                foreach ($master_bank as $item){
                $data_bank[$x] = [
                    'kode'=>$item->kode_bank,
                    'nama_bank'=>$item->nama_bank,
                ];
                $x++;
            }
        }

        $master_provinsi = MasterProvinsi::groupBy('kode_provinsi')->get();
        $x=0;
        if (!isset($master_provinsi[0])) {
            $master_provinsi = null;
        }
        else {
                foreach ($master_provinsi as $item){
                $data_provinsi[$x] = [
                    'kode'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                ];
                $x++;
            }
        }

        $master_kota = MasterProvinsi::all();
        $x=0;
        if (!isset($master_kota[0])) {
            $master_kota = null;
        }
        else {
                foreach ($master_kota as $item){
                $data_kota[$x] = [
                    'kode_provinsi'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                    'kode_kota'=>$item->kode_kota,
                    'nama_kota'=>$item->nama_kota
                ];
                $x++;
            }
        }

        return [
            'nama' => $detil->nama_investor,
            'tempat_lahir' => $detil->tempat_lahir_investor,
            'tgl_lahir' => $detil->tgl_lahir_investor,
            'jenis_kelamin' => $detil->jenis_kelamin_investor,
            'no_ktp' => $detil->no_ktp_investor,
            'no_npwp' => $detil->no_npwp_investor,
            'nohp' => $detil->phone_investor,
            'alamat' => $detil->alamat_investor,
            'provinsi' => $detil->provinsi_investor,
            'kota' => $detil->kota_investor,
            'kode_pos' => $detil->kode_pos_investor,
            'foto_investor' => '/storage/'.$detil->pic_investor,
            'foto_ktp' => '/storage/'.$detil->pic_ktp_investor,
            'foto_investorKtp' => '/storage/'.$detil->pic_user_ktp_investor,
            'rekening' => $detil->rekening,
            'bank' => $detil->bank_investor,
            'nama_pemilik_rekening' => $detil->nama_pemilik_rek,
            'data_jenis_kelamin' => $data_jenis_kelamin,
            'data_bank' => $data_bank,
            'data_provinsi' => $data_provinsi,
            'data_kota' => $data_kota
        ];
    }

    public function showProfileBaru() {
        $id = Auth::guard('api')->user()->id;
        $detil = DetilInvestor::where('investor_id', $id)
                                ->first();
        $master_jenis_kelamin = MasterJenisKelamin::all();
        $x=0;
        if (!isset($master_jenis_kelamin[0])) {
            $master_jenis_kelamin = null;
        }
        else {
                foreach ($master_jenis_kelamin as $item){
                $data_jenis_kelamin[$x] = [
                    'id'=>$item->id_jenis_kelamin,
                    'jenis_kelamin'=>$item->jenis_kelamin,
                ];
                $x++;
            }
        }

        $master_bank = MasterBank::all();
        $x=0;
        if (!isset($master_bank[0])) {
            $master_bank = null;
        }
        else {
                foreach ($master_bank as $item){
                $data_bank[$x] = [
                    'kode'=>$item->kode_bank,
                    'nama_bank'=>$item->nama_bank,
                ];
                $x++;
            }
        }

        $master_provinsi = MasterProvinsi::groupBy('kode_provinsi')->get();
        $x=0;
        if (!isset($master_provinsi[0])) {
            $master_provinsi = null;
        }
        else {
                foreach ($master_provinsi as $item){
                $data_provinsi[$x] = [
                    'kode'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                ];
                $x++;
            }
        }

        $master_kota = MasterProvinsi::all();
        $x=0;
        if (!isset($master_kota[0])) {
            $master_kota = null;
        }
        else {
                foreach ($master_kota as $item){
                $data_kota[$x] = [
                    'kode_provinsi'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                    'kode_kota'=>$item->kode_kota,
                    'nama_kota'=>$item->nama_kota
                ];
                $x++;
            }
        }

        $master_kawin = MasterKawin::all();
        $x=0;
        if (!isset($master_kawin[0])) {
            $master_kawin = null;
        }
        else {
                foreach ($master_kawin as $item){
                $data_kawin[$x] = [
                    'id_kawin'=>$item->id_kawin,
                    'jenis_kawin'=>$item->jenis_kawin,

                ];
                $x++;
            }
        }

        $master_pendapatan = MasterPendapatan::all();
        $x=0;
        if (!isset($master_pendapatan[0])) {
            $master_pendapatan = null;
        }
        else {
                foreach ($master_pendapatan as $item){
                $data_pendapatan[$x] = [
                    'id_pendapatan'=>$item->id_pendapatan,
                    'pendapatan'=>$item->pendapatan,

                ];
                $x++;
            }
        }

        $master_pendidikan = MasterPendidikan::all();
        $x=0;
        if (!isset($master_pendidikan[0])) {
            $master_pendidikan = null;
        }
        else {
                foreach ($master_pendidikan as $item){
                $data_pendidikan[$x] = [
                    'id_pendidikan'=>$item->id_pendidikan,
                    'pendidikan'=>$item->pendidikan,

                ];
                $x++;
            }
        }

        $master_pekerjaan = MasterPekerjaan::all();
        $x=0;
        if (!isset($master_pekerjaan[0])) {
            $master_pekerjaan = null;
        }
        else {
                foreach ($master_pekerjaan as $item){
                $data_pekerjaan[$x] = [
                    'id_pekerjaan'=>$item->id_pekerjaan,
                    'pekerjaan'=>$item->pekerjaan,

                ];
                $x++;
            }
        }

        return [
            'nama' => $detil->nama_investor,
            'tempat_lahir' => $detil->tempat_lahir_investor,
            'tgl_lahir' => $detil->tgl_lahir_investor,
            'jenis_kelamin' => $detil->jenis_kelamin_investor,
            'no_ktp' => $detil->no_ktp_investor,
            'no_npwp' => $detil->no_npwp_investor,
            'nohp' => $detil->phone_investor,
            'alamat' => $detil->alamat_investor,
            'provinsi' => $detil->provinsi_investor,
            'kota' => $detil->kota_investor,
            'kode_pos' => $detil->kode_pos_investor,
            'foto_investor' => '/storage/'.$detil->pic_investor,
            'foto_ktp' => '/storage/'.$detil->pic_ktp_investor,
            'foto_investorKtp' => '/storage/'.$detil->pic_user_ktp_investor,
            'rekening' => $detil->rekening,
            'bank' => $detil->bank_investor,
            'nama_pemilik_rekening' => $detil->nama_pemilik_rek,
            'data_jenis_kelamin' => $data_jenis_kelamin,
            'data_bank' => $data_bank,
            'data_provinsi' => $data_provinsi,
            'data_kota' => $data_kota,
            'data_kawin' => $data_kawin,
            'data_pendapatan' => $data_pendapatan,
            'data_pendidikan' => $data_pendidikan,
            'data_pekerjaan' => $data_pekerjaan,
            'nama_ibu_kandung' => $detil->nama_ibu_kandung,
            'status_kawin' => $detil->status_kawin_investor,
            'pendapatan' => $detil->pendapatan_investor,
            'kecamatan' => $detil->kecamatan,
            'kelurahan' => $detil->kelurahan,
            'pendidikan' => $detil->pendidikan_investor,
            'pekerjaan' => $detil->pekerjaan_investor
        ];
    }

    public function allMaster() {
        
        $master_jenis_kelamin = MasterJenisKelamin::all();
        $x=0;
        if (!isset($master_jenis_kelamin[0])) {
            $master_jenis_kelamin = null;
        }
        else {
                foreach ($master_jenis_kelamin as $item){
                $data_jenis_kelamin[$x] = [
                    'id'=>$item->id_jenis_kelamin,
                    'jenis_kelamin'=>$item->jenis_kelamin,
                ];
                $x++;
            }
        }

        $master_bank = MasterBank::all();
        $x=0;
        if (!isset($master_bank[0])) {
            $master_bank = null;
        }
        else {
                foreach ($master_bank as $item){
                $data_bank[$x] = [
                    'kode'=>$item->kode_bank,
                    'nama_bank'=>$item->nama_bank,
                ];
                $x++;
            }
        }

        $master_provinsi = MasterProvinsi::groupBy('kode_provinsi')->get();
        $x=0;
        if (!isset($master_provinsi[0])) {
            $master_provinsi = null;
        }
        else {
                foreach ($master_provinsi as $item){
                $data_provinsi[$x] = [
                    'kode'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                ];
                $x++;
            }
        }

        $master_kota = MasterProvinsi::all();
        $x=0;
        if (!isset($master_kota[0])) {
            $master_kota = null;
        }
        else {
                foreach ($master_kota as $item){
                $data_kota[$x] = [
                    'kode_provinsi'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                    'kode_kota'=>$item->kode_kota,
                    'nama_kota'=>$item->nama_kota
                ];
                $x++;
            }
        }

        return [
            'data_jenis_kelamin' => $data_jenis_kelamin,
            'data_bank' => $data_bank,
            'data_provinsi' => $data_provinsi,
            'data_kota' => $data_kota
        ];
    }

    public function allMasterBaru() {
        
        $master_jenis_kelamin = MasterJenisKelamin::all();
        $x=0;
        if (!isset($master_jenis_kelamin[0])) {
            $master_jenis_kelamin = null;
        }
        else {
                foreach ($master_jenis_kelamin as $item){
                $data_jenis_kelamin[$x] = [
                    'id'=>$item->id_jenis_kelamin,
                    'jenis_kelamin'=>$item->jenis_kelamin,
                ];
                $x++;
            }
        }

        $master_bank = MasterBank::all();
        $x=0;
        if (!isset($master_bank[0])) {
            $master_bank = null;
        }
        else {
                foreach ($master_bank as $item){
                $data_bank[$x] = [
                    'kode'=>$item->kode_bank,
                    'nama_bank'=>$item->nama_bank,
                ];
                $x++;
            }
        }

        $master_provinsi = MasterProvinsi::groupBy('kode_provinsi')->get();
        $x=0;
        if (!isset($master_provinsi[0])) {
            $master_provinsi = null;
        }
        else {
                foreach ($master_provinsi as $item){
                $data_provinsi[$x] = [
                    'kode'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                ];
                $x++;
            }
        }

        $master_kota = MasterProvinsi::all();
        $x=0;
        if (!isset($master_kota[0])) {
            $master_kota = null;
        }
        else {
                foreach ($master_kota as $item){
                $data_kota[$x] = [
                    'kode_provinsi'=>$item->kode_provinsi,
                    'nama_provinsi'=>$item->nama_provinsi,
                    'kode_kota'=>$item->kode_kota,
                    'nama_kota'=>$item->nama_kota
                ];
                $x++;
            }
        }

        $master_kawin = MasterKawin::all();
        $x=0;
        if (!isset($master_kawin[0])) {
            $master_kawin = null;
        }
        else {
                foreach ($master_kawin as $item){
                $data_kawin[$x] = [
                    'id_kawin'=>$item->id_kawin,
                    'jenis_kawin'=>$item->jenis_kawin,

                ];
                $x++;
            }
        }

        $master_pendapatan = MasterPendapatan::all();
        $x=0;
        if (!isset($master_pendapatan[0])) {
            $master_pendapatan = null;
        }
        else {
                foreach ($master_pendapatan as $item){
                $data_pendapatan[$x] = [
                    'id_pendapatan'=>$item->id_pendapatan,
                    'pendapatan'=>$item->pendapatan,

                ];
                $x++;
            }
        }

        $master_pendidikan = MasterPendidikan::all();
        $x=0;
        if (!isset($master_pendidikan[0])) {
            $master_pendidikan = null;
        }
        else {
                foreach ($master_pendidikan as $item){
                $data_pendidikan[$x] = [
                    'id_pendidikan'=>$item->id_pendidikan,
                    'pendidikan'=>$item->pendidikan,

                ];
                $x++;
            }
        }

        $master_pekerjaan = MasterPekerjaan::all();
        $x=0;
        if (!isset($master_pekerjaan[0])) {
            $master_pekerjaan = null;
        }
        else {
                foreach ($master_pekerjaan as $item){
                $data_pekerjaan[$x] = [
                    'id_pekerjaan'=>$item->id_pekerjaan,
                    'pekerjaan'=>$item->pekerjaan,

                ];
                $x++;
            }
        }

        return [
            'data_jenis_kelamin' => $data_jenis_kelamin,
            'data_bank' => $data_bank,
            'data_provinsi' => $data_provinsi,
            'data_kota' => $data_kota,
            'data_kawin' => $data_kawin,
            'data_pendapatan' => $data_pendapatan,
            'data_pendidikan' => $data_pendidikan,
            'data_pekerjaan' => $data_pekerjaan
        ];
    }
    // public function updateProfile(Request $request) {
    //     $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

    //     $detil->nama_investor = $request->nama_investor;
    //     // $detil->no_ktp_investor = $request->no_ktp_investor;
    //     // $detil->pasangan_investor = $request->pasangan_investor;
    //     // $detil->pasangan_phone = $request->pasangan_phone;
    //     // $detil->job_investor = $request->job_investor;
    //     $detil->alamat_investor = $request->alamat_investor;
    //     // if ($request->hasFile('pic_investor')) {
    //     //     Storage::disk('public')->delete($detil->pic_investor);
    //     //     $detil->pic_investor = $this->upload('pic_investor', $request, $detil->investor_id );
    //     // }
    //     $detil->rekening = $request->rekening;
    //     $detil->bank = $request->bank;
    //     // $detil->no_npwp_investor = $request->no_npwp_investor;
    //     $detil->save();
        
    //     return response()->json(['success' => "Profile berhasil diupdate"]);
    // }
    public function updateProfile(Request $request) {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        $detil->investor_id = Auth::guard('api')->user()->id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening;
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
        if ($request->hasFile('pic_investor')) {
            Storage::disk('public')->delete($detil->pic_investor);
            $detil->pic_investor = $this->upload('pic_investor', $request, Auth::guard('api')->user()->id);
        }

        if ($request->hasFile('pic_ktp_investor')) {
            Storage::disk('public')->delete($detil->pic_ktp_investor);
            $detil->pic_ktp_investor = $this->upload('pic_ktp_investor', $request, Auth::guard('api')->user()->id);
        }

        if ($request->hasFile('pic_user_ktp_investor')) {
            Storage::disk('public')->delete($detil->pic_user_ktp_investor);
            $detil->pic_user_ktp_investor = $this->upload('pic_user_ktp_investor', $request, Auth::guard('api')->user()->id);
        }
        
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

        $detil->save();

        return response()->json(['success' => "Profile berhasil diupdate"]);
    }

    private function upload($column,Request $request, $investor_id)
    {
        if ($request->hasFile($column)) {
            $file = $request->file($column);
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

    public function updateProfileNew(Request $request) {
        $detil = DetilInvestor::where('investor_id', Auth::user()->id)->first();

        $detil->investor_id = Auth::user()->id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
        $detil->kode_pos_investor = $request->kode_pos;
        $detil->tempat_lahir_investor = $request->tempat_lahir;
        $detil->tgl_lahir_investor = $request->tgl_lahir.'-'.$request->bln_lahir.'-'.$request->thn_lahir;
        $detil->jenis_kelamin_investor = $request->jenis_kelamin;
        $detil->status_kawin_investor = null;
        $detil->status_rumah_investor = null;
        $detil->agama_investor = null;
        $detil->pekerjaan_investor = null;
        $detil->bidang_pekerjaan = null;
        $detil->online_investor = null;
        $detil->pendapatan_investor = null;
        $detil->asset_investor = null;
        $detil->pengalaman_investor = null;
        $detil->pendidikan_investor = null;
        $detil->bank_investor = $request->bank;
        $detil->rekening = $request->rekening;
        $detil->nama_pemilik_rek = $request->nama_pemilik_rek;
        // if ($request->hasFile('pic_investor')) {
        //     // Storage::disk('public')->delete($detil->pic_investor);
        //     $detil->pic_investor = 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
        // }else{
        //     $detil->pic_investor = null;
        // }

        // if ($request->hasFile('pic_ktp_investor')) {
        //     // Storage::disk('public')->delete($detil->pic_ktp_investor);
        //     $detil->pic_ktp_investor = 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();
        // }else{
        //     $detil->pic_ktp_investor = null;
        // }

        // if ($request->hasFile('pic_user_ktp_investor')) {
        //     // Storage::disk('public')->delete($detil->pic_user_ktp_investor);
        //     $detil->pic_user_ktp_investor = 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();
        // }else{
        //     $detil->pic_user_ktp_investor = null;
        // }
        
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

        $detil->save();

        return response()->json(['success' => "Profil berhasil diubah"]);
    }

    public function updateProfileBaru(Request $request) {
        $investor_id=Auth::guard('api')->user()->id;

        $detil = DetilInvestor::where('investor_id', $investor_id)->first();

        $detil->investor_id = $investor_id;
        $detil->tipe_pengguna = null;
        $detil->nama_investor = $request->nama;
        $detil->no_ktp_investor = $request->no_ktp;
        $detil->no_npwp_investor = $request->no_npwp == '' ? null : $request->no_npwp;
        $detil->phone_investor = $request->no_hp;
        $detil->alamat_investor = $request->alamat;
        $detil->provinsi_investor = $request->provinsi;
        $detil->kota_investor = $request->kota;
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
        $detil->kecamatan = $request->kecamatan;
        $detil->kelurahan = $request->kelurahan;
        $detil->nama_ibu_kandung = $request->nama_ibu_kandung;
        // if ($request->hasFile('pic_investor')) {
        //     // Storage::disk('public')->delete($detil->pic_investor);
        //     $detil->pic_investor = 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension();
        // }else{
        //     $detil->pic_investor = null;
        // }

        // if ($request->hasFile('pic_ktp_investor')) {
        //     // Storage::disk('public')->delete($detil->pic_ktp_investor);
        //     $detil->pic_ktp_investor = 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension();
        // }else{
        //     $detil->pic_ktp_investor = null;
        // }

        // if ($request->hasFile('pic_user_ktp_investor')) {
        //     // Storage::disk('public')->delete($detil->pic_user_ktp_investor);
        //     $detil->pic_user_ktp_investor = 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension();
        // }else{
        //     $detil->pic_user_ktp_investor = null;
        // }
        
        $detil->jenis_badan_hukum = null;
        $detil->nama_perwakilan = null;
        $detil->no_ktp_perwakilan = null;

        $detil->save();

        return response()->json(['success' => "Profil berhasil diubah"]);
    }

    public function actionUpload1(Request $request)
    {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        
        if ($request->hasFile('pic_investor')) {
            Storage::disk('public')->delete($detil->pic_investor);
            $file = $request->file('pic_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor.' . $file->getClientOriginalExtension();

            $detil->update(['pic_investor'=>'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension()]);

//            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete($detil->pic_investor);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }

        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function actionUpload2(Request $request)
    {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        if ($request->hasFile('pic_ktp_investor')) {
            Storage::disk('public')->delete($detil->pic_ktp_investor);
            $file = $request->file('pic_ktp_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor.' . $file->getClientOriginalExtension();

            $detil->update(['pic_ktp_investor' => 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension()]);

            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete($detil->pic_investor);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload3(Request $request)
    {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        if ($request->hasFile('pic_user_ktp_investor')) {
            Storage::disk('public')->delete($detil->pic_user_ktp_investor);
            $file = $request->file('pic_user_ktp_investor');
            $resize = Image::make($file)->resize(480,640, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $file->getClientOriginalExtension();

            $detil->update(['pic_user_ktp_investor' => 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension()]);

            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete($detil->pic_investor);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
            
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload1new(Request $request)
    {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        
        if ($request->hasFile('pic_investor')) {
            Storage::disk('public')->delete($detil->pic_investor);
            $file = $request->file('pic_investor');
            $resize = Image::make($file)->save();
            $filename = Carbon::now()->toDateString() . 'pic_investor.' . $file->getClientOriginalExtension();

            $detil->update(['pic_investor'=>'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_investor.' . $request->file('pic_investor')->getClientOriginalExtension()]);

//            save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::guard('api')->user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
//            save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete($detil->pic_investor);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }

        }
        else {
            return response()->json([
                'failed' => 'File Kosong'
            ]);
        }
    }

    public function actionUpload2new(Request $request)
    {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        if ($request->hasFile('pic_ktp_investor')) {
            Storage::disk('public')->delete($detil->pic_ktp_investor);
            $file = $request->file('pic_ktp_investor');
            $resize = Image::make($file)->save();
            $filename = Carbon::now()->toDateString() . 'pic_ktp_investor.' . $file->getClientOriginalExtension();

            $detil->update(['pic_ktp_investor' => 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_ktp_investor.' . $request->file('pic_ktp_investor')->getClientOriginalExtension()]);

            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete($detil->pic_investor);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function actionUpload3new(Request $request)
    {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        if ($request->hasFile('pic_user_ktp_investor')) {
            Storage::disk('public')->delete($detil->pic_user_ktp_investor);
            $file = $request->file('pic_user_ktp_investor');
            $resize = Image::make($file)->save();
            $filename = Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $file->getClientOriginalExtension();

            $detil->update(['pic_user_ktp_investor' => 'user/'. Auth::guard('api')->user()->id.'/'.Carbon::now()->toDateString() . 'pic_user_ktp_investor.' . $request->file('pic_user_ktp_investor')->getClientOriginalExtension()]);

            //  save nama file berdasarkan tanggal upload+nama file
            $store_path = 'user/' . Auth::user()->id;
            $path = $file->storeAs($store_path, $filename, 'public');
            //  save gambar yang di upload di public storage
            
            // Storage::disk('public')->delete($detil->pic_investor);

            if(Storage::disk('public')->exists('user/'.Auth::guard('api')->user()->id.'/'.$filename)){
                return response()->json([
                    'success' => 'Berhasil di upload'
                ]);
            }else{
                return response()->json([
                    'failed' => 'File gagal di upload'
                ]);
            }
            
        }
        else {
            return [
                'failed' => 'File Kosong'
            ];
        }
    }

    public function changePassword(Request $request) {
        $old = $request->get('old_password');
        if (!(Hash::check($old, Auth::guard('api')->user()->password))) {
            // The passwords matches
            return response()->json(["error"=>"Kata sandi lama anda salah"]);
        }
 
        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return response()->json(["error"=>"Kata sandi baru harus berbeda dengan kata sandi lama"]);
        }

        if(strlen($request->get('new_password')) < 6 ){
            return response()->json(["error"=>"Panjang kata sandi harus lebih dari 6 karakter"]);
        }
        
        // $validatedData = Validator::make([
        //     'old_password' => $request->old_password,
        //     'new_password' => $request->new_password,
        //     'new_password_confirmation' => $request->new_password_confirmation
        // ], [
        //     'old_password' => 'required',
        //     'new_password' => 'required|string|min:6|confirmed',
        // ]);

        // if ($validatedData->fails()) {
        //     return response()->json(['error'=>'Password confirmation did not match']);
        // }
            
        $new = $request->get('new_password');
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($new);
        $user->save();
 
        return response()->json(["success"=>"Perubahan kata sandi berhasil "]);
    }

    public function get_aktif_dana(Request $request) {
        
        $id=$request->pendanaan_id;
        
        $get_data_query = ListImbalUser::select('list_imbal_user.id', 'list_imbal_user.tanggal_payout', 'list_imbal_user.imbal_payout', 'list_imbal_user.ket_weekend', 'list_imbal_user.status_payout', 'detil_imbal_user.proposional')
                                ->where('list_imbal_user.pendanaan_id',$id)
                                //   ->where('list_imbal_user.status_payout',2)
                                  ->leftJoin('detil_imbal_user','detil_imbal_user.pendanaan_id','=','list_imbal_user.pendanaan_id')
                                //   ->groupBy('list_imbal_user.tanggal_payout');
                                  ->get();

        $get_data_prop = ListImbalUser::select('list_imbal_user.id', 'list_imbal_user.tanggal_payout', 'list_imbal_user.imbal_payout', 'list_imbal_user.ket_weekend', 'list_imbal_user.status_payout', 'detil_imbal_user.proposional')
                                ->where('list_imbal_user.pendanaan_id',$id)
                                //   ->where('list_imbal_user.status_payout',2)
                                  ->leftJoin('detil_imbal_user','detil_imbal_user.pendanaan_id','=','list_imbal_user.pendanaan_id')
                                //   ->groupBy('list_imbal_user.tanggal_payout');
                                  ->first();
        $tanggal_payout = date("d M Y",strtotime($get_data_prop['tanggal_payout']));
        if($get_data_prop['status_payout']==1){
            $status_imbal_hasil='Proporsional Gagal Transfer';
        }else if($get_data_prop['status_payout']==2){
            $status_imbal_hasil='Proposional Berhasil Transfer';
        }else if($get_data_prop['status_payout']==3){
            $status_imbal_hasil='Proposional Dalam Proses';
        }else if($get_data_prop['status_payout']==4){
            $status_imbal_hasil='Proposional Realokasi';
        }else{
            $status_imbal_hasil='Proposional';
        }

        $data=array();
        for($i=0; $i<sizeof($get_data_query)+1; $i++){
            if($i===0){
                $data[]=[
                    "id"=>$i,
                    "bulan"=>1,
                    "tanggal_payout"=>$tanggal_payout,
                    "ket_weekend"=>strip_tags($get_data_prop['ket_weekend']),
                    "imbal_hasil_diterima"=>$get_data_prop['proposional'],
                    "status_imbal_hasil"=>$status_imbal_hasil,
                ];
            }else{
                for($i=0; $i<sizeof($get_data_query); $i++){
                $tanggal_payout = date("d M Y",strtotime($get_data_query[$i]['tanggal_payout']));
                
                if($i==count($get_data_query)-2){
                    if($get_data_query[$i]['imbal_payout']!=='0.00'){
                    if($get_data_query[$i]['status_payout']==2){
                        $status_imbal_hasil='Sisa Imbal Hasil Berhasil di Transfer';
                    }else if($get_data_query[$i]['status_payout']==4){
                        $status_imbal_hasil='Sisa Imbal Hasil Berhasil di Realokasi';
                    }else{
                        $status_imbal_hasil='Sisa Imbal Hasil Akhir';
                    }
                    $data[]=[
                        "id"=>$i+1,
                        "bulan"=>$i,
                        "tanggal_payout" => $tanggal_payout,
                        "ket_weekend"=>strip_tags($get_data_query[$i]['ket_weekend']),
                        "imbal_hasil_diterima" =>$get_data_query[$i]['imbal_payout'],
                        "status_imbal_hasil" => $status_imbal_hasil,
                    ];
                    }
                }
                else if($i==count($get_data_query)-1){
                    if($get_data_query[$i]['status_payout']==4){
                        $status_imbal_hasil='Dana Pokok Di Alokasikan ke Dana Tersedia';
                    }else{
                        $status_imbal_hasil='Dana Pokok';
                    }
                    $data[]=[
                        "id"=>$i+1,
                        "bulan"=>$i-1,
                        "tanggal_payout" => $tanggal_payout,
                        "ket_weekend"=>strip_tags($get_data_query[$i]['ket_weekend']),
                        "imbal_hasil_diterima" =>$get_data_query[$i]['imbal_payout'],
                        "status_imbal_hasil" => $status_imbal_hasil,
                    ];
                }
                else{
                    if($get_data_query[$i]['status_payout']==1){
                        $status_imbal_hasil='Gagal Transfer';
                    }else if($get_data_query[$i]['status_payout']==2){
                        $status_imbal_hasil='Berhasil Transfer';
                    }else if($get_data_query[$i]['status_payout']==3){
                        $status_imbal_hasil='Dalam Proses';
                    }else if($get_data_query[$i]['status_payout']==4){
                        $status_imbal_hasil='Imbal Hasil Realokasi';
                    }else{
                        $status_imbal_hasil='Proyek Berjalan';
                    }
                    $data[]=[
                        "id"=>$i+1,
                        "bulan"=>$i+1,
                        "tanggal_payout" => $tanggal_payout,
                        "ket_weekend"=>strip_tags($get_data_query[$i]['ket_weekend']),
                        "imbal_hasil_diterima" =>$get_data_query[$i]['imbal_payout'],
                        "status_imbal_hasil" => $status_imbal_hasil,
                    ];
                    }
            }
            }
        }
        return json_encode($data);
    }

    public function list_proyek_funded() {
        $id=Auth::guard('api')->user()->id;
        // $id=21139;
        $pendanaan_aktif_query = PendanaanAktif::select('pendanaan_aktif.id', 'pendanaan_aktif.investor_id', 'pendanaan_aktif.proyek_id', 'pendanaan_aktif.total_dana', 'pendanaan_aktif.nominal_awal', 'pendanaan_aktif.tanggal_invest', 'pendanaan_aktif.status', 'proyek.nama', 'proyek.tgl_mulai', 'proyek.profit_margin')
                                            ->join('proyek', 'proyek.id', '=', 'pendanaan_aktif.proyek_id')
                                            ->where('pendanaan_aktif.investor_id', $id)
                                            ->where('pendanaan_aktif.status', 1)
                                            ->whereNotIn('pendanaan_aktif.proyek_id',[\DB::raw('select proyek_id from log_pengembalian_dana where investor_id = '.$id.' group by proyek_id')])
                                            ->whereIn('pendanaan_aktif.proyek_id',[\DB::raw('select id from proyek where proyek_id = pendanaan_aktif.proyek_id and status in (1,2,3) group by proyek_id')])
                                            ->orderBy('pendanaan_aktif.id','desc')
                                            ->get();
        
        $x=0;
        if (!isset($pendanaan_aktif_query[0])) {
            $pendanaan_aktif_query = null;
        }
        else {
                foreach ($pendanaan_aktif_query as $item){

                $profit_explode = (explode('.',$item->profit_margin));
                if($profit_explode[1]=='00'){
                    $profit_margin=$profit_explode[0];
                }else{
                    $profit_margin=$item->profit_margin;
                }
                
                $pendanaan_aktif[$x] = [
                    'pendanaan_id'=>$item->id,
                    'investor_id'=>$item->investor_id,
                    'proyek_id'=>$item->proyek_id,
                    'total_dana'=>$item->total_dana,
                    'nominal_awal'=>$item->nominal_awal,
                    'status'=>$item->status,
                    'tanggal_invest'=>$item->tanggal_invest->toDateString(),
                    'nama_proyek'=>$item->nama,
                    'tgl_mulai_proyek'=>$item->tgl_mulai,
                    'profit_margin'=>$profit_margin
                ];
                $x++;
            }
        }
        return  json_encode($pendanaan_aktif);
    }

    public function all_imbal(){

    $id=Auth::guard('api')->user()->id;
    // $id=21139;

    $all_imbal_query = Log_Imbal_User::where('log_imbal_user.investor_id', $id)
                                 ->whereNotIn('keterangan',['Dana Pokok'])
                                 ->leftJoin('proyek','proyek.id','=','log_imbal_user.proyek_id')
                                 ->leftJoin('pendanaan_aktif','pendanaan_aktif.id','=','log_imbal_user.pendanaan_id')
                                 ->select(DB::raw('SUM(nominal) as total'),'log_imbal_user.id','proyek.nama','proyek.tgl_mulai','proyek.tgl_selesai','pendanaan_aktif.tanggal_invest','pendanaan_aktif.total_dana')
                                 ->groupBy('log_imbal_user.pendanaan_id')
                                 ->orderBy('proyek.id','DESC')
                                 ->get();
        
        $y=0;
        $z=0;
        if (!isset($all_imbal_query[0])) {
            $all_imbal = null;
            $total_imbal = 0;
        }
        else {
            foreach ($all_imbal_query as $item){
            $all_imbal[$y] = [
                'id'=>$item->id,
                'total_imbal'=>number_format($item->total,0,',','.'),
                'nama_proyek'=>$item->nama,
                'tanggal_mulai'=>$item->tgl_mulai,
                'tanggal_selesai'=>$item->tgl_selesai,
                'tanggal_invest'=>$item->tanggal_invest,
                'total_dana'=>number_format($item->total_dana,0,',','.'),
            ];
            $y++;
            }
            $total_imbal=0;
            foreach ($all_imbal_query as $item){
               $total_imbal+=$item->total;
                $z++;
            }
        }

        return[
            'all_imbal' => $all_imbal,
            'total_imbal'=> number_format($total_imbal,0,',','.')
        ];

    }

    // public function register_akad(){
        
    //     // $investor_id = 52237;
    //     $investor_id = Auth::guard('api')->user()->id;
    //     $getDataInvestor = DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')->where('investor.id',$investor_id)->first();
        
    //     $dataJenisKelamin = MasterJenisKelamin::where('id_jenis_kelamin',$getDataInvestor->jenis_kelamin_investor)->first();

    //     $dataKotaProvinsi = MasterProvinsi::where('kode_kota',$getDataInvestor->kota_investor)->first();

    //     $dataTglLahir = explode('-',$getDataInvestor->tgl_lahir_investor);
    //     $tgl =  $dataTglLahir[0];
    //     $bln = $dataTglLahir[1];
    //     $thn = $dataTglLahir[2];
    //     if (strlen($tgl) == 1) {$tgl_new = '0'.$tgl;} else {$tgl_new = $tgl;}
    //     if (strlen($bln) == 1) {$bln_new = '0'.$bln;} else {$bln_new = $bln;}

    //     // $data_user = $getDataInvestor->investor_id;
    //     $data_provider = 1;

        
    //     $client = new Client();
    //     $data_json = array();
    //     $data_json = ['JSONFile' => [
    //                         'userid' => config('app.userid'),
    //                         'alamat' => $getDataInvestor->alamat_investor,
    //                         'jenis_kelamin' => $dataJenisKelamin->jenis_kelamin,
    //                         'kecamatan' => $getDataInvestor->kecamatan !== NULL ? $getDataInvestor->kecamatan : '-',
    //                         'kelurahan' => $getDataInvestor->kecamatan !== NULL ? $getDataInvestor->kelurahan : '-',
    //                         'kode-pos' => $getDataInvestor->kode_pos_investor,
    //                         'kota' => $dataKotaProvinsi->nama_kota,
    //                         'nama' => $getDataInvestor->nama_investor,
    //                         'tlp' => $getDataInvestor->phone_investor,
    //                         'tgl_lahir' => $tgl_new.'-'.$bln_new.'-'.$thn,
    //                         'provinci' => $dataKotaProvinsi->nama_provinsi,
    //                         'idktp' => $getDataInvestor->no_ktp_investor,
    //                         'tmp_lahir' => $getDataInvestor->tempat_lahir_investor,
    //                         'email' => $getDataInvestor->email,
    //                         'npwp' => $getDataInvestor->no_npwp_investor,
    //                         'redirect' => true
    //                     ]
    //                 ];

    //     $jsonFile = json_encode($data_json);
    //     // echo $jsonFile;die;

    //     $fotoDiri = $this->cekFotoDiriExist($getDataInvestor->id);

    //     $fotoKtp = $this->cekFotoKtpExist($getDataInvestor->id);

        
    //     // Log::info('foto_KTP = '.$fotoKtp);
    //     // Log::info('foto_DIRI = '.$fotoDiri);        
    //     //echo $fotoDiri.'--'.$fotoKtp;die;
    
    //     $multipart_form =   [
    //                             [
    //                                 'name' => 'jsonfield',
    //                                 'contents' => $jsonFile
    //                             ],
    //                             [
    //                                 'name' => 'fotodiri',
    //                                 'contents' => $fotoDiri
    //                             ],
    //                             [
    //                                 'name' => 'fotoktp',
    //                                 'contents' => $fotoKtp
    //                             ],
    //                             [
    //                                 'name' => 'ttd',
    //                                 'contents' => NULL
    //                             ],
    //                             [
    //                                 'name' => 'fotonpwp',
    //                                 'contents' => NULL
    //                             ]  
    //                         ];
    //     $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
    //     $cek = $client->post(config('app.api_digisign').'REG-MITRA.html',[
    //             'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
    //                             'Authorization' => config('app.authorization').' '.config('app.token')
    //                         ],
                
    //             'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
    //             'verify' => false
    //         ]);

    //     $response_API = ['status_all' => $cek->getBody()->getContents()];    

    //     return response()->json($response_API);

    // }


    public function register_akad(){
        
        // $investor_id = 52257;
        $investor_id = Auth::guard('api')->user()->id;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->registerDigiSignInvestor($investor_id);

        return $return_register;

    }

    public function registerRDLInvestor(){
        $investor_id = Auth::guard('api')->user()->id;
        // $investor_id = 52259;
        $kode_bank = '009';

        $RDL = new RDLController;

        $register_investor_rdl = $RDL->RegisterInvestor($investor_id, $kode_bank);

        return $register_investor_rdl;
    }

    public function registerAccountNumberInvestor( Request $request){
        $investor_id = Auth::guard('api')->user()->id;
        $kode_bank = '009';
        $cif_number = '9100749959';

        $RDL = new RDLController;

        $register_investor_account_number = $RDL->RegisterInvestorAccount($investor_id, $request->cif_number, $kode_bank);

        return $register_investor_account_number;
    }

    private function cekFotoDiriExist($userId)
    {
        $link1 = '../storage/app/public/user/'.$userId.'/*pic_investor.jpeg';
        $link2 = '../storage/app/public/user/'.$userId.'/*pic_investor.jpg';
        $link3 = '../storage/app/public/user/'.$userId.'/*pic_investor.bmp';
        $link4 = '../storage/app/public/user/'.$userId.'/*pic_investor.png';
        $link5 = '../storage/app/public/user/'.$userId.'/*pic_investor.JPG';
        $link6 = '../storage/app/public/user/'.$userId.'/*pic_investor.JPEG';

        $file1 = glob($link1);
        $file2 = glob($link2);
        $file3 = glob($link3);
        $file4 = glob($link4);
        $file5 = glob($link5);
        $file6 = glob($link6);

        if (count($file1) != 0)
        {
            $fotoDiriExist = fopen($file1[0], 'r');
        }
        elseif (count($file2) != 0)
        {
            $fotoDiriExist = fopen($file2[0], 'r');
        }
        elseif (count($file3) != 0)
        {
            $fotoDiriExist = fopen($file3[0], 'r');
        }
        elseif (count($file4) != 0)
        {
            $fotoDiriExist = fopen($file4[0], 'r');
        }
        elseif (count($file5) != 0)
        {
            $fotoDiriExist = fopen($file5[0], 'r');
        }
        elseif (count($file6) != 0)
        {
            $fotoDiriExist = fopen($file6[0], 'r');
        }
        else
        {
            $fotoDiriExist = NULL;
        }

        return $fotoDiriExist;
    }

    private function cekFotoKtpExist($userId)
    {
        $link1 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.jpeg';
        $link2 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.jpg';
        $link3 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.bmp';
        $link4 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.png';
        $link5 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.JPG';
        $link6 = '../storage/app/public/user/'.$userId.'/*pic_ktp_investor.JPEG';

        $file1 = glob($link1);
        $file2 = glob($link2);
        $file3 = glob($link3);
        $file4 = glob($link4);
        $file5 = glob($link5);
        $file6 = glob($link6);

        if (count($file1) != 0)
        {
            $fotoKtpExist = fopen($file1[0], 'r');
        }
        elseif (count($file2) != 0)
        {
            $fotoKtpExist = fopen($file2[0], 'r');
        }
        elseif (count($file3) != 0)
        {
            $fotoKtpExist = fopen($file3[0], 'r');
        }
        elseif (count($file4) != 0)
        {
            $fotoKtpExist = fopen($file4[0], 'r');
        }
        elseif (count($file5) != 0)
        {
            $fotoKtpExist = fopen($file5[0], 'r');
        }
        elseif (count($file6) != 0)
        {
            $fotoKtpExist = fopen($file6[0], 'r');
        }
        else
        {
            $fotoKtpExist = NULL;
        }

        return $fotoKtpExist;
    }

    public function callbackRegisterInvestor(Request $req)
    {
        $investor_id = Auth::guard('api')->user()->id;  
        $getDataTableInvestor = CheckUserSign::where('investor_id',$investor_id)
                                    ->where('provider_id',$req->provider_id)
                                    ->first();

        $cekUser = $getDataTableInvestor;

        if ($cekUser === NULL || $req->step == 'register')
        {
            $checkUserSignInvestor = new CheckUserSign;
            $checkUserSignInvestor->investor_id = $investor_id;
            $checkUserSignInvestor->provider_id = $req->provider_id;
            $checkUserSignInvestor->status = $req->status;
            $checkUserSignInvestor->link_aktifasi = $req->url;
            $checkUserSignInvestor->tgl_register = date("Y-m-d");
            $checkUserSignInvestor->tgl_aktifasi = NULL;

            $checkUserSignInvestor->save();

            $response = ['status' => 'Data Berhasil di Update'];
        }
        else
        {

            $response = ['status' => 'Data Gagal di Update'];
        }
        return $response;
    }

    public function actDigiSign(Request $request){
        $email = $request->email;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->aktivasiDigiSign($email);

        return $return_register;
    }

    public function signDigiSign(Request $request){
        $investor_id = Auth::guard('api')->user()->id;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->signDigiSignInvestor($investor_id);

        return $return_register;
    }

    public function signDigiSignInvestorBorrower(Request $request){
        $investor_id = Auth::guard('api')->user()->id;
        $proyek_id = $request->proyek_id;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->signDigiSignMurobahahInvestor($investor_id, $proyek_id);

        return $return_register;
    }

    public function sendDocDigiSignInvestorBorrower(Request $request){
        $investor_id = Auth::guard('api')->user()->id;
        $proyek_id = $request->proyek_id;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->sendDocInvestorBorrower($proyek_id, $investor_id);

        return $return_register;
    }
    
     public function createDocDigiSignInvestorBorrower(Request $request){
        
        // $investor_id = 52257;
        $investor_id = Auth::guard('api')->user()->id;
        $proyek_id = $request->proyek_id;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->createDocInvestorBorrower($investor_id, $proyek_id);

        if($return_register['status'] == 'Gagal'){
            return response()->json(['status' => 'Failed']);
        }else{
            $getDataBorrower    =   BorrowerPendanaan::select('brw_users.brw_id')->leftJoin('brw_users','brw_users.brw_id','=','brw_pendanaan.brw_id')
                                                        ->leftJoin('brw_users_details','brw_users_details.brw_id','=','brw_pendanaan.brw_id')
                                                        ->where('brw_pendanaan.id_proyek',$proyek_id)
                                                        ->first();
            $id_borrower = $getDataBorrower !== null ? $getDataBorrower->brw_id : null;

            $data=[
                'status' => 'Success',
                'id_borrower'=>$id_borrower,
                'investor_id' =>$investor_id
            ];

            return response()->json($data);
        }
    }

    public function sendDigiSignawal(Request $request){
        $investor_id = Auth::guard('api')->user()->id;
        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->sendDigiSignInvestor($investor_id);

        return $return_register;
    }

    public function signDigiSignMurobahah(Request $request){

        $investor_id = Auth::guard('api')->user()->id;
        $id_proyek = $request->id_proyek;

        $digiSign = new DigiSignController;
        
        $return_register = $digiSign->signDigiSignMurobahahInvestor($investor_id, $id_proyek);

        return $return_register;
    }

    public function downloadBase64DigiSignMurobahah(Request $request){

        $getDocId = LogAkadDigiSignInvestor::where('proyek_id',$request->proyek_id)->orderBy('id_log_akad_investor','desc')->first();

        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA64.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];    

        return response()->json($response_API);
    }

    public function downloadDigiSignInvestor(Request $request){
        // $investor_id = 52323;
        $investor_id = Auth::guard('api')->user()->id;

        $getDocId = LogAkadDigiSignInvestor::where('investor_id',$investor_id)->orderBy('id_log_akad_investor','desc')->first();

        $doc_id = $getDocId->document_id;
        
        $client = new Client();
        $data_json = array();
        $data_json = ['JSONFile' => [
                            'userid' => config('app.userid'),  
                            'document_id' => $doc_id,                                
                        ]
                    ];
        $jsonFile = json_encode($data_json);
        $multipart_form = [
                               [
                                   'name' => 'jsonfield',
                                   'contents' => $jsonFile
                               ] 
             
         ];
         $boundary = '----WebKitFormBoundary7MA4YWxkTrZu0gW';
         $cek = $client->post(config('app.api_digisign').'DWMITRA64.html',[
                    'headers' => [  'Content-Type' => 'multipart/form-data; '.config('app.boundary'),
                                    'Authorization' => config('app.authorization').' '.config('app.token')
                                ],     
            
                    'body' => new \GuzzleHttp\Psr7\MultipartStream($multipart_form, $boundary),
                    'verify' => false
                ]);

        $response_API = ['status_all' => $cek->getBody()->getContents()];    

        return response()->json($response_API);

    }

    public function convertBase64(Request $request){
        $b64 = $request->file;
        $bin = base64_decode($b64, true);
    
        if (strpos($bin, '%PDF') !== 0) {
            return response()->json([
                'Failed' => 'File gagal di upload'
            ]);
        }
        $path_user = 'download_akad/'.Auth::guard('api')->user()->id.'akad_investor.'.'pdf';

        $path = Storage::disk('public')->put($path_user, $bin);

        return response()->json([
            'Success' => 'File berhasil di upload'
        ]);
    }

    public function convertBase64Murobahah(Request $request){
        $b64 = $request->file;
        $bin = base64_decode($b64, true);
    
        if (strpos($bin, '%PDF') !== 0) {
            return response()->json([
                'Failed' => 'File gagal di upload'
            ]);
        }
        $path_user = 'download_akad/'.Auth::guard('api')->user()->id.'akad_murobahah_investor.'.'pdf';

        $path = Storage::disk('public')->put($path_user, $bin);

        return response()->json([
            'Success' => 'File berhasil di upload'
        ]);
    }

    public function logAkad(Request $request){
        
        $investor_id = Auth::guard('api')->user()->id;
        $rekening = RekeningInvestor::where('investor_id', $investor_id)
                                    ->first();
        $total_asset = isset($rekening->total_dana) ? $rekening->total_dana: 0;

        $digiSign = new DigiSignController;
        $digiSign->createDocInvestor($investor_id);

        if ($investor_id)
        {
            $logAkadDigiSign = new LogAkadDigiSignInvestor;
            $logAkadDigiSign->investor_id = $investor_id;
            $logAkadDigiSign->provider_id = 0;
            $logAkadDigiSign->total_aset = $total_asset;
            $logAkadDigiSign->document_id = 0;
            $logAkadDigiSign->status = 'complete';
            $logAkadDigiSign->tgl_sign = date("Y-m-d");

            $logAkadDigiSign->save();

            $response = ['status' => '00', 'link' => Storage::url('akad_investor/'.$investor_id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf')];
        }
        else
        {

            $response = ['status' => '01', 'link' => ''];
        }
        return $response;
    }

    public function downloadAkad(Request $request){
        
        $investor_id = Auth::guard('api')->user()->id;
        $rekening = RekeningInvestor::where('investor_id', $investor_id)
                                    ->first();
        $total_asset = isset($rekening->total_dana) ? $rekening->total_dana: 0;

        $digiSign = new DigiSignController;
        $a = $digiSign->createDocInvestor($investor_id);

        if ($a)
        {
            $response = ['status' => '00', 'link' => Storage::url('akad_investor/'.$investor_id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf')];
        }
        else
        {

            $response = ['status' => '01', 'link' => ''];
        }
        return $response;
    }

    public function get_id_log(){
        $investor_id = Auth::guard('api')->user()->id;

        $log = LogAkadDigiSignInvestor::where('investor_id', $investor_id)->orderby('id_log_akad_investor', 'desc')->first();
        $id = $log->id_log_akad_investor;
        $proyek_id = $log->proyek_id;
        return[
            'id_log' => $id,
            'proyek_id' => $proyek_id
        ];

    }

}
