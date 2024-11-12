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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    public $invoice_date;
    public $remarks;
    public float $subtotal = 0;
    public float $totalDiscount = 0;
    public float $tax = 0;
    public float $total = 0;
    public $payment_mode = 'Credit Card';
    public $invoice_status = 'Pending';
    public $selected_shipping_address = 1;
    public $shipping_addresses = [];

    protected $rules = [
        'customer_id' => 'required|exists:customers,id',
        'entity_id' => 'required|exists:entities,id',
        'shipping_address' => 'required|string',
        'orderDetails' => 'required|array|min:1',
        'orderDetails.*.product_id' => 'required|exists:products,id',
        'orderDetails.*.quantity' => 'required|numeric|min:1',
        'orderDetails.*.unit_price' => 'required|numeric|min:0',
        'orderDetails.*.discount' => 'required|numeric|min:0',
        'tax' => 'required|numeric|min:0',
        'payment_mode' => 'required|in:Credit Card,Bank Transfer,Cash',
        'invoice_status' => 'required|in:Pending,Paid,Cancelled',
        'selected_shipping_address' => 'required|in:1,2,3',
        'invoice_date' => 'required|date',
        'remarks' => 'nullable|string|max:1000',
        'payment_terms' => 'nullable|string|max:255',
        'delivery_status' => 'required|in:Pending,Shipped,Delivered,Cancelled',
    ];

    public function mount()
    {
        $this->customers = Customer::all();
        $this->entities = Entity::active()->get();
        $this->products = Product::all();
        $this->created_by = Auth::id();
        $this->modified_by = Auth::id();
        $this->addOrderDetail();

        $this->oldInvoiceStatus = $this->invoice_status;
        $this->oldDeliveryStatus = $this->delivery_status;
    }

    public function updatedCustomerId($value)
    {
        $this->updateShippingAddresses();
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
        $this->orderDetails[] = [
            'product_id' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'discount' => 0,
            'total' => 0,
        ];
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
        $product = Product::find($productId);
        $this->orderDetails[$index]['unit_price'] = $product ? $product->unit_price : 0;
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
        $this->total = max($this->subtotal - $this->totalDiscount + $this->tax, 0);
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
            DB::transaction(function () {
                $currentUserId = Auth::id();

                if (!$currentUserId) {
                    throw new \Exception('No authenticated user found');
                }

                $invoiceNumber = OrderMaster::generateInvoiceNumber();

                $order = OrderMaster::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $this->customer_id,
                    'entity_id' => $this->entity_id,
                    'shipping_address' => $this->shipping_address,
                    'invoice_date' => $this->invoice_date,
                    'subtotal' => $this->subtotal,
                    'discount' => $this->totalDiscount,
                    'tax' => $this->tax,
                    'total' => $this->total,
                    'payment_mode' => $this->payment_mode,
                    'invoice_status' => $this->invoice_status,
                    'remarks' => $this->remarks,
                    'payment_terms' => $this->payment_terms,
                    'delivery_status' => $this->delivery_status,
                    'created_by' => $currentUserId,
                    'modified_by' => $currentUserId,
                ]);

                foreach ($this->orderDetails as $detail) {
                    $order->orderDetails()->create([
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity'],
                        'unit_price' => $detail['unit_price'],
                        'discount' => $detail['discount'],
                        'total' => $detail['total'],
                    ]);

                    $inventory = Inventory::where('product_code', $detail['product_id'])
                        ->where('remaining', '>=', $detail['quantity'])
                        ->first();

                    if ($inventory) {
                        $newRemainingQuantity = $inventory->remaining - $detail['quantity'];
                        $inventory->update([
                            'consumed' => $inventory->consumed + $detail['quantity'],
                            'remaining' => $newRemainingQuantity,
                        ]);

                        Stock::create([
                            'inventory_id' => $inventory->id,
                            'product_id' => $detail['product_id'],
                            'previous_quantity' => $inventory->remaining,
                            'quantity_change' => -$detail['quantity'],
                            'new_quantity' => $newRemainingQuantity,
                            'reason' => 'Order Fulfillment',
                            'created_by' => $currentUserId,
                        ]);
                    } else {
                        throw new \Exception("Insufficient inventory for product ID: {$detail['product_id']}");
                    }
                }

                if ($customer = Customer::find($this->customer_id)) {
                    Mail::to($customer->email)->send(new OrderConfirmation($order, $customer));
                }
            });

            notyf()->success('Order created successfully and confirmation email sent.');
            $this->reset(['orderDetails', 'customer_id', 'shipping_address', 'subtotal', 'totalDiscount', 'tax', 'total', 'invoice_date', 'remarks']);
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
                'invoice_date' => $this->invoice_date,
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
            ]);
            
            notyf()->error('An error occurred while creating the order. Check logs for details.');
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
