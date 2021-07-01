<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminAddPendanaanEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $pendanaan, $rekening, $user;
    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.admin_pendanaan')->with('pendanaan', $this->pendanaan)->with('rekening', $this->rekening)->with('user', $this->user);
    }
}
