<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Proyek;
use App\Jobs\OneTimePayout;

class CheckProyek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:proyek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check every proyek start date';

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
        //
        $day = Carbon::today('Asia/Jakarta');
        $allProyek = Proyek::where('status',1)->whereDate('tgl_selesai',$day)->get();
        foreach($allProyek as $proyek){
            $proyek->status = 0;
            $proyek->save();
            if($proyek->interval == 0){
                OneTimePayout::dispatch($proyek);
            }
        }
    }
}
