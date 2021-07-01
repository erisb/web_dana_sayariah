<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetilInvestor;
use App\PendanaanAktif;
use App\RekeningInvestor;
use App\Investor;
use App\News;
use Auth;
use Hash;
use Storage;
use Illuminate\Support\Facades\DB;
use Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['checkToken']]);
    }

    public function home(){
        $pendanaan = PendanaanAktif::where('investor_id', Auth::guard('api')->user()->id)->where('status', 1)->get();
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
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
        

        $i=0;
        if (!isset($pendanaan[0])) {
            $danaku = null;
            $bagi_hasil = 0;
        }
        else {
            foreach ($pendanaan as $item) {
                $danaku[$i] = [
                    'id'=>$item->id,
                    'nama' => $item->proyek->nama,
                    'gambar' => '/storage/'.$item->proyek->gambar_utama
                ];
                $i++;
            }
            $bagi_hasil = $pendanaan->sum('total_dana')-$pendanaan->sum('nominal_awal');
        }
        
        return [
            'rekening' => [
                'total_aset' => $rekening->total_dana,
                'dana_tersedia' => $rekening->unallocated,
                'bagi_hasil' => $bagi_hasil,
                'total_pendanaan' => $pendanaan->sum('total_dana')
            ],
            'pendanaan' => $danaku,
            'news' => $newest,
        ];
    }

    public function mainProfile(){
        $investor = Investor::where('id', Auth::guard('api')->user()->id)->first();
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        return [
            'nama' => $detil->nama_investor,
            'email' => $investor->email,
            'gambar' => '/storage/'.$detil->pic_investor,
        ];
    }

    public function showVa(){
        $rekening = RekeningInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        $va= $rekening->va_number;

        return [
            'va' => $va,
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
        $detail = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();
        return [
            'nama' => $detail->nama_investor,
            'nohp' => $detail->phone_investor,
            'rekening' => $detail->rekening,
            'bank' => $detail->bank,
            'alamat' => $detail->alamat_investor
        ];
    }

    public function updateProfile(Request $request) {
        $detil = DetilInvestor::where('investor_id', Auth::guard('api')->user()->id)->first();

        $detil->nama_investor = $request->nama_investor;
        // $detil->no_ktp_investor = $request->no_ktp_investor;
        // $detil->pasangan_investor = $request->pasangan_investor;
        // $detil->pasangan_phone = $request->pasangan_phone;
        // $detil->job_investor = $request->job_investor;
        $detil->alamat_investor = $request->alamat_investor;
        // if ($request->hasFile('pic_investor')) {
        //     Storage::disk('public')->delete($detil->pic_investor);
        //     $detil->pic_investor = $this->upload('pic_investor', $request, $detil->investor_id );
        // }
        $detil->rekening = $request->rekening;
        $detil->bank = $request->bank;
        // $detil->no_npwp_investor = $request->no_npwp_investor;
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

}
