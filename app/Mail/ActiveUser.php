<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActiveUser extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $hash;
    private $otp;
    private $title;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $hash, $otp)
    {
        $this->name       = $name;
        $this->hash         = $hash;
        $this->otp          =    $otp;
    }

    public function build()
    {
        return $this->subject('Active User!')->view('mail.active_user', ['name' => $this->name, 'hash' => $this->hash, 'otp' => $this->otp]);
    }
}
