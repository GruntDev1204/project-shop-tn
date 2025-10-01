<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotifi extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    private $orderCode;
    private $name;
    private $total;
    private $expired;


    /**
     * Create a new message instance.
     */
    public function __construct($orderCode, $name, $total, $expired)
    {
        $this->orderCode       = $orderCode;
        $this->name         = $name;
        $this->total          =    $total;
        $this->expired          =    $expired;
    }

    public function build()
    {
        return $this->subject('#Your new order : ' . $this->orderCode . '')->view('mail.order', ['name' => $this->name, 'total' => $this->total, 'orderCode' => $this->orderCode, 'expired' => $this->expired]);
    }
}
