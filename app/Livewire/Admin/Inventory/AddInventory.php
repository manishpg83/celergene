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
    public $minExpireDate;
    public $isEditMode = false;
    public $reason;

    public function rules()
    {
        return [
            'product_code' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'batch_number' => 'required|string|max:255',
            'expiry' => 'nullable|date_format:Y-m|after_or_equal:' . date('Y-m'),
            'quantity' => 'required|integer|min:1',
            'remaining' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->inventory_id = request()->query('id');
        $this->minExpireDate = date('Y-m');
        $this->expiry = date('Y') . '-12';

        if ($this->inventory_id) {
            $inventory = Inventory::find($this->inventory_id);
            if ($inventory) {
                $this->fill($inventory->toArray());
                $this->expiry = $inventory->expiry ? date('Y-m', strtotime($inventory->expiry)) : $this->expiry;
                $this->isEditMode = true;

                $latestStock = Stock::where('inventory_id', $this->inventory_id)
                    ->latest('created_at')
                    ->first();

                $this->reason = $latestStock ? $latestStock->reason : '';
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
            ->paginate(5);
    }

    public function saveInventory()
    {

        DB::transaction(function () {
            $oldInventory = Inventory::find($this->inventory_id);
            $oldQuantity = $oldInventory ? $oldInventory->quantity : 0;

            $newQuantity = $this->isEditMode ? $oldQuantity + $this->quantity : $this->quantity;
            $this->remaining = $newQuantity - $this->consumed;

            if (!$this->expiry) {
                $this->expiry = (date('Y') + 1) . '-12';
            }
            $formattedExpireDate = $this->expiry . '-01';

            $inventory = Inventory::updateOrCreate(
                ['id' => $this->inventory_id],
                [
                    'product_code' => $this->product_code,
                    'warehouse_id' => $this->warehouse_id,
                    'batch_number' => $this->batch_number,
                    'expiry' => $formattedExpireDate,
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
                'reason' => $this->reason,
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
