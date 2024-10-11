<?php
namespace App\Livewire\Admin\Customerstype;

use App\Models\CustomerType; // Import the model
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTypeList extends Component
{
    use WithPagination;

    public $customertype, $customerTypeId;
    public $perPage = 5;
    public $status = 'active';
    public $search = '';
    public $confirmingDeletion = false;

    public function mount()
    {
        $this->resetForm();
    }

    public function delete()
    {
        $customerType = CustomerType::withTrashed()->find($this->customerTypeId);

        if ($customerType->trashed()) {
            $customerType->forceDelete();
            notyf()->success('Customer type permanently deleted.');
        } else {
            $customerType->status = 'inactive';
            $customerType->save();
            $customerType->delete();
            notyf()->success('Customer type suspended. Click delete again to permanently remove.');
        }

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->customerTypeId = $id;
        $customerType = CustomerType::withTrashed()->find($id);

        if ($customerType->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete();
        }
    }

    public function restore($id)
    {
        $customerType = CustomerType::withTrashed()->find($id);
        $customerType->restore();
        $customerType->status = 'active';
        $customerType->save();
        notyf()->success('Customer type restored successfully.');
    }

    public function editCustomerType($id)
    {
        return redirect()->route('admin.customerstype.add', ['id' => $id]);
    }

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

        session()->flash('message', 'Customer type updated successfully.');
    }

    private function resetForm()
    {
        $this->customertype = '';
        $this->status = 'active';
        $this->customerTypeId = null; // Reset the ID
    }

    public function toggleActive(CustomerType $customerType)
    {
        if (!$customerType->trashed()) {
            $customerType->status = $customerType->status === 'active' ? 'inactive' : 'active';
            $customerType->save();
            notyf()->success('Customer type status updated successfully.');
        }
    }

    public function render()
    {
        // Adjust the query to show all customer types, including inactive ones
        $customerTypes = CustomerType::where('customertype', 'like', '%' . $this->search . '%')
            ->withTrashed() // Include trashed customer types
            ->orderBy('id')
            ->paginate($this->perPage);

        return view('livewire.admin.customerstype.customer-type-list', [
            'customerTypes' => $customerTypes
        ]);
    }
}
