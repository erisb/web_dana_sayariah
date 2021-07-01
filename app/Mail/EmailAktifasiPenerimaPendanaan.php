<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailAktifasiPenerimaPendanaan extends Mailable
{
    use Queueable, SerializesModels;
    protected $user, $email, $email_verif;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $email, $email_verif)
    {
        $this->user = $user;
        $this->email = $email;
        $this->email_verif = $email_verif;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = array(
            'username'=>$this->user,
            'email'=>$this->email,
            'email_verif'=>$this->email_verif
        );
        return $this->view('email.email_confirm_borrower')->with('data', $data);
    }
}
