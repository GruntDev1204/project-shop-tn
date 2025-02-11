<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $token;
    private $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $token, $otp)
    {
        $this->email       = $email;
        $this->token         = $token;
        $this->otp      = $otp;
    }

    public function build()
    {
        return $this->subject("request forgot password!")->view('mail.reset_password', ['email' => $this->email, 'token' => $this->token , 'otp' => $this->otp]);
    }
}
