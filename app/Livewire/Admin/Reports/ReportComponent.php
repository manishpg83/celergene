<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderMaster;
use App\Models\OrderInvoice;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Log;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportComponent extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $country;
    public $perPage = 10;
    public $search = '';
    public $selectedYear;
    public $customer;

    protected $queryString = [
        'search' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'country' => ['except' => ''],
        'selectedYear' => ['except' => ''],
    ];

    public function mount()
    {
        // Set default date range to current month
        $this->startDate = now()->startOfYear()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->selectedYear = now()->year;
    }

    public function render()
    {
        if (empty($this->startDate) && empty($this->endDate)) {
            $monthlyData = $this->getMonthlyData($this->selectedYear);
            $countries = Customer::distinct()->pluck('billing_country')->filter()->sort()->values();

            return view('livewire.admin.reports.report-component', [
                'monthlyData' => $monthlyData,
                'countries' => $countries,
                'showMonthlyView' => true,
                'selectedYear' => $this->selectedYear,
            ]);
        } else {
            $invoicesQuery = OrderInvoice::query()
                ->join('customers', 'order_invoice.customer_id', '=', 'customers.id')
                ->join('order_invoice_details', 'order_invoice.id', '=', 'order_invoice_details.order_invoice_id')
                ->select(
                    'order_invoice.id',
                    'order_invoice.invoice_number',
                    'order_invoice.total',
                    'order_invoice.created_at as invoice_date',
                    'customers.first_name',
                    'customers.last_name',
                    'customers.billing_country as country',
                    DB::raw('SUM(order_invoice_details.quantity) as box_count'),
                )
                ->whereRaw("order_invoice.invoice_number NOT LIKE 'ship%'")
                ->groupBy(
                    'order_invoice.id',
                    'order_invoice.invoice_number',
                    'order_invoice.created_at',
                    'customers.first_name',
                    'customers.last_name',
                    'customers.billing_country'
                );


            // Apply filters
            if ($this->startDate) {
                $invoicesQuery->whereDate('order_invoice.created_at', '>=', $this->startDate);
            }

            if ($this->endDate) {
                $invoicesQuery->whereDate('order_invoice.created_at', '<=', $this->endDate);
            }

            if ($this->country) {
                $invoicesQuery->where('customers.billing_country', $this->country);
            }

            if ($this->search) {
                $invoicesQuery->where(function ($query) {
                    $query->where('customers.first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('customers.last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('order_invoice.invoice_number', 'like', '%' . $this->search . '%');
                });
            }

            $invoices = $invoicesQuery->orderBy('order_invoice.created_at')->paginate($this->perPage);

            // Calculate additional data for each invoice
            $reportData = $invoices->map(function ($invoice) {
                $boxCount = $invoice->invoiceDetails->sum('quantity');
                $totalAmountCHF = $invoice->total;
                $pricePerBox = $invoice->box_count > 0 ? $invoice->total_chf / $invoice->box_count : 0;

                return [
                    'id' => $invoice->id,
                    'date' => date('d-M-y', strtotime($invoice->invoice_date)),
                    'invoice_number' => $invoice->invoice_number,
                    'name' => $invoice->first_name . ' ' . $invoice->last_name,
                    'box_count' => $boxCount,
                    'price_per_box' => $pricePerBox,
                    'amount_chf' => $totalAmountCHF,
                    'country' => $invoice->country,
                    'amount_usd' => $totalAmountCHF,
                    'amount_usd_raw' => $totalAmountCHF,
                    'amount_chf_raw' => $totalAmountCHF
                ];
            });

            // Get unique countries for filter
            $countries = Customer::distinct()->pluck('billing_country')->filter()->sort()->values();

            return view('livewire.admin.reports.report-component', [
                'reportData' => $reportData,
                'countries' => $countries,
                'invoices' => $invoices,
                'showMonthlyView' => false,
            ]);
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'startDate', 'endDate', 'country']);
    }

    public function resetYear()
    {
        $this->selectedYear = now()->year;
    }

    public function setYear($year)
    {
        $this->selectedYear = $year;
        $this->resetFilters(); // Clear date filters to show monthly view
    }




    // Update the exportCsv method
    public function exportCsv()
    {
        if (empty($this->startDate) && empty($this->endDate)) {
            return $this->exportMonthlyCsv($this->selectedYear);
        } else {
            return $this->exportFilteredCsv();
        }
    }

    private function writeHeaderToFile($file, $title = '')
    {
        // Company header section
        fputcsv($file, ['CELERGENE BIOTECH']);
        fputcsv($file, ['━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━']);
        fputcsv($file, ['SALES REPORT']);

        // Report details
        if (!empty($title)) {
            fputcsv($file, [$title]);
        }

        // Additional information
        fputcsv($file, ['Report Generated: ' . date('d-M-Y H:i:s')]);
        if ($this->country) {
            fputcsv($file, ['Country Filter: ' . $this->country]);
        }
        if ($this->search) {
            fputcsv($file, ['Search Term: ' . $this->search]);
        }

        // Separator line
        fputcsv($file, ['━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━']);

        // Empty line before data
        fputcsv($file, []);
    }

    private function writeMonthHeader($file, $monthName)
    {
        // Month section header
        fputcsv($file, ['Month: ' . $monthName]);
        fputcsv($file, ['─────────────────────────────────────────']);
    }

    public function exportFilteredCsv()
    {
        try {
            \Log::info('Starting filtered CSV export process...');

            $data = $this->getReportData();
            \Log::info('Data retrieved:', ['data_count' => $data]);

            // Group data by month
            $groupedData = collect($data)->groupBy(function ($item) {
                return date('F Y', strtotime($item['date']));
            })->sortKeys();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="sales_report_' . date('Y-m-d') . '.csv"',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'public'
            ];

            $callback = function () use ($groupedData) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel compatibility

                // Write company header
                fputcsv($file, ['CELERGENE BIOTECH']);
                fputcsv($file, ['━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━']);
                fputcsv($file, ['SALES REPORT']);

                if ($this->startDate && $this->endDate) {
                    $startDate = date('d-M-y', strtotime($this->startDate));
                    $endDate = date('d-M-y', strtotime($this->endDate));
                    fputcsv($file, ["Period: $startDate to $endDate"]);
                }

                fputcsv($file, ['Report Generated: ' . date('d-M-Y H:i:s')]);
                fputcsv($file, ['━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━']);
                fputcsv($file, []); // Spacer

                foreach ($groupedData as $month => $monthData) {
                    fputcsv($file, ["Month: $month"]);
                    fputcsv($file, ['─────────────────────────────────────────']);

                    // Headers
                    $headers = [
                        'S/N',
                        'Date',
                        'Invoice #',
                        'Name',
                        'Product ID',
                        'Product Name',
                        'Qty',
                        'Per Box',
                        'Amount (USD)',
                        '', // Spacer
                        'S/N',
                        'Country',
                        '# of boxes',
                        'Total Amt (USD)'
                    ];
                    fputcsv($file, $headers);

                    // Group invoices and get country summary
                    $invoiceGroups = collect($monthData)->groupBy('invoice_number');
                    $invoiceRowsData = $this->generateInvoiceRows($invoiceGroups);
                    $invoiceRows = $invoiceRowsData['rows'];
                    $monthlyTotal = $invoiceRowsData['monthlyTotal'];

                    $countrySummary = $this->getCountrySummaryForData($monthData);
                    usort($countrySummary, function ($a, $b) {
                        return ($b['amount_usd_raw'] ?? 0) <=> ($a['amount_usd_raw'] ?? 0);
                    });

                    $maxRows = max(count($invoiceRows), count($countrySummary));
                    $summaryTotalBoxes = 0;
                    $summaryTotalUSD = 0;

                    for ($i = 0; $i < $maxRows; $i++) {
                        $left = $invoiceRows[$i] ?? array_fill(0, 9, '');
                        $right = [
                            '',
                            $i < count($countrySummary) ? $i + 1 : '',
                            $i < count($countrySummary) ? $countrySummary[$i]['country'] : '',
                            $i < count($countrySummary) ? $countrySummary[$i]['box_count'] : '',
                            $i < count($countrySummary) ? $countrySummary[$i]['amount_usd'] : ''
                        ];
                        fputcsv($file, array_merge($left, $right));

                        if ($i < count($countrySummary)) {
                            $summaryTotalBoxes += (int) $countrySummary[$i]['box_count'];
                            $summaryTotalUSD += isset($countrySummary[$i]['amount_usd_raw'])
                                ? $countrySummary[$i]['amount_usd_raw']
                                : floatval(str_replace(',', '', $countrySummary[$i]['amount_usd'] ?? '0'));
                        }
                    }

                    // Country total row
                    $summaryTotalRow = array_fill(0, 9, '');
                    $summaryTotalRow[9] = '';
                    $summaryTotalRow[10] = 'Total';
                    $summaryTotalRow[11] = '';
                    $summaryTotalRow[12] = $summaryTotalBoxes;
                    $summaryTotalRow[13] = 'USD ' . number_format($summaryTotalUSD, 2);
                    fputcsv($file, $summaryTotalRow);
                    $monthlyTotalRow = array_fill(0, 14, '');
                    $monthlyTotalRow[5] = 'Monthly Total'; // Product Name column
                    $monthlyTotalRow[8] = 'USD ' . number_format($monthlyTotal, 2); // Amount column
                    fputcsv($file, $monthlyTotalRow);
                    fputcsv($file, array_fill(0, 14, ''));
                    fputcsv($file, array_fill(0, 14, ''));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('CSV Export Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'memory_usage' => memory_get_usage(true),
                'peak_memory' => memory_get_peak_usage(true)
            ]);

            session()->flash('error', 'Error generating CSV file. Please check logs for details.');
            return redirect()->back();
        }
    }

    private function generateInvoiceRows($invoiceGroups)
    {
        $rows = [];
        $invoicesSN = 1;
        $monthlyTotal = 0;

        foreach ($invoiceGroups as $invoiceNumber => $invoiceItems) {
            $firstItem = $invoiceItems->first();
            $invoiceTotalBoxes = 0;
            $invoiceTotalAmount = 0;

            $products = [];

            foreach ($invoiceItems as $invoice) {
                if (isset($invoice['products']) && is_array($invoice['products'])) {
                    foreach ($invoice['products'] as $product) {
                        $products[] = [
                            'product_id' => $product['product_id'],
                            'product_name' => $product['product_name'],
                            'quantity' => $product['quantity'],
                            'price_per_box' => $product['price_per_box'],
                            'amount_chf' => $product['amount_chf_raw']
                        ];
                        $invoiceTotalBoxes += (int) ($product['quantity'] ?? 0);
                        $invoiceTotalAmount += $product['amount_chf_raw'] ?? 0;
                    }
                } else {
                    $products[] = [
                        'product_id' => $invoice['product_id'],
                        'product_name' => $invoice['product_name'],
                        'quantity' => $invoice['quantity'],
                        'price_per_box' => $invoice['price_per_box'],
                        'amount_chf' => $invoice['amount_chf']
                    ];
                    $invoiceTotalBoxes += (int) ($invoice['quantity'] ?? $invoice['box_count'] ?? 0);
                    $invoiceTotalAmount += $invoice['amount_chf_raw'] ?? 0;
                }
            }

            $invoiceProductCount = count($products);
            $monthlyTotal += $invoiceTotalAmount;
            for ($i = 0; $i < $invoiceProductCount; $i++) {
                if ($i == 0) {
                    $rows[] = [
                        $invoicesSN,
                        date('d-M-y', strtotime($firstItem['date'])),
                        $invoiceNumber,
                        $firstItem['name'],
                        $products[$i]['product_id'],
                        $products[$i]['product_name'],
                        $products[$i]['quantity'],
                        $products[$i]['price_per_box'],
                        $products[$i]['amount_chf']
                    ];
                } else {
                    $rows[] = [
                        '',
                        '',
                        '',
                        '',
                        $products[$i]['product_id'],
                        $products[$i]['product_name'],
                        $products[$i]['quantity'],
                        $products[$i]['price_per_box'],
                        $products[$i]['amount_chf']
                    ];
                }
            }

            // Invoice total row
            $rows[] = [
                '',
                '',
                '',
                '',
                '',
                'Invoice Total',
                $invoiceTotalBoxes,
                '',
                $invoiceTotalAmount
            ];

            $invoicesSN++;
        }

        // Final monthly total row is added separately in your main code
        return ['rows' => $rows, 'monthlyTotal' => $monthlyTotal];

    }

    private function getCountrySummaryForData($data)
    {
        $countrySummary = [];

        foreach ($data as $item) {
            $country = $item['country'];
            $boxCount = 0;
            $amountUsd = 0;

            // Get box count and amount from products
            if (isset($item['products']) && is_array($item['products'])) {
                foreach ($item['products'] as $product) {
                    $boxCount += $product['quantity'] ?? 0;
                    $amountUsd += $product['amount_usd_raw'] ?? 0;
                }
            } else {
                // Fallback for data without products breakdown
                $boxCount = $item['box_count'] ?? 0;
                $amountUsd = $item['amount_usd_raw'] ?? 0;
            }

            $found = false;
            foreach ($countrySummary as &$summary) {
                if ($summary['country'] === $country) {
                    $summary['box_count'] += $boxCount;
                    $summary['amount_usd_raw'] += $amountUsd;
                    $summary['amount_usd'] = number_format($summary['amount_usd_raw'], 2);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $countrySummary[] = [
                    'country' => $country,
                    'box_count' => $boxCount,
                    'amount_usd' => number_format($amountUsd, 2),
                    'amount_usd_raw' => $amountUsd
                ];
            }
        }

        return $countrySummary;
    }

   

    public function exportExcel()
    {
        if (empty($this->startDate) && empty($this->endDate)) {
            return $this->exportMonthlyExcel($this->selectedYear);
        } else {
            return $this->exportFilteredExcel();
        }
    }

    private function exportFilteredExcel()
    {
        try {
            \Log::info('Starting filtered Excel export process...');

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            \Log::info('Spreadsheet object created successfully');

            $data = $this->getReportData();
            \Log::info('Data retrieved:', ['data_count' => $data->count()]);

            $groupedData = collect($data)->groupBy(function ($item) {
                return date('F Y', strtotime($item['date']));
            })->sortKeys();

            $row = 1;

            $sheet->setCellValue('A' . $row, 'CELERGENE BIOTECH');
            $sheet->getStyle('A' . $row)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 16,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1a5d1a']
                ]
            ]);
            $row++;

            $sheet->setCellValue('A' . $row, '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $row++;

            $sheet->setCellValue('A' . $row, 'SALES REPORT');
            $sheet->getStyle('A' . $row)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 14,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '116530'],
                ]
            ]);
            $row++;

            if ($this->startDate && $this->endDate) {
                $startDate = date('d-M-y', strtotime($this->startDate));
                $endDate = date('d-M-y', strtotime($this->endDate));
                $sheet->setCellValue('A' . $row, "Period: $startDate to $endDate");
                $row++;
            }

            $sheet->setCellValue('A' . $row, 'Report Generated: ' . date('d-M-Y H:i:s'));
            $row++;

            $sheet->setCellValue('A' . $row, '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $row++;

            $row++;

            foreach ($groupedData as $month => $monthData) {
                $sheet->mergeCells("A$row:I$row");
                $sheet->setCellValue("A$row", "Month: $month");
                $sheet->getStyle("A$row")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
                $row++;

                $sheet->setCellValue('A' . $row, '─────────────────────────────────────────');
                $row++;

                $headers = ['S/N', 'Date', 'Invoice #', 'Name', 'Product ID', 'Product Name', 'Qty', 'Per Box', 'Amount (USD)', '', 'S/N', 'Country', '# of boxes', 'Total Amt (USD)'];
                $sheet->fromArray($headers, NULL, 'A' . $row);
                $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $sheet->getStyle('K' . $row . ':N' . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle("J$row")->applyFromArray([
                    'borders' => [
                        'left' => ['borderStyle' => Border::BORDER_NONE],
                        'right' => ['borderStyle' => Border::BORDER_NONE],
                        'top' => ['borderStyle' => Border::BORDER_NONE],
                        'bottom' => ['borderStyle' => Border::BORDER_NONE],
                    ],
                ]);
                $row++;

                $countrySummary = $this->getCountrySummaryForData($monthData);

                usort($countrySummary, function ($a, $b) {
                    return ($b['amount_usd_raw'] ?? 0) <=> ($a['amount_usd_raw'] ?? 0);
                });

                $invoiceGroups = collect($monthData)->groupBy('invoice_number');
                $expandedInvoices = [];

                foreach ($invoiceGroups as $invoiceNumber => $invoiceItems) {
                    $firstItem = $invoiceItems->first();
                    $totalBoxes = 0;
                    $totalAmount = 0;
                    $productText = '';
                    $productIdText = '';
                    $qtyText = '';
                    $perBoxText = '';
                    $amountText = '';

                    foreach ($invoiceItems as $idx => $invoice) {
                        if (isset($invoice['products']) && is_array($invoice['products'])) {
                            foreach ($invoice['products'] as $product) {
                                $productIdText .= $product['product_id'] . "\n";
                                $productText .= $product['product_name'] . "\n";
                                $qtyText .= $product['quantity'] . "\n";
                                $perBoxText .= $product['price_per_box'] . "\n";
                                $amountText .= number_format($product['amount_chf_raw'] ?? 0, 2) . "\n";
                                $totalBoxes += (int) ($product['quantity'] ?? 0);
                                $totalAmount += $product['amount_chf_raw'] ?? 0;
                            }
                        } else {
                            $productIdText .= $invoice['product_id'] . "\n";
                            $productText .= $invoice['product_name'] . "\n";
                            $qtyText .= $invoice['quantity'] . "\n";
                            $perBoxText .= $invoice['price_per_box'] . "\n";
                            $amountText .= $invoice['amount_chf'] . "\n";
                            $totalBoxes += (int) ($invoice['quantity'] ?? $invoice['box_count'] ?? 0);
                            $totalAmount += $invoice['amount_chf_raw'] ?? 0;
                        }
                    }

                    $productIdText = rtrim($productIdText);
                    $productText = rtrim($productText);
                    $qtyText = rtrim($qtyText);
                    $perBoxText = rtrim($perBoxText);
                    $amountText = rtrim($amountText);

                    $expandedInvoices[] = [
                        'date' => $firstItem['date'],
                        'invoice_number' => $invoiceNumber,
                        'name' => $firstItem['name'],
                        'product_id' => $productIdText,
                        'product_name' => $productText,
                        'quantity' => $qtyText,
                        'box_count' => $totalBoxes,
                        'price_per_box' => $perBoxText,
                        'amount_chf' => $amountText,
                        'amount_chf_raw' => $totalAmount,
                        'country' => $firstItem['country'],
                        'amount_usd_raw' => isset($firstItem['amount_usd_raw']) ?
                            $invoiceItems->sum('amount_usd_raw') :
                            floatval(str_replace(',', '', $firstItem['amount_usd'] ?? '0')),
                    ];
                }

                $maxRows = max(count($expandedInvoices), count($countrySummary));
                $sn = 1;
                $totalBoxes = 0;
                $totalCHF = 0;
                $totalUSD = 0;
                $summaryTotalBoxes = 0;
                $summaryTotalUSD = 0;

                $dataStartRow = $row;
                for ($i = 0; $i < $maxRows; $i++) {
                    $rowData = [
                        isset($expandedInvoices[$i]) ? $sn++ : '',
                        isset($expandedInvoices[$i]) ? date('d-M-y', strtotime($expandedInvoices[$i]['date'])) : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['invoice_number'] : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['name'] : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['product_id'] : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['product_name'] : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['quantity'] : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['price_per_box'] : '',
                        isset($expandedInvoices[$i]) ? $expandedInvoices[$i]['amount_chf'] : '',
                        '',
                        isset($countrySummary[$i]) ? ($i + 1) : '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['country'] : '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['box_count'] : '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['amount_usd'] : ''
                    ];

                    $sheet->fromArray([$rowData], NULL, 'A' . $row);

                    if (isset($expandedInvoices[$i])) {
                        $sheet->getStyle("E$row")->getAlignment()->setWrapText(true);
                        $sheet->getStyle("F$row")->getAlignment()->setWrapText(true);
                        $sheet->getStyle("G$row")->getAlignment()->setWrapText(true);
                        $sheet->getStyle("H$row")->getAlignment()->setWrapText(true);
                        $sheet->getStyle("I$row")->getAlignment()->setWrapText(true);

                        $lineCount = max(
                            substr_count($expandedInvoices[$i]['product_id'], "\n") + 1,
                            substr_count($expandedInvoices[$i]['product_name'], "\n") + 1,
                            substr_count($expandedInvoices[$i]['quantity'], "\n") + 1
                        );
                        $sheet->getRowDimension($row)->setRowHeight($lineCount * 15);
                    }

                    // Apply borders only to columns A-I and K-N, excluding J
                    $sheet->getStyle("A$row:I$row")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                            'right' => [
                                'borderStyle' => Border::BORDER_NONE,
                            ],
                        ],
                    ]);
                    $sheet->getStyle("K$row:N$row")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                            'left' => [
                                'borderStyle' => Border::BORDER_NONE,
                            ],
                        ],
                    ]);

                    $sheet->getStyle("J$row")->applyFromArray([
                        'borders' => [
                            'left' => ['borderStyle' => Border::BORDER_NONE],
                            'right' => ['borderStyle' => Border::BORDER_NONE],
                            'top' => ['borderStyle' => Border::BORDER_NONE],
                            'bottom' => ['borderStyle' => Border::BORDER_NONE],
                            'outline' => ['borderStyle' => Border::BORDER_NONE],
                            'inside' => ['borderStyle' => Border::BORDER_NONE],
                        ],
                    ]);

                    $sheet->getStyle("A$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // S/N
                    $sheet->getStyle("G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Qty
                    $sheet->getStyle("I$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Amount
                    $sheet->getStyle("K$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Summary S/N
                    $sheet->getStyle("M$row:N$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Summary numbers

                    $row++;
                    if (isset($expandedInvoices[$i])) {
                        $invoiceTotalRow = [
                            '',
                            '',
                            '',
                            '',
                            '',
                            'Invoice Total',
                            $expandedInvoices[$i]['box_count'],
                            '',
                            number_format($expandedInvoices[$i]['amount_chf_raw'], 2) // Summed and formatted
                        ];
                        $sheet->fromArray([$invoiceTotalRow], NULL, 'A' . $row);

                        $sheet->getStyle("A$row:I$row")->applyFromArray([
                            'font' => ['bold' => true],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                            'borders' => [
                                'top' => ['borderStyle' => Border::BORDER_THIN],
                            ],
                        ]);

                        $sheet->getStyle("G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $sheet->getStyle("I$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                        $row++;
                    }


                    if (isset($expandedInvoices[$i])) {
                        $totalBoxes += (int) $expandedInvoices[$i]['box_count'];
                        $totalCHF += $expandedInvoices[$i]['amount_chf_raw'] ?? 0;
                        $totalUSD += $expandedInvoices[$i]['amount_usd_raw'] ?? 0;
                    }

                    if (isset($countrySummary[$i])) {
                        $summaryTotalBoxes += (int) $countrySummary[$i]['box_count'];
                        $summaryTotalUSD += isset($countrySummary[$i]['amount_usd_raw'])
                            ? $countrySummary[$i]['amount_usd_raw']
                            : floatval(str_replace(',', '', $countrySummary[$i]['amount_usd'] ?? '0'));
                    }
                }

                $totalData = [
                    'Total',
                    '',
                    '',
                    '',
                    '',
                    '',
                    $totalBoxes,
                    '',
                    number_format($totalCHF, 2),
                    '',
                    'Total',
                    '',
                    $summaryTotalBoxes,
                    number_format($summaryTotalUSD, 2)
                ];
                $sheet->fromArray([$totalData], NULL, 'A' . $row);
                $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_DOUBLE,
                            'color' => ['rgb' => '000000'],
                        ],
                        'top' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                $sheet->getStyle("G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Total Qty
                $sheet->getStyle("I$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Total Amount
                $sheet->getStyle("M$row:N$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Summary totals

                $sheet->getStyle("A$dataStartRow:N$row")->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $row += 3;
            }

            $sheet->getColumnDimension('A')->setWidth(7);  // S/N
            $sheet->getColumnDimension('B')->setWidth(10);  // Date
            $sheet->getColumnDimension('C')->setWidth(16);  // Invoice #
            $sheet->getColumnDimension('D')->setWidth(20);  // Name
            $sheet->getColumnDimension('E')->setWidth(12);  // Product ID
            $sheet->getColumnDimension('F')->setWidth(22);  // Product Name
            $sheet->getColumnDimension('G')->setWidth(8);   // Qty
            $sheet->getColumnDimension('H')->setWidth(12);  // Per Box
            $sheet->getColumnDimension('I')->setWidth(15);  // Amount
            $sheet->getColumnDimension('J')->setWidth(5);   // Spacer
            $sheet->getColumnDimension('K')->setWidth(10);  // S/N
            $sheet->getColumnDimension('L')->setWidth(15);  // Country
            $sheet->getColumnDimension('M')->setWidth(15);  // # of boxes
            $sheet->getColumnDimension('N')->setWidth(20);  // Total Amt (USD)

            \Log::info('Preparing file for download...');
            $writer = new Xlsx($spreadsheet);
            $filename = 'sales_report_' . date('Y-m-d') . '.xlsx';

            $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
            $writer->save($tempFile);

            \Log::info('File saved to temp location: ' . $tempFile);

            return response()->download($tempFile, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel Export Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'memory_usage' => memory_get_usage(true),
                'peak_memory' => memory_get_peak_usage(true)
            ]);

            session()->flash('error', 'Error generating Excel file. Please check logs for details.');
            return redirect()->back();
        }
    }

    private function getReportData()
    {
        try {
            $query = DB::table('order_invoice')
                ->join('customers', 'order_invoice.customer_id', '=', 'customers.id')
                ->select(
                    'order_invoice.id',
                    'order_invoice.created_at as date',
                    'order_invoice.invoice_number',
                    'customers.first_name',
                    'customers.last_name',
                    'customers.id as customer_id',
                    'customers.billing_country as country',
                    'order_invoice.total as amount_chf'
                )
                ->whereRaw("order_invoice.invoice_number NOT LIKE 'ship%'");

            // Apply date range filter if set
            if ($this->startDate && $this->endDate) {
                $query->whereBetween('order_invoice.created_at', [$this->startDate, $this->endDate]);
            }

            // Apply other filters if set
            if ($this->country) {
                $query->where('customers.billing_country', $this->country);
            }

            if ($this->customer) {
                $query->where('customers.id', $this->customer);
            }

            $salesData = $query->orderBy('order_invoice.created_at', 'desc')->get();

            // Process the data
            $formattedData = [];
            foreach ($salesData as $sale) {
                $products = DB::table('order_invoice_details')
                    ->select(
                        'order_invoice_details.id',
                        'order_invoice_details.product_id',
                        'products.product_name',
                        'order_invoice_details.quantity',
                        'order_invoice_details.unit_price as price_per_unit',
                        'order_invoice_details.total as subtotal_chf',
                        // DB::raw('order_invoice_details.quantity * order_invoice_details.unit_price as subtotal_chf')
                    )
                    ->join('products', 'order_invoice_details.product_id', '=', 'products.id')
                    ->where('order_invoice_details.order_invoice_id', $sale->id)
                    ->get();

                $exchangeRate = 1.076;
                $amountUSD = $sale->amount_chf;

                // Format the products data
                $formattedProducts = [];
                foreach ($products as $product) {
                    $subtotalUSD = $product->subtotal_chf * $exchangeRate;
                    $formattedProducts[] = [
                        'product_id' => $product->product_id,
                        'product_name' => $product->product_name,
                        'quantity' => $product->quantity,
                        'price_per_box' => number_format($product->price_per_unit, 2),
                        'amount_chf' => $product->subtotal_chf,
                        'amount_chf_raw' => $product->subtotal_chf,
                        'amount_usd' => $product->subtotal_chf,
                        'amount_usd_raw' => $product->subtotal_chf
                    ];
                }

                // Calculate total box count from products
                $totalBoxes = 0;
                foreach ($products as $product) {
                    $totalBoxes += $product->quantity;
                }

                // Format the customer name
                $customerName = $sale->first_name . ' ' . $sale->last_name;

                // Add the sale to the formatted data
                $formattedData[] = [
                    'id' => $sale->id,
                    'date' => date('Y-m-d', strtotime($sale->date)),
                    'invoice_number' => $sale->invoice_number,
                    'name' => $customerName,
                    'country' => $sale->country,
                    'box_count' => $totalBoxes,
                    'price_per_box' => '', // Will be shown at product level
                    'amount_chf' => $sale->amount_chf,
                    'amount_chf_raw' => $sale->amount_chf,
                    'amount_usd' => number_format($amountUSD, 2),
                    'amount_usd_raw' => $amountUSD,
                    'products' => $formattedProducts
                ];
            }

            return collect($formattedData);
        } catch (\Exception $e) {
            \Log::error('Error getting report data', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return collect([]);
        }
    }

    //Not in use getMonthlyData, getCountrySummaryData, exportMonthlyCsv
    private function getMonthlyData($year)
    {
        $monthlyData = [];

        // Process each month
        for ($month = 1; $month <= 12; $month++) {
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate));

            // Store original filter values
            $originalStartDate = $this->startDate;
            $originalEndDate = $this->endDate;
            $originalCountry = $this->country;
            $originalSearch = $this->search;

            // Temporarily set filter dates to query this month
            $this->startDate = $startDate;
            $this->endDate = $endDate;

            // Get report data for this month
            $reportData = $this->getReportData();
            $countrySummary = $this->getCountrySummaryData();

            // Reset the filters to original values
            $this->startDate = $originalStartDate;
            $this->endDate = $originalEndDate;
            $this->country = $originalCountry;
            $this->search = $originalSearch;

            // Calculate month totals
            $totalBoxes = 0;
            $totalCHF = 0;
            $totalUSD = 0;

            foreach ($reportData as $item) {
                $totalBoxes += $item['box_count'];
                $totalCHF += $item['amount_chf_raw'];
                $totalUSD += $item['amount_usd_raw'];
            }

            // Add month data if there are records
            $monthlyData[] = [
                'month' => date('F', strtotime($startDate)),
                'month_number' => $month,
                'reportData' => $reportData,
                'countrySummary' => $countrySummary,
                'totalBoxes' => $totalBoxes,
                'totalCHF' => $totalCHF,
                'totalUSD' => $totalUSD,
            ];
        }

        return $monthlyData;
    }
    private function getCountrySummaryData()
    {
        $invoicesQuery = OrderInvoice::query()
            ->join('customers', 'order_invoice.customer_id', '=', 'customers.id')
            ->select(
                'customers.billing_country as country',
                'order_invoice.id'
            )
            ->with(['invoiceDetails'])
            ->whereRaw("order_invoice.invoice_number NOT LIKE 'ship%'");


        // Apply filters
        if ($this->startDate) {
            $invoicesQuery->whereDate('order_invoice.created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $invoicesQuery->whereDate('order_invoice.created_at', '<=', $this->endDate);
        }

        if ($this->country) {
            $invoicesQuery->where('customers.billing_country', $this->country);
        }

        if ($this->search) {
            $invoicesQuery->where(function ($query) {
                $query->where('customers.first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('customers.last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('order_invoice.invoice_number', 'like', '%' . $this->search . '%');
            });
        }

        $invoices = $invoicesQuery->get();

        $countryData = [];
        foreach ($invoices as $invoice) {
            $country = $invoice->country ?: 'Unknown';

            if (!isset($countryData[$country])) {
                $countryData[$country] = [
                    'box_count' => 0,
                    'amount_chf' => 0,
                    'amount_usd' => 0
                ];
            }

            // Calculate values from invoice details
            $invoiceBoxCount = $invoice->invoiceDetails->sum('quantity');
            $invoiceAmountCHF = $invoice->invoiceDetails->sum(function ($detail) {
                return $detail->unit_price * $detail->quantity;
            });
            $invoiceAmountUSD = $invoiceAmountCHF * 1.076;

            $countryData[$country]['box_count'] += $invoiceBoxCount;
            $countryData[$country]['amount_chf'] += $invoiceAmountCHF;
            $countryData[$country]['amount_usd'] += $invoiceAmountUSD;
        }

        $summaryData = [];
        $index = 1;
        foreach ($countryData as $country => $data) {
            $summaryData[] = [
                'sn' => $index++,
                'country' => $country,
                'box_count' => $data['box_count'],
                'amount_chf' => $data['amount_chf'],
                'amount_usd' => number_format($data['amount_usd'], 2),
                'amount_usd_raw' => $data['amount_usd']
            ];
        }

        return $summaryData;
    }
    public function exportMonthlyCsv($year = null)
    {
        $year = $year ?? now()->year;
        $monthlyData = $this->getMonthlyData($year);

        usort($monthlyData, function ($a, $b) {
            return $b['month_number'] <=> $a['month_number'];
        });

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="monthly_sales_report_' . date('Y-m-d') . '.csv"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public'
        ];

        $callback = function () use ($monthlyData, $year) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            $this->writeHeaderToFile($file, "Year: $year");

            foreach ($monthlyData as $monthData) {
                if (count($monthData['reportData']) === 0) {
                    continue;
                }

                $monthAbbr = substr($monthData['month'], 0, 3);

                $this->writeMonthHeader($file, $monthAbbr);

                fputcsv($file, ['S/N', 'Date', 'Invoice #', 'Name', 'CAV', 'Per Box', 'Amount (USD)', 'Country', 'USD', '', 'S/N', 'Country', '# of boxes', 'Total Amt (USD)']);

                $reportData = $monthData['reportData'];
                $countrySummary = $monthData['countrySummary'];

                usort($countrySummary, function ($a, $b) {
                    return ($b['amount_usd_raw'] ?? 0) <=> ($a['amount_usd_raw'] ?? 0);
                });

                foreach ($countrySummary as $index => $item) {
                    $countrySummary[$index]['sn'] = $index + 1;
                }

                $maxRows = max(count($reportData), count($countrySummary));

                $sn = 1;
                $totalBoxes = 0;
                $totalCHF = 0;
                $totalUSD = 0;
                $summaryTotalBoxes = 0;
                $summaryTotalUSD = 0;

                for ($i = 0; $i < $maxRows; $i++) {
                    $dateValue = '';
                    if (isset($reportData[$i])) {
                        $originalDate = $reportData[$i]['date'];
                        try {
                            $date = new \DateTime($originalDate);
                            $dateValue = $date->format('d-M-y');
                        } catch (\Exception $e) {
                            $dateValue = $originalDate;
                        }
                    }

                    $rowData = [
                        isset($reportData[$i]) ? $sn++ : '',
                        $dateValue,
                        isset($reportData[$i]) ? $reportData[$i]['invoice_number'] : '',
                        isset($reportData[$i]) ? $reportData[$i]['name'] : '',
                        isset($reportData[$i]) ? $reportData[$i]['box_count'] : '',
                        isset($reportData[$i]) ? $reportData[$i]['price_per_box'] : '',
                        isset($reportData[$i]) ? $reportData[$i]['amount_chf'] : '',
                        isset($reportData[$i]) ? $reportData[$i]['country'] : '',
                        isset($reportData[$i]) ? $reportData[$i]['amount_usd'] : '',
                        '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['sn'] : '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['country'] : '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['box_count'] : '',
                        isset($countrySummary[$i]) ? $countrySummary[$i]['amount_usd'] : ''
                    ];

                    fputcsv($file, $rowData);

                    if (isset($reportData[$i])) {
                        $totalBoxes += (int) $reportData[$i]['box_count'];
                        $totalCHF += $reportData[$i]['amount_chf_raw'] ?? 0;
                        $totalUSD += $reportData[$i]['amount_usd_raw'] ?? 0;
                    }

                    if (isset($countrySummary[$i])) {
                        $summaryTotalBoxes += (int) $countrySummary[$i]['box_count'];

                        if (isset($countrySummary[$i]['amount_usd_raw'])) {
                            $summaryTotalUSD += $countrySummary[$i]['amount_usd_raw'];
                        } else {
                            $summaryTotalUSD += floatval(str_replace(',', '', $countrySummary[$i]['amount_usd'] ?? '0'));
                        }
                    }
                }

                // Add month total row
                fputcsv($file, [
                    'Total',
                    '',
                    '',
                    '',
                    $totalBoxes,
                    '',
                    $totalCHF,
                    '',
                    number_format($totalUSD, 2),
                    '',
                    'Total',
                    '',
                    $summaryTotalBoxes,
                    number_format($summaryTotalUSD, 2)
                ]);

                // Add empty row as separator between months
                fputcsv($file, array_fill(0, 15, ''));
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}