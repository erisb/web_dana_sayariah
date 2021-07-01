<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\PendanaanAktif;
use App\Proyek;
use App\BorrowerPendaan;
use App\BorrowerUsers;
use App\BorrowerDetails;

class AFPIUpload extends Command
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
        
    }
}
