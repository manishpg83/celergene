<?php

namespace App\Livewire\Admin\Inventory;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AddInventory extends Component
{
    use WithPagination;

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
        'remaining' => 'required|integer|min:1',
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

    public function getStockHistoryProperty()
    {
        if (!$this->inventory_id || !$this->isEditMode) {
            return collect([]);
        }

        return Stock::with('creator')
            ->where('inventory_id', $this->inventory_id)
            ->where('product_id', $this->product_code)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
    }

    public function saveInventory()
    {    

        DB::transaction(function () {
            $oldInventory = Inventory::find($this->inventory_id);
            $oldQuantity = $oldInventory ? $oldInventory->quantity : 0;
    
            $newQuantity = $this->isEditMode ? $oldQuantity + $this->quantity : $this->quantity;
            $this->remaining = $newQuantity - $this->consumed;
    
            $inventory = Inventory::updateOrCreate(
                ['id' => $this->inventory_id],
                [
                    'product_code' => $this->product_code,
                    'warehouse_id' => $this->warehouse_id,
                    'batch_number' => $this->batch_number,
                    'expiry' => $this->expiry,
                    'quantity' => $newQuantity,
                    'consumed' => $this->consumed,
                    'remaining' => $this->remaining,
                    'created_by' => $this->inventory_id ? $oldInventory->created_by : Auth::id(),
                    'modified_by' => Auth::id(),
                ]
            );
        
            Stock::create([
                'inventory_id' => $inventory->id,
                'product_id' => $this->product_code,
                'previous_quantity' => $oldQuantity,
                'quantity_change' => $this->quantity,
                'new_quantity' => $newQuantity,
                'reason' => $this->inventory_id ? 'Added more stock' : 'New inventory',
                'created_by' => Auth::id()
            ]);
    
        });
    
        notyf()->success($this->inventory_id ? 'Inventory updated successfully.' : 'Inventory added successfully.');
        return redirect()->route('admin.inventory.index');
    }    

    public function back()
    {
        return redirect()->route('admin.inventory.index');
    }

    public function render()
    {
        return view('livewire.admin.inventory.add-inventory', [
            'products' => Product::all(),
            'warehouses' => Warehouse::all(),
            'stockHistory' => $this->stockHistory
        ]);
    }
}