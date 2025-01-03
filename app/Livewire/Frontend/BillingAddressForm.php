<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class BillingAddressForm extends Component
{
    public $firstname;
    public $lastname;
    public $companyname;
    public $address1;
    public $address2;
    public $state;
    public $city;
    public $zip;
    public $country;
    public $phone;

    protected $rules = [
        'firstname' => 'required|max:100',
        'lastname' => 'required|max:100',
        'companyname' => 'max:100',
        'address1' => 'required|max:100',
        'address2' => 'max:100',
        'state' => 'required|max:100',
        'city' => 'required|max:100',
        'zip' => 'required|numeric|max:999999',
        'country' => 'required',
        'phone' => 'required|numeric|max:9999999999',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        session()->flash('message', 'Billing address saved successfully!');
    }

    public function render()
    {
        return view('livewire.frontend.billing-address-form');
    }
}
