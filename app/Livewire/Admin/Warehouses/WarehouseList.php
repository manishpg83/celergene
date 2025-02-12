<?php

namespace App\Livewire\Admin\Warehouses;

use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class WarehouseList extends Component
{
    use WithPagination;

    public $warehouseId;
    public $warehouse_name, $country, $type, $remarks;
    public $search = '', $perPage = 25, $isEditing = false;
    public $sortField = 'warehouse_name';
    public $sortDirection = 'asc';
    public $confirmingDeletion = false;

    protected $rules = [
        'warehouse_name' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'remarks' => 'nullable|string',
    ];

    public function mount()
    {
        $this->resetFields();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset(['warehouseId', 'warehouse_name', 'country', 'type', 'remarks']);
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
        $warehouse = Warehouse::withTrashed()->find($id);

        if ($warehouse->trashed()) {
            notyf()->error('Cannot edit a suspended entity. Please restore it first.');
            return;
        }
        
        $this->dispatch('openEditTab', route('admin.warehouses.add', ['id' => $id]));
    }

    public function save()
    {
        $this->validate();

        $warehouse = $this->warehouseId ? Warehouse::withTrashed()->find($this->warehouseId) : new Warehouse();

        $warehouse->fill($this->only(['warehouse_name', 'country', 'type', 'remarks']));
        $warehouse->save();

        $this->isEditing = false;
        notyf()->success('Warehouse saved successfully.');
    }

    public function delete()
    {
        $warehouse = Warehouse::withTrashed()->find($this->warehouseId);

        if ($warehouse->trashed()) {
            $warehouse->forceDelete();
            notyf()->success('Warehouse permanently deleted.');
        } else {
            $warehouse->delete();
            notyf()->success('Warehouse suspended. Click delete again to permanently remove.');
        }

        $this->confirmingDeletion = false;
    }

    public function confirmDelete($id)
    {
        $this->warehouseId = $id;
        $warehouse = Warehouse::withTrashed()->find($id);

        if ($warehouse->trashed()) {
            $this->confirmingDeletion = true;
        } else {
            $this->delete();
        }
    }

    public function restore($id)
    {
        $warehouse = Warehouse::withTrashed()->find($id);
        $warehouse->restore();
        notyf()->success('Warehouse restored successfully.');
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

    public function render()
    {
        $query = Warehouse::query()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('warehouse_name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('country', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('type', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->withTrashed()
            ->orderBy($this->sortField, $this->sortDirection);

        $warehouses = $query->paginate($this->perPage);
        $perpagerecords = perpagerecords();
        return view('livewire.admin.warehouses.warehouse-list', [
            'warehouses' => $warehouses,
            'perpagerecords' => $perpagerecords,
        ]);
    }
}
