<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $deliveryOrder;
    public $status;

    public function __construct($deliveryOrder, $status)
    {
        $this->deliveryOrder = $deliveryOrder;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject("Your Order Has Been Shipped")
                    ->view('admin.emails.order-shipped');
    }
}