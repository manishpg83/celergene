<?php

namespace App\Livewire\Admin\Customer;

use App\Models\Customer;
use Livewire\Component;

class AddCustomer extends Component
{
    public $confirmingDeletion = false;
    public $showForm = true; // Form is shown by default
    public $isEditing = false; // Flag to check if we're editing or adding
    public $customer_id;
    public $customer_type, $salutation, $first_name, $last_name, $mobile_number, $email;
    public $company_name, $business_reg_number, $vat_number, $payment_term_display;
    public $payment_term_actual, $credit_rating, $allow_consignment = false;
    public $must_receive_payment_before_delivery = false;
    public $billing_address, $billing_country, $billing_postal_code;
    public $shipping_address_receiver_name_1, $shipping_address_1, $shipping_country_1, $shipping_postal_code_1;
    public $shipping_address_receiver_name_2, $shipping_address_2, $shipping_country_2, $shipping_postal_code_2;
    public $shipping_address_receiver_name_3, $shipping_address_3, $shipping_country_3, $shipping_postal_code_3;

    protected $rules = [
        'customer_type' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'mobile_number' => 'required|string',
        'email' => 'required|email',
        'payment_term_display' => 'required|string',
        'payment_term_actual' => 'required|in:7D,14D,30D',
        'billing_address' => 'required|string',
        'billing_country' => 'required|string',
        'shipping_address_receiver_name_1' => 'required|string',
        'shipping_address_1' => 'required|string',
        'shipping_country_1' => 'required|string',
    ];

    public function mount($customerId = null)
    {
        if ($customerId) {
            $this->isEditing = true;
            $this->customer_id = $customerId;
            $customer = Customer::findOrFail($customerId);
            $this->fill($customer->toArray()); // Fill the form with customer data
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $customer = Customer::findOrFail($this->customer_id);
            $customer->update($this->customerData());
            notyf()->success('Customer updated successfully.');
        } else {
            Customer::create($this->customerData());
            notyf()->success('Customer created successfully.');
        }

        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->customer_id = null;
        $this->customer_type = '';
        $this->salutation = '';
        $this->first_name = '';
        $this->last_name = '';
        $this->mobile_number = '';
        $this->email = '';
        $this->company_name = '';
        $this->business_reg_number = '';
        $this->vat_number = '';
        $this->payment_term_display = '';
        $this->payment_term_actual = '';
        $this->credit_rating = '';
        $this->allow_consignment = false;
        $this->must_receive_payment_before_delivery = false;
        $this->billing_address = '';
        $this->billing_country = '';
        $this->billing_postal_code = '';
        $this->shipping_address_receiver_name_1 = '';
        $this->shipping_address_1 = '';
        $this->shipping_country_1 = '';
        $this->shipping_postal_code_1 = '';
        $this->shipping_address_receiver_name_2 = '';
        $this->shipping_address_2 = '';
        $this->shipping_country_2 = '';
        $this->shipping_postal_code_2 = '';
        $this->shipping_address_receiver_name_3 = '';
        $this->shipping_address_3 = '';
        $this->shipping_country_3 = '';
        $this->shipping_postal_code_3 = '';
    }

    private function customerData()
    {
        return [
            'customer_type' => $this->customer_type,
            'salutation' => $this->salutation,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'business_reg_number' => $this->business_reg_number,
            'vat_number' => $this->vat_number,
            'payment_term_display' => $this->payment_term_display,
            'payment_term_actual' => $this->payment_term_actual,
            'credit_rating' => $this->credit_rating,
            'allow_consignment' => $this->allow_consignment,
            'must_receive_payment_before_delivery' => $this->must_receive_payment_before_delivery,
            'billing_address' => $this->billing_address,
            'billing_country' => $this->billing_country,
            'billing_postal_code' => $this->billing_postal_code,
            'shipping_address_receiver_name_1' => $this->shipping_address_receiver_name_1,
            'shipping_address_1' => $this->shipping_address_1,
            'shipping_country_1' => $this->shipping_country_1,
            'shipping_postal_code_1' => $this->shipping_postal_code_1,
            'shipping_address_receiver_name_2' => $this->shipping_address_receiver_name_2,
            'shipping_address_2' => $this->shipping_address_2,
            'shipping_country_2' => $this->shipping_country_2,
            'shipping_postal_code_2' => $this->shipping_postal_code_2,
            'shipping_address_receiver_name_3' => $this->shipping_address_receiver_name_3,
            'shipping_address_3' => $this->shipping_address_3,
            'shipping_country_3' => $this->shipping_country_3,
            'shipping_postal_code_3' => $this->shipping_postal_code_3,
            'created_by' => auth()->guard('admin')->id(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.customer.add-customer');
    }
}
