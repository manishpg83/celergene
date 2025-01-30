<?php

namespace App\Livewire\Frontend\Account;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Addbillingaddress extends Component
{
    public $customerId;
    public $billing_fname;
    public $billing_lname;
    public $billing_company_name;
    public $billing_address;
    public $billing_address_2;
    public $billing_city;
    public $billing_state;
    public $billing_country;
    public $billing_postal_code;
    public $billing_phone;
    public $billing_email;

    public function mount($id = null)
    {
        if ($id) {
            $customer = Customer::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if ($customer) {
                $this->customerId = $customer->id;
                $this->billing_fname = $customer->billing_fname;
                $this->billing_lname = $customer->billing_lname;
                $this->billing_company_name = $customer->billing_company_name;
                $this->billing_address = $customer->billing_address;
                $this->billing_address_2 = $customer->billing_address_2;
                $this->billing_city = $customer->billing_city;
                $this->billing_state = $customer->billing_state;
                $this->billing_country = $customer->billing_country;
                $this->billing_postal_code = $customer->billing_postal_code;
                $this->billing_phone = $customer->billing_phone;
                $this->billing_email = $customer->billing_email;
            } else {
                return redirect()->route('billingaddress')->with('error', 'Address not found.');
            }
        }
    }

    public function saveAddress()
    {
        $this->validate([
            'billing_fname' => 'required|string|max:255',
            'billing_lname' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_address_2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_country' => 'required|string|max:255',
            'billing_postal_code' => 'required|string|max:10',
            'billing_phone' => 'required|string|max:20',
            'billing_email' => 'required|email|max:255',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'billing_fname' => $this->billing_fname,
            'billing_lname' => $this->billing_lname,
            'billing_company_name' => $this->billing_company_name,
            'billing_address' => $this->billing_address,
            'billing_address_2' => $this->billing_address_2,
            'billing_city' => $this->billing_city,
            'billing_state' => $this->billing_state,
            'billing_country' => $this->billing_country,
            'billing_postal_code' => $this->billing_postal_code,
            'billing_phone' => $this->billing_phone,
            'billing_email' => $this->billing_email,
            'updated_by' => Auth::id()
        ];

        if ($this->customerId) {
            $customer = Customer::find($this->customerId);
            if ($customer && $customer->user_id == Auth::id()) {
                $customer->update($data);
                notyf()->success('Address updated successfully.');
            } else {
                notyf()->error('Customer not found or doesn’t belong to the logged-in user.');
            }
        } else {
            $existingCustomer = Customer::where('user_id', Auth::id())->first();

            if ($existingCustomer) {
                $existingCustomer->update($data);
                notyf()->success('Address updated successfully.');
            } else {
                $data['created_by'] = Auth::id();
                $data['customer_type_id'] = 1;
                $data['payment_term_display'] = 'default';

                Customer::create($data);
                notyf()->success('Address added successfully.');
            }
        }

        return redirect()->route('billingaddress');
    }

    public function render()
    {
        return view('livewire.frontend.account.addbillingaddress');
    }
}
