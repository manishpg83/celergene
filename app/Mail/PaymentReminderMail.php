<?php
// app/Mail/PaymentReminderMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;
    public $orderDetails;
    public $paymentLink;

    public function __construct($order, $customer, $orderDetails, $paymentLink = null)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->orderDetails = $orderDetails;
        $this->paymentLink = $paymentLink;
    }

    public function build()
    {
        return $this->subject('Complete Your Payment - Order #' . $this->order->order_id)
                    ->view('frontend.emails.payment-reminder')
                    ->with([
                        'order' => $this->order,
                        'customer' => $this->customer,
                        'orderDetails' => $this->orderDetails,
                        'paymentLink' => $this->paymentLink,
                        'billingAddress' => $this->getBillingAddress(),
                        'shippingAddress' => $this->getShippingAddress(),
                    ]);
    }

    private function getBillingAddress()
    {
        return [
            'name' => $this->customer->billing_fname . ' ' . $this->customer->billing_lname,
            'company' => $this->customer->billing_company_name,
            'address' => $this->customer->billing_address,
            'address2' => $this->customer->billing_address_2,
            'city' => $this->customer->billing_city,
            'state' => $this->customer->billing_state,
            'postal_code' => $this->customer->billing_postal_code,
            'country' => $this->customer->billing_country,
            'phone' => $this->customer->billing_phone,
            'email' => $this->customer->billing_email,
        ];
    }

    private function getShippingAddress()
    {
        if ($this->order->use_billing_as_shipping) {
            return $this->getBillingAddress();
        }

        return [
            'address' => $this->order->shipping_address,
        ];
    }
}
