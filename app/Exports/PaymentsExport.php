<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $debtors;

    public function __construct($debtors)
    {
        $this->debtors = $debtors;
    }

    public function collection()
    {
        return $this->debtors;
    }

    public function headings(): array
    {
        return [
            'Invoice ID',
            'Invoice Date',
            'Name',
            'Company Name',
            'Country',
            'Invoice Amount',
            'Order Amount',
            'Overdue by (Days)',
            'Created By',
        ];
    }

    public function map($debtor): array
    {
        return [
            $debtor->invoice_number,
            $debtor->invoice_date,
            $debtor->customer->first_name . ' ' . $debtor->customer->last_name,
            $debtor->customer->company_name,
            $debtor->customer->billing_country,
            number_format($debtor->total, 2),
            number_format($debtor->order->total ?? 0, 2),
            $debtor->overdue_days,
            $debtor->createdBy->name,
        ];
    }
}