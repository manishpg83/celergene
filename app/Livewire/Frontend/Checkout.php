<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Checkout extends Component
{
    public $billingAddress;
    public $user;
    public $cartItems = [];
    public $subtotal = 0;
    public $total = 0;
    
    protected $listeners = [
        'receiveCartData',
        'cartUpdated' => 'updateCart',
        'cart-updated' => 'updateCart'
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadBillingAddress();
        $this->updateCart();
    }

    private function loadBillingAddress()
    {
        if ($this->user) {
            $this->billingAddress = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->select(
                    'billing_address',
                    'billing_country',
                    'billing_postal_code',
                    'first_name',
                    'last_name',
                    'mobile_number',
                    'email',
                    'company_name'
                )
                ->first();
        }
    }

    public function updateCart()
    {
        $cart = session()->get('cart', []);
        $this->cartItems = is_array($cart) ? $cart : [];
        $this->calculateTotals();
    }

    public function receiveCartData($data)
    {
        $this->cartItems = $data;
        $this->calculateTotals();
    }

    private function calculateTotals()
{
    $this->subtotal = 0;

    foreach ($this->cartItems as $productCode => &$item) { // Use reference to modify the cart item
        $product = Product::where('product_code', $productCode)->first();
        if ($product && isset($item['quantity'])) {
            $item['total'] = $product->unit_price * $item['quantity']; // Add 'total' to the cart item
            $this->subtotal += $item['total']; // Add the item total to the subtotal
        }
    }

    $this->total = $this->subtotal; // Add tax/shipping calculations here if needed
}


    public function processOrder()
    {
        // Validate user is logged in
        if (!Auth::check()) {
            session()->flash('error', 'Please login to complete your order.');
            return redirect()->route('login');
        }

        try {
            DB::beginTransaction();

            // Create Order Master
            $orderNumber = 'ORD-' . Str::random(10);
            $orderId = DB::table('order_master')->insertGetId([
                'order_number' => $orderNumber,
                'customer_id' => $this->user->id,
                'entity_id' => 1,
                'order_date' => now(),
                'subtotal' => $this->subtotal,
                'total' => $this->subtotal,
                'order_status' => 'pending',
                'order_type' => 'Regular',
                'shipping_address' => $this->billingAddress->billing_address,
                'created_by' => $this->user->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create Order Details
            foreach ($this->cartItems as $productCode => $item) {
                $product = Product::where('product_code', $productCode)->first();
                
                if ($product) {
                    DB::table('order_details')->insert([
                        'order_id' => $orderId,
                        'product_id' => $product->id,                       
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->unit_price,
                        'total' => $this->total,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Clear the cart after successful order
            session()->forget('cart');
            
            // Dispatch events to update cart components
            $this->dispatch('cartCountUpdated');
            $this->dispatch('cart-updated');

            DB::commit();

            // Redirect to order confirmation
            session()->flash('success', 'Order placed successfully! Your order number is ' . $orderNumber);
            return redirect()->route('order.confirmation', ['orderNumber' => $orderNumber]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'There was an error processing your order. Please try again.');
            Log::error('Order Processing Error: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.frontend.checkout', [
            'billingAddress' => $this->billingAddress,
            'cartItems' => $this->cartItems
        ]);
    }
}