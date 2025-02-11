<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $token;
    private $expired;
    private $created;
    private $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $created  , $expired , $token, $otp)
    {
        $this->name       = $name;
        $this->token         = $token;
        $this->expired         = $expired;
        $this->created         = $created;
        $this->otp      = $otp;
    }

    public function build()
    {
        return $this->subject("Request to reset password!")->view('mail.reset_password', ['name' => $this->name, 'token' => $this->token , 'otp' => $this->otp  , 'expired' => $this->expired , 'created' => $this->created]);
    }
}
