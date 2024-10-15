<?php

namespace App\Livewire\Admin\Warehouses;

use Livewire\Component;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class AddWarehouse extends Component
{
    public $warehouse_id, $warehouse_name, $country, $type, $remarks;
    public $isEditMode = false;

    protected $listeners = ['editWarehouse'];

    public function resetFields()
    {
        $this->warehouse_id = null;
        $this->warehouse_name = '';
        $this->country = '';
        $this->type = '';
        $this->remarks = '';
        $this->isEditMode = false;
    }

    public function saveWarehouse()
    {
        $this->validate([
            'warehouse_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        Warehouse::updateOrCreate(
            ['id' => $this->warehouse_id],
            [
                'warehouse_name' => $this->warehouse_name,
                'country' => $this->country,
                'type' => $this->type,
                'remarks' => $this->remarks,
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
            ]
        );

        session()->flash('message', $this->warehouse_id ? 'Warehouse updated successfully.' : 'Warehouse created successfully.');
        $this->resetFields();
        notyf()->success('warehouse created successfully.');
    }

    public function editWarehouse($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $this->warehouse_id = $warehouse->id;
        $this->warehouse_name = $warehouse->warehouse_name;
        $this->country = $warehouse->country;
        $this->type = $warehouse->type;
        $this->remarks = $warehouse->remarks;
        $this->isEditMode = true;
    }

    public function back()
    {
        return redirect()->route('admin.warehouses');
    }

    public function render()
    {
        return view('livewire.admin.warehouses.add-warehouse');
    }
}
