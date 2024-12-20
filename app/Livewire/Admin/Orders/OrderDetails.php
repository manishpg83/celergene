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
    public $isConsignment;
    public $deliveryOrders;
    public $invoices;
    public $quantitySplits = [];
    public $actual_freight;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
        Log::info('Mounting OrderDetails component with order_id: ' . $order_id);

        try {
            $this->order = OrderMaster::where('order_id', $order_id)->firstOrFail();
            Log::info('Order found:', ['order' => $this->order->toArray()]);

            // Log raw delivery orders before processing
            $rawDeliveryOrders = DeliveryOrder::with('warehouse', 'details')
                ->where('order_id', $order_id)
                ->get();
            Log::info('Raw delivery orders:', ['delivery_orders' => $rawDeliveryOrders->toArray()]);

            // Log after grouping
            $groupedOrders = $rawDeliveryOrders->groupBy('warehouse_id');
            Log::info('Grouped by warehouse:', ['grouped_orders' => $groupedOrders->toArray()]);

            $this->deliveryOrders = DeliveryOrder::with('warehouse', 'details.product')
                ->where('order_id', $order_id)
                ->get()
                ->groupBy('warehouse_id')
                ->map(function ($orders, $warehouseId) {
                    $firstOrder = $orders->first();
                    // Get only the details for this specific delivery order
                    return [
                        'warehouse_id' => $warehouseId,
                        'delivery_number' => $firstOrder->delivery_number,
                        'delivery_date' => $firstOrder->delivery_date,
                        'warehouse_name' => $firstOrder->warehouse->warehouse_name,
                        'status' => $firstOrder->status,
                        'quantity' => $firstOrder->details->sum('quantity'), 
                        'remarks' => $firstOrder->remarks,
                        'id' => $firstOrder->id,
                        'products' => $firstOrder->details->map(function ($detail) { 
                            return [
                                'product' => $detail->product,
                                'quantity' => $detail->quantity,
                                'unit_price' => $detail->unit_price,
                                'total' => $detail->total,
                            ];
                        })->toArray(), 
                    ];
                })
                ->values();
            Log::info('Final processed delivery orders:', ['delivery_orders' => $this->deliveryOrders->toArray()]);

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
    
            $allDetails = DeliveryOrderDetail::with('product')
                ->whereHas('deliveryOrder', function($query) use ($deliveryOrder) {
                    $query->where('order_id', $deliveryOrder->order_id)
                        ->where('warehouse_id', $deliveryOrder->warehouse_id);
                })
                ->get();
    
    
            $customer = $deliveryOrder->orderMaster->customer;
            $entity = Entity::first();
    
            if (!$customer) {
                notyf()->error("Customer not found.");
                return redirect()->back();
            }
    
            foreach ($allDetails as $detail) {
                $detail->sample_quantity = $isFirstDelivery ? 
                    optional($detail->orderDetail)->sample_quantity ?? 0 : 
                    0;
            }
    
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
