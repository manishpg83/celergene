<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $orderNumber;
    public $user;
    public $billingAddress;
    public $shippingAddress;
    public $orderId;
    public $shippingName;
    public $shippingCompany;
    public $shippingPhone;

    public function __construct($orderNumber, $user, $billingAddress, $shippingAddress, $orderId, $shippingName, $shippingCompany, $shippingPhone)
    {
        $this->orderNumber = $orderNumber;
        $this->user = $user;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->orderId = $orderId;
        $this->shippingName = $shippingName;
        $this->shippingCompany = $shippingCompany;
        $this->shippingPhone = $shippingPhone;
    }

    public function build()
    {

        $orderMaster = \App\Models\OrderMaster::where('order_id', $this->orderId)->first();
        $customer = \App\Models\Customer::find($orderMaster->customer_id);

        $billingName = trim($customer->billing_fname . ' ' . $customer->billing_lname);
        $billingCompany = $customer->billing_company_name;



        return $this->subject('Payment Confirmation for Order No: ' . $this->orderNumber)
            ->view('frontend.emails.user_order_confirmation')
            ->with([
                'orderNumber' => $this->orderNumber,
                'billingAddress' => $this->billingAddress,
                'shippingAddress' => $this->shippingAddress,
                'orderId' => $this->orderId,
                'orderMaster' => $orderMaster,
                'billingName' => $billingName,
                'billingCompany' => $billingCompany,
                'shippingName' => $this->shippingName,
                'shippingCompany' => $this->shippingCompany,
                'shippingPhone' => $this->shippingPhone,
            ]);
    }
}
