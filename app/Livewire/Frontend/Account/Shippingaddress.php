<?php

namespace App\Livewire\Frontend\Account;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class Shippingaddress extends Component
{
    public function getAddresses()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        if (!$customer) {
            return [];
        }
    
        $addresses = [];
        
        for ($i = 1; $i <= 3; $i++) {
            $addressField = "shipping_address_{$i}";
            $nameField = "shipping_address_receiver_name_{$i}";
            $countryField = "shipping_country_{$i}";
            $postalField = "shipping_postal_code_{$i}";
            $phoneField = "shipping_phone_{$i}";
    
            if ($customer->$addressField) {
                $addresses[] = [
                    'id' => $i,
                    'title' => "Shipping address {$i}",
                    'name' => $customer->$nameField,
                    'address' => $customer->$addressField,
                    'country' => $customer->$countryField,
                    'postal_code' => $customer->$postalField,
                    'email' => $customer->email,
                    'phone' => $customer->$phoneField ?? $customer->mobile_number,
                ];
            }
        }
    
        return $addresses;
    }

    public function deleteAddress($addressNumber)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        
        if ($customer) {
            $customer->update([
                "shipping_address_{$addressNumber}" => null,
                "shipping_address_receiver_name_{$addressNumber}" => null,
                "shipping_country_{$addressNumber}" => null,
                "shipping_postal_code_{$addressNumber}" => null,
                "shipping_phone_{$addressNumber}" => null,
                'updated_by' => Auth::id()
            ]);
    
            notyf()->success('Address removed successfully');
        }
    }

    public function render()
    {
        $addresses = $this->getAddresses();
        $canAddMore = count($addresses) < 3;

        return view('livewire.frontend.account.shippingaddress', [
            'addresses' => $addresses,
            'canAddMore' => $canAddMore
        ]);
    }
}