<?php

namespace App\Livewire\Admin\Customerstype;

use App\Models\CustomerType;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTypeList extends Component
{
    use WithPagination;

    public $customer_type, $customerTypeId;
    public $perPage = 25;
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
        $customerType = CustomerType::withTrashed()->find($id);

        if ($customerType->trashed()) {
            notyf()->error('Cannot edit a suspended customer type. Please restore it first.');
            return;
        }
        $this->dispatch('openEditTab', route('admin.customerstype.add', ['id' => $id]));
    }

    public function updateCustomerType()
    {
        $this->validate([
            'customertype' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $customerType = CustomerType::find($this->customerTypeId);
        $customerType->update([
            'customer_type' => $this->customertype,
            'status' => $this->status,
        ]);

        $this->resetForm();

        session()->flash('message', 'Customer type updated successfully.');
    }

    private function resetForm()
    {
        $this->customer_type = '';
        $this->status = 'active';
        $this->customerTypeId = null;
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
        $customerTypes = CustomerType::where('customer_type', 'like', '%' . $this->search . '%')
            ->withTrashed()
            ->orderBy('id')
            ->paginate($this->perPage);
        $perpagerecords = perpagerecords();

        return view('livewire.admin.customerstype.customer-type-list', [
            'customerTypes' => $customerTypes,
            'perpagerecords' => $perpagerecords,
        ]);
    }
}
