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
use App\Models\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class Checkout extends Component
{
    public $billingAddress;
    public $shippingAddresses = [];
    public $selectedShippingAddress;
    public $useBillingAddress = true;
    public $billing_address;
    public $billing_address_2;
    public $billing_city;
    public $billing_state;
    public $billing_phone;
    public $billing_email;
    public $billing_company_name;
    public $billing_country;
    public $billing_postal_code;
    public $billing_fname;
    public $billing_lname;
    public $shipping_firstname;
    public $shipping_lastname;
    public $shipping_company_name;
    public $shipping_address1;
    public $shipping_address2;
    public $shipping_city;
    public $shipping_zip;
    public $shipping_country;
    public $shipping_state;
    public $shipping_email;
    public $shipping_phone;
    public $shipping_notes;

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
        $this->loadShippingAddresses();
        $this->updateCart();
    }

    private function loadShippingAddresses()
    {
        if ($this->user) {
            $customer = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->select(
                    'shipping_address_receiver_name_1',
                    'shipping_address_receiver_lname_1',
                    'shipping_address_1',
                    'shipping_address_1_1',
                    'shipping_city_1',
                    'shipping_state_1',
                    'shipping_phone_1',
                    'shipping_email_1',
                    'shipping_company_name_1',
                    'shipping_country_1',
                    'shipping_postal_code_1',
                    'shipping_address_receiver_name_2',
                    'shipping_address_receiver_lname_2',
                    'shipping_address_2',
                    'shipping_address_2_1',
                    'shipping_city_2',
                    'shipping_state_2',
                    'shipping_phone_2',
                    'shipping_email_2',
                    'shipping_company_name_2',
                    'shipping_country_2',
                    'shipping_postal_code_2',
                    'shipping_address_receiver_name_3',
                    'shipping_address_receiver_lname_3',
                    'shipping_address_3',
                    'shipping_address_3_1',
                    'shipping_city_3',
                    'shipping_state_3',
                    'shipping_phone_3',
                    'shipping_email_3',
                    'shipping_company_name_3',
                    'shipping_country_3',
                    'shipping_postal_code_3'
                )
                ->first();

            $this->shippingAddresses = [
                [
                    'receiver_name' => $customer->shipping_address_receiver_name_1,
                    'receiver_name2' => $customer->shipping_address_receiver_lname_1,
                    'address' => $customer->shipping_address_1,
                    'address_2' => $customer->shipping_address_1_1,
                    'city' => $customer->shipping_city_1,
                    'state' => $customer->shipping_state_1,
                    'phone' => $customer->shipping_phone_1,
                    'shipping_email' => $customer->shipping_email_1,
                    'shipping_company_name' => $customer->shipping_company_name_1,
                    'country' => $customer->shipping_country_1,
                    'postal_code' => $customer->shipping_postal_code_1,
                ],
                [
                    'receiver_name' => $customer->shipping_address_receiver_name_2,
                    'receiver_name2' => $customer->shipping_address_receiver_lname_2,
                    'address' => $customer->shipping_address_2,
                    'address_2' => $customer->shipping_address_2_1,
                    'city' => $customer->shipping_city_2,
                    'state' => $customer->shipping_state_2,
                    'phone' => $customer->shipping_phone_2,
                    'shipping_email' => $customer->shipping_email_2,
                    'shipping_company_name' => $customer->shipping_company_name_2,
                    'country' => $customer->shipping_country_2,
                    'postal_code' => $customer->shipping_postal_code_2,
                ],
                [
                    'receiver_name' => $customer->shipping_address_receiver_name_3,
                    'receiver_name2' => $customer->shipping_address_receiver_lname_3,
                    'address' => $customer->shipping_address_3,
                    'address_2' => $customer->shipping_address_3_1,
                    'city' => $customer->shipping_city_3,
                    'state' => $customer->shipping_state_3,
                    'phone' => $customer->shipping_phone_3,
                    'shipping_email' => $customer->shipping_email_3,
                    'shipping_company_name' => $customer->shipping_company_name_3,
                    'country' => $customer->shipping_country_3,
                    'postal_code' => $customer->shipping_postal_code_3,
                ]
            ];
        }
        Log::debug("Shipping Addresses Loaded: ", $this->shippingAddresses);
    }


    public function handleAddressChange()
    {
        Log::debug("Selected Shipping Address Value: " . $this->selectedShippingAddress);

        $selectedAddress = collect($this->shippingAddresses)->firstWhere('address', $this->selectedShippingAddress);

        if ($selectedAddress) {
            Log::debug("Selected Address: ", $selectedAddress);

            $this->shipping_firstname = $selectedAddress['receiver_name'];
            $this->shipping_lastname = $selectedAddress['receiver_name2'];
            $this->shipping_company_name = $selectedAddress['shipping_company_name'];
            $this->shipping_email = $selectedAddress['shipping_email'];
            $this->shipping_address1 = $selectedAddress['address'];
            $this->shipping_address2 = $selectedAddress['address_2'] ?? '';
            $this->shipping_city = $selectedAddress['city'];
            $this->shipping_zip = $selectedAddress['postal_code'];
            $this->shipping_country = $selectedAddress['country'];
            $this->shipping_state = $selectedAddress['state'] ?? '';
            $this->shipping_phone = $selectedAddress['phone'] ?? '';
            $this->shipping_notes = '';
        }
    }

    private function loadBillingAddress()
    {
        if ($this->user) {
            $this->billingAddress = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->select(
                    'billing_address',
                    'billing_address_2',
                    'billing_city',
                    'billing_state',
                    'billing_phone',
                    'billing_email',
                    'billing_company_name',
                    'billing_country',
                    'billing_postal_code',
                    'billing_fname',
                    'billing_lname'
                )
                ->first();
            if ($this->billingAddress) {
                $this->billing_address = $this->billingAddress->billing_address ?? '';
                $this->billing_address_2 = $this->billingAddress->billing_address_2 ?? '';
                $this->billing_city = $this->billingAddress->billing_city ?? '';
                $this->billing_state = $this->billingAddress->billing_state ?? '';
                $this->billing_phone = $this->billingAddress->billing_phone ?? '';
                $this->billing_email = $this->billingAddress->billing_email ?? '';
                $this->billing_company_name = $this->billingAddress->billing_company_name ?? '';
                $this->billing_country = $this->billingAddress->billing_country ?? '';
                $this->billing_postal_code = $this->billingAddress->billing_postal_code ?? '';
                $this->billing_fname = $this->billingAddress->billing_fname ?? '';
                $this->billing_lname = $this->billingAddress->billing_lname ?? '';
            }
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

        foreach ($this->cartItems as $productCode => &$item) {
            $product = Product::where('product_code', $productCode)->first();
            if ($product && isset($item['quantity'])) {
                $item['total'] = $product->unit_price * $item['quantity'];
                $this->subtotal += $item['total'];
            }
        }

        $this->total = $this->subtotal;
    }

    public function processOrder()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to complete your order.');
            return redirect()->route('login');
        }

        $shippingAddress = $this->useBillingAddress
            ? ($this->billing_address ?? 'N/A')
            : ($this->shipping_address1 ?? 'N/A');

        try {
            DB::beginTransaction();

            if ($this->useBillingAddress) {
                DB::table('customers')
                    ->where('user_id', $this->user->id)
                    ->update([
                        'shipping_address_receiver_name_3' => $this->billing_fname,
                        'shipping_address_receiver_lname_3' => $this->billing_lname,
                        'shipping_address_3' => $this->billing_address,
                        'shipping_email_3' => $this->billing_email,
                        'shipping_company_name_3' => $this->billing_company_name,
                        'shipping_address_3_1' => $this->billing_address_2,
                        'shipping_city_3' => $this->billing_city,
                        'shipping_state_3' => $this->billing_state,
                        'shipping_phone_3' => $this->billing_phone,
                        'shipping_country_3' => $this->billing_country,
                        'shipping_postal_code_3' => $this->billing_postal_code,
                    ]);
            } else {
                DB::table('customers')
                    ->where('user_id', $this->user->id)
                    ->update([
                        'shipping_address_receiver_name_3' => $this->shipping_firstname,
                        'shipping_address_receiver_lname_3' => $this->shipping_lastname,
                        'shipping_address_3' => $this->shipping_address1,
                        'shipping_email_3' => $this->shipping_email,
                        'shipping_company_name_3' => $this->shipping_companyname,
                        'shipping_address_3_1' => $this->shipping_address2,
                        'shipping_city_3' => $this->shipping_city,
                        'shipping_state_3' => $this->shipping_state,
                        'shipping_phone_3' => $this->shipping_phone,
                        'shipping_country_3' => $this->shipping_country,
                        'shipping_postal_code_3' => $this->shipping_zip,
                    ]);
            }

            DB::table('customers')
                ->where('user_id', $this->user->id)
                ->update([
                    'billing_fname' => $this->billing_fname,
                    'billing_lname' => $this->billing_lname,
                    'billing_address' => $this->billing_address,
                    'billing_address_2' => $this->billing_address_2,
                    'billing_city' => $this->billing_city,
                    'billing_state' => $this->billing_state,
                    'billing_phone' => $this->billing_phone,
                    'billing_email' => $this->billing_email,
                    'billing_company_name' => $this->billing_company_name,
                    'billing_country' => $this->billing_country,
                    'billing_postal_code' => $this->billing_postal_code,
                ]);

            $customer = DB::table('customers')
                ->where('user_id', $this->user->id)
                ->first();

            $orderNumber = 'ORD-' . Str::random(10);
            $orderId = DB::table('order_master')->insertGetId([
                'order_number' => $orderNumber,
                'customer_id' => $customer->id,
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
            $this->redirectToPaypal($orderId, $orderNumber);
            session()->forget('cart');

            $this->dispatch('cartCountUpdated');
            $this->dispatch('cart-updated');

            DB::commit();

            session()->flash('order_number', $orderNumber);
            $this->dispatch('show-thank-you-modal');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Order processing error: ' . $e->getMessage());
            Log::error('Order Processing Error: ' . $e->getMessage());
            return null;
        }
    }

    private function redirectToPaypal($orderId, $orderNumber)
    {
        try {
            $provider = new PayPalClient;

            $provider->getAccessToken();

            $order = [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
                'purchase_units' => [
                    [
                        'reference_id' => $orderNumber,
                        'amount' => [
                            'currency_code' => config('paypal.currency', 'USD'),
                            'value' => number_format($this->total, 2, '.', ''),
                        ],
                        'description' => "Order #{$orderNumber}",
                    ]
                ]
            ];

            $response = $provider->createOrder($order);

            Log::info('PayPal Order Creation Response:', ['response' => $response]);

            if (isset($response['id']) && $response['id']) {
                Payment::create([
                    'order_id' => $orderId,
                    'payment_method' => 'PayPal',
                    'transaction_id' => $response['id'],
                    'amount' => $this->total,
                    'currency' => config('paypal.currency', 'USD'),
                    'status' => 'pending',
                ]);

                $approveLink = collect($response['links'])
                    ->firstWhere('rel', 'approve')['href'] ?? null;

                if ($approveLink) {
                    return redirect($approveLink);
                }
            }

            throw new \Exception('Failed to create PayPal order: ' . json_encode($response));
        } catch (\Exception $e) {
            Log::error('PayPal Integration Error: ' . $e->getMessage(), [
                'order_id' => $orderId,
                'order_number' => $orderNumber,
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Payment processing failed. Please try again later.');
            return redirect()->route('checkout.error');
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
