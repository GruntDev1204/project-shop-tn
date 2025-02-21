<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestLogin2FA extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $token;
    private $expired;
    private $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $expired , $otp)
    {
        $this->name       = $name;
        $this->expired         = $expired;
        $this->otp      = $otp;
    }

    public function build()
    {
        return $this->subject("Request to login!")->view('mail.request_login', ['name' => $this->name, 'otp' => $this->otp  , 'expired' => $this->expired]);
    }
}
