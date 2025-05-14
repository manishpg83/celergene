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
    public $editedPaymentId, $editedAmount, $editedPaymentDate, $editedPaymentMethod;
    public $editedStatus, $editedBankCharge, $editedPaymentDetails;
    public $payments = [], $totalPaid = 0, $pendingAmount = 0;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::findOrFail($order_id);

        $this->refreshPayments();
    }

    public function refreshPayments()
    {
        $this->payments = Payment::where('order_id', $this->order_id)->get();
        $this->totalPaid = $this->payments->sum('amount');
        $this->pendingAmount = max(0, $this->order->total - $this->totalPaid);
    }

    public function savePayment()
    {
        $this->validate([
            'payment_method' => 'required',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status' => 'required|in:pending,partially paid,fully paid with bank charges,fully paid without bank charges',
            'payment_details' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'bank_charge' => 'nullable|numeric|min:0'
        ]);

        $bank_charge = $this->bank_charge ?? 0;

        Payment::create([
            'order_id' => $this->order_id,
            'payment_method' => $this->payment_method,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'transaction_id' => $this->transaction_id,
            'payment_date' => $this->payment_date,
            'payment_details' => $this->payment_details,
            'bank_charge' => $bank_charge
        ]);

        notyf()->success('Payment recorded successfully!');
        $this->reset(['payment_method', 'amount', 'payment_date', 'status', 'payment_details', 'transaction_id', 'bank_charge']);

        $this->refreshPayments();
    }

    public function editPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $this->editedPaymentId = $payment->id;
        $this->editedAmount = $payment->amount;
        $this->editedPaymentDate = $payment->payment_date;
        $this->editedPaymentMethod = $payment->payment_method;
        $this->editedStatus = $payment->status;
        $this->editedBankCharge = $payment->bank_charge;
        $this->editedPaymentDetails = $payment->payment_details;
    }

    public function updatePayment()
    {
        try {
            $this->validate([
                'editedAmount' => 'required|numeric|min:0',
                'editedPaymentDate' => 'required|date',
                'editedPaymentMethod' => 'required',
                'editedStatus' => 'required|in:pending,partially paid,fully paid with bank charges,fully paid without bank charges',
                'editedBankCharge' => 'nullable|numeric|min:0',
                'editedPaymentDetails' => 'nullable|string',
            ]);

            $bank_charge = $this->editedBankCharge ?? 0;

            $payment = Payment::findOrFail($this->editedPaymentId);
            $payment->update([
                'amount' => $this->editedAmount,
                'payment_date' => $this->editedPaymentDate,
                'payment_method' => $this->editedPaymentMethod,
                'status' => $this->editedStatus,
                'bank_charge' => $bank_charge,
                'payment_details' => $this->editedPaymentDetails,
            ]);

            $this->reset([
                'editedPaymentId',
                'editedAmount',
                'editedPaymentDate',
                'editedPaymentMethod',
                'editedStatus',
                'editedBankCharge',
                'editedPaymentDetails',
            ]);

            $this->dispatch('closeModal');
            notyf()->success('Payment updated successfully!');
            $this->refreshPayments();

            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            notyf()->error('Failed to update payment.');
        }
    }

    public function render()
    {
        $currencySymbol = DB::table('currency')
            ->where('id', $this->order->currency_id)
            ->value('symbol');

        return view('livewire.admin.payment.manage-payment', [
            'payments' => $this->payments,
            'currencySymbol' => $currencySymbol,
            'pendingAmount' => $this->pendingAmount,
            'totalPaid' => $this->totalPaid,
        ]);
    }
}
