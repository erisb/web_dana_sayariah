<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\NewsletterEmail;

class BroadcastEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data, $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new NewsletterEmail($this->data);

        Mail::to($this->user->email)->send($email);
    }
}
