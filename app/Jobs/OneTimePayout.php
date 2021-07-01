<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PendanaanAktif;


class OneTimePayout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Proyek $proyek)
    {
        //
        $this->data = $proyek;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $proyek = $this->data;
        $day = Carbon::today('Asia/Jakarta');

        $proyekLength = $proyek->tgl_mulai->diffInMonths($proyek->tgl_selesai);
        $pendanaan = PendanaanAktif::where('proyek_id', $proyek->id)->get();

        foreach ($pendanaan as $row) {
            # code...

            $percentage = $proyek->profit_margin;
            $monthlyPercen = ($percentage - 3)/12;
            $dayPercentage = $monthlyPercen /30;
            $bonusPercent = 3 * $proyekLength /12;

            // get the excesss day
            $excessDay = $pendanaan->tanggal_invest->diffInDays($proyek->tgl_mulai);
            $extra_cash = $dayPercentage/100 * $excessDay * $pendanaan->nominal_awal;

            // get full pay amount
            $payout = $pendanaan->nominal_awal * $monthlyPercen/100 * $proyekLength;

            // get the bonus pay amount
            $bonus = $pendanaan->nominal_awal * $bonusPercent;

            // add all the cash to user
            $totalPayout = $payout + $bonus + $extra_cash;
            $pendanaan->total_dana += $totalPayout;
            $pendanaan->last_pay = $day;
            $pendanaan->status = 0;
            $pendanaan->save();
            $pendanaan->investor->rekeningInvestor->unallocated += $pendanaan->nominal_awal;
            $pendanaan->investor->rekeningInvestor->save();

            // add cash to rekening
            $rekening = $this->addToRekening($pendanaan->investor,$payout);

            event(new UserMonthlyPayEvent($pendanaan,$payout,'Monthly payout'));

        }
    }


    private function addToRekening($user,$payout){
        $rekening = $user->rekeningInvestor;
        $rekening->unallocated += $payout;
        $rekening->total_dana += $payout;
        $rekening->save();
        event(new MutasiInvestorEvent($user->id,'CREDIT',$payout,'Monthly payout'));

        $user = Investor::find($user->id);
        dispatch(new DepositEmail($payout, 'PAYOUT_MONTHLY', $user, $this->data));
        return $rekening;
    }
}
