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
    use Queueable, SerializesModels;

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
        $customer = \App\Models\Customer::find($orderMaster->customer_id);

        $billingName = trim($customer->billing_fname . ' ' . $customer->billing_lname);
        $billingCompany = $customer->billing_company_name;

        $shippingName = trim($customer->shipping_address_receiver_name_1 . ' ' . $customer->shipping_address_receiver_lname_1);
        $shippingCompany = $customer->shipping_company_name_1;
        $shippingPhone = $customer->shipping_phone_1;


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
                'shippingName' => $shippingName,
                'shippingCompany' => $shippingCompany,
                'shippingPhone' => $shippingPhone,
            ]);
    }
}
