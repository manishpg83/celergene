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
use App\Models\DeliveryOrderDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetails as NewOrderDetails;

class OrderDetails extends Component
{
    public $order;
    public $order_id;
    public $currencySymbol;
    public $isConsignment;
    public $deliveryOrders;
    public $invoices;
    public $quantitySplits = [];
    public $actual_freight;
    public $sampleQuantities = [];
    public $customUnitPrices = [];
    public $isEditingOrderDate = false;
    public $editedOrderDate;
    public $editedInvoiceDate;
    public $editingInvoiceId;
    public $isEditingInvoiceDate = false;
    public $editingDeliveryId = null;
    public $editingStatus;
    public $editingTrackingNumber;
    public $editingTrackingUrl;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        try {
            $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();

            $this->order = OrderMaster::with(['currency'])
                ->where('order_id', $order_id)
                ->firstOrFail();

            $this->currencySymbol = $this->order->currency ? $this->order->currency->symbol : '$';

            $rawDeliveryOrders = DeliveryOrder::with('warehouse', 'details.product')
                ->where('order_id', $order_id)
                ->get();
            $this->editedOrderDate = $this->order->order_date;

            $this->deliveryOrders = $rawDeliveryOrders->map(function ($deliveryOrder) {
                return [
                    'warehouse_id' => $deliveryOrder->warehouse_id,
                    'delivery_number' => $deliveryOrder->delivery_number,
                    'tracking_number' => $deliveryOrder->tracking_number,
                    'delivery_date' => $deliveryOrder->delivery_date,
                    'warehouse_name' => $deliveryOrder->warehouse->warehouse_name,
                    'status' => $deliveryOrder->status,
                    'quantity' => $deliveryOrder->details->sum('quantity'),
                    'remarks' => $deliveryOrder->remarks,
                    'id' => $deliveryOrder->id,
                    'products' => $deliveryOrder->details->map(function ($detail) {
                        return [
                            'product' => $detail->product,
                            'quantity' => $detail->quantity,
                            'unit_price' => $detail->unit_price,
                            'total' => $detail->total,
                        ];
                    })->toArray(),
                ];
            })->values();

            $this->invoices = OrderInvoice::where('order_id', $order_id)->get();
            $this->actual_freight = $this->order->actual_freight;
        } catch (\Exception $e) {
            Log::error('Error in OrderDetails mount:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            notyf()->error("Unable to load order details.");
        }
    }
    public function editDelivery($deliveryId)
    {
        $delivery = DeliveryOrder::find($deliveryId);
        if ($delivery) {
            $this->editingDeliveryId = $deliveryId;
            $this->editingStatus = $delivery->status;
            $this->editingTrackingNumber = $delivery->tracking_number;
            $this->editingTrackingUrl = $delivery->tracking_url;
        }
    }
    public function updateDelivery()
    {
        $delivery = DeliveryOrder::find($this->editingDeliveryId);
        if ($delivery) {
            $delivery->update([
                'status' => $this->editingStatus,
                'tracking_number' => $this->editingTrackingNumber,
                'tracking_url' => $this->editingTrackingUrl
            ]);

            $this->editingDeliveryId = null;
            $this->editingStatus = null;
            $this->editingTrackingNumber = null;
            $this->editingTrackingUrl = null;

            $this->mount($this->order_id);

            notyf()->success('Delivery order updated successfully.');
        }
    }

    public function cancelEdit()
    {
        $this->editingDeliveryId = null;
        $this->editingStatus = null;
        $this->editingTrackingNumber = null;
        $this->editingTrackingUrl = null;
    }
    public function editInvoiceDate($invoiceId)
    {
        $this->editingInvoiceId = $invoiceId;
        $invoice = OrderInvoice::find($invoiceId);
        $this->editedInvoiceDate = $invoice->invoice_date ?? $invoice->created_at->format('Y-m-d');
        $this->isEditingInvoiceDate = true;

        $this->dispatch('openEditInvoiceDateModal');
    }


    public function updateInvoiceDate()
    {
        try {
            $this->validate([
                'editedInvoiceDate' => 'required|date'
            ]);

            $invoice = OrderInvoice::findOrFail($this->editingInvoiceId);
            $invoice->invoice_date = $this->editedInvoiceDate;
            $invoice->save();

            $this->isEditingInvoiceDate = false;
            $this->dispatch('closeModal');
            notyf()->success("Invoice date updated successfully!");

            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            notyf()->error("Failed to update invoice date.");
        }
    }

    public function updateOrderDate()
    {
        try {
            $this->validate([
                'editedOrderDate' => 'required|date'
            ]);

            $order = OrderMaster::where('order_id', $this->order_id)->firstOrFail();
            $order->order_date = $this->editedOrderDate;
            $order->save();

            $this->isEditingOrderDate = false;
            $this->dispatch('closeModal');

            $this->order = $order->fresh();
            notyf()->success("Order date updated successfully!");

            return redirect()->route('admin.orders.details', ['order_id' => $this->order_id]);
        } catch (\Exception $e) {
            notyf()->error("Failed to update order date.");
        }
    }

    public function editOrderDate($orderId)
    {
        $this->editedOrderDate = $orderId;
        $order = OrderMaster::find($orderId);
        $this->editedOrderDate = $order->order_date ?? $order->created_at->format('Y-m-d');
        $this->isEditingInvoiceDate = true;

        $this->dispatch('openEditOrderDateModal');
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
        $this->sampleQuantities = array_map('intval', $this->sampleQuantities);

        $orderDetails = NewOrderDetails::where('order_id', $this->order_id)->get();

        foreach ($orderDetails as $index => $detail) {
            $requestedQty = $this->quantitySplits[$index] ?? 0;
            $sampleQty = $this->sampleQuantities[$index] ?? 0;
            if ($requestedQty > $detail->invoice_rem) {
                notyf()->error("Requested quantity for {$detail->product->product_name} exceeds remaining quantity!");
                return;
            }

            if ($sampleQty > $detail->invoice_rem_sample) {
                notyf()->error("Requested sample quantity for {$detail->product->product_name} exceeds remaining sample quantity!");
                return;
            }
        }
        $hasQuantitiesToInvoice = collect($this->quantitySplits)->sum() > 0 || collect($this->sampleQuantities)->sum() > 0;

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
            $sampleQty = $this->sampleQuantities[$index] ?? 0;


            if ($splitQty > 0 || $sampleQty > 0) {
                $detail->invoice_rem -= $splitQty;
                $detail->invoice_rem_sample -= $sampleQty;
                $detail->save();

                $unitPrice = isset($this->customUnitPrices[$index]) && $this->customUnitPrices[$index] > 0
                    ? $this->customUnitPrices[$index]
                    : $detail->unit_price;

                $productSubtotal = $splitQty * $unitPrice;
                $totalSubtotal += $productSubtotal;
                $totalQuantity += $splitQty;

                $invoiceDetails[] = [
                    'product_id' => $detail->product_id,
                    'unit_price' => $unitPrice,
                    'quantity' => $splitQty,
                    'delivered_quantity' => 0,
                    'invoiced_quantity' => $splitQty,
                    'discount' => $detail->discount,
                    'total' => $splitQty * $unitPrice - $detail->discount,
                    'manual_product_name' => $detail->manual_product_name,
                    'sample_quantity' => $detail->sample_quantity,
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
                'sample_quantity' => $sampleQty,
            ]);
        }

        return $invoice;
    }

    public function downloadInvoice($invoiceDetailId, $order_id)
    {
        try {
            $invoiceDetail = OrderInvoiceDetail::findOrFail($invoiceDetailId);
            $invoice = OrderInvoice::findOrFail($invoiceDetail->order_invoice_id);
            $customer = Customer::findOrFail($invoice->customer_id);
            $order = OrderMaster::with(['orderDetails.product', 'currency'])
                ->where('order_id', $order_id)
                ->firstOrFail();

            $currencySymbol = $order->currency ? $order->currency->symbol : '$';

            $orderInvoiceDetails = OrderInvoiceDetail::where('order_invoice_id', $invoice->id)->get();
            $customerName = preg_replace('/[^A-Za-z0-9\-]/', '_', $customer->first_name . '_' . $customer->last_name);
            $fileName = "{$customerName}-{$invoiceDetail->id}.pdf";

            $pdf = PDF::loadView('admin.order.invoicenew-pdf', [
                'invoiceDetail' => $invoiceDetail,
                'invoice' => $invoice,
                'customer' => $customer,
                'order' => $order,
                'orderInvoiceDetails' => $orderInvoiceDetails,
                'currencySymbol' => $currencySymbol,
            ]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } catch (\Exception $e) {
            notyf()->error("Could not download invoice detail PDF.");
            return redirect()->back();
        }
    }
    public function downloadShippingInvoice($invoiceDetailId, $order_id)
    {
        try {
            Log::info("Download Shipping Invoice started", [
                'invoiceDetailId' => $invoiceDetailId,
                'order_id' => $order_id,
                'user_id' => Auth::id(),
            ]);
    
            $invoiceDetail = OrderInvoiceDetail::findOrFail($invoiceDetailId);
            Log::info("Invoice detail found", ['invoiceDetailId' => $invoiceDetail->id]);
    
            $invoice = OrderInvoice::findOrFail($invoiceDetail->order_invoice_id);
            Log::info("Invoice found", ['invoice_id' => $invoice->id]);
    
            $customer = Customer::findOrFail($invoice->customer_id);
            Log::info("Customer found", ['customer_id' => $customer->id]);
    
            $order = OrderMaster::with(['orderDetails.product', 'currency'])
                ->where('order_id', $order_id)
                ->firstOrFail();
            Log::info("Order found", ['order_id' => $order->order_id]);
    
            $currencySymbol = $order->currency ? $order->currency->symbol : '$';
    
            $orderInvoiceDetails = OrderInvoiceDetail::where('order_invoice_id', $invoice->id)->get();
            foreach ($orderInvoiceDetails as $detail) {
                $detail->unit_price = 5;
                $detail->total = $detail->quantity * 5;
            }
            $subtotal = $orderInvoiceDetails->sum('total'); 
            $freight = $invoice->freight;
            $tax = $invoice->tax; 
            $total = $subtotal + $freight + $tax; 
            $invoice->subtotal = $subtotal;
            $invoice->total = $total;
    
            Log::info("Calculated invoice amounts", [
                'subtotal' => $subtotal,
                'freight' => $freight,
                'tax' => $tax,
                'total' => $total
            ]);
    
            $customerName = preg_replace('/[^A-Za-z0-9\-]/', '_', $customer->first_name . '_' . $customer->last_name);
            $fileName = "{$customerName}-Shipping-{$invoiceDetail->id}.pdf";
    
            Log::info("Generating PDF", ['fileName' => $fileName]);
    
            $pdf = PDF::loadView('admin.order.invoicenew-pdf', [
                'invoiceDetail' => $invoiceDetail,
                'invoice' => $invoice,
                'customer' => $customer,
                'order' => $order,
                'orderInvoiceDetails' => $orderInvoiceDetails,
                'currencySymbol' => $currencySymbol,
            ]);
    
            Log::info("PDF generated successfully", ['fileName' => $fileName]);
    
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName);
        } catch (\Exception $e) {
            Log::error("Error downloading shipping invoice PDF", [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'invoiceDetailId' => $invoiceDetailId,
                'order_id' => $order_id,
                'user_id' => Auth::id(),
            ]);
    
            notyf()->error("Could not download shipping invoice PDF.");
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

            $allDetails = DeliveryOrderDetail::with('product')
                ->where('delivery_order_id', $deliveryOrderId)
                ->get();

            $customer = $deliveryOrder->orderMaster->customer;
            $entityId = $deliveryOrder->orderMaster->entity_id;
            $entity = Entity::find($entityId);

            if (!$customer) {
                notyf()->error("Customer not found.");
                return redirect()->back();
            }

            /* foreach ($allDetails as $detail) {
                $detail->sample_quantity = $isFirstDelivery ?
                    optional($detail->orderDetail)->sample_quantity ?? 0 :
                    0;
            } */

            $fileName = "Delivery-Order-{$deliveryOrder->id}.pdf";

            $pdf = PDF::loadView('admin.order.delivery_order_pdf', [
                'deliveryOrder' => $deliveryOrder,
                'customer' => $customer,
                'entity' => $entity,
                'allDetails' => $allDetails,
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
