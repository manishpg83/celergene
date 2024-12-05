<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Stock;
use App\Models\Entity;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\OrderMaster;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use App\Rules\UniqueProductInOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Enums\OrderWorkflowType;

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
    public float $tax = 0;
    public float $total = 0;
    public float $freight = 0;
    public $payment_mode = 'Credit Card';
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
            'workflow_type' => 'required|string|in:' . implode(',', array_keys(OrderWorkflowType::options())),
        ];

        if ($this->workflow_type === OrderWorkflowType::MULTI_DELIVERY->value) {
            $rules['orderDetails.*.delivery_date'] = 'required|date|after_or_equal:order_date';
        }

        if ($this->workflow_type === OrderWorkflowType::CONSIGNMENT->value) {
            $rules['orderDetails.*.consignment_terms'] = 'required|string|max:255';
        }

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
        $this->addOrderDetail();

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
        $country = $customer["shipping_country_{$index}"];
        $postalCode = $customer["shipping_postal_code_{$index}"];

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
        ];

        if ($this->workflow_type === OrderWorkflowType::MULTI_DELIVERY->value) {
            $newDetail['delivery_date'] = '';
        }
        if ($this->workflow_type === OrderWorkflowType::CONSIGNMENT->value) {
            $newDetail['consignment_terms'] = '';
        }

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
            $quantity = floatval($detail['quantity']);
            $unitPrice = floatval($detail['unit_price']);
            $discount = floatval($detail['discount']);

            $this->subtotal += $quantity * $unitPrice;
            $this->totalDiscount += $discount;

            $this->orderDetails[$index]['total'] = max(($quantity * $unitPrice) - $discount, 0);
        }

        $this->calculateFinalTotal();
    }

    private function calculateFinalTotal()
    {
        $this->total = max($this->subtotal - $this->totalDiscount + $this->freight + $this->tax, 0);
    }

    public function updatedTax()
    {
        $this->tax = floatval($this->tax);
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
            // Check inventory availability first
            foreach ($this->orderDetails as $detail) {
                if ($detail['product_id'] != 1) { // Skip check for custom products
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

                $order = OrderMaster::create([
                    'order_number' => $invoiceNumber,
                    'customer_id' => $this->customer_id,
                    'entity_id' => $this->entity_id,
                    'shipping_address' => $this->shipping_address,
                    'order_date' => $this->order_date,
                    'subtotal' => $this->subtotal,
                    'discount' => $this->totalDiscount,
                    'freight' => $this->freight,
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
                ]);
                
                foreach ($this->orderDetails as $detail) {
                    // Add debugging log
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
                        'discount' => $detail['discount'],  
                        'total' => $detail['total'],
                    ];

                    // Add another log to verify the final array
                    Log::info('Final Order Detail Array:', $orderDetail);

                    $order->orderDetails()->create($orderDetail);
                }

                if ($customer = Customer::find($this->customer_id)) {
                    Mail::to($customer->email)->send(new OrderConfirmation($order, $customer));
                }
            });

            notyf()->success('Order created successfully and confirmation email sent.');
            $this->reset(['orderDetails', 'customer_id', 'shipping_address', 'subtotal', 'totalDiscount', 'tax', 'total', 'order_date', 'remarks']);
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

    public function back()
    {
        return redirect()->route('admin.orders.index');
    }

    public function render()
    {
        return view('livewire.admin.orders.create-order');
    }
}
