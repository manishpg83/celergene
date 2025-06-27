<?php

namespace App\Exports;

use App\Models\OrderMaster;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $currentYearStart = now()->startOfYear()->format('Y-m-d');
        $currentYearEnd = now()->endOfYear()->format('Y-m-d');

        return OrderMaster::with(['customer', 'orderDetails.product', 'entity'])
            ->when($this->filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_id', 'like', '%' . $search . '%')
                        ->orWhereHas('customer', function ($customerQuery) use ($search) {
                            $customerQuery->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('entity', function ($entityQuery) use ($search) {
                            $entityQuery->where('company_name', 'like', '%' . $search . '%');
                        })
                        ->orWhere('total', 'like', '%' . $search . '%')
                        ->orWhere('order_date', 'like', '%' . $search . '%')
                        ->orWhere('payment_mode', 'like', '%' . $search . '%')
                        ->orWhere('order_type', 'like', '%' . $search . '%');
                });
            })
            ->when($this->filters['selectedEntityId'] ?? null, function ($query, $entityId) {
                $query->where('entity_id', $entityId);
            })
            ->when($this->filters['dateStart'] ?? null && $this->filters['dateEnd'] ?? null, function ($query) {
                $query->whereDate('order_date', '>=', $this->filters['dateStart'])
                    ->whereDate('order_date', '<=', $this->filters['dateEnd']);
            })
            ->when(!($this->filters['dateStart'] ?? null) && !($this->filters['dateEnd'] ?? null), function ($query) use ($currentYearStart, $currentYearEnd) {
                $query->whereDate('order_date', '>=', $currentYearStart)
                    ->whereDate('order_date', '<=', $currentYearEnd);
            })
            ->when($this->filters['statusFilter'] ?? null !== '', function ($query) {
                $query->where('order_status', $this->filters['statusFilter']);
            })
            ->when($this->filters['showCancelled'] ?? null == 1, function ($query) {
                $query->where('order_status', 'Cancelled');
            })
            ->when($this->filters['showCancelled'] ?? null == 0, function ($query) {
                $query->where('order_status', '!=', 'Cancelled');
            })
            ->when($this->filters['paymentModeFilter'] ?? null !== '', function ($query) {
                $query->where('payment_mode', $this->filters['paymentModeFilter']);
            })
            ->when($this->filters['orderTypeFilter'] ?? null !== '', function ($query) {
                $query->where('order_type', $this->filters['orderTypeFilter']);
            })
            ->where('parent_order_id', null) // Only main orders
            ->orderBy($this->filters['sortField'] ?? 'created_at', $this->filters['sortDirection'] ?? 'desc');
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Order Type',
            'Customer Name',
            'Customer Email',
            'Order Date',
            'Total Amount',
            'Currency',
            'Payment Mode',
            'Order Status',
            'Entity/Company',
            'Shipping Address',
            'Remarks',
            'Created At',
            'Updated At'
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_id,
            $order->order_type,
            ($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? ''),
            $order->customer->email ?? '',
            $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y') : '',
            number_format($order->total, 2),
            $order->currency->symbol ?? '$',
            $order->payment_mode,
            $order->order_status,
            $order->entity->company_name ?? '',
            $order->shipping_address,
            $order->remarks,
            $order->created_at ? $order->created_at->format('M d, Y H:i:s') : '',
            $order->updated_at ? $order->updated_at->format('M d, Y H:i:s') : '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}