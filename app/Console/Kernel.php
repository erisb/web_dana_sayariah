<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\cutOffImbalHasil',
        'App\Console\Commands\cutOffDanaPokok'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('console:payout')->timezone('Asia/Jakarta')->monthlyOn(1,'00:01');
        // $schedule->command('console:proyek')->timezone('Asia/Jakarta')->dailyAt('00:01');
        $schedule->command('console:backupdb')->timezone('Asia/Jakarta')->twiceDaily(6,18);
        $schedule->command('console:cutOffImbalHasil')->timezone('Asia/Jakarta')->dailyAt('15:00');
        // $schedule->command('console:cutOffDanaPokok')->dailyAt('11:15');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
