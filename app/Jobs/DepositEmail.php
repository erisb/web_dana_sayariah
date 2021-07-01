<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\PayoutEmail;
use App\Mail\DepositEmail as DepositMail;

class DepositEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $amount, $perihal, $pendanaan, $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($amount, $perihal, $user, $pendanaan = null)
    {
        $this->amount = $amount;
        $this->perihal = $perihal;
        $this->pendanaan = $pendanaan;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->perihal == 'DEPOSIT'){
            $email = new DepositMail($this->amount, $this->user);
        }
        else {
            $email = new PayoutEmail($this->amount, $this->user, $this->pendanaan);
        }

        Mail::to($this->user->email)->send($email);
        
    }
}
