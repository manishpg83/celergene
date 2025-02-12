<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;
    protected $order_id;

    public function __construct($order, $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->order_id = 'INV-' . str_pad($order->order_id, 8, '0', STR_PAD_LEFT);
    }

    public function build()
    {
        try {
            if (!$this->order->relationLoaded('orderDetails')) {
                $this->order->load(['orderDetails.product', 'currency']);
            }

            return $this->subject('Order Confirmation #' . $this->order_id)
                ->view('admin.emails.order-confirmation')
                ->with([
                    'order' => $this->order,
                    'customer' => $this->customer,
                    'order_id' => $this->order_id,
                    'company_details' => [
                        'name' => 'Celergen',
                        'address' => config('app.company_address', ''),
                        'phone' => config('app.company_phone', ''),
                        'email' => config('app.company_email', ''),
                    ]
                ]);

        } catch (\Exception $e) {
            Log::error('Failed to build order confirmation email', [
                'order_id' => $this->order->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}