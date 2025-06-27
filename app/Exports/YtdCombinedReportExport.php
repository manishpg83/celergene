<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class YtdCombinedReportExport implements FromArray, WithTitle, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $year;
    protected $orderTypesData;
    protected $countriesByOrderType;
    protected $currentReportType;

    public function __construct($year, $orderTypesData, $countriesByOrderType, $currentReportType = 'order_types')
    {
        $this->year = $year;
        $this->orderTypesData = $orderTypesData;
        $this->countriesByOrderType = $countriesByOrderType;
        $this->currentReportType = $currentReportType;
    }

    public function array(): array
    {
        $rows = [];
        $rows[] = [config('app.name') . " - YTD Report - {$this->year}", "", ""];
        $rows[] = ["", "", ""];

        $rows[] = ["YTD SALES BY ORDER TYPE - {$this->year}", "", ""];
        $rows[] = ['Order Type', 'No. of Boxes', 'Total Amount (USD)'];

        foreach ($this->orderTypesData as $row) {
            if ($this->currentReportType === 'online_countries' && $row['type'] !== 'Online') {
                continue;
            }
            if ($this->currentReportType === 'corporate_countries' && $row['type'] !== 'Offline (Corporate & Individual)') {
                continue;
            }

            $rows[] = [
                $row['type'],
                number_format($row['boxes']),
                number_format($row['amount'], 2)
            ];
        }
        $rows[] = ["", "", ""];
        $rows[] = ["", "", ""];

        foreach ($this->countriesByOrderType as $orderTypeId => $data) {
            if (empty($data['countries'])) {
                continue;
            }

            if ($this->currentReportType === 'online_countries' && $orderTypeId !== 'online') {
                continue;
            }
            if ($this->currentReportType === 'corporate_countries' && $orderTypeId !== 'offline') {
                continue;
            }

            $rows[] = ["YTD SALES BY COUNTRY ({$data['name']}) - {$this->year}", "", ""];
            $rows[] = ['Country', 'No. of Boxes', 'Total Amount (USD)'];

            $totalBoxes = 0;
            $totalAmount = 0;

            foreach ($data['countries'] as $row) {
                $rows[] = [
                    $row['country'],
                    number_format($row['boxes']),
                    number_format($row['amount'], 2)
                ];
                $totalBoxes += $row['boxes'];
                $totalAmount += $row['amount'];
            }

            $rows[] = [
                'Grand Total',
                number_format($totalBoxes),
                number_format($totalAmount, 2)
            ];

            $rows[] = ["", "", ""];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();

                $sheet->getStyle("A1:C{$highestRow}")->applyFromArray([
                    'font' => ['name' => 'Arial', 'size' => 10],
                ]);

                $sheet->getStyle("B1:C{$highestRow}")->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                ]);

                $currentRow = 1;
                foreach ($sheet->getRowIterator() as $row) {
                    $cellValue = $sheet->getCell('A' . $currentRow)->getValue();

                    if (str_contains($cellValue, config('app.name'))) {
                        $sheet->mergeCells("A{$currentRow}:C{$currentRow}");
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'font' => ['bold' => true, 'size' => 14],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                    } elseif (str_starts_with($cellValue, 'YTD SALES')) {
                        $sheet->mergeCells("A{$currentRow}:C{$currentRow}");
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'font' => ['bold' => true, 'size' => 12],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                    } elseif (in_array($cellValue, ['Order Type', 'Country'])) {
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'font' => ['bold' => true],
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'FFD9D9D9']],
                        ]);
                    } elseif ($cellValue === 'Grand Total') {
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'font' => ['bold' => true],
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'FFEFEFEF']],
                        ]);
                    }

                    if (!empty($cellValue)) {
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'borders' => [
                                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']],
                            ],
                        ]);
                    }

                    $currentRow++;
                }

                foreach (range('A', 'C') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }

    public function title(): string
    {
        return "YTD Report {$this->year}";
    }
}