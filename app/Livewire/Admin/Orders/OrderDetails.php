<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use App\Models\OrderMaster;
use App\Models\OrderDetails as NewOrderDetails;
use App\Models\OrderInvoice;
use App\Models\DeliveryOrder;

class OrderDetails extends Component
{
    public $order;
    public $order_id;
    public $deliveryOrders;
    public $invoices;
    public $quantitySplits = [];

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();
        $this->deliveryOrders = DeliveryOrder::where('order_id', $order_id)->get();
        $this->invoices = OrderInvoice::where('order_id', $order_id)->get();
    }

    public function generateInvoices()
    {
        $orderDetails = NewOrderDetails::where('order_id', $this->order_id)->get();

        $remainingQuantity = $orderDetails->sum('remaining_quantity');
        $totalRequested = array_sum($this->quantitySplits);

        if ($totalRequested > $remainingQuantity) {
            session()->flash('error', 'Requested quantities exceed remaining quantity!');
            return;
        }

        foreach ($this->quantitySplits as $splitQty) {
            if ($splitQty > 0) {
                $invoiceData = $this->createInvoice($splitQty);
                $this->downloadInvoice($invoiceData);
            }
        }

        $this->mount($this->order_id); // Refresh the data
    }

    private function createInvoice($quantity)
    {
        // Adjust remaining quantities in the order details
        $orderDetails = NewOrderDetails::where('order_id', $this->order_id)->orderBy('id')->get();

        foreach ($orderDetails as $detail) {
            if ($quantity > 0 && $detail->remaining_quantity > 0) {
                $deductQty = min($quantity, $detail->remaining_quantity);
                $quantity -= $deductQty;

                $detail->remaining_quantity -= $deductQty;
                $detail->save();
            }
        }

        // Create invoice in the database
        $invoice = OrderInvoice::create([
            'order_id' => $this->order_id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'status' => 'Draft',
            'total' => $this->calculateInvoiceTotal($quantity),
            'remarks' => 'Generated for consignment',
            'customer_id' => $this->order->customer_id, // Ensure this field is set
            'entity_id' => $this->order->entity_id,
            'shipping_address' => $this->order->shipping_address, // Add shipping address
        ]);

        return $invoice;
    }

    private function calculateInvoiceTotal($quantity)
    {
        $orderDetails = NewOrderDetails::where('order_id', $this->order_id)->get();

        $total = 0;
        foreach ($orderDetails as $detail) {
            $total += $detail->unit_price * $quantity - $detail->discount;
        }

        return $total;
    }

    private function downloadInvoice($invoice)
    {
        $pdf = PDF::loadView('pdf.invoice', ['invoice' => $invoice, 'order' => $this->order]);
        return $pdf->download("Invoice-{$invoice->invoice_number}.pdf");
    }

    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.order-details');
    }
}

