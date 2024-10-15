<?php

namespace App\Livewire\Admin\Warehouses;

use Livewire\Component;
use App\Models\Warehouse;
use Livewire\WithPagination;

class WarehouseList extends Component
{
    use WithPagination;

    public $warehouses;
    public $search = '';
    public $perPage = 20;
    public $confirmingDeletion = false;
    public $warehouseIdToDelete;

    protected $listeners = ['warehouseUpdated' => 'refreshWarehouses'];

    public function mount()
    {
        $this->refreshWarehouses();
    }

    public function refreshWarehouses()
    {
        $this->warehouses = Warehouse::all();
    }

    public function editWarehouse($id)
    {
        $this->emit('editWarehouse', $id);
    }

    public function confirmDelete($id)
    {
        $this->warehouseIdToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function deleteWarehouse()
    {
        // Implement delete logic
        Warehouse::destroy($this->warehouseIdToDelete);
        $this->confirmingDeletion = false;
        session()->flash('message', 'Warehouse deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.warehouses.warehouse-list');
    }
}
