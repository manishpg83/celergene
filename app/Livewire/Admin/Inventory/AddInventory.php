<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class AddInventory extends Component
{
    public $inventory_id;
    public $product_code;
    public $warehouse_id;
    public $batch_number;
    public $expiry;
    public $quantity;
    public $consumed = 0;
    public $remaining;
    public $isEditMode = false;

    protected $rules = [
        'product_code' => 'required|exists:products,id',
        'warehouse_id' => 'required|exists:warehouses,id',
        'batch_number' => 'required|string|max:255',
        'expiry' => 'required|date',
        'quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->inventory_id = request()->query('id');

        if ($this->inventory_id) {
            $inventory = Inventory::find($this->inventory_id);
            if ($inventory) {
                $this->fill($inventory->toArray());
                $this->isEditMode = true;
            }
        }
    }

    public function saveInventory()
    {
        $this->validate();

        Inventory::updateOrCreate(
            ['id' => $this->inventory_id],
            [
                'product_code' => $this->product_code,
                'warehouse_id' => $this->warehouse_id,
                'batch_number' => $this->batch_number,
                'expiry' => $this->expiry,
                'quantity' => $this->quantity,
                'consumed' => $this->consumed,
                'remaining' => $this->quantity,
                'created_by' => Auth::id(), 
                'modified_by' => Auth::id(),
            ]
        );

        notyf()->success($this->isEditMode ? 'Inventory updated successfully.' : 'Inventory added successfully.');
        return redirect()->route('admin.inventory.index');
    }

    public function back()
    {
        return redirect()->route('admin.inventory.index');
    }

    public function render()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();

        return view('livewire.admin.inventory.add-inventory', compact('products', 'warehouses'));
    }
}
