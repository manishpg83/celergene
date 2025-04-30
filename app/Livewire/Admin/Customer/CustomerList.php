<?php

namespace App\Livewire\Admin\Customer;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerList extends Component
{
    use WithPagination;

    public $customerId;
    public $first_name, $last_name, $email;
    public $search = '', $perPage = 25, $isEditing = false;
    public $sortField = 'first_name';
    public $sortDirection = 'asc';
    public $confirmingDeletion = false;
    public $status = 'all';

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:customers,email',
    ];

    public function mount()
    {
        $this->resetFields();
    }

    public function render()
    {
        $query = Customer::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('company_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('billing_country', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                if ($this->status === 'active') {
                    $query->whereNull('deleted_at');
                } elseif ($this->status === 'inactive') {
                    $query->whereNotNull('deleted_at');
                }
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection);

        $customers = $query->paginate($this->perPage);
        $perpagerecords = perpagerecords();
        return view('livewire.admin.customer.customer-list', [
            'customers' => $customers,
            'perpagerecords' => $perpagerecords,
        ]);
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset(['customerId', 'first_name', 'last_name', 'email']);
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

    public function edit($id)
    {
        $customer = Customer::withTrashed()->find($id);
        if ($customer->trashed()) {
            notyf()->error('Customer is suspended. Please restore the customer first.');
        } else {
            $this->dispatch('openEditTab', route('admin.customer.add', ['id' => $customer->id]));
        }
    }

    public function save()
    {
        $this->validate();

        $customer = $this->customerId ? Customer::withTrashed()->find($this->customerId) : new Customer();

        $customer->fill($this->only(['first_name', 'last_name', 'email']));
        $customer->save();

        $this->isEditing = false;
        notyf()->success('Customer saved successfully.');
    }

    public function delete()
    {
        $customer = Customer::withTrashed()->find($this->customerId);

        if ($customer->trashed()) {
            $customer->forceDelete();
            notyf()->success('Customer permanently deleted.');
        } else {
            $customer->delete();
            notyf()->success('Customer suspended. Click delete again to permanently remove.');
        }

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->customerId = $id;
        $customer = Customer::withTrashed()->find($id);

        if ($customer->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete();
        }
    }

    public function restore($id)
    {
        $customer = Customer::withTrashed()->find($id);
        $customer->restore();
        notyf()->success('Customer restored successfully.');
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

    public function updatedStatus()
    {
        $this->resetPage();
    }



    public function exportExcel()
    {
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('company_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('billing_country', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                if ($this->status === 'active') {
                    $query->whereNull('deleted_at');
                } elseif ($this->status === 'inactive') {
                    $query->whereNotNull('deleted_at');
                }
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        return Excel::download(
            new CustomersExport($customers),
            'customers-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportCsv()
    {
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('company_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('billing_country', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                if ($this->status === 'active') {
                    $query->whereNull('deleted_at');
                } elseif ($this->status === 'inactive') {
                    $query->whereNotNull('deleted_at');
                }
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        return Excel::download(
            new CustomersExport($customers),
            'customers-' . now()->format('Y-m-d') . '.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }
}
