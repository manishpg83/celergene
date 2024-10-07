<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCustomer extends Component
{
    use WithPagination;
    public $showForm = false;
    public $customer_type, $salutation, $first_name, $last_name, $mobile_number, $email;
    public $company_name, $business_reg_number, $vat_number, $payment_term_display;
    public $payment_term_actual, $credit_rating, $allow_consignment = false;
    public $must_receive_payment_before_delivery = false;
    public $billing_address, $billing_country, $billing_postal_code;
    public $shipping_address_receiver_name_1, $shipping_address_1, $shipping_country_1, $shipping_postal_code_1;
    public $shipping_address_receiver_name_2, $shipping_address_2, $shipping_country_2, $shipping_postal_code_2;
    public $shipping_address_receiver_name_3, $shipping_address_3, $shipping_country_3, $shipping_postal_code_3;

    public $search = '';
    public $perPage = 1;

    protected $rules = [
        'customer_type' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'mobile_number' => 'required|string',
        'email' => 'required|email',
        'payment_term_display' => 'required|string',
        'payment_term_actual' => 'required|in:Term1,Term2,Term3',
        'billing_address' => 'required|string',
        'billing_country' => 'required|string',
        'shipping_address_receiver_name_1' => 'required|string',
        'shipping_address_1' => 'required|string',
        'shipping_country_1' => 'required|string',
    ];

    public function render()
    {
        $customers = Customer::where('first_name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.admin.admin-customer', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        Customer::create([
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
        ]);

        session()->flash('message', 'Customer created successfully.');

        $this->resetInputFields();
    }

    public function resetInputFields()
    {
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
}
