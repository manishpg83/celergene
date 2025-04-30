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
            $this->firstname = $customer->billing_fname ?? $customer->first_name;
            $this->lastname = $customer->billing_lname ?? $customer->last_name;
            $this->companyname = $customer->billing_company_name ?? $customer->company_name;
            $this->email = $customer->billing_email ?? $customer->email;
            $this->address1 = $customer->billing_address;
            $this->address2 = $customer->billing_address_2;
            $this->state = $customer->billing_state;
            $this->city = $customer->billing_city;
            $this->zip = $customer->billing_postal_code;
            $this->country = $customer->billing_country;
            $this->phone = $customer->billing_phone;
        }
    }

    public function submit()
    {
        try {
            $validatedData = $this->validate();

            if ($this->customerId) {
                $customer = Customer::find($this->customerId);
            } else {
                $customer = Customer::where('user_id', Auth::id())->first();
            }

            if ($customer) {
                $customer->update([
                    'billing_fname' => $this->firstname,
                    'billing_lname' => $this->lastname,
                    'billing_company_name' => $this->companyname,
                    'billing_phone' => $this->phone,
                    'billing_address' => $this->address1,
                    'billing_country' => $this->country,
                    'billing_postal_code' => $this->zip,
                    'billing_email' => $this->email,
                    'updated_by' => Auth::id(),
                ]);
                Log::info('Customer updated: ', $customer->toArray());
            } else {
                $customer = Customer::create([
                    'user_id' => Auth::id(),
                    'customer_type_id' => 1,
                    'billing_fname' => $this->firstname,
                    'billing_lname' => $this->lastname,
                    'billing_company_name' => $this->companyname,
                    'billing_phone' => $this->phone,
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
                Log::info('New customer created: ', $customer->toArray());
            }

            notyf()->success('Billing address saved successfully!');
            return redirect()->route('myaccount');

        } catch (\Exception $e) {
            Log::error('Error saving billing address: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            notyf()->error('Failed to save billing address.');
        }
    }


    public function render()
    {
        Log::info('BillingAddressForm rendered');
        return view('livewire.frontend.billing-address-form');
    }

}