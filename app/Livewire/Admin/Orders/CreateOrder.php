<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\OrderMaster;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CreateOrder extends Component
{
    public $customers;
    public $products;
    public $orderDetails = [];
    public $invoice_date, $customer_id, $shipping_address, $subtotal, $discount, $tax, $total;

    public function mount()
    {
        $this->customers = Customer::all();
        $this->products = Product::all();
        $this->subtotal = 0;
        $this->discount = 0;
        $this->tax = 0;
        $this->total = 0;
        $this->addOrderDetail();
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

    public function removeOrderDetail($index)
    {
        unset($this->orderDetails[$index]);
        $this->orderDetails = array_values($this->orderDetails);
        $this->calculateSubtotal();
    }

    public function updatedOrderDetails($field, $value)
    {
        Log::info("updatedOrderDetails called", ['field' => $field, 'value' => $value]);

        $index = explode('.', $field)[1] ?? null;
        $fieldName = explode('.', $field)[2] ?? null;
        
        if ($fieldName === 'id') {
            Log::info("Calling fetchUnitPrice", ['index' => $index, 'id' => $value]);
            $this->fetchUnitPrice($index, $value);
        }

        if ($fieldName === 'quantity' || $fieldName === 'discount') {
            $this->calculateTotal($index);
        }

        $this->calculateSubtotal();
    }

    public function fetchUnitPrice($index, $id)
    {
        Log::info("fetchUnitPrice called", ['index' => $index, 'id' => $id]);

        $product = Product::find($id);
        if ($product) {
            Log::info("Product found", ['unitPrice' => $product->unit_price]);
            $this->orderDetails[$index]['unit_price'] = $product->unit_price;
            $this->calculateTotal($index);
        } else {
            Log::warning("Product not found", ['id' => $id]);
            $this->orderDetails[$index]['unit_price'] = 0;
        }
    }

    private function calculateTotal($index)
    {
        $quantity = $this->orderDetails[$index]['quantity'] ?? 0;
        $unit_price = $this->orderDetails[$index]['unit_price'] ?? 0;
        $discount = $this->orderDetails[$index]['discount'] ?? 0;

        $total = ($quantity * $unit_price) - $discount;
        $this->orderDetails[$index]['total'] = max($total, 0);
    }

    private function calculateSubtotal()
    {
        $this->subtotal = array_sum(array_column($this->orderDetails, 'total'));
        $this->calculateFinalTotal();
    }

    private function calculateFinalTotal()
    {
        $this->total = $this->subtotal - $this->discount + $this->tax;
        $this->total = max($this->total, 0);
    }

    public function render()
    {
        return view('livewire.admin.orders.create-order');
    }
}
