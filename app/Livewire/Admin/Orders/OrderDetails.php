<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Entity;
use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\OrderInvoice;
use App\Models\DeliveryOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\OrderWorkflowType;
use App\Models\OrderInvoiceDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetails as NewOrderDetails;

class OrderDetails extends Component
{
    public $order;
    public $order_id;
    public $isConsignment;
    public $deliveryOrders;
    public $invoices;
    public $quantitySplits = [];
    public $actual_freight;

    public function mount($order_id)
    {
        $this->order_id = $order_id;

        try {
            $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();
            $this->deliveryOrders = DeliveryOrder::where('order_id', $order_id)->get();
            $this->invoices = OrderInvoice::where('order_id', $order_id)->get();
            $this->actual_freight = $this->order->actual_freight;
        } catch (\Exception $e) {
            notyf()->error("Unable to load order details.");
        }
    }
    
    public function updateActualFreight()
    {
        try {
            $order = OrderMaster::where('order_id', $this->order_id)->firstOrFail();
            $order->actual_freight = $this->actual_freight;
            $order->save();

            notyf()->success("Actual freight updated successfully!");
        } catch (\Exception $e) {
            notyf()->error("Failed to update actual freight.");
        }
    }
    
    public function generateInvoices()
    {
        $this->quantitySplits = array_map('intval', $this->quantitySplits);

        $orderDetails = NewOrderDetails::where('order_id', $this->order_id)->get();

        foreach ($orderDetails as $index => $detail) {
            $requestedQty = $this->quantitySplits[$index] ?? 0;

            if ($requestedQty > $detail->invoice_rem) {
                notyf()->error("Requested quantity for {$detail->product->product_name} exceeds remaining quantity!");
                return;
            }
        }

        $hasQuantitiesToInvoice = collect($this->quantitySplits)->sum() > 0;

        if ($hasQuantitiesToInvoice) {
            $this->createCombinedInvoice($orderDetails);
        }

        $this->mount($this->order_id);
        notyf()->success('Invoices generated successfully!');
    }
    
    private function createCombinedInvoice($orderDetails)
    {
        $mainOrder = $this->order;
        
        $invoiceDetails = [];
        $totalSubtotal = 0;
        $totalQuantity = 0;
    
        foreach ($orderDetails as $index => $detail) {
            $splitQty = $this->quantitySplits[$index] ?? 0;
            
            if ($splitQty > 0) {
                $detail->invoice_rem -= $splitQty;
                $detail->save();
    
                $productSubtotal = $splitQty * $detail->unit_price;
                $totalSubtotal += $productSubtotal;
                $totalQuantity += $splitQty;
    
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
    
        $totalOrderQuantity = $mainOrder->orderDetails->sum('quantity');
        $tax = ($mainOrder->tax / $totalOrderQuantity) * $totalQuantity;
        $freight = ($mainOrder->freight / $totalOrderQuantity) * $totalQuantity;
    
        $total = $totalSubtotal + $tax + $freight;
    
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

    public function downloadInvoice($invoiceDetailId)
    {
        try {
            Log::info("Attempting to download invoice for detail ID: {$invoiceDetailId}");
    
            $invoiceDetail = OrderInvoiceDetail::findOrFail($invoiceDetailId);
            $invoice = OrderInvoice::findOrFail($invoiceDetail->order_invoice_id);
            $customer = Customer::findOrFail($invoice->customer_id);
    
            $fileName = "Invoice-Detail-{$invoiceDetail->id}.pdf";            
            $pdf = PDF::loadView('admin.order.invoicenew-pdf', [
                'invoiceDetail' => $invoiceDetail,
                'invoice' => $invoice,
                'customer' => $customer,
            ]);            
    
            Log::info("PDF successfully generated for invoice detail ID: {$invoiceDetailId}");
    
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
    
        } catch (\Exception $e) {
            Log::error("Failed to download invoice detail PDF: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'invoiceDetailId' => $invoiceDetailId,
            ]);
            notyf()->error("Could not download invoice detail PDF.");
            return redirect()->back();
        }
    }
    

    public function downloadDeliveryOrder($deliveryOrderId)
{
    try {
        $deliveryOrder = DeliveryOrder::with([
            'details.product', 
            'warehouse', 
            'orderMaster'
        ])->findOrFail($deliveryOrderId);

        $isFirstDelivery = DeliveryOrder::where('order_id', $deliveryOrder->order_id)
            ->where('id', '<=', $deliveryOrderId)
            ->count() === 1;

        $customer = optional($deliveryOrder->orderMaster)->customer;
        $entity = Entity::first();

        if (!$customer) {
            notyf()->error("Customer not found.");
            return redirect()->back();
        }

        $deliveryDetailsWithSamples = $deliveryOrder->details->map(function ($detail) use ($isFirstDelivery) {
            $sampleQuantity = $isFirstDelivery ? 
                optional($detail->orderDetail)->sample_quantity ?? 0 : 
                0;
                
            return [
                'product' => $detail->product,
                'quantity' => $detail->quantity,
                'sample_quantity' => $sampleQuantity,
                'unit_price' => $detail->unit_price,
                'discount' => $detail->discount,
                'total' => $detail->total
            ];
        });

        $fileName = "Delivery-Order-{$deliveryOrder->id}.pdf";

        $pdf = PDF::loadView('admin.order.delivery_order_pdf', [
            'deliveryOrder' => $deliveryOrder,
            'customer' => $customer,
            'entity' => $entity,
            'deliveryDetails' => $deliveryDetailsWithSamples,
            'isFirstDelivery' => $isFirstDelivery
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $fileName);

    } catch (\Exception $e) {
        Log::error('Delivery Order PDF generation error: ' . $e->getMessage());
        notyf()->error("Could not download Delivery Order PDF: " . $e->getMessage());
        return redirect()->back();
    }
}
    
    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        try {
            $workflowType = $this->order->workflow_type;
    
            return view('livewire.admin.orders.order-details', [
                'showSplitInvoices' => $workflowType === OrderWorkflowType::CONSIGNMENT,
            ]);
        } catch (\Exception $e) {
            notyf()->error("An error occurred while rendering the view.");
            return view('livewire.admin.orders.order-details', ['showSplitInvoices' => false]);
        }
    }
}
