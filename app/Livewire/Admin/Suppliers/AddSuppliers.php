<?php

namespace App\Livewire\Admin\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class AddSuppliers extends Component
{
    public $supplier_id;
    public $supplier_name;
    public $country;
    public $remarks;
    public $created_by;
    public $isEditMode = false;

    protected $rules = [
        'supplier_name' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'remarks' => 'nullable|string',
    ];

    public function mount()
    {
        $this->supplier_id = request()->query('id');

        if ($this->supplier_id) {
            $supplier = Supplier::find($this->supplier_id);
            if ($supplier) {
                $this->supplier_name = $supplier->supplier_name;
                $this->country = $supplier->country;
                $this->remarks = $supplier->remarks;
                $this->created_by = $supplier->created_by;
                $this->isEditMode = true;
            }
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->isEditMode) {
            $supplier = Supplier::find($this->supplier_id);
            if ($supplier) {
                $supplier->update([
                    'supplier_name' => $this->supplier_name,
                    'country' => $this->country,
                    'remarks' => $this->remarks,
                    'created_by' => $this->created_by,
                ]);
                notyf()->success('Supplier updated successfully.');
            }
        } else {
            Supplier::create([
                'supplier_name' => $this->supplier_name,
                'country' => $this->country,
                'remarks' => $this->remarks,
                'created_by' => $this->created_by,
            ]);
            notyf()->success('Supplier added successfully.');
        }

        return redirect()->route('admin.suppliers.index');
    }

    public function softDelete($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->delete();
            notyf()->success('Supplier deleted successfully.');
        }
    }

    public function back()
    {
        return redirect()->route('admin.suppliers.index');
    }

    public function render()
    {
        return view('livewire.admin.suppliers.add-suppliers');
    }
}
