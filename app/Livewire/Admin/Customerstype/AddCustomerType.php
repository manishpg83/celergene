<?php

namespace App\Livewire\Admin\Customerstype;

use App\Models\CustomerType;
use Livewire\Component;

class AddCustomerType extends Component
{
    public $customer_type;
    public $status;
    public $customerTypeId;

    public function mount()
    {
        $this->customerTypeId = request()->query('id');
        if ($this->customerTypeId) {
            $customerType = CustomerType::find($this->customerTypeId);
            if ($customerType) {
                $this->customer_type = $customerType->customer_type;
                $this->status = $customerType->status;
            }
        }
    }
    protected $rules = [
        'customer_type' => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    public function saveCustomerType()
    {
        $this->validate();

        if ($this->customerTypeId) {
            $customerType = CustomerType::find($this->customerTypeId);
            $customerType->update([
                'customer_type' => $this->customer_type,
                'status' => $this->status,
            ]);
            notyf()->success('Customer type updated successfully.');
        } else {
            CustomerType::create([
                'customer_type' => $this->customer_type,
                'status' => $this->status,
            ]);
            notyf()->success('Customer type added successfully.');
        }
        return redirect()->route('admin.customerstype.index');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->customer_type = '';
        $this->status = 'active';
        $this->customerTypeId = null;
    }
    public function back()
    {
        return redirect()->route('admin.customerstype.index');
    }
    public function render()
    {
        return view('livewire.admin.customerstype.add-customer-type');
    }
}
