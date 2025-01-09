<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class MyAccount extends Component
{
    public $user;
    public $customer;

    protected $listeners = [
        'deleteBillingAddress' => 'deleteBillingAddress',
        'deleteShippingAddress' => 'deleteShippingAddress'
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->customer = Customer::where('user_id', $this->user->id)->first();
    }

    public function deleteBillingAddress($customerId)
    {
        try {
            $customer = Customer::find($customerId);
    
            if (!$customer) {
                Log::error('Customer not found');
                return;
            }
    
            if ((int)$customer->user_id !== Auth::id()) {
                Log::error('User ID mismatch', [
                    'customer_user_id' => $customer->user_id,
                    'auth_user_id' => Auth::id()
                ]);
                return;
            }
    
            $result = $customer->update([
                'billing_address' => null,
                'billing_country' => null,
                'billing_postal_code' => null,
            ]);
    
            $this->customer = Customer::where('user_id', $this->user->id)->first();
            notyf()->success('Billing address deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in deleteBillingAddress:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    

    public function deleteShippingAddress($addressNumber)
    {
        try {
            $customer = Customer::where('user_id', Auth::id())->first();

            if (!$customer) {
                Log::error('Customer not found for shipping address deletion');
                return;
            }

            $updateData = [];
            switch ($addressNumber) {
                case 1:
                    $updateData = [
                        'shipping_address_receiver_name_1' => null,
                        'shipping_address_1' => null,
                        'shipping_country_1' => null,
                        'shipping_postal_code_1' => null
                    ];
                    break;
                case 2:
                    $updateData = [
                        'shipping_address_receiver_name_2' => null,
                        'shipping_address_2' => null,
                        'shipping_country_2' => null,
                        'shipping_postal_code_2' => null
                    ];
                    break;
                case 3:
                    $updateData = [
                        'shipping_address_receiver_name_3' => null,
                        'shipping_address_3' => null,
                        'shipping_country_3' => null,
                        'shipping_postal_code_3' => null
                    ];
                    break;
                default:
                    Log::error('Invalid address number: ' . $addressNumber);
                    return;
            }

            $result = $customer->update($updateData);

            if ($result) {
                $this->customer = Customer::where('user_id', Auth::id())->first();
                notyf()->success('Shipping address deleted successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Error in deleteShippingAddress:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.my-account', [
            'user' => $this->user,
            'customer' => $this->customer,
        ]);
    }
}
