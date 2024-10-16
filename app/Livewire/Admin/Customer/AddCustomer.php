<?php

namespace App\Livewire\Admin\Customer;

use App\Models\Customer;
use App\Models\CustomerType;
use Livewire\Component;

class AddCustomer extends Component
{
    public $confirmingDeletion = false;
    public $showForm = true;
    public $isEditing = false;
    public $customer_id;
    public $sameAsBilling = false;

    public $customer_type_id;
    public $salutation, $first_name, $last_name, $mobile_number, $email;
    public $company_name, $business_reg_number, $vat_number, $payment_term_display;
    public $payment_term_actual, $credit_rating, $allow_consignment = false;
    public $must_receive_payment_before_delivery = false;
    public $billing_address, $billing_country, $billing_postal_code;
    public $shipping_address_receiver_name_1, $shipping_address_1, $shipping_country_1, $shipping_postal_code_1;
    public $shipping_address_receiver_name_2, $shipping_address_2, $shipping_country_2, $shipping_postal_code_2;
    public $shipping_address_receiver_name_3, $shipping_address_3, $shipping_country_3, $shipping_postal_code_3;

    public $customerTypes;

    protected $rules = [
        'customer_type_id' => 'required|exists:customerstype,id',
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

    public function mount()
    {
        $this->customerTypes = CustomerType::where('status', 'active')->get();
        $this->customer_id = request()->query('id');

        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            if ($customer) {
                $this->fillCustomerData($customer);
                $this->isEditing = true;
            }
        }
    }

    private function fillCustomerData($customer)
    {
        $this->customer_type_id = $customer->customer_type_id;
        $this->salutation = $customer->salutation;
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
        $this->mobile_number = $customer->mobile_number;
        $this->email = $customer->email;
        $this->company_name = $customer->company_name;
        $this->business_reg_number = $customer->business_reg_number;
        $this->vat_number = $customer->vat_number;
        $this->payment_term_display = $customer->payment_term_display;
        $this->payment_term_actual = $customer->payment_term_actual;
        $this->credit_rating = $customer->credit_rating;
        $this->allow_consignment = $customer->allow_consignment;
        $this->must_receive_payment_before_delivery = $customer->must_receive_payment_before_delivery;
        $this->billing_address = $customer->billing_address;
        $this->billing_country = $customer->billing_country;
        $this->billing_postal_code = $customer->billing_postal_code;
        $this->shipping_address_receiver_name_1 = $customer->shipping_address_receiver_name_1;
        $this->shipping_address_1 = $customer->shipping_address_1;
        $this->shipping_country_1 = $customer->shipping_country_1;
        $this->shipping_postal_code_1 = $customer->shipping_postal_code_1;
        $this->shipping_address_receiver_name_2 = $customer->shipping_address_receiver_name_2;
        $this->shipping_address_2 = $customer->shipping_address_2;
        $this->shipping_country_2 = $customer->shipping_country_2;
        $this->shipping_postal_code_2 = $customer->shipping_postal_code_2;
        $this->shipping_address_receiver_name_3 = $customer->shipping_address_receiver_name_3;
        $this->shipping_address_3 = $customer->shipping_address_3;
        $this->shipping_country_3 = $customer->shipping_country_3;
        $this->shipping_postal_code_3 = $customer->shipping_postal_code_3;
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

        return redirect()->route('admin.customer.index');
    }

    public function updatedSameAsBilling($value)
    {
        if ($value) {
            $this->shipping_address_receiver_name_1 = $this->first_name . ' ' . $this->last_name;
            $this->shipping_address_1 = $this->billing_address;
            $this->shipping_country_1 = $this->billing_country;
            $this->shipping_postal_code_1 = $this->billing_postal_code;
        } else {
            $this->resetShippingFields();
        }
    }

    private function resetShippingFields()
    {
        $this->shipping_address_receiver_name_1 = '';
        $this->shipping_address_1 = '';
        $this->shipping_country_1 = '';
        $this->shipping_postal_code_1 = '';
    }

    public function resetInputFields()
    {
        $this->customer_id = null;
        $this->customer_type_id = '';
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
        $this->resetShippingFields();
    }

    private function customerData()
    {
        return [
            'customer_type_id' => $this->customer_type_id,
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
            'updated_by' => auth()->guard('admin')->id(),
        ];
    }

    public function back()
    {
        return redirect()->route('admin.customer.index');
    }

    public function render()
    {
        return view('livewire.admin.customer.add-customer', [
            'customerTypes' => $this->customerTypes
        ]);
    }
}
