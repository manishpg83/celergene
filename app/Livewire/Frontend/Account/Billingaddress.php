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
    public $addressToDelete;
    public $showDeleteConfirmation = false;
    public function mount()
    {
        $this->fetchAddresses();
        $this->checkIfAddressExists();
    }

    public function fetchAddresses()
    {
        $this->addresses = Customer::where('user_id', Auth::id())
            ->whereNotNull('billing_address')
            ->get();
    }

    public function checkIfAddressExists()
    {
        $this->addressExists = $this->addresses->count() > 0;
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
        $this->deleteAddress($this->addressToDelete);
        $this->showDeleteConfirmation = false;
    }
    public function deleteAddress($addressId)
    {
        $address = Customer::where('id', $addressId)
            ->where('user_id', Auth::id())
            ->first();

        if ($address) {
            $address->billing_address = null;
            $address->billing_fname = null;
            $address->billing_lname = null;
            $address->billing_address_2 = null;
            $address->billing_city = null;
            $address->billing_state = null;
            $address->billing_phone = null;
            $address->billing_email = null;
            $address->billing_country = null;
            $address->billing_postal_code = null;

            $address->save();
            $this->showDeleteConfirmation = false;
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
