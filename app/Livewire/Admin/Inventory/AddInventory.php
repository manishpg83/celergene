<?php

namespace App\Livewire\Admin\Inventory;

use App\Models\BatchNumber;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\InventoryHistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
    public $total_qty = 0;
    public $consumed = 0;
    public $remaining;
    public $minExpireDate;
    public $isEditMode = false;
    public $reason;

    public $destination_warehouse_id;
    public $transfer_quantity;
    public $transfer_reason;

    public $batchNumbers = [];

    public function rules()
    {
        return [
            'product_code' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'batch_number' => 'required|string|max:255',
            'expiry' => 'nullable|date_format:Y-m|after_or_equal:' . date('Y-m'),
            'quantity' => 'required|integer|min:0',
            'remaining' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'destination_warehouse_id' => 'required|exists:warehouses,id',
            'transfer_quantity' => 'required|integer|min:1',
            'transfer_reason' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->inventory_id = request()->query('id');
        $this->minExpireDate = date('Y-m');


        $this->batchNumbers = BatchNumber::pluck('batch_number', 'id')->toArray();
        if ($this->inventory_id) {
            $inventory = Inventory::find($this->inventory_id);
            if ($inventory) {
                $this->fill($inventory->toArray());
                $this->expiry = $inventory->expiry ? date('Y-m', strtotime($inventory->expiry)) : $this->expiry;
                $this->isEditMode = true;
                $this->total_qty = $inventory->total_qty;

                $this->quantity = 0;
                $this->remaining = $inventory->remaining;
                $latestStock = Stock::where('inventory_id', $this->inventory_id)
                    ->latest('created_at')
                    ->first();
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
            ->paginate(25);
    }
    public function saveInventory()
    {
        DB::transaction(function () {
            $oldInventory = $this->inventory_id ? Inventory::find($this->inventory_id) : null;

            $oldQuantity = $oldInventory ? $oldInventory->quantity : 0;
            $oldRemaining = $oldInventory ? $oldInventory->remaining : 0;
            $oldConsumed = $oldInventory ? $oldInventory->consumed : 0;
            $oldTotalQty = $oldInventory ? $oldInventory->total_qty : 0;

            $newQuantity = $oldQuantity + $this->quantity;
            $newRemaining = $oldRemaining + $this->quantity;

            $newTotalQty = $this->quantity > 0 ? $oldTotalQty + $this->quantity : $oldTotalQty;

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
                    'total_qty' => $newTotalQty,
                    'consumed' => $oldConsumed,
                    'remaining' => $newRemaining,
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
            $this->quantity = 0;
        });

        notyf()->success($this->inventory_id ? 'Inventory updated successfully.' : 'Inventory added successfully.');
        $this->dispatch('$refresh');
        $this->refreshLatestStockData();
    }
    public function refreshLatestStockData()
    {
        if (!$this->inventory_id)
            return;

        $latestStock = Stock::where('inventory_id', $this->inventory_id)
            ->latest('created_at')
            ->first();

        if ($latestStock) {
            // $this->quantity = $latestStock->new_quantity;
            $this->reason = $latestStock->reason;
        }

        $inventory = Inventory::find($this->inventory_id);
        $this->remaining = $inventory?->remaining;
        $this->total_qty = $inventory?->total_qty;
    }

    public function initiateTransfer()
    {
        $this->reset(['destination_warehouse_id', 'transfer_quantity', 'transfer_reason']);
        $this->dispatchBrowserEvent('openTransferModal');
    }

    public function exportExcel()
    {
        if (!$this->inventory_id || !$this->isEditMode) {
            notyf()->error('No inventory data to export.');
            return;
        }

        $stockCount = Stock::where('inventory_id', $this->inventory_id)
            ->where('product_id', $this->product_code)
            ->count();

        if ($stockCount == 0) {
            notyf()->warning('No stock history data available to export.');
            return;
        }

        $inventory = Inventory::find($this->inventory_id);
        $fileName = 'inventory_history_' . $inventory->product->product_code . '_' . date('Y_m_d_H_i_s') . '.xlsx';

        return Excel::download(
            new InventoryHistoryExport($this->inventory_id, $this->product_code),
            $fileName
        );
    }

    public function exportCsv()
    {
        if (!$this->inventory_id || !$this->isEditMode) {
            notyf()->error('No inventory data to export.');
            return;
        }

        $stockCount = Stock::where('inventory_id', $this->inventory_id)
            ->where('product_id', $this->product_code)
            ->count();

        if ($stockCount == 0) {
            notyf()->warning('No stock history data available to export.');
            return;
        }

        $inventory = Inventory::find($this->inventory_id);
        $fileName = 'inventory_history_' . $inventory->product->product_code . '_' . date('Y_m_d_H_i_s') . '.csv';

        return Excel::download(
            new InventoryHistoryExport($this->inventory_id, $this->product_code),
            $fileName,
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function transferStock()
    {
        $this->validate([
            'destination_warehouse_id' => 'required|exists:warehouses,id',
            'transfer_quantity' => 'required|integer|min:1|lte:' . $this->remaining,
            'transfer_reason' => 'required|string|max:255',
        ]);

        if (!$this->expiry) {
            $this->expiry = (date('Y') + 1) . '-12';
        }

        $formattedExpireDate = date('Y-m-d', strtotime($this->expiry . '-01'));

        DB::transaction(function () use ($formattedExpireDate) {
            $inventory = Inventory::find($this->inventory_id);
            $inventory->quantity -= $this->transfer_quantity;
            $inventory->remaining -= $this->transfer_quantity;
            $inventory->save();

            $destinationInventory = Inventory::firstOrCreate(
                [
                    'product_code' => $this->product_code,
                    'warehouse_id' => $this->destination_warehouse_id,
                    'batch_number' => $this->batch_number,
                ],
                [
                    'expiry' => $formattedExpireDate,
                    'quantity' => 0,
                    'total_qty' => 0,
                    'consumed' => 0,
                    'remaining' => 0,
                    'created_by' => Auth::id(),
                    'modified_by' => Auth::id(),
                ]
            );

            $destinationInventory->quantity += $this->transfer_quantity;
            $destinationInventory->remaining += $this->transfer_quantity;
            $destinationInventory->total_qty += $this->transfer_quantity;
            $destinationInventory->save();

            Stock::create([
                'inventory_id' => $inventory->id,
                'product_id' => $this->product_code,
                'previous_quantity' => $inventory->quantity + $this->transfer_quantity,
                'quantity_change' => -$this->transfer_quantity,
                'new_quantity' => $inventory->quantity,
                'reason' => $this->transfer_reason,
                'created_by' => Auth::id(),
            ]);

            Stock::create([
                'inventory_id' => $destinationInventory->id,
                'product_id' => $this->product_code,
                'previous_quantity' => $destinationInventory->quantity - $this->transfer_quantity,
                'quantity_change' => $this->transfer_quantity,
                'new_quantity' => $destinationInventory->quantity,
                'reason' => $this->transfer_reason,
                'created_by' => Auth::id(),
            ]);
        });

        notyf()->success('Stock transferred successfully.');
        $this->dispatch('$refresh');
        $this->refreshLatestStockData();
    }


    public function back()
    {
        return redirect()->route('admin.inventory.index');
    }

    public function render()
    {
        $products = Product::where('id', '!=', 1)->get();
        return view('livewire.admin.inventory.add-inventory', [
            'products' => $products,
            'warehouses' => Warehouse::all(),
            'stockHistory' => $this->stockHistory,
            'batchNumbers' => $this->batchNumbers,
        ]);
    }
}
