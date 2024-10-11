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
    public $search = '';
    public $isEditing = false;
    public $sortField = 'customertype';
    public $sortDirection = 'asc';
    public $statusFilter = 'all'; // Initialize statusFilter
    public $confirmingDeletion = false;

    protected $rules = [
        'customertype' => 'required|string|max:255',
        'status' => 'required|in:active,inactive', // Validate status
    ];

    public function mount()
    {
        $this->resetFields();
    }

    public function render()
    {
        $query = CustomerType::query()
            ->when($this->search, function ($query) {
                $query->where('customertype', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter); // Use statusFilter here
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection);

        $customerTypes = $query->paginate($this->perPage);

        return view('livewire.admin.customerstype.customer-type-list', [
            'customerTypes' => $customerTypes,
        ]);
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function updatedStatusFilter($value)
    {
        $this->statusFilter = $value;
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'customerTypeId',
            'customertype',
            'status'
        ]);
        $this->status = 'active'; // Set default status
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function create()
    {
        $this->resetFields();
        $this->isEditing = true;
    }

    public function edit(CustomerType $customerType)
    {
        return redirect()->route('admin.customerstype.add', ['id' => $customerType->id]);
    }

    public function save()
    {
        $this->validate();

        $customerType = $this->customerTypeId ? CustomerType::find($this->customerTypeId) : new CustomerType();

        $customerType->fill($this->only(['customertype', 'status'])); // Update to use status
        $customerType->save();

        $this->isEditing = false;
        notyf()->success('Customer type saved successfully.');
    }

    public function delete()
    {
        $customerType = CustomerType::withTrashed()->find($this->customerTypeId);

        if ($customerType->trashed()) {
            $customerType->forceDelete();
            notyf()->success('Customer type permanently deleted.');
        } else {
            $customerType->status = 'inactive'; // Update status to inactive
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
        $customerType->status = 'active'; // Restore status to active
        $customerType->save();
        notyf()->success('Customer type restored successfully.');
    }

    public function toggleActive($id)
    {
        $customerType = CustomerType::withTrashed()->findOrFail($id);
        $customerType->status = $customerType->status === 'active' ? 'inactive' : 'active';
        $customerType->save();

        if ($customerType->trashed() && $customerType->status === 'active') {
            $customerType->restore();
        } elseif (!$customerType->trashed() && $customerType->status === 'inactive') {
            $customerType->delete();
        }

        notyf()->success('Customer type status updated successfully.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->resetFields();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }
}
