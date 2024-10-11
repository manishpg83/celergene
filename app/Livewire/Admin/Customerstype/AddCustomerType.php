<?php

namespace App\Livewire\Admin\Customerstype;

use App\Models\CustomerType; // Import the model
use Livewire\Component;

class AddCustomerType extends Component
{
    public $customertype;
    public $status;
    public $customerTypeId;

    public function mount()
    {
        $this->customerTypeId = request()->query('id');
        if ($this->customerTypeId) {
            $customerType = CustomerType::find($this->customerTypeId);
            if ($customerType) {
                $this->customertype = $customerType->customertype;
                $this->status = $customerType->status;
            }
        }
    }
    // Validation rules
    protected $rules = [
        'customertype' => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    // Method to add or update customer type
    public function saveCustomerType()
    {
        $this->validate();

        // If we have a customerTypeId, we're updating an existing record
        if ($this->customerTypeId) {
            $customerType = CustomerType::find($this->customerTypeId);
            $customerType->update([
                'customertype' => $this->customertype,
                'status' => $this->status,
            ]);
            notyf()->success('Customer type updated successfully.');
        } else {
            // Otherwise, we're creating a new record
            CustomerType::create([
                'customertype' => $this->customertype,
                'status' => $this->status,
            ]);
            notyf()->success('Customer type added successfully.');
        }

        // Reset form fields
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->customertype = '';
        $this->status = 'active';
        $this->customerTypeId = null; // Reset the ID
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
