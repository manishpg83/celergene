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

class YtdCombinedReportExport implements FromArray, WithTitle, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $year;
    protected $customerTypes;
    protected $countriesByCustomerType;

    public function __construct($year, $customerTypes, $countriesByCustomerType)
    {
        $this->year = $year;
        $this->customerTypes = $customerTypes;
        $this->countriesByCustomerType = $countriesByCustomerType;
    }

    public function array(): array
    {
        $rows = [];

        // Section 1: Customer Type Sales
        $rows[] = ["YTD SALES BY CUSTOMER TYPE - {$this->year}", "", ""];
        $rows[] = ['Customer Type', 'No. of Boxes', 'Total Amount (USD)'];
        foreach ($this->customerTypes as $row) {
            $rows[] = [$row['type'], $row['boxes'], $row['amount']];
        }

        $rows[] = ["", "", ""];
        $rows[] = ["", "", ""];

        // Sections for each customer type's countries
        foreach ($this->countriesByCustomerType as $customerTypeId => $data) {
            if (empty($data['countries'])) {
                continue;
            }

            $customerTypeName = $data['name'];
            $rows[] = ["YTD SALES BY COUNTRY ({$customerTypeName}) - {$this->year}", "", ""];
            $rows[] = ['Country', 'No. of Boxes', 'Total Amount (USD)'];

            // Calculate grand total for this customer type's countries
            $totalBoxes = 0;
            $totalAmount = 0;

            foreach ($data['countries'] as $row) {
                $rows[] = [$row['country'], $row['boxes'], $row['amount']];
                $totalBoxes += $row['boxes'];
                $totalAmount += $row['amount'];
            }

            // Add grand total row for this customer type
            $rows[] = ['Grand Total', $totalBoxes, $totalAmount];

            $rows[] = ["", "", ""];
            $rows[] = ["", "", ""];
        }

        return $rows;
    }

    public function headings(): array
    {
        // Laravel Excel needs this even if it's handled in the array method
        return [];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rows = $this->array();

                $currentRow = 1;

                foreach ($rows as $row) {
                    $isSectionHeader = isset($row[0]) && str_starts_with($row[0], 'YTD SALES');
                    $isGrandTotal = isset($row[0]) && $row[0] === 'Grand Total';

                    if ($isSectionHeader) {
                        // Merge and bold the header
                        $sheet->mergeCells("A{$currentRow}:C{$currentRow}");
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'font' => ['bold' => true],
                            'alignment' => ['horizontal' => 'center'],
                        ]);
                    }

                    if ($isGrandTotal) {
                        $sheet->getStyle("A{$currentRow}:C{$currentRow}")->applyFromArray([
                            'font' => ['bold' => true],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFEFEFEF'],
                            ],
                        ]);
                    }

                    // Apply border to all cells in row if it's a data row (skip empty)
                    if (!empty(array_filter($row))) {
                        $range = "A{$currentRow}:C{$currentRow}";
                        $sheet->getStyle($range)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => 'FF000000'],
                                ],
                            ],
                        ]);
                    }

                    $currentRow++;
                }
            }
        ];
    }

    public function title(): string
    {
        return "YTD Report {$this->year}";
    }
}