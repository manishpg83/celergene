<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WarehouseOrderUpdate extends Notification
{
    use Queueable;

    protected $order;
    protected $productDetails; // Change from inventory to productDetails
    protected $warehouseName;
    protected $shippingAddress;
    protected $deliveryOrder;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $order
     * @param  array  $productDetails
     * @param  string $warehouseName
     * @param  string $shippingAddress
     * @param  string $deliveryOrder
     */
    public function __construct($order, $productDetails,$deliveryOrder, $warehouseName, $shippingAddress)
    {
        $this->order = $order;
        $this->productDetails = $productDetails;
        $this->deliveryOrder = $deliveryOrder;
        $this->warehouseName = $warehouseName;
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $customer = $this->order->customer;
        $updateLink = isset($this->deliveryOrder)
        ? url("/warehouse/update-delivery/{$this->deliveryOrder->id}")
        : '#';
        return (new MailMessage)
        ->subject("Delivery Order Request - Order {$this->order->order_id}")
            ->markdown('admin.emails.warehouse-do', [
                'order' => $this->order,
                'productDetails' => $this->productDetails,
                'warehouseName' => $this->warehouseName,
                'shippingAddress' => $this->shippingAddress,
                'customerMobile' => $customer->mobile_number ?? 'N/A',
                'updateLink' => $updateLink,
            ]);
    }

}
