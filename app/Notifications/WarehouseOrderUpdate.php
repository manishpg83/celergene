<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WarehouseOrderUpdate extends Notification
{
    use Queueable;

    protected $order;
    protected $inventory;
    protected $warehouseName;
    protected $shippingAddress;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $order
     * @param  mixed  $inventory
     * @param  string $warehouseName
     * @param  string $shippingAddress
     */
    public function __construct($order, $inventory, $warehouseName, $shippingAddress)
    {
        $this->order = $order;
        $this->inventory = $inventory;
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
        $orderDetails = $this->order->orderDetails;
        $customer = $this->order->customer;

        return (new MailMessage)
            ->subject('Order Update Notification')
            ->markdown('admin.emails.warehouse-do', [
                'order' => $this->order,
                'orderDetails' => $orderDetails,
                'inventory' => $this->inventory,
                'warehouseName' => $this->warehouseName,
                'shippingAddress' => $this->shippingAddress,
                'customerMobile' => $customer->mobile_number ?? 'N/A',
            ]);
    }
}
