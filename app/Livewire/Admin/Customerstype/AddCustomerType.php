<?php

namespace App\Livewire\Admin\Customerstype;

use App\Models\CustomerType; // Import the model
use Livewire\Component;

class AddCustomerType extends Component
{
    public $customertype; // Property for the customer type input
    public $status; // Status for the customer type
    public $customerTypeId; // ID of the customer type being edited

    // This lifecycle hook runs when the component is instantiated
    public function mount($customerType = null)
    {
        if ($customerType) {
            $this->customerTypeId = $customerType->id;
            $this->customertype = $customerType->customertype;
            $this->status = $customerType->status;
        } else {
            $this->status = 'active'; // Default status for new customer type
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
            session()->flash('message', 'Customer type updated successfully.');
        } else {
            // Otherwise, we're creating a new record
            CustomerType::create([
                'customertype' => $this->customertype,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Customer type added successfully.');
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

    public function render()
    {
        return view('livewire.admin.customerstype.add-customer-type');
    }
}
