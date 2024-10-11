<?php

namespace App\Livewire\Admin\Customerstype;

use App\Models\CustomerType; // Import the model
use Livewire\Component;

class CustomerTypeList extends Component
{
    public $customerTypes; // Property to hold the customer types
    public $customertype, $status, $customerTypeId; // Properties for form data

    // Load customer types when the component is mounted
    public function mount()
    {
        $this->customerTypes = CustomerType::all();
        $this->status = 'active'; // Default status for the form
    }

    // Method to delete a customer type
    public function deleteCustomerType($id)
    {
        $customerType = CustomerType::findOrFail($id);
        $customerType->delete();

        // Refresh the list after deletion
        $this->customerTypes = CustomerType::all();

        // Optionally show a success message
        session()->flash('message', 'Customer type deleted successfully.');
    }

    // Method to set up editing
    // Method to redirect to the edit form
    public function editCustomerType($id)
    {
        return redirect()->route('customerstype.add', ['id' => $id]);
    }


    // Method to update customer type
    public function updateCustomerType()
    {
        $this->validate([
            'customertype' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $customerType = CustomerType::find($this->customerTypeId);
        $customerType->update([
            'customertype' => $this->customertype,
            'status' => $this->status,
        ]);

        // Reset the form fields
        $this->resetForm();

        // Refresh the list after update
        $this->customerTypes = CustomerType::all();

        session()->flash('message', 'Customer type updated successfully.');
    }

    private function resetForm()
    {
        $this->customertype = '';
        $this->status = 'active';
        $this->customerTypeId = null; // Reset the ID
    }

    public function render()
    {
        return view('livewire.admin.customerstype.customer-type-list', [
            'customerTypes' => $this->customerTypes
        ]);
    }
}
