<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PendanaanAktif;
use App\Events\UserMonthlyPayEvent;
use App\PenarikanDana;
use App\Events\MutasiInvestorEvent;
use Carbon\Carbon;
use App\Subscribe;
use App\Jobs\DepositEmail;
use App\Investor;

class ProcessPayoutMonthly implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PendanaanAktif $pendanaan)
    {
        //
        $this->data = $pendanaan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //handle the job
        // $pendanaan = $this->data;
        // $day = Carbon::today('Asia/Jakarta');
        
        // // get the profit margin
        // $percentage = $pendanaan->proyek->profit_margin;
        // $monthPercentage = ($percentage-3)/12;
        // $dayPercentage = $monthPercentage/30;
        // $proyekLength = $pendanaan->proyek->tgl_mulai->diffInMonths($pendanaan->proyek->tgl_selesai);
        // $user = $pendanaan->investor;

        // if($pendanaan->last_pay == Null){
        //     // for the first payout, give some extra according to how long he put the money before the project start
        //     $excessDay = $pendanaan->tanggal_invest->diffInDays($day);
        //     $extra_cash = $dayPercentage/100 * $excessDay * $pendanaan->nominal_awal;
        //     $payout = $pendanaan->nominal_awal * $monthPercentage/100;
        //     $pendanaan->total_dana += $payout + $extra_cash;
        //     $pendanaan->last_pay = $day;
        //     $pendanaan->save();

        //     $payout = $payout + $extra_cash;
        // }
        // else{
        //     if($day->diffInMonths($pendanaan->proyek->tgl_mulai) < 12){
        //         $payout = $pendanaan->nominal_awal * $monthPercentage/100;
        //         $pendanaan->total_dana += $payout;
        //         $pendanaan->last_pay = $day;
        //         $pendanaan->save();    
        //     }
        //     else{
        //         $payout = $pendanaan->nominal_awal * 3 /100 * $proyekLength /12;
        //         // Add payout to total_pendanaan
        //         $pendanaan->total_dana += $payout;
        //         $pendanaan->last_pay = $day;
        //         $pendanaan->status = 0;
        //         $pendanaan->save(); 
        //         // move the cash to the unallocated slot
        //         $pendanaan->investor->rekeningInvestor->unallocated += $pendanaan->nominal_awal;
        //         $pendanaan->investor->rekeningInvestor->save();    
        //     }
        // }

        // // add cash to rekening
        // $rekening = $this->addToRekening($user,$payout);

        // event(new UserMonthlyPayEvent($pendanaan,$payout,'Monthly payout'));    

        // PenarikanDana::create([
        //     'investor_id' => $user->id,
        //     'jumlah' => $total_payout,
        //     'no_rekening' => $user->detilInvestor->rekening,
        //     'bank' => $user->detilInvestor->bank,
        //     'perihal' => 'AUTOMATED PAYOUT'
        // ]);

        // // check if investor is subscribing on monthly penarikan for this particular pendanaan
        // $subscribe = Subscribe::where('investor_id',$user->id)->where('pendanaanAktif_id',$pendanaan->id)->first();
        // if($subscribe && $subscribe->last_pay->diffInMonths($day) == $subscribe->interval_pay){
        //     $total_payout = $payout * $subscribe->interval_pay;
        //     // check if the cash is still available 
        //     if($total_payout < $rekening->unallocated){
        //         // create penarikan
        //         PenarikanDana::create([
        //             'investor_id' => $user->id,
        //             'jumlah' => $total_payout,
        //             'no_rekening' => $subscribe->rekening,
        //             'bank' => $subscribe->BANK,
        //         ]);
        //         // reduce the cash in rekening
        //         $rekening->unallocated -= $total_payout;
        //         $rekening->total_dana -= $total_payout;
        //         $rekening->save();

        //         // call mutation event to log the cash flow
        //         event(new MutasiInvestorEvent($user->id,'DEBIT',$total_payout,'Penarikan dana bagi hasil'));
                
        //         $subscribe->last_pay = Carbon::today();
        //         $subscribe->save();
        //         if($pendanaan->status == 0){
        //             $subscribe->delete();
        //         }
        //     }
        //     else{
        //         // Email the user about the problem
        //     }
        // }
        // log incoming cash
    }
    private function addToRekening($user,$payout){
        $rekening = $user->rekeningInvestor;
        $rekening->unallocated += $payout;
        $rekening->total_dana += $payout;
        $rekening->save(); 
        event(new MutasiInvestorEvent($user->id,'CREDIT',$payout,'Monthly payout'));
        
        return $rekening;
    }
}
