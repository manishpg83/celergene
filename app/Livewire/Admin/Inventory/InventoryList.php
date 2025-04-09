<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;

class InventoryList extends Component
{
    use WithPagination;

    public $perPage = 25;
    public $search = '';
    public $confirmingDeletion = false;
    public $inventoryId;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    protected $updatesQueryString = ['search', 'perPage'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortField = $field;
        }

        $this->resetPage();
    }

    public function render()
    {
        $inventories = Inventory::with(['product', 'warehouse', 'modifiedBy'])
            ->withTrashed()
            ->where(function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%')
                        ->orWhere('product_code', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('warehouse', function ($q) {
                        $q->where('warehouse_name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('batch_number', 'like', '%' . $this->search . '%')
                    ->orWhere('quantity', 'like', '%' . $this->search . '%')
                    ->orWhereHas('modifiedBy', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $perpagerecords = perpagerecords();

        return view('livewire.admin.inventory.inventory-list', [
            'inventories' => $inventories,
            'perpagerecords' => $perpagerecords,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->inventoryId = $id;
    }

    public function deleteInventory()
    {
        $inventory = Inventory::withTrashed()->find($this->inventoryId);
        if ($inventory) {
            $inventory->forceDelete();
            notyf()->success('Inventory item permanently deleted.');
        }

        $this->confirmingDeletion = false;
    }

    public function suspend($id)
    {
        $inventory = Inventory::find($id);
        if ($inventory) {
            $inventory->delete();
            notyf()->success('Inventory item suspended. Click permanently delete to remove.');
        }
    }

    public function restoreInventory($id)
    {
        $inventory = Inventory::withTrashed()->find($id);
        if ($inventory) {
            $inventory->restore();
            notyf()->success('Inventory item restored successfully.');
        }
    }

    public function editInventory($id)
    {
        $inventory = Inventory::withTrashed()->find($id);

        if ($inventory->trashed()) {
            notyf()->error('Cannot edit a suspended inventory item. Please restore it first.');
            return;
        }

        $this->dispatch('openEditTab', route('admin.inventory.add', ['id' => $id]));
    }
}
