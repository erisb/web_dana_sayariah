<?php

namespace App\Console\Commands;
use Illuminate\Http\Request;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\DetilImbalUser;
use App\ListImbalUser;
use App\Log_Imbal_User;

class cutOffImbalHasil extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:cutOffImbalHasil';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'proses cutOffimbalhasil';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateCutOff = date("Y-m-d",strtotime("+1 day"));
        #testdata
        // $dateCutOff = '2019-10-14';
        $jmlproyek = ListImbalUser::distinct()->where('tanggal_payout',$dateCutOff)->where('status_payout', 5)->get(['proyek_id']);
        #periksa by proyek
        for($n=0;$n<count($jmlproyek);$n++){
            $id_proyek = $jmlproyek[$n]->proyek_id;
            #periksa apakah tanggal cutoff pertama?
            $cekprop = ListImbalUser::distinct()->where('proyek_id',$id_proyek)->get(['tanggal_payout']);
                #tanggal proporsional setiap proyek
                $tglprop = $cekprop[0]->tanggal_payout;
            $user = ListImbalUser::where('proyek_id', $id_proyek)->where('tanggal_payout',$dateCutOff)->get();
            
            // var_dump($user[0]);die();
            
            if($dateCutOff == $tglprop){
                // echo $id_proyek." pembagian proporsional<br>";
                #update listimbaluser by user
                for($s=0;$s<count($user);$s++){
                    $user[$s]->status_payout = 2 ;
                    $user[$s]->keterangan = '';
                    $user[$s]->status_libur = 0;
                    $user[$s]->keterangan_libur = '';
                    $user[$s]->update();
                #insertlogimbaluser
                   $nominal = DetilImbalUser::where('pendanaan_id', $user[$s]->pendanaan_id)->first();
                   $ceek = Log_Imbal_User::where('id_listimbaluser',$user[$s]->id)->get();
                //    echo $nominal->pendanaan_id.'-'.$nominal->proposional."#";
                   $log_imbal =  New Log_Imbal_User;
                   if(count($ceek)==0){
                    $log_imbal->investor_id = $user[$s]->investor_id;
                    $log_imbal->proyek_id = $user[$s]->proyek_id;
                    $log_imbal->pendanaan_id = $user[$s]->pendanaan_id;
                    $log_imbal->nominal = $nominal->proposional + $user[$s]->imbal_payout;
                    $log_imbal->id_listimbaluser = $user[$s]->id;
                    $log_imbal->keterangan = 'imbal_hasil + proposional';
                    $log_imbal->save();
                   }
                }
            }else{
                // var_dump($user);
                #insertlistimbaluser
                $flag = array();
                for($s=0;$s<count($user);$s++){
                    $nominal = DetilImbalUser::where('pendanaan_id', $user[$s]->pendanaan_id)->first();
                    #cek apakah dana pokok atau sisa imbal hasil
                    if($user[$s]->imbal_payout == $nominal->sisa_imbal){
                        $user[$s]->status_payout = 2 ;
                        $user[$s]->keterangan = '';
                        $user[$s]->status_libur = 0;
                        $user[$s]->keterangan_libur = '';
                        $user[$s]->update();

                        $flag[$s] = 'sih';
                    }elseif($user[$s]->imbal_payout == $nominal->total_dana){
                        $user[$s]->status_payout = 4 ;
                        $user[$s]->keterangan = '';
                        $user[$s]->status_libur = 0;
                        $user[$s]->keterangan_libur = '';
                        $user[$s]->update();

                        $flag[$s] = 'dp';
                    }else{
                        $user[$s]->status_payout = 2 ;
                        $user[$s]->keterangan = '';
                        $user[$s]->status_libur = 0;
                        $user[$s]->keterangan_libur = '';
                        $user[$s]->update();

                        $flag[$s] = 'non';
                    }
                   #cek anti dobel id_listimbaluser
                    $ceeek = Log_Imbal_User::where('id_listimbaluser',$user[$s]->id)->get();
                   #insertlogimbaluser
                   $log_imbal =  New Log_Imbal_User; 
                    if(count($ceeek) == 0){
                        $log_imbal->investor_id = $user[$s]->investor_id;
                        $log_imbal->proyek_id = $user[$s]->proyek_id;
                        $log_imbal->pendanaan_id = $user[$s]->pendanaan_id;
                        $log_imbal->nominal =$user[$s]->imbal_payout;
                        $log_imbal->id_listimbaluser = $user[$s]->id;
                        if($flag[$s] == 'sih'){
                            $log_imbal->keterangan = 'imbal_hasil_sisa';
                        }elseif($flag[$s] == 'dp'){
                            $log_imbal->keterangan = 'dana_pokok';
                        }else{
                            $log_imbal->keterangan = 'imbal_hasil';
                        }
                        $log_imbal->save();
                    }
                }
                // echo count($user);
                // echo $id_proyek."imbal hasil biasa<br>";
            }       
            
        }

        #kodelamakatanyapenyebabdoublerecordbutithinkisnot
        // $pay = ListImbalUser::where('tanggal_payout',$dateCutOff)->where('status_payout', 5)->get();
        // if(count($pay) > 0){
        //     for($x=0; $x < sizeof($pay);$x++)
        //     {
        //         // update status listimbaluser menjadi transfered
        //         $pay[$x]->status_payout = 2 ;
        //         $pay[$x]->keterangan = '';
        //         $pay[$x]->status_libur = 0;
        //         $pay[$x]->keterangan_libur = '';
        //         $pay[$x]->update();

        //         // pengecekan bulan pertama
        //         $cekprop = ListImbalUser::distinct()
        //                                 ->where('proyek_id',$pay[$x]->proyek_id)
        //                                 ->get(['tanggal_payout'])->first();
        //         if($cekprop->tanggal_payout == $dateCutOff){
        //             $nominal = DB::table('detil_imbal_user')
        //                 ->where('pendanaan_id', $pay[$x]->pendanaan_id)
        //                 ->where('proyek_id', $pay[$x]->proyek_id)
        //                 ->first();
        //             DB::table('log_imbal_user')->insert([
        //                     'investor_id' => $pay[$x]->investor_id,
        //                     'proyek_id' => $pay[$x]->proyek_id,
        //                     'pendanaan_id' => $pay[$x]->pendanaan_id,
        //                     'nominal' => $nominal->proposional + $pay[$x]->imbal_payout,
        //                     'id_listimbaluser' => $pay[$x]->id,
        //                     'keterangan' => 'imbal_hasil + proposional'
        //             ]);
        //         }else{
        //             DB::table('log_imbal_user')->insert([
        //                     'investor_id' => $pay[$x]->investor_id,
        //                     'proyek_id' => $pay[$x]->proyek_id,
        //                     'pendanaan_id' => $pay[$x]->pendanaan_id,
        //                     'nominal' => $pay[$x]->imbal_payout,
        //                     'id_listimbaluser' => $pay[$x]->id,
        //                     'keterangan' => 'imbal_hasil'
        //             ]);
        //         }
        //     }
        // }
            #endofkodelamakatanyapenyebabdoublerecordbutithinkisnot
    }
}
