<?php

namespace App\Livewire\Frontend\Account;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Shippingaddress extends Component
{
    public $addressToDelete;
    public $showDeleteConfirmation = false;


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

    public function confirmDelete($addressId)
    {
        $this->addressToDelete = $addressId;        
        $this->showDeleteConfirmation = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
    }

    public function performDelete()
    {        
        $customer = Customer::where('user_id', Auth::id())->first();
        if ($customer && $this->addressToDelete) {
            $customer->update([
                "shipping_address_{$this->addressToDelete}" => null,
                "shipping_address_receiver_name_{$this->addressToDelete}" => null,
                "shipping_country_{$this->addressToDelete}" => null,
                "shipping_postal_code_{$this->addressToDelete}" => null,
                "shipping_phone_{$this->addressToDelete}" => null,
                'updated_by' => Auth::id()
            ]);

            $this->showDeleteConfirmation = false;

            notyf()->success('Address removed successfully.');            
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