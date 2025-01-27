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
        return (new MailMessage)
            ->subject('Order Update Notification')
            ->line('Order with Invoice ID: ' . $this->order->order_id . ' has been updated.')
            ->line('Order Status: ' . $this->order->delivery_status)
            ->line('Warehouse: ' . $this->warehouseName)
            ->line('Shipping Address: ' . $this->shippingAddress)
            ->line('Product: ' . $this->inventory->product->name)
            ->line('Quantity Used: ' . $this->inventory->consumed)
            ->line('Remaining Quantity: ' . $this->inventory->remaining)
            ->line('Thank you for using our application!');
    }
}
