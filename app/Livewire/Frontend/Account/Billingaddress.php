<?php

namespace App\Livewire\Frontend\Account;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;

class Billingaddress extends Component
{
    public $addresses;
    public $addressExists = false;
    public function mount()
    {
        $this->fetchAddresses();
        $this->checkIfAddressExists();
    }

    public function fetchAddresses()
    {
        $this->addresses = Customer::where('user_id', Auth::id())->get();
    }

    public function checkIfAddressExists()
    {
        $existingAddress = Customer::where('user_id', Auth::id())
                                ->whereNotNull('billing_address')
                                ->first();

        if ($existingAddress) {
            $this->addressExists = true;
        }
    }

    public function deleteAddress($addressId)
    {
        $address = Customer::where('id', $addressId)
                           ->where('user_id', Auth::id())
                           ->first();
    
        if ($address) {
            $address->billing_address = null;
            $address->billing_country = null;
            $address->billing_postal_code = null;
    
            $address->save();
    
            notyf()->success('Billing address details removed successfully.');
    
            $this->fetchAddresses();
    
            $this->checkIfAddressExists();
        } else {
            notyf()->error('Address not found or you don’t have permission to remove the details.');
        }
    }
       
    public function render()
    {
        return view('livewire.frontend.account.billingaddress');
    }
}
