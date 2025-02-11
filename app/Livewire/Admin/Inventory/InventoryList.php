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

    protected $updatesQueryString = ['search', 'perPage'];

    public function render()
    {
        $inventories = Inventory::with('product', 'warehouse', 'modifiedBy')
            ->withTrashed()
            ->where(function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('warehouse', function ($q) {
                    $q->where('warehouse_name', 'like', '%' . $this->search . '%');
                });
            })
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
