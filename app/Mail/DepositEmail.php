<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DepositEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $amount, $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($amount, $user)
    {
        $this->amount = $amount;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.email_deposit')->with('amount', $this->amount)->with('user', $this->user);
    }
}
