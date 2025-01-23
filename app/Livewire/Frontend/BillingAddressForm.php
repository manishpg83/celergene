<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

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
    public $customerId;

    protected $rules = [
        'firstname' => 'required|max:100',
        'lastname' => 'required|max:100',
        'companyname' => 'max:100',
        'address1' => 'required|max:100',
        'address2' => 'max:100',
        'zip' => 'required|numeric|max:999999',
        'country' => 'required',
        'phone' => 'required|numeric|max:9999999999',
    ];

    public function mount($customerId = null)
    {
        $this->customerId = $customerId;
        
        if ($this->customerId) {
            $customer = Customer::find($this->customerId);
        } else {
            $customer = Customer::where('user_id', Auth::id())->first();
        }

        if ($customer) {
            $this->firstname = $customer->first_name;
            $this->lastname = $customer->last_name;
            $this->companyname = $customer->company_name;
            $this->address1 = $customer->billing_address;
            $this->address2 = $customer->shipping_address_1;
            $this->state = '';
            $this->city = '';
            $this->zip = $customer->billing_postal_code;
            $this->country = $customer->billing_country;
            $this->phone = $customer->mobile_number;
        }
    }

    public function submit()
    {
        $validatedData = $this->validate();
        
        if ($this->customerId) {
            $customer = Customer::find($this->customerId);
        } else {
            $customer = Customer::where('user_id', Auth::id())->first();
        }
         
        if ($customer) {
            $customer->update([
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'company_name' => $this->companyname,
                'mobile_number' => $this->phone,
                'billing_address' => $this->address1,
                'billing_country' => $this->country,
                'billing_postal_code' => $this->zip,
                'updated_by' => Auth::id(),
            ]);
        } else {
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
                'email' => 'placeholder@example.com',
                'salutation' => 'Mr.',
                'payment_term_display' => 'Default Term',
                'payment_term_actual' => '30 Days',
                'credit_rating' => 'Good',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }
    
        notyf()->success('Billing address saved successfully!');
        return redirect()->route('myaccount');
    }   

    public function render()
    {
        Log::info('BillingAddressForm rendered');
        return view('livewire.frontend.billing-address-form');
    }
    
}