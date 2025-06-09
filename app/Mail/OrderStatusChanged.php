<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;
    public $payment;

    public function __construct($order, $oldStatus, $newStatus, $payment = null)
    {
        $this->order = $order->load([
            'customer',
            'orderDetails.product',
            'modifier'
        ]);
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->payment = $payment ?? $order->payments()->latest()->first();
    }

    public function build()
    {
        return $this->subject('Payment Notification for Order No: #' . $this->order->order_id)
                    ->view('admin.emails.order-status-changed');
    }
}
