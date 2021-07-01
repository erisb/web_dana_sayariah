<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\EmailAktifasiPenerimaPendanaan;
use App\Mail\AdminVerification;
use App\Admins;

class ProcessEmailBorrower implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data, $email, $email_verif, $code;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($username, $email, $email_verif, $code)
    {
        $this->data = $username;
        $this->email = $email;
        $this->email_verif = $email_verif;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->code == 'regis') {
            $email = new EmailAktifasiPenerimaPendanaan($this->data, $this->email, $this->email_verif);
            Mail::to($this->email)->send($email);
        }
        // else {
        //     $email = new AdminVerification($this->data);
        //     $admin = Admins::whereIn('id',[4,5,7]);
        //     foreach ($admin as $item) {
        //         Mail::to($item->email)->send($email);
        //     }
        // }
    }
}
