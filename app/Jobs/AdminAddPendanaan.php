<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\AdminAddPendanaanEmail;

class AdminAddPendanaan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $pendanaan, $rekening, $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pendanaan, $rekening, $user)
    {
        $this->pendanaan = $pendanaan;
        $this->rekening = $rekening;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new AdminAddPendanaanEmail($this->pendanaan, $this->rekening, $this->user);
        
        Mail::to($this->user->email)->send($email);
    }
}
