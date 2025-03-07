<?php

namespace App\Livewire\Frontend\Account;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Addshippingaddress extends Component
{
    public $firstName;
    public $lastName;
    public $companyName;
    public $country;
    public $streetAddress;
    public $apartmentAddress;
    public $city;
    public $state;
    public $pincode;
    public $addressNumber;
    public $email;
    public $phoneNumber;

    protected $rules = [
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'companyName' => 'nullable|string|max:255',
        'country' => 'required|string|max:255',
        'streetAddress' => 'required|string|max:255',
        'apartmentAddress' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'pincode' => 'required|string|max:20',
        'phoneNumber' => 'required|string|max:20',
    ];

    public function mount($addressNumber = null)
    {
        $addressNumber = request()->query('addressNumber');
        $this->addressNumber = $addressNumber;

        $customer = Customer::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'customer_type_id' => 1,
                'payment_term_display' => 'Default',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]
        );
        if ($addressNumber) {
            $this->loadExistingAddress($customer);
        } else {
            $this->loadCustomerData($customer);

            if ($customer->billing_address) {
                $this->loadBillingAddress($customer);
            }
        }
    }

    protected function loadCustomerData($customer)
    {
        $this->firstName = $customer->first_name ?? Auth::user()->first_name ?? '';
        $this->lastName = $customer->last_name ?? Auth::user()->last_name ?? '';
        $this->companyName = $customer->company_name;
        $this->email = $customer->email ?? Auth::user()->email;
        $this->phoneNumber = $customer->mobile_number;
    }

    protected function loadExistingAddress($customer)
    {
        $addressNumber = $this->addressNumber;
    
        if ($addressNumber) {
            $this->streetAddress = $customer->{"shipping_address_$addressNumber"} ?? '';
            $this->country = $customer->{"shipping_country_$addressNumber"} ?? '';
            $this->pincode = $customer->{"shipping_postal_code_$addressNumber"} ?? '';
            $this->city = $customer->{"shipping_city_$addressNumber"} ?? '';
            $this->state = $customer->{"shipping_state_$addressNumber"} ?? '';
            $this->phoneNumber = $customer->{"shipping_phone_$addressNumber"} ?? '';
            $this->companyName = $customer->{"shipping_company_name_$addressNumber"} ?? '';
            $fullName = $customer->{"shipping_address_receiver_name_$addressNumber"} ?? '';
            if ($fullName) {
                $nameParts = explode(' ', $fullName, 2);
                $this->firstName = $nameParts[0] ?? '';
                $this->lastName = $nameParts[1] ?? '';
            }
    
            if ($this->streetAddress && str_contains($this->streetAddress, "\n")) {
                [$this->streetAddress, $this->apartmentAddress] = explode("\n", $this->streetAddress, 2);
            }
    
            if (!$this->email) {
                $this->email = $customer->email ?? '';
            }
            if (!$this->phoneNumber) {
                $this->phoneNumber = $customer->mobile_number ?? '';
            }
            $this->dispatch('contentChanged');
        }
    }

    protected function loadBillingAddress($customer)
    {
        $this->streetAddress = $customer->billing_address;
        $this->country = $customer->billing_country;
        $this->pincode = $customer->billing_postal_code;
        $this->city = $customer->billing_city;
        $this->state = $customer->billing_state;

        if (str_contains($this->streetAddress, "\n")) {
            [$this->streetAddress, $this->apartmentAddress] = explode("\n", $this->streetAddress, 2);
        }
    }

    public function save()
    {
        $this->validate();
    
        $customer = Customer::where('user_id', Auth::id())->first();
    
        $customer->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'mobile_number' => $this->phoneNumber,
            'updated_by' => Auth::id(),
        ]);
    
        $addressNumber = $this->addressNumber ?? $this->getNextAvailableAddressSlot($customer);
    
        $fullAddress = $this->streetAddress;
        if ($this->apartmentAddress) {
            $fullAddress .= "\n" . $this->apartmentAddress;
        }
    
        $customer->update([
            "shipping_address_receiver_name_{$addressNumber}" => "{$this->firstName} {$this->lastName}",
            "shipping_address_{$addressNumber}" => $fullAddress,
            "shipping_country_{$addressNumber}" => $this->country,
            "shipping_postal_code_{$addressNumber}" => $this->pincode,
            "shipping_city_{$addressNumber}" => $this->city,
            "shipping_state_{$addressNumber}" => $this->state,
            "shipping_phone_{$addressNumber}" => $this->phoneNumber,
            "shipping_company_name_{$addressNumber}" => $this->companyName,
            'updated_by' => Auth::id(),
        ]);
    
        notyf()->success('Shipping address saved successfully!');
        return redirect()->route('shippingaddress');
    }

    protected function getNextAvailableAddressSlot($customer)
    {
        for ($i = 1; $i <= 3; $i++) {
            if (!$customer->{"shipping_address_{$i}"}) {
                return $i;
            }
        }
        return 1;
    }

    public function render()
    {
        $countries = DB::table('country')->pluck('name', 'name');

        return view('livewire.frontend.account.addshippingaddress', [
            'countries' => $countries,
        ]);
    }
}
