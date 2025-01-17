<?php

namespace App\Livewire\Frontend;

use App\Mail\OrderConfirmation;
use App\Mail\UserOrderConfirmation;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{
    public $billingAddress;
    public $shippingAddresses = [];
    public $selectedShippingAddress;
    public $useBillingAddress = true; // Default to checked

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
        $this->loadShippingAddresses(); // Fetch shipping addresses
        $this->updateCart();
    }

    private function loadShippingAddresses()
    {
        if ($this->user) {
            $customer = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->select(
                    'shipping_address_receiver_name_1',
                    'shipping_address_1',
                    'shipping_country_1',
                    'shipping_postal_code_1',
                    'shipping_address_receiver_name_2',
                    'shipping_address_2',
                    'shipping_country_2',
                    'shipping_postal_code_2',
                    'shipping_address_receiver_name_3',
                    'shipping_address_3',
                    'shipping_country_3',
                    'shipping_postal_code_3'
                )
                ->first();

            $this->shippingAddresses = [
                [
                    'receiver_name' => $customer->shipping_address_receiver_name_1,
                    'address' => $customer->shipping_address_1,
                    'country' => $customer->shipping_country_1,
                    'postal_code' => $customer->shipping_postal_code_1,
                ],
                [
                    'receiver_name' => $customer->shipping_address_receiver_name_2,
                    'address' => $customer->shipping_address_2,
                    'country' => $customer->shipping_country_2,
                    'postal_code' => $customer->shipping_postal_code_2,
                ],
                [
                    'receiver_name' => $customer->shipping_address_receiver_name_3,
                    'address' => $customer->shipping_address_3,
                    'country' => $customer->shipping_country_3,
                    'postal_code' => $customer->shipping_postal_code_3,
                ]
            ];
        }
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
        if (!Auth::check()) {
            session()->flash('error', 'Please login to complete your order.');
            return redirect()->route('login');
        }

        $shippingAddress = $this->useBillingAddress
            ? $this->billingAddress->billing_address
            : request()->input('shipping_address'); // Assuming the form sends a shipping address via request

        try {
            DB::beginTransaction();

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
                'shipping_address' => $shippingAddress,
                'created_by' => $this->user->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            foreach ($this->cartItems as $productCode => $item) {
                $product = Product::where('product_code', $productCode)->first();

                if ($product) {
                    DB::table('order_details')->insert([
                        'order_id' => $orderId,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->unit_price,
                        'total' => $item['total'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            Mail::to($this->user->email)->send(new UserOrderConfirmation($orderNumber, $this->user));

            session()->forget('cart');

            $this->dispatch('cartCountUpdated');
            $this->dispatch('cart-updated');

            DB::commit();

            session()->flash('order_number', $orderNumber);
            $this->dispatch('show-thank-you-modal');

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
