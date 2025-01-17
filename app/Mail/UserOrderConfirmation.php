<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserOrderConfirmation extends Mailable
{
   public $orderNumber;
    public $user;

    public function __construct($orderNumber, $user)
    {
        $this->orderNumber = $orderNumber;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Thank You for Your Order!')
                    ->view('frontend.emails.user_order_confirmation')
                    ->with([
                        'orderNumber' => $this->orderNumber,
                        'user' => $this->user
                    ]);
    }
}
