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
    
        // Check if there are any quantities to invoice
        $hasQuantitiesToInvoice = collect($this->quantitySplits)->sum() > 0;
        
        if ($hasQuantitiesToInvoice) {
            // Create a single invoice for all selected quantities
            $this->createCombinedInvoice($orderDetails);
        }
    
        $this->mount($this->order_id);
        session()->flash('success', 'Invoices generated successfully!');
    }
    
    private function createCombinedInvoice($orderDetails)
    {
        $mainOrder = $this->order;
        
        // Prepare invoice details and update remaining quantities
        $invoiceDetails = [];
        $totalSubtotal = 0;
        $totalQuantity = 0;
    
        foreach ($orderDetails as $index => $detail) {
            $splitQty = $this->quantitySplits[$index] ?? 0;
            
            if ($splitQty > 0) {
                // Subtract the split quantity from the original order detail's remaining quantity
                $detail->invoice_rem -= $splitQty;
                $detail->save();
    
                // Calculate subtotal for this product
                $productSubtotal = $splitQty * $detail->unit_price;
                $totalSubtotal += $productSubtotal;
                $totalQuantity += $splitQty;
    
                // Prepare invoice detail entry
                $invoiceDetails[] = [
                    'product_id' => $detail->product_id,
                    'unit_price' => $detail->unit_price,
                    'quantity' => $splitQty,
                    'delivered_quantity' => 0,
                    'invoiced_quantity' => $splitQty,
                    'discount' => $detail->discount,
                    'total' => $splitQty * $detail->unit_price - $detail->discount,
                    'manual_product_name' => $detail->manual_product_name,
                ];
            }
        }
    
        // Proportionally calculate tax and freight based on the total quantity
        $totalOrderQuantity = $mainOrder->orderDetails->sum('quantity');
        $tax = ($mainOrder->tax / $totalOrderQuantity) * $totalQuantity;
        $freight = ($mainOrder->freight / $totalOrderQuantity) * $totalQuantity;
    
        $total = $totalSubtotal + $tax + $freight;
    
        // Create the invoice
        $invoice = OrderInvoice::create([
            'order_id' => $this->order_id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'status' => 'Draft',
            'total' => $total,
            'remarks' => 'Generated for split quantities',
            'customer_id' => $mainOrder->customer_id,
            'entity_id' => $mainOrder->entity_id,
            'shipping_address' => $mainOrder->shipping_address,
            'subtotal' => $totalSubtotal,
            'tax' => $tax,
            'freight' => $freight,
            'created_by' => Auth::id(),
        ]);
    
        // Create invoice details entries
        foreach ($invoiceDetails as $detailData) {
            OrderInvoiceDetail::create([
                'order_invoice_id' => $invoice->id,
                'product_id' => $detailData['product_id'],
                'unit_price' => $detailData['unit_price'],
                'quantity' => $detailData['quantity'],
                'delivered_quantity' => $detailData['delivered_quantity'],
                'invoiced_quantity' => $detailData['invoiced_quantity'],
                'discount' => $detailData['discount'],
                'total' => $detailData['total'],
                'manual_product_name' => $detailData['manual_product_name'],
            ]);
        }
    
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
            $invoice = OrderInvoice::findOrFail($invoiceDetail->order_invoice_id);
            $customer = Customer::findOrFail($invoice->customer_id);
            
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
            session()->flash('error', 'Could not download invoice detail PDF.');
            return redirect()->back();
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

