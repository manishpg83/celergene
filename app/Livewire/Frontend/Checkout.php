<?php

namespace App\Livewire\Frontend;

use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderMaster;
use Illuminate\Support\Str;
use App\Models\OrderInvoice;
use App\Mail\OrderConfirmation;
use App\Models\OrderInvoiceDetail;
use Illuminate\Support\Facades\DB;
use App\Mail\UserOrderConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
    public $countries = [];

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

        $this->countries = DB::table('country')
            ->select('code', 'name')
            ->orderBy('name')
            ->get()
            ->toArray(); // Convert to array for better handling
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
    }


    public function handleAddressChange()
    {

        $selectedAddress = collect($this->shippingAddresses)->firstWhere('address', $this->selectedShippingAddress);

        if ($selectedAddress) {

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
        // Validate the form fields
        $this->validate([
            'billing_fname' => 'required',
            'billing_lname' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_state' => 'required',
            'billing_postal_code' => 'required',
            'billing_country' => 'required',
            'billing_phone' => 'required',
            'billing_email' => 'required|email',
        ], [
            'required' => 'The :attribute field is required.',
            'email' => 'Please enter a valid email address.'
        ]);

        // Add shipping validation if billing address isn't used for shipping
        if (!$this->useBillingAddress) {
            $this->validate([
                'shipping_firstname' => 'required',
                'shipping_lastname' => 'required',
                'shipping_address1' => 'required',
                'shipping_city' => 'required',
                'shipping_state' => 'required',
                'shipping_zip' => 'required',
                'shipping_country' => 'required',
                'shipping_phone' => 'required',
                'shipping_email' => 'required|email',
            ]);
        }

        try {
            DB::beginTransaction();

            if (Auth::check()) {
                $this->user = Auth::user();
                $this->user->update(['is_guest' => false]);

                $customer = Customer::where('user_id', $this->user->id)->first();
            } else {
                $existingUser = User::where('email', $this->billing_email)->first();

                if ($existingUser) {
                    $this->user = $existingUser;
                    if (!$this->user->is_guest) {
                        $this->user->update(['is_guest' => true]);
                    }
                    $customer = Customer::where('user_id', $this->user->id)->first();
                } else {
                    $this->user = User::create([
                        'name' => $this->billing_fname . ' ' . $this->billing_lname,
                        'email' => $this->billing_email,
                        'first_name' => $this->billing_fname,
                        'last_name' => $this->billing_lname,
                        'phone' => $this->billing_phone,
                        'adress' => $this->billing_address,
                        'city' => $this->billing_city,
                        'state' => $this->billing_state,
                        'password' => bcrypt(Str::random(8)),
                        'is_guest' => true,
                    ]);

                    $customer = Customer::create([
                        'user_id' => $this->user->id,
                        'customer_type_id' => 1,
                        'first_name' => $this->billing_fname,
                        'last_name' => $this->billing_lname,
                        'mobile_number' => $this->billing_phone,
                        'email' => $this->billing_email,
                        'billing_fname' => $this->billing_fname,
                        'billing_lname' => $this->billing_lname,
                        'billing_address' => $this->billing_address,
                        'billing_address_2' => $this->billing_address_2,
                        'billing_city' => $this->billing_city,
                        'billing_state' => $this->billing_state,
                        'billing_phone' => $this->billing_phone,
                        'billing_email' => $this->billing_email,
                        'billing_country' => $this->billing_country,
                        'billing_postal_code' => $this->billing_postal_code,
                        'created_by' => 1,
                        'updated_by' => 1
                    ]);
                }
            }
            if ($customer) {
                $customer->update([
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
            }
            $orderNumber = OrderMaster::generateOrderNumber();

            $shippingAddress = $this->useBillingAddress
                ? ($this->billing_address ?? 'N/A')
                : ($this->shipping_address1 ?? 'N/A');

            $orderId = DB::table('order_master')->insertGetId([
                'order_number' => $orderNumber,
                'customer_id' => $customer->id,
                'entity_id' => 1,
                'currency_id' => 1,
                'order_date' => now(),
                'subtotal' => $this->subtotal,
                'total' => $this->subtotal,
                'order_status' => 'Pending',
                'order_type' => 'Online',
                'payment_mode' => 'Credit Card',
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

            $this->generateInvoice($orderId);

            $this->redirectToPaypal($orderId, $orderNumber);

            session()->forget('cart');
            $this->dispatch('cartCountUpdated');
            $this->dispatch('cart-updated');

            DB::commit();

            session()->flash('order_number', $orderNumber);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Processing Error', ['error' => $e->getMessage()]);
            session()->flash('error', 'Order processing error: ' . $e->getMessage());
            return null;
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

            $orderInvoiceNumber = $this->generateUniqueInvoiceNumber('regular');
            $orderInvoiceData = [
                'invoice_number' => $orderInvoiceNumber,
                'invoice_date' => now(),
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
                'created_by' => Auth::id() ?? 1,
                'invoice_type' => 'regular',
                'invoice_category' => 'regular'
            ];
            $orderInvoice = OrderInvoice::create($orderInvoiceData);

            $invoiceDetails = [];
            foreach ($order->orderDetails as $orderDetail) {
                $invoiceDetails[] = [
                    'order_invoice_id' => $orderInvoice->id,
                    'product_id' => $orderDetail->product_id,
                    'unit_price' => $orderDetail->unit_price,
                    'quantity' => $orderDetail->quantity,
                    'sample_quantity' => 0,
                    'delivered_quantity' => $orderDetail->quantity,
                    'invoiced_quantity' => $orderDetail->quantity,
                    'discount' => 0,
                    'total' => $orderDetail->total,
                    'manual_product_name' => $orderDetail->manual_product_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            OrderInvoiceDetail::insert($invoiceDetails);

            $shippingInvoiceNumber = $this->generateUniqueInvoiceNumber('shipping');
            $shippingInvoiceData = $orderInvoiceData;
            $shippingInvoiceData['invoice_number'] = $shippingInvoiceNumber;
            $shippingInvoiceData['invoice_category'] = 'shipping';
            $shippingInvoice = OrderInvoice::create($shippingInvoiceData);
            $shippingUnitPrice = getShippingUnitPrice();

            $shippingInvoiceDetails = [];
            foreach ($order->orderDetails as $orderDetail) {
                $shippingInvoiceDetails[] = [
                    'order_invoice_id' => $shippingInvoice->id,
                    'product_id' => $orderDetail->product_id,
                    'unit_price' => $shippingUnitPrice,
                    'quantity' => $orderDetail->quantity,
                    'sample_quantity' => 0,
                    'delivered_quantity' => $orderDetail->quantity,
                    'invoiced_quantity' => $orderDetail->quantity,
                    'discount' => 0.00,
                    'total' => $shippingUnitPrice * $orderDetail->quantity,
                    'manual_product_name' => $orderDetail->manual_product_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            OrderInvoiceDetail::insert($shippingInvoiceDetails);

            $order->update([
                'is_generated' => true,
                'modified_by' => Auth::id()
            ]);

            DB::commit();

            return [
                'order_invoice' => $orderInvoice,
                'shipping_invoice' => $shippingInvoice
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Invoice generation failed: ' . $e->getMessage());
            return null;
        }
    }


    protected function generateUniqueInvoiceNumber($category = 'regular')
    {
        do {
            $prefix = ($category === 'shipping') ? 'SHIP-' : 'INV-';
            $invoiceNumber = $prefix . now()->format('Ymd') . '-' . Str::random(4);
        } while (OrderInvoice::where('invoice_number', $invoiceNumber)->exists());
        return $invoiceNumber;
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
                Log::info('PayPal Order Creation');
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

                Log::info('PayPal Approve Link:', ['link' => $approveLink]);

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
