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

    public function __construct($order, $inventory)
    {
        $this->order = $order;
        $this->inventory = $inventory;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Update Notification')
            ->line('Order with Invoice ID: ' . $this->order->order_id . ' has been updated.')
            ->line('Order Status: ' . $this->order->delivery_status)
            ->line('Product: ' . $this->inventory->product->name)
            ->line('Quantity Used: ' . $this->inventory->consumed)
            ->line('Remaining Quantity: ' . $this->inventory->remaining)
            ->line('Thank you for using our application!');
    }
}