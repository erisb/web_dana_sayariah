<?php

namespace App\Http\Middleware;

use Closure;
use App\Investor;
use Auth;
use App\Http\Controllers\UserController;
use App\MasterProvinsi;
use App\MasterAgama;
use App\MasterAsset;
use App\MasterBadanHukum;
use App\MasterBank;
use App\MasterBidangPekerjaan;
use App\MasterJenisKelamin;
use App\MasterJenisPengguna;
use App\MasterKawin;
use App\MasterKepemilikanRumah;
use App\MasterNegara;
use App\MasterOnline;
use App\MasterPekerjaan;
use App\MasterPendapatan;
use App\MasterPendidikan;
use App\MasterPengalamanKerja;
use App\DetilInvestor;

class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user())
        {
            $user = Auth::user();
            if($user->email_verif){
                
                return redirect('/user/userverification')->with('confirmationemail', true);
            }
            // if ($user->status == 'notfilled'){
            else if ($user->status == 'notfilled'){
                $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
                // $master_agama = MasterAgama::all();
                // $master_asset = MasterAsset::all();
                // $master_badan_hukum = MasterBadanHukum::all();
                $master_bank = MasterBank::all();
                // $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
                $master_jenis_kelamin = MasterJenisKelamin::all();
                // $master_jenis_pengguna = MasterJenisPengguna::all();
                 $master_kawin = MasterKawin::all();
                // $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
                // $master_negara = MasterNegara::all();
                // $master_online = MasterOnline::all();
                $master_pekerjaan = MasterPekerjaan::all();
                $master_pendapatan = MasterPendapatan::all();
                $master_pendidikan = MasterPendidikan::all();
                // $master_pengalaman_kerja = MasterPengalamanKerja::all();
                return redirect('/user/userverification')->with([
                        'dataverification' => true,
                        'master_provinsi' => $master_provinsi,
                        // 'master_agama' => $master_agama,
                        // 'master_asset' => $master_asset,
                        // 'master_badan_hukum' => $master_badan_hukum,
                        'master_bank' => $master_bank,
                        // 'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
                        'master_jenis_kelamin' => $master_jenis_kelamin,
                        // 'master_jenis_pengguna' => $master_jenis_pengguna,
                         'master_kawin' => $master_kawin,
                        // 'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
                        // 'master_negara' => $master_negara,
                        // 'master_online' => $master_online,
                         'master_pekerjaan' => $master_pekerjaan,
                         'master_pendapatan' => $master_pendapatan,
                         'master_pendidikan' => $master_pendidikan,
                        // 'master_pengalaman_kerja' => $master_pengalaman_kerja,

                    ]);
            }

            else if ($user->status == 'reject'){
                $detil=DetilInvestor::leftJoin('investor','investor.id','=','detil_investor.investor_id')
                            ->where('detil_investor.investor_id', $user->id)
                            ->first();
                $master_provinsi = MasterProvinsi::distinct('kode_provinsi','nama_provinsi')->get(['kode_provinsi','nama_provinsi']);
                // $master_agama = MasterAgama::all();
                // $master_asset = MasterAsset::all();
                // $master_badan_hukum = MasterBadanHukum::all();
                $master_bank = MasterBank::all();
                // $master_bidang_pekerjaan = MasterBidangPekerjaan::all();
                $master_jenis_kelamin = MasterJenisKelamin::all();
                // $master_jenis_pengguna = MasterJenisPengguna::all();
                // $master_kawin = MasterKawin::all();
                // $master_kepemilikan_rumah = MasterKepemilikanRumah::all();
                // $master_negara = MasterNegara::all();
                // $master_online = MasterOnline::all();
                // $master_pekerjaan = MasterPekerjaan::all();
                // $master_pendapatan = MasterPendapatan::all();
                // $master_pendidikan = MasterPendidikan::all();
                // $master_pengalaman_kerja = MasterPengalamanKerja::all();
                $data_tgl = !empty($detil->tgl_lahir_investor) ? explode("-",$detil->tgl_lahir_investor) : '';
                $data_thn = $data_tgl[2];

                return redirect('/user/userverification')->with([
                                                            'datareject' => true,
                                                            'detil' => $detil,
                                                            'master_provinsi' => $master_provinsi,
                                                            // 'master_agama' => $master_agama,
                                                            // 'master_asset' => $master_asset,
                                                            // 'master_badan_hukum' => $master_badan_hukum,
                                                            'master_bank' => $master_bank,
                                                            // 'master_bidang_pekerjaan' => $master_bidang_pekerjaan,
                                                            'master_jenis_kelamin' => $master_jenis_kelamin,
                                                            // 'master_jenis_pengguna' => $master_jenis_pengguna,
                                                            // 'master_kawin' => $master_kawin,
                                                            // 'master_kepemilikan_rumah' => $master_kepemilikan_rumah,
                                                            // 'master_negara' => $master_negara,
                                                            // 'master_online' => $master_online,
                                                            // 'master_pekerjaan' => $master_pekerjaan,
                                                            // 'master_pendapatan' => $master_pendapatan,
                                                            // 'master_pendidikan' => $master_pendidikan,
                                                            // 'master_pengalaman_kerja' => $master_pengalaman_kerja,
                                                            'data_thn' => $data_thn
                                                        ]);
            }

            else if($user->status == 'pending'){
                return redirect('/user/userverification')->with('waitinglist', true);
            } 

            else if($user->status == 'suspend'){
                return redirect('/user/userverification')->with('suspend', true);
            }
        }
        
        elseif(Auth::guard('borrower')->check()){
            $borrower = Auth::guard('borrower')->user();
            if ($borrower->status == 'notfilled'){
                return redirect('borrower/lengkapi_profile');
            }

            else if ($borrower->status == 'reject'){
                return redirect('borrower/status_reject');
            }

            else if($borrower->status == 'pending'){
                return redirect('borrower/status_pending');
            } 

            else if($borrower->status == 'suspend'){
                return redirect('/#loginModal');
            }
            else if($borrower->status == 'active'){
                return redirect('borrower/dashboardPendanaan');
            }
        }
        
        
        else
        {
            return redirect('/#loginModal');
        }
        
        return $next($request);
    }
}
