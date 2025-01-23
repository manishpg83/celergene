<?php

namespace App\Livewire\Admin\Warehouses;

use Livewire\Component;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\WarehouseEmail;
use Illuminate\Support\Facades\Auth;

class AddWarehouse extends Component
{
    public $warehouse_id, $warehouse_name, $country, $type, $remarks, $supplier_id, $address;
    public $emails = []; // For storing multiple emails
    public $isEditMode = false;
    public $suppliers;

    protected $listeners = ['editWarehouse'];

    public function mount()
    {
        $this->suppliers = Supplier::all();
        
        $this->warehouse_id = request()->query('id');

        if ($this->warehouse_id) {
            $warehouse = Warehouse::with('emails')->find($this->warehouse_id);
            if ($warehouse) {
                $this->warehouse_name = $warehouse->warehouse_name;
                $this->country = $warehouse->country;
                $this->type = $warehouse->type;
                $this->remarks = $warehouse->remarks;
                $this->supplier_id = $warehouse->supplier_id;
                $this->address = $warehouse->address;
                $this->emails = $warehouse->emails->pluck('email')->toArray();
                $this->isEditMode = true;
            }
        }
    }

    public function resetFields()
    {
        $this->warehouse_id = null;
        $this->warehouse_name = '';
        $this->country = '';
        $this->type = '';
        $this->remarks = '';
        $this->address = '';
        $this->supplier_id = null;
        $this->emails = [];
        $this->isEditMode = false;
    }

    public function addEmailField()
    {
        $this->emails[] = '';
    }

    public function removeEmailField($index)
    {
        unset($this->emails[$index]);
        $this->emails = array_values($this->emails);
    }

    public function saveWarehouse()
    {
        $this->validate([
            'warehouse_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'emails.*' => 'required|email|distinct',
            'address' => 'required|string|max:500',
        ]);

        $warehouse = Warehouse::updateOrCreate(
            ['id' => $this->warehouse_id],
            [
                'warehouse_name' => $this->warehouse_name,
                'country' => $this->country,
                'type' => $this->type,
                'remarks' => $this->remarks,
                'supplier_id' => $this->supplier_id,
                'address' => $this->address,
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
            ]
        );

        // Sync emails
        $warehouse->emails()->delete();
        foreach ($this->emails as $email) {
            $warehouse->emails()->create(['email' => $email]);
        }

        notyf()->success($this->warehouse_id ? 'Warehouse updated successfully.' : 'Warehouse created successfully.');
        $this->resetFields();
        return redirect()->route('admin.warehouses.index');
    }

    public function render()
    {
        return view('livewire.admin.warehouses.add-warehouse');
    }
}
