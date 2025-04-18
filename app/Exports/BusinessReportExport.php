<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BusinessReportExport implements FromArray, WithTitle, WithHeadings, WithEvents
{
    protected $data;
    protected $currency;
    protected $year;

    public function __construct(array $data, string $currency, string $year)
    {
        $this->data = $data;
        $this->currency = $currency;
        $this->year = $year;
    }

    public function array(): array
    {
        $rows = [];

        // Add header row
        $headers = [
            'Country', 'Full Name', 'Currency Code',
            'Jan Qty', 'Jan ' . $this->currency,
            'Feb Qty', 'Feb ' . $this->currency,
            'Mar Qty', 'Mar ' . $this->currency,
            'Apr Qty', 'Apr ' . $this->currency,
            'May Qty', 'May ' . $this->currency,
            'Jun Qty', 'Jun ' . $this->currency,
            'Jul Qty', 'Jul ' . $this->currency,
            'Aug Qty', 'Aug ' . $this->currency,
            'Sep Qty', 'Sep ' . $this->currency,
            'Oct Qty', 'Oct ' . $this->currency,
            'Nov Qty', 'Nov ' . $this->currency,
            'Dec Qty', 'Dec ' . $this->currency,
            'Total Qty', 'Total ' . $this->currency
        ];

        $rows[] = $headers;

        // Add data rows
        foreach ($this->data as $row) {
            $dataRow = [
                $row['country'],
                $row['fullname'],
                $row['currencycode'],
                $row['JanQty'], $row['JanUSD'],
                $row['FebQty'], $row['FebUSD'],
                $row['MarQty'], $row['MarUSD'],
                $row['AprQty'], $row['AprUSD'],
                $row['MayQty'], $row['MayUSD'],
                $row['JunQty'], $row['JunUSD'],
                $row['JulQty'], $row['JulUSD'],
                $row['AugQty'], $row['AugUSD'],
                $row['SepQty'], $row['SepUSD'],
                $row['OctQty'], $row['OctUSD'],
                $row['NovQty'], $row['NovUSD'],
                $row['DecQty'], $row['DecUSD'],
                $row['TotalQty'], $row['TotalUSD']
            ];
            $rows[] = $dataRow;
        }

        // Add blank line before totals
        $rows[] = array_fill(0, count($headers), '');

        // Add totals row
        $totals = ['Grand Total', '', ''];
        $totalColumns = [
            'JanQty', 'JanUSD', 'FebQty', 'FebUSD', 'MarQty', 'MarUSD',
            'AprQty', 'AprUSD', 'MayQty', 'MayUSD', 'JunQty', 'JunUSD',
            'JulQty', 'JulUSD', 'AugQty', 'AugUSD', 'SepQty', 'SepUSD',
            'OctQty', 'OctUSD', 'NovQty', 'NovUSD', 'DecQty', 'DecUSD',
            'TotalQty', 'TotalUSD'
        ];

        foreach ($totalColumns as $col) {
            $columnTotal = array_sum(array_column($this->data, $col));
            $totals[] = $col === 'TotalQty' || strpos($col, 'Qty') !== false ? $columnTotal : round($columnTotal, 2);
        }

        $rows[] = $totals;

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return "Business Report {$this->year}";
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = count($this->data) + 3; // +3 because we added a blank line (header row + data rows + blank line + totals row)

                // Style the header row
                $sheet->getStyle('A1:AC1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFD9D9D9'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style the totals row (now two rows down from where it was before)
                $sheet->getStyle("A{$lastRow}:AC{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEFEFEF'],
                    ],
                ]);

                // Add borders to all cells except the blank line
                $sheet->getStyle("A1:AC".($lastRow-1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                
                // Add borders to totals row
                $sheet->getStyle("A{$lastRow}:AC{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Auto-size columns
                foreach(range('A','AC') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}