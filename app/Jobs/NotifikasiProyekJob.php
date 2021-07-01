<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\NotifikasiProyekEmail;
use Mail;
use App\Admins;

class NotifikasiProyekJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->data = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $email = new NotifikasiProyekEmail();
            $dataEmail = Admins::all();

            foreach($dataEmail as $emails)
            {
                Mail::to($emails->email)->send($email);
            }
    }
}