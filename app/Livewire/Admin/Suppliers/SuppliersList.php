<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SuppliersList extends Component
{
    use WithPagination;

    public $perPage = 25;
    public $search = '';
    public $sortField = 'supplier_name'; // Default sort field
    public $sortDirection = 'asc';      // Default sort direction
    public $confirmingDeletion = false;
    public $supplierId;

    protected $updatesQueryString = ['search', 'perPage'];

    public function render()
    {
        $suppliers = Supplier::query()
            ->withTrashed()
            ->where(function ($query) {
                $query->where('supplier_name', 'like', '%' . $this->search . '%')
                    ->orWhere('country', 'like', '%' . $this->search . '%')
                    ->orWhere('remarks', 'like', '%' . $this->search . '%')
                    ->orWhereHas('creator', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $perpagerecords = perpagerecords();

        return view('livewire.admin.suppliers.suppliers-list', [
            'suppliers' => $suppliers,
            'perpagerecords' => $perpagerecords,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }


    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->supplierId = $id;
    }

    public function suspend($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->delete();
            notyf()->success('Supplier suspended. Click permanently delete to remove.');
        }
    }

    public function deleteSupplier()
    {
        $supplier = Supplier::withTrashed()->find($this->supplierId);

        if ($supplier && $supplier->trashed()) {
            $supplier->forceDelete();
            notyf()->success('Supplier permanently deleted.');
        }

        $this->confirmingDeletion = false;
    }

    public function restoreSupplier($id)
    {
        $supplier = Supplier::withTrashed()->find($id);
        if ($supplier) {
            $supplier->restore();
            notyf()->success('Supplier restored successfully.');
        }
    }

    public function edit($id)
    {
        return redirect()->route('admin.suppliers.add', ['id' => $id]);
    }
}
