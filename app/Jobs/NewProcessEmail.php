<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\EmailAktifasi;
use App\Mail\AdminVerification;
use App\Admins;

class NewProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data, $code;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $code)
    {
        $this->data = $user;
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
            $email = new EmailAktifasi($this->data);
            Mail::to($this->data->email)->send($email);
        }
        // else {
        //     $email = new AdminAktifasi($this->data);
        //     $admin = Admins::whereIn('id',[4,5,7]);
        //     foreach ($admin as $item) {
        //         Mail::to($item->email)->send($email);
        //     }
        // }
    }
}
