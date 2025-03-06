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
    public $billingAddress;
    public $shippingAddress;
    public $orderId;

    public function __construct($orderNumber, $user, $billingAddress, $shippingAddress, $orderId)
    {
        $this->orderNumber = $orderNumber;
        $this->user = $user;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->orderId = $orderId;
    }

    public function build()
    {
        $orderMaster = \App\Models\OrderMaster::where('order_id', $this->orderId)->first();
        
        return $this->subject('Order Confirmation #' . $this->orderNumber)
                    ->view('frontend.emails.user_order_confirmation')
                    ->with([
                        'orderNumber' => $this->orderNumber,
                        'user' => $this->user,
                        'billingAddress' => $this->billingAddress,
                        'shippingAddress' => $this->shippingAddress,
                        'orderId' => $this->orderId,
                        'orderMaster' => $orderMaster
                    ]);
    }
    
}
