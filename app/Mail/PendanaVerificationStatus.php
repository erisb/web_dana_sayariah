<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PendanaVerificationStatus extends Mailable
{
    use Queueable, SerializesModels;
    protected $data, $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $code)
    {
        $this->data = $data;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->code){
            return $this->view('email.verif_ok')->with('data', $this->data);
        }
        else {
            return $this->view('email.verif_fail')->with('data', $this->data);
        }
        
    }
}
