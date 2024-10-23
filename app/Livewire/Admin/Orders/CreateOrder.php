<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class CreateOrder extends Component
{
    public $customers;
    public $products;
    public $orderDetails = [];
    public $customer_id;
    public $shipping_address;
    public float $subtotal = 0;
    public float $totalDiscount = 0;
    public float $tax = 0;
    public float $total = 0;
    public $payment_mode = 'Credit Card';
    public $invoice_status = 'Pending';
    public $selected_shipping_address = 1;
    public $shipping_addresses = [];

    protected $rules = [
        'customer_id' => 'required',
        'shipping_address' => 'required',
        'orderDetails' => 'required|array|min:1',
        'orderDetails.*.product_id' => 'required',
        'orderDetails.*.quantity' => 'required|numeric|min:1',
        'orderDetails.*.unit_price' => 'required|numeric|min:0',
        'orderDetails.*.discount' => 'required|numeric|min:0',
        'tax' => 'required|numeric|min:0',
        'payment_mode' => 'required|in:Credit Card,Bank Transfer,Cash',
        'invoice_status' => 'required|in:Pending,Paid,Cancelled',
        'selected_shipping_address' => 'required|in:1,2,3',
    ];

    public function mount()
    {
        $this->customers = Customer::all();
        $this->products = Product::all();
        $this->addOrderDetail();
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
            } else {
            }
            $this->updateShippingAddress();
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

        foreach ($this->orderDetails as $detail) {
            $quantity = floatval($detail['quantity']);
            $unitPrice = floatval($detail['unit_price']);
            $discount = floatval($detail['discount']);

            $this->subtotal += $quantity * $unitPrice;
            $this->totalDiscount += $discount;

            $total = ($quantity * $unitPrice) - $discount;
            $detail['total'] = max($total, 0);
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

        try {
            DB::transaction(function () {
                $order = OrderMaster::create([
                    'customer_id' => $this->customer_id,
                    'shipping_address' => $this->shipping_address,
                    'invoice_date' => now(),
                    'subtotal' => $this->subtotal,
                    'discount' => $this->totalDiscount,
                    'tax' => $this->tax,
                    'total' => $this->total,
                    'payment_mode' => $this->payment_mode,
                    'invoice_status' => $this->invoice_status,
                ]);

                foreach ($this->orderDetails as $detail) {
                    $order->orderDetails()->create([
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity'],
                        'unit_price' => $detail['unit_price'],
                        'discount' => $detail['discount'],
                        'total' => $detail['total'],
                    ]);
                }
            });

            session()->flash('message', 'Order created successfully.');
            $this->reset(['orderDetails', 'customer_id', 'shipping_address', 'subtotal', 'totalDiscount', 'tax', 'total']);
            $this->addOrderDetail();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating the order: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.orders.create-order');
    }
}
