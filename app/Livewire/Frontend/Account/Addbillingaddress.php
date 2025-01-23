<?php

namespace App\Livewire\Frontend\Account;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Addbillingaddress extends Component
{
    public $customerId;
    public $first_name;
    public $last_name;
    public $company_name;
    public $billing_address;
    public $billing_postal_code;
    public $mobile_number;
    public $email;

    public function mount($id = null)
    {
        if ($id) {
            $customer = Customer::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if ($customer) {
                $this->customerId = $customer->id;
                $this->first_name = $customer->first_name;
                $this->last_name = $customer->last_name;
                $this->company_name = $customer->company_name;
                $this->billing_address = $customer->billing_address;
                $this->billing_postal_code = $customer->billing_postal_code;
                $this->mobile_number = $customer->mobile_number;
                $this->email = $customer->email;
            } else {
                return redirect()->route('billingaddress')->with('error', 'Address not found.');
            }
        } else {
            $user = Auth::user();
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->company_name = $user->company;
            $this->mobile_number = $user->phone;
            $this->email = $user->email;
        }
    }

    public function saveAddress()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_postal_code' => 'required|string|max:10',
            'mobile_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'billing_address' => $this->billing_address,
            'billing_postal_code' => $this->billing_postal_code,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
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
