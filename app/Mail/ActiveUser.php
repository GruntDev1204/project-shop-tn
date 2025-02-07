<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActiveUser extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $hash;
    private $title;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $hash, $title)
    {
        $this->name       = $name;
        $this->hash         = $hash;
        $this->title      = $title;
    }

    public function build()
    {
        return $this->subject($this->title)->view('mail.active_user', ['name' => $this->name, 'hash' => $this->hash]);
    }
}
