<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;

    public function __construct($order, $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->subject('Order Confirmation #' . $this->order->id)
                    ->view('admin.emails.order-confirmation');
    }
}