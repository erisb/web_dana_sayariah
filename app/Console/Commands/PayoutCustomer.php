<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\PendanaanAktif;
use App\Proyek;
use App\Jobs\ProcessPayoutMonthly;

class PayoutCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:payout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and pay every pendanaan';

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
        // get every pendanaan that due today
        // $pendanaan = PendanaanAktif::where('status',1)->get();
        // // $backersDue = PendanaanAktif::whereDate('last_pay','<=',$day->subMonth(1))->whereDate('last_pay','!=',$day)->get();
        // foreach($pendanaan as $row){
        //     // add job to queue
        //     if($row->proyek->interval == 1){
        //         ProcessPayoutMonthly::dispatch($row);
        //     }
            
        // }

        // // Get pendanaan that get pay only at the end of proyek
        // $pendanaan = PendanaanAktif::where('pay_interval',0)->where('status',1)->get();
        // foreach($pendanaan as $row){
        //     OneTimePayout::dispatch($row);
        // }


        // $this->info('Payout processing success');
    }
}
