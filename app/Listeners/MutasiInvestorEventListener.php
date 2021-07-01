<?php

namespace App\Listeners;

use App\Events\MutasiInvestorEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\MutasiInvestor;
use App\RekeningInvestor;
use App\Investor;
use App\Jobs\DepositEmail;


class MutasiInvestorEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MutasiInvestorEvent  $event
     * @return void
     */
    public function handle(MutasiInvestorEvent $event)
    {

        //Create new Mutasi on investor account
        $mutasi = new MutasiInvestor();
        $mutasi->investor_id = $event->user_id;
        $mutasi->nominal = $event->nominal;
        $mutasi->perihal = $event->perihal;
        $mutasi->tipe = $event->type;
        $mutasi->save();

        $user = Investor::find($event->user_id);

        if ($event->perihal == 'Transfer Rekening') {
            dispatch(new DepositEmail($event->nominal, 'DEPOSIT', $user));
        }
        if ($event->perihal == 'Monthly payout') {
            dispatch(new DepositEmail($event->nominal, 'PAYOUT_MONTHLY', $user));
        }
    }
}
