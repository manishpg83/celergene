<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CountryReportExport implements WithMultipleSheets
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new CountryReportSheet($this->data, $this->startDate, $this->endDate),
        ];
    }
}

use Illuminate\Support\Collection;

class CountryReportSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $rows = [];

        $totalBoxes = 0;
        $totalAmount = 0;

        foreach ($this->data as $row) {
            $rows[] = [
                $row['month'],
                $row['boxes'],
                number_format($row['amount'], 2),
            ];

            $totalBoxes += $row['boxes'];
            $totalAmount += $row['amount'];
        }

        $rows[] = [];
        $rows[] = [
            'Grand Total',
            $totalBoxes,
            number_format($totalAmount, 2),
        ];

        return new Collection($rows);
    }

    public function headings(): array
    {
        return [
            'Month',
            'Number of Boxes',
            'Total Amount (USD)',
        ];
    }

    public function title(): string
    {
        return 'Country Sales Report';
    }
}
