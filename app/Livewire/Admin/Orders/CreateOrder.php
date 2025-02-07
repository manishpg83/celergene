<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderWorkflowType;
use App\Mail\OrderConfirmation;
use App\Models\Customer;
use App\Models\Entity;
use App\Models\Inventory;
use App\Models\OrderInvoice;
use App\Models\OrderInvoiceDetail;
use App\Models\OrderMaster;
use App\Models\Product;
use App\Models\Stock;
use App\Rules\UniqueProductInOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateOrder extends Component
{
    public $isSubmitting = false;
    public $entities;
    public $entity_id;
    public $customers;
    public $created_by;
    public $oldInvoiceStatus;
    public $oldDeliveryStatus;
    public $modified_by;
    public $payment_terms;
    public $delivery_status = 'Pending';
    public $products;
    public $orderDetails = [];
    public $customer_id;
    public $shipping_address;
    public $order_date;
    public $remarks;
    public float $subtotal = 0;
    public float $totalDiscount = 0;
    public $tax = 0;
    public float $total = 0;
    public $freight = 0;
    public float $actual_freight = 0;
    public $payment_mode = 'Bank Transfer';
    public $invoice_status = 'Pending';
    public $selected_shipping_address = 1;
    public $shipping_addresses = [];
    public $is_generated = false;
    public $workflow_type = OrderWorkflowType::STANDARD->value;

    protected function rules()
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'entity_id' => 'required|exists:entities,id',
            'shipping_address' => 'required|string',
            'actual_freight' => 'numeric|min:0',
            'orderDetails' => 'required|array|min:1',
            'orderDetails.*.product_id' => [
                'required',
                'exists:products,id',
                new UniqueProductInOrder($this->orderDetails),
            ],
            'orderDetails.*.quantity' => 'required|numeric|min:1',
            'orderDetails.*.unit_price' => 'required|numeric|min:0',
            'orderDetails.*.discount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'freight' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:Credit Card,Bank Transfer,Cash',
            'invoice_status' => 'required|in:Pending,Paid,Cancelled',
            'selected_shipping_address' => 'required|in:1,2,3',
            'order_date' => 'required|date',
            'remarks' => 'nullable|string|max:1000',
            'payment_terms' => 'nullable|string|max:255',
            'delivery_status' => 'required|in:Pending,Shipped,Delivered,Cancelled',
            'is_generated' => 'boolean',
            'orderDetails.*.manual_product_name' => [
                'required_if:orderDetails.*.product_id,1',
                'string',
                'max:255',
            ],
            'orderDetails.*.sample_quantity' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'workflow_type' => 'required|string|in:' . implode(',', array_keys(OrderWorkflowType::options())),
        ];  

        return $rules;
    }

    private function getAvailableProducts($index = null)
    {
        $selectedProductIds = array_column($this->orderDetails, 'product_id');

        if ($index !== null && isset($this->orderDetails[$index]['product_id'])) {
            $selectedProductIds = array_diff($selectedProductIds, [$this->orderDetails[$index]['product_id']]);
        }

        return $this->products->filter(function ($product) use ($selectedProductIds) {
            return !in_array($product->id, $selectedProductIds);
        });
    }

    public function mount()
    {
        $this->customers = Customer::all();
        $this->entities = Entity::active()->get();
        $this->products = Product::all();
        $this->created_by = Auth::id();
        $this->modified_by = Auth::id();
        $this->freight = 0;
        $this->tax = 0;
        $this->addOrderDetail();
        $this->order_date = now()->format('Y-m-d');
        $this->oldInvoiceStatus = $this->invoice_status;
        $this->oldDeliveryStatus = $this->delivery_status;
    }

    public function updatedCustomerId($value)
    {
        $this->updateShippingAddresses();

        $customer = Customer::find($value);

        if ($customer) {
            $this->payment_terms = $customer->payment_term_display;
        } else {
            $this->payment_terms = '';
        }
    }

    public function updatedSelectedShippingAddress($value)
    {
        $this->updateShippingAddress();
    }

    private function updateShippingAddresses()
    {
        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            if ($customer) {
                $this->shipping_addresses = [
                    1 => $this->formatAddress($customer, 1),
                    2 => $this->formatAddress($customer, 2),
                    3 => $this->formatAddress($customer, 3),
                ];
                $this->updateShippingAddress();
            }
        } else {
            $this->shipping_addresses = [];
            $this->shipping_address = '';
        }
    }

    private function formatAddress($customer, $index)
    {
        $receiver = $customer["shipping_address_receiver_name_{$index}"];
        $address = $customer["shipping_address_{$index}"];
        $countryCode = $customer["shipping_country_{$index}"];
        $postalCode = $customer["shipping_postal_code_{$index}"];
    
        $countries = [
            'LUX' => 'Luxembourg',
            'USA' => 'United States of America',
            'MAL' => 'Malaysia',
            'IND' => 'India',
            'SIN' => 'Singapore',
            'CHI' => 'China',
            'SWI' => 'Switzerland',
            'THA' => 'Thailand',
            'PHI' => 'Philippines',
        ];
    
        $country = $countries[$countryCode] ?? $countryCode;
    
        if ($receiver || $address || $country || $postalCode) {
            return implode(", ", array_filter([$receiver, $address, $country, $postalCode]));
        }
        return null;
    }    

    private function updateShippingAddress()
    {
        $this->shipping_address = $this->shipping_addresses[$this->selected_shipping_address] ?? '';
    }

    public function addOrderDetail()
    {
        $newDetail = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'discount' => 0,
            'total' => 0,
            'custom_product' => false,
            'manual_product_name' => '',
            'sample_quantity' => 0
        ];

        $this->orderDetails[] = $newDetail;
        $this->calculateTotals();
    }

    public function updatedOrderDetails($value, $key)
    {
        [$index, $field] = explode('.', $key);

        if ($field === 'product_id') {
            $this->fetchUnitPrice($index, $value);
        }

        $this->calculateTotals();
    }

    public function fetchUnitPrice($index, $productId)
    {
        if ($productId == 1) {
            $this->orderDetails[$index]['unit_price'] = 0;
            $this->orderDetails[$index]['custom_product'] = true;
        } else {
            $product = Product::find($productId);
            $this->orderDetails[$index]['unit_price'] = $product ? $product->unit_price : 0;
            $this->orderDetails[$index]['custom_product'] = false;
        }
        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $this->subtotal = 0;
        $this->totalDiscount = 0;

        foreach ($this->orderDetails as $index => $detail) {
            $regularQuantity = floatval($detail['quantity']) - floatval($detail['sample_quantity'] ?? 0);
            //$unitPrice = floatval($detail['unit_price']);
            $quantity = floatval($detail['quantity']);
            $unitPrice = floatval($detail['unit_price']);
            $discount = floatval($detail['discount']);

            if ($regularQuantity > 0) {
                $this->subtotal += $regularQuantity * $unitPrice;
                $this->totalDiscount += $discount;
                
                $this->orderDetails[$index]['total'] = max(($regularQuantity * $unitPrice) - $discount, 0);
            } else {
                $this->orderDetails[$index]['total'] = 0;
            }
        }

        $this->calculateFinalTotal();
    }

    private function calculateFinalTotal()
    {
        $this->subtotal = floatval($this->subtotal);
        $this->totalDiscount = floatval($this->totalDiscount);
        $this->freight = floatval($this->freight);
        $this->tax = floatval($this->tax);
    
        $this->total = max($this->subtotal - $this->totalDiscount + $this->freight + $this->tax, 0);
    }
    
    public function updatedFreight()
    {
        if (empty($this->freight) || !is_numeric($this->freight)) {
            $this->freight = 0;
        } else {
            $this->freight = floatval($this->freight);
        }
    
        $this->calculateFinalTotal();
    }

    public function updatedTax()
    {
        if (empty($this->tax) || !is_numeric($this->tax)) {
            $this->tax = 0;
        } else {
            $this->tax = floatval($this->tax);
        }
    
        $this->calculateFinalTotal();
    }

    public function removeOrderDetail($index)
    {
        unset($this->orderDetails[$index]);
        $this->orderDetails = array_values($this->orderDetails);
        $this->calculateTotals();
    }

    public function submitOrder()
    {
        $this->validate();
        $this->isSubmitting = true;

        try {
            foreach ($this->orderDetails as $detail) {
                if ($detail['product_id'] != 1) {
                    $totalAvailable = Inventory::where('product_code', $detail['product_id'])
                        ->sum('remaining');

                    if ($totalAvailable < $detail['quantity']) {
                        $product = Product::find($detail['product_id']);
                        $productName = $product ? $product->name : "Product #{$detail['product_id']}";
                        notyf()->error("Insufficient inventory for {$productName}. Available: {$totalAvailable}, Requested: {$detail['quantity']}");
                        throw new \Exception("Insufficient inventory");
                    }
                }
            }

            DB::transaction(function () {
                $currentUserId = Auth::id();

                if (!$currentUserId) {
                    throw new \Exception('No authenticated user found');
                }

                $invoiceNumber = OrderMaster::generateOrderNumber();

                $orderData = [
                    'order_number' => $invoiceNumber,
                    'customer_id' => $this->customer_id,
                    'entity_id' => $this->entity_id,
                    'shipping_address' => $this->shipping_address,
                    'order_date' => $this->order_date,
                    'subtotal' => $this->subtotal,
                    'discount' => $this->totalDiscount,
                    'freight' => $this->freight,
                    'actual_freight' => $this->actual_freight,
                    'tax' => $this->tax,
                    'total' => $this->total,
                    'payment_mode' => $this->payment_mode,
                    'invoice_status' => $this->invoice_status,
                    'remarks' => $this->remarks,
                    'payment_terms' => $this->payment_terms,
                    'delivery_status' => $this->delivery_status,
                    'created_by' => $currentUserId,
                    'modified_by' => $currentUserId,
                    'is_generated' => false,
                    'workflow_type' => $this->workflow_type,
                ];

                /* if ($this->workflow_type === 'consignment') {
                    $orderData['subtotal'] = 0;
                    $orderData['freight'] = 0;
                    $orderData['tax'] = 0;
                    $orderData['total'] = 0;
                } */

                $order = OrderMaster::create($orderData);

                foreach ($this->orderDetails as $detail) {
                    $regularQuantity = floatval($detail['quantity']) - floatval($detail['sample_quantity'] ?? 0);
                    Log::info('Order Detail Values:', [
                        'quantity' => $detail['quantity'],
                        'remaining_quantity' => $detail['quantity'],
                        'detail_array' => $detail
                    ]);

                    $orderDetail = [
                        'product_id' => $detail['product_id'],
                        'manual_product_name' => $detail['product_id'] == 1 ? $detail['manual_product_name'] : null,
                        'quantity' => $detail['quantity'],
                        'unit_price' => $detail['unit_price'],
                        'remaining_quantity' => $detail['quantity'],
                        'invoice_rem' => $detail['quantity'],
                        'sample_quantity' => $detail['sample_quantity'] ?? 0,
                        'sample_quantity_remaining' => $detail['sample_quantity'] ?? 0,
                        'invoice_rem_sample' => $detail['sample_quantity'] ?? 0,
                        'total' => $detail['total'],
                    ];

                    Log::info('Final Order Detail Array:', $orderDetail);
                    $order->orderDetails()->create($orderDetail);
                }

                /* if ($customer = Customer::find($this->customer_id)) {
                    Mail::to($customer->email)->send(new OrderConfirmation($order, $customer));
                } */
                $this->generateInvoice($order->order_id);
            });

            notyf()->success('Order created successfully and confirmation email sent.');
            $this->reset(['orderDetails', 'customer_id', 'shipping_address', 'subtotal', 'totalDiscount', 'tax','freight', 'total', 'order_date', 'remarks']);
            $this->addOrderDetail();
            $this->isSubmitting = false;

            return redirect()->route('admin.orders.index');
        } catch (\Exception $e) {
            $this->isSubmitting = false;
            Log::error('Order creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'orderDetails' => $this->orderDetails,
                'customer_id' => $this->customer_id,
                'shipping_address' => $this->shipping_address,
                'order_date' => $this->order_date,
                'subtotal' => $this->subtotal,
                'totalDiscount' => $this->totalDiscount,
                'tax' => $this->tax,
                'total' => $this->total,
                'payment_mode' => $this->payment_mode,
                'invoice_status' => $this->invoice_status,
                'remarks' => $this->remarks,
                'payment_terms' => $this->payment_terms,
                'delivery_status' => $this->delivery_status,
                'created_by' => Auth::id(),
                'workflow_type' => $this->workflow_type,
            ]);

            if ($e->getMessage() !== "Insufficient inventory") {
                notyf()->error('An error occurred while creating the order. Check logs for details.');
            }
        }
    }
    
    public function generateInvoice($order_id)
    {
        $order = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
            ->where('order_id', $order_id)
            ->firstOrFail();

        $this->generateInvoiceWithWorkflow($order_id, $order->workflow_type);
    }

    public function generateInvoiceWithWorkflow($order_id, $workflow_type)
    {
        DB::beginTransaction();
        try {
            $order = OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
                ->where('order_id', $order_id)
                ->firstOrFail();

            $invoiceNumber = $this->generateUniqueInvoiceNumber();
            $workflowType = strtolower($workflow_type->value);
            $invoiceData = [
                'invoice_number' => $invoiceNumber,
                'order_id' => $order->order_id,
                'customer_id' => $order->customer_id,
                'entity_id' => $order->entity_id,
                'shipping_address' => $order->shipping_address,
                'subtotal' => $order->subtotal,
                'discount' => $order->discount,
                'freight' => $order->freight,
                'tax' => $order->tax,
                'total' => $order->total,
                'remarks' => $order->remarks,
                'payment_terms' => $order->payment_terms,
                'status' => 'Confirmed',
                'created_by' => Auth::id(),
                'invoice_type' => $this->determineInvoiceType($order)
            ];
            $invoice = OrderInvoice::create($invoiceData);

            $invoiceDetails = [];
            foreach ($order->orderDetails as $orderDetail) {
                $invoiceDetails[] = [
                    'order_invoice_id' => $invoice->id,
                    'product_id' => $orderDetail->product_id,
                    'unit_price' =>  $orderDetail->unit_price,
                    'quantity' => $orderDetail->quantity,
                    'delivered_quantity' =>  $orderDetail->quantity,
                    'invoiced_quantity' =>  $orderDetail->quantity,
                    'discount' =>  $orderDetail->discount,
                    'total' =>  $orderDetail->total,
                    'manual_product_name' => $orderDetail->manual_product_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            OrderInvoiceDetail::insert($invoiceDetails);

            $order->update([
                'is_generated' => true,
                'modified_by' => Auth::id()
            ]);

            DB::commit();

            //notyf()->success('Invoice generated successfully with number: ' . $invoiceNumber);
            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Invoice generation failed: ' . $e->getMessage());
            notyf()->error('Could not generate invoice: ' . $e->getMessage());
            return null;
        }
    }
    
    protected function generateUniqueInvoiceNumber()
    {
        do {
            $prefix = 'INV-' . now()->format('Ymd') . '-';
            $randomSuffix = Str::random(4);
            $invoiceNumber = $prefix . $randomSuffix;
        } while (OrderInvoice::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    protected function determineInvoiceType($order)
    {
        if ($order->workflow_type === 'consignment') {
            return 'consignment';
        }

        if ($order->workflow_type === 'multi_delivery') {
            return 'consignment';
        }

        if ($order->parent_order_id !== null) {
            return 'split_delivery';
        }

        return 'regular';
    }
    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.create-order');
    }
}
