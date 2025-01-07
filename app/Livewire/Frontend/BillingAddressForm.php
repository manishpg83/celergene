<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

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

    public function mount()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        if ($customer) {
            $this->firstname = $customer->first_name;
            $this->lastname = $customer->last_name;
            $this->companyname = $customer->company_name;
            $this->phone = $customer->mobile_number;
        }
    }

    public function submit()
    {
        $validatedData = $this->validate();
        
        Customer::create([
            'user_id' => Auth::id(),
            'customer_type_id' => 1,
            'first_name' => $this->firstname,
            'last_name' => $this->lastname,
            'company_name' => $this->companyname,
            'mobile_number' => $this->phone,
            'billing_address' => $this->address1,
            'billing_country' => $this->country,
            'billing_postal_code' => $this->zip,
            'shipping_address_1' => $this->address2 ?: $this->address1,
            'shipping_country_1' => $this->country,
            'shipping_postal_code_1' => $this->zip,
            'shipping_address_receiver_name_1' => $this->firstname . ' ' . $this->lastname,
            'email' => 'placeholder@example.com',
            'salutation' => 'Mr.',
            'payment_term_display' => 'Default Term',
            'payment_term_actual' => '30 Days',
            'credit_rating' => 'Good',
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        
        notyf()->success('Billing address saved successfully!');
        return redirect()->route('myaccount');
    }
     
    public function render()
    {
        return view('livewire.frontend.billing-address-form');
    }
}
