<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class ShippingAddressForm extends Component
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
    public $addressNumber;

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

    public function mount($addressNumber = null)
    {
        $this->addressNumber = $addressNumber;
        $customer = Customer::where('user_id', Auth::id())->first();

        if ($customer && $addressNumber) {
            $this->firstname = $customer->first_name;
            $this->lastname = $customer->last_name;
            $this->companyname = $customer->company_name;
            $this->phone = $customer->mobile_number;

            if ($addressNumber == 1) {
                $this->address1 = $customer->shipping_address_1;
                $this->country = $customer->shipping_country_1;
                $this->zip = $customer->shipping_postal_code_1;
            } else if ($addressNumber == 2) {
                $this->address1 = $customer->shipping_address_2;
                $this->country = $customer->shipping_country_2;
                $this->zip = $customer->shipping_postal_code_2;
            }
        }
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $customer = Customer::where('user_id', Auth::id())->first();

        if ($customer) {
            if ($this->addressNumber) {
                $addressField = 'shipping_address_' . $this->addressNumber;
                $countryField = 'shipping_country_' . $this->addressNumber;
                $postalField = 'shipping_postal_code_' . $this->addressNumber;
                $nameField = 'shipping_address_receiver_name_' . $this->addressNumber;

                $customer->update([
                    $addressField => $this->address1,
                    $countryField => $this->country,
                    $postalField => $this->zip,
                    $nameField => $this->firstname . ' ' . $this->lastname,
                    'updated_by' => Auth::id(),
                ]);
            } else {
                $nextAddressNumber = 1;
                if ($customer->shipping_address_1) {
                    if ($customer->shipping_address_2) {
                        $nextAddressNumber = 3;
                    } else {
                        $nextAddressNumber = 2;
                    }
                }

                $addressField = 'shipping_address_' . $nextAddressNumber;
                $countryField = 'shipping_country_' . $nextAddressNumber;
                $postalField = 'shipping_postal_code_' . $nextAddressNumber;
                $nameField = 'shipping_address_receiver_name_' . $nextAddressNumber;

                $customer->update([
                    $addressField => $this->address1,
                    $countryField => $this->country,
                    $postalField => $this->zip,
                    $nameField => $this->firstname . ' ' . $this->lastname,
                    'updated_by' => Auth::id(),
                ]);
            }
        } else {
            Customer::create([
                'user_id' => Auth::id(),
                'customer_type_id' => 1,
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'company_name' => $this->companyname,
                'mobile_number' => $this->phone,
                'shipping_address_1' => $this->address1,
                'shipping_country_1' => $this->country,
                'shipping_postal_code_1' => $this->zip,
                'shipping_address_receiver_name_1' => $this->firstname . ' ' . $this->lastname,
                'email' => 'placeholder@example.com',
                'salutation' => 'Mr.',
                'payment_term_display' => 'Default Term',
                'payment_term_actual' => '30 Days',
                'credit_rating' => 'Good',
                'billing_address' => $this->address1,
                'billing_country' => $this->country,
                'billing_postal_code' => $this->zip,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        notyf()->success('Shipping address saved successfully!');
        return redirect()->route('myaccount');
    }

    public function deleteAddress($addressNumber)
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if ($customer) {
            $customer->update([
                'shipping_address_' . $addressNumber => null,
                'shipping_country_' . $addressNumber => null,
                'shipping_postal_code_' . $addressNumber => null,
                'shipping_address_receiver_name_' . $addressNumber => null,
                'updated_by' => Auth::id(),
            ]);

            notyf()->success('Shipping address deleted successfully!');
        }

        return redirect()->route('myaccount');
    }

    public function render()
    {
        return view('livewire.frontend.shipping-address-form');
    }
}
