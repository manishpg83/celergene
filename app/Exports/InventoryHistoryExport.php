<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryHistoryExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $inventoryId;
    protected $productId;

    public function __construct($inventoryId, $productId)
    {
        $this->inventoryId = $inventoryId;
        $this->productId = $productId;
    }

    public function collection()
    {
        return Stock::with(['creator', 'inventory.product', 'inventory.warehouse'])
            ->where('inventory_id', $this->inventoryId)
            ->where('product_id', $this->productId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Product Code',
            'Warehouse',
            'Batch Number',
            'Previous Quantity',
            'Quantity Change',
            'New Quantity',
            'Reason',
            'Created By',
            'Created At'
        ];
    }

    public function map($stock): array
    {
        return [
            $stock->created_at->format('Y-m-d'),
            $stock->inventory->product->product_code ?? 'N/A',
            $stock->inventory->warehouse->warehouse_name ?? 'N/A',
            $stock->inventory->batch_number ?? 'N/A',
            $stock->previous_quantity,
            $stock->quantity_change,
            $stock->new_quantity,
            $stock->reason,
            $stock->creator->name ?? 'N/A',
            $stock->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}