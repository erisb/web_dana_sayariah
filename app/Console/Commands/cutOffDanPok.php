<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class cutOffDanPok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cut-Off-Dana-Pokok-dan-Imbal-Hasil:cutOffImbalHasil';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cut-Off-Dana-Pokok-dan-Imbal-Hasil';

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
        echo "ini dia gan";
    }
}
