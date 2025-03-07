<?php

namespace App\Livewire\Admin\Payment;

use App\Models\OrderMaster;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ManagePayment extends Component
{
    public $order_id, $payment_method, $amount, $currency = 'USD', $status = 'pending', $transaction_id;
    public $payment_date, $payment_details, $bank_charge;
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
            'transaction_id' => 'nullable|string',
            'bank_charge' => 'nullable|numeric|min:0'
        ]);

        Payment::create([
            'order_id' => $this->order_id,
            'payment_method' => $this->payment_method,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'transaction_id' => $this->transaction_id,
            'payment_date' => $this->payment_date,
            'payment_details' => $this->payment_details,
            'bank_charge' => $this->bank_charge
        ]);

        notyf()->success('Payment recorded successfully!');
        $this->reset(['payment_method', 'amount', 'payment_date', 'status', 'payment_details', 'transaction_id', 'bank_charge']);
    } 

    public function render()
    {
        // Fetch the currency symbol based on the order's currency_id
        $currencySymbol = DB::table('currency')
            ->where('id', $this->order->currency_id)
            ->value('symbol');
    
        return view('livewire.admin.payment.manage-payment', [
            'payments' => Payment::where('order_id', $this->order_id)->latest()->get(),
            'currencySymbol' => $currencySymbol, // Pass the currency symbol to the view
        ]);
    }
}
