<?php

namespace App\Listeners;

use App\Events\UserMonthlyPayEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMontyhlyPayListener
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
     * @param  UserMonthlyPayEvent  $event
     * @return void
     */
    public function handle(UserMonthlyPayEvent $event)
    {
        //Send Email to user

        // Add log to log pendanaan
        $event->pendanaan->logPendanaan()->create([
            'nominal' => $event->amount,
            'tipe' => $event->tipe,
        ]);

    }
}
