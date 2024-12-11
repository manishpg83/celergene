<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\OrderInvoice;
use App\Models\DeliveryOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrderInvoiceDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetails as NewOrderDetails;


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
        $this->quantitySplits = array_map('intval', $this->quantitySplits);

        $orderDetails = NewOrderDetails::where('order_id', $this->order_id)->get();

        // Validate quantities product-wise
        foreach ($orderDetails as $index => $detail) {
            $requestedQty = $this->quantitySplits[$index] ?? 0;
            
            if ($requestedQty > $detail->invoice_rem) {
                session()->flash('error', "Requested quantity for {$detail->product->product_name} exceeds remaining quantity!");
                return;
            }
        }

        // Generate invoices for each product separately
        foreach ($orderDetails as $index => $detail) {
            $splitQty = $this->quantitySplits[$index] ?? 0;
            
            if ($splitQty > 0) {
                $invoice = $this->createInvoice($splitQty, $detail->id);
            }
        }

        $this->mount($this->order_id);
        session()->flash('success', 'Invoices generated successfully!');
    }

    // Modify createInvoice method to accept a specific order detail ID
    private function createInvoice($quantity, $orderDetailId)
    {
        // Find the original order detail
        $originalOrderDetail = NewOrderDetails::findOrFail($orderDetailId);

        // Subtract the split quantity from the original order detail's remaining quantity
        $originalOrderDetail->invoice_rem -= $quantity;
        $originalOrderDetail->save();

        $mainOrder = $this->order;

        $subtotal = $quantity * $originalOrderDetail->unit_price;

        // Proportionally calculate tax and freight based on the specific quantity
        $totalOrderQuantity = $mainOrder->orderDetails->sum('quantity');
        $tax = ($mainOrder->tax / $totalOrderQuantity) * $quantity;
        $freight = ($mainOrder->freight / $totalOrderQuantity) * $quantity;

        $total = $subtotal + $tax + $freight;

        // Create the invoice
        $invoice = OrderInvoice::create([
            'order_id' => $this->order_id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'status' => 'Draft',
            'total' => $total,
            'remarks' => 'Generated for split quantity',
            'customer_id' => $mainOrder->customer_id,
            'entity_id' => $mainOrder->entity_id,
            'shipping_address' => $mainOrder->shipping_address,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'freight' => $freight,
            'created_by' => Auth::id(),
        ]);

        // Create an entry in order_invoice_details
        OrderInvoiceDetail::create([
            'order_invoice_id' => $invoice->id,
            'product_id' => $originalOrderDetail->product_id,
            'unit_price' => $originalOrderDetail->unit_price,
            'quantity' => $quantity,
            'delivered_quantity' => 0, // You might want to adjust this based on your business logic
            'invoiced_quantity' => $quantity,
            'discount' => $originalOrderDetail->discount,
            'total' => $quantity * $originalOrderDetail->unit_price - $originalOrderDetail->discount,
            'manual_product_name' => $originalOrderDetail->manual_product_name,
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

    public function downloadInvoice($invoiceDetailId)
    {
        try {            
            $invoiceDetail = OrderInvoiceDetail::findOrFail($invoiceDetailId);
            $invoiceid =  $invoiceDetail->order_invoice_id;
            $invoice = OrderInvoice::findOrFail($invoiceid);
            $customerid =  $invoice->customer_id;
            $customer = Customer::findOrFail($customerid);
            $fileName = "Invoice-Detail-{$invoiceDetail->id}.pdf";            
            $pdf = PDF::loadView('admin.order.invoicenew-pdf', [
                'invoiceDetail' => $invoiceDetail,
                'invoice' => $invoice,
                'customer' => $customer,
            ]);            
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } catch (\Exception $e) {
            Log::error('Invoice detail download failed: ' . $e->getMessage());
            notyf()->error('Could not download invoice detail PDF.');
        }
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

