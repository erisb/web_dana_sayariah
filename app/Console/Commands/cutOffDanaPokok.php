<?php

namespace App\Console\Commands;
use Illuminate\Http\Request;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\DetilImbalUser;
use App\ListImbalUser;
use App\Log_Imbal_User;
use App\Proyek;
use App\RekeningInvestor;

class cutOffDanaPokok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:cutOffDanaPokok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'proses cutOffDanaPokok';

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
       $dateCutOff = date("Y-m-d");
    
        // $dateCutOff = '2020-09-12';
       $projekEnd = Proyek::where('tgl_selesai', $dateCutOff)->get(); 

       $jmlProjekEnd = count($projekEnd);
       if($jmlProjekEnd > 0){
        $tgl_payout = array();
            // get id proyek
        for($e=0;$e<$jmlProjekEnd;$e++){
            $projekList = ListImbalUser::where('proyek_id',$projekEnd[$e]->id)->orderBy('id', 'DESC')->first();
            $tgl_payout[] = $projekList->tanggal_payout;
        }
        
        $flag = array();
        for($i=0;$i<count($tgl_payout);$i++){
            $daftar = DB::select("select * from list_imbal_user where tanggal_payout = '".$tgl_payout[$i]."' AND proyek_id = ".$projekEnd[$i]->id);
            foreach ($daftar as $key => $value) {
                if($value->imbal_payout == $value->total_dana){
                    // 4 dana disimpan
                    ListImbalUser::where('id', $value->id)->update(['status_payout' => 4]);
                    $flag[$i] = 'dp';
                    
                    $addrek = RekeningInvestor::where('investor_id',$value->investor_id)->get();
                        for($a=0;$a < sizeof($addrek);$a++)
                        {
                            $addrek[$a]->unallocated += $value->imbal_payout;
                            $addrek[$a]->save();
                        }
                }else{
                    // 2 dana ditransfer
                    ListImbalUser::where('id', $value->id)->update(['status_payout' => 2]);
                    $flag[$i] = 'sih';
                }
                #cek anti dobel id_listimbaluser
                $ceeek = Log_Imbal_User::where('id_listimbaluser',$value->id)->get();
                #insertlogimbaluser
                $log_imbal =  New Log_Imbal_User; 
                if(count($ceeek) == 0){
                    //  echo $i."uhuy";
                    $log_imbal->investor_id = $value->investor_id;
                    $log_imbal->proyek_id = $value->proyek_id;
                    $log_imbal->pendanaan_id = $value->pendanaan_id;
                    $log_imbal->nominal = $value->imbal_payout;
                    $log_imbal->id_listimbaluser = $value->id;
                    if($flag[$i] == 'sih'){
                        $log_imbal->keterangan = 'imbal_hasil_sisa';
                    }elseif($flag[$i] == 'dp'){
                        $log_imbal->keterangan = 'dana_pokok';
                    }else{
                        $log_imbal->keterangan = 'imbal_hasil';
                    }
                    $log_imbal->save();

                }else{
                    //  echo $value->id."indah";
                }
            }
        }
        #modultest
        echo count($daftar);
        echo "bismillah sukses";
       }else{
           echo "kosong";
       }
    }
}
