<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\PendanaVerificationStatus;
use Mail;

class InvestorVerif implements ShouldQueue
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
            $email = new PendanaVerificationStatus($this->data, $this->code);

            Mail::to($this->data->email)->send($email);
    }
}
