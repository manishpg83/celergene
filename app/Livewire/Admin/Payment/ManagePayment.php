<?php

namespace App\Livewire\Admin\Payment;

use Livewire\Component;
use App\Models\Payment;
use App\Models\OrderMaster;

class ManagePayment extends Component
{
    public $order_id, $payment_method, $amount, $currency = 'USD', $status = 'pending', $transaction_id;
    public $payment_date, $payment_details;
    public $order;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::findOrFail($order_id);
    }

    public function savePayment()
    {
        $this->validate([
            'payment_method' => 'required',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,partially paid,fully paid',
            'payment_details' => 'nullable|string',
            'transaction_id' => 'nullable|string'
        ]);

        Payment::create([
            'order_id' => $this->order_id,
            'payment_method' => $this->payment_method,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'transaction_id' => $this->transaction_id,
            'payment_date' => $this->payment_date,
            'payment_details' => $this->payment_details
        ]);

        notyf()->success('Payment recorded successfully!');
        $this->reset(['payment_method', 'amount', 'payment_date', 'status', 'payment_details', 'transaction_id']);
    }

    public function render()
    {
        return view('livewire.admin.payment.manage-payment', [
            'payments' => Payment::where('order_id', $this->order_id)->latest()->get()
        ]);
    }
}
