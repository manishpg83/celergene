<?php

namespace App\Livewire\Admin\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\OrderInvoice;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\YtdCombinedReportExport;
use Illuminate\Pagination\LengthAwarePaginator;

class YtdReport extends Component
{
    use WithPagination;

    public $year;
    public $reportType = 'order_types';
    public $loading = false;
    public $perPage = 25;
    public $orderTypesData = [];
    public $countriesData = [];
    protected $paginationTheme = 'tailwind';

    public $reportTypes = [
        'order_types' => 'YTD SALES BY ORDER TYPE',
        'online_countries' => 'YTD SALES BY COUNTRY (ONLINE ORDERS)',
        'corporate_countries' => 'YTD SALES BY COUNTRY (OFFLINE ORDERS)',
    ];

    public function mount()
    {
        $this->year = date('Y');
        $this->loadData();
    }

    public function updatedYear()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function updatedReportType()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function loadData()
    {
        $this->loading = true;

        try {
            if ($this->reportType === 'order_types') {
                $this->loadOrderTypeData();
            } else {
                $this->loadCountriesData();
            }
        } catch (\Exception $e) {
            Log::error('Error loading data: ' . $e->getMessage());
            $this->dispatch('notify-error', message: 'Failed to load report data');
        } finally {
            $this->loading = false;
        }
    }

    protected function loadOrderTypeData()
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $invoices = OrderInvoice::where('invoice_category', '!=', 'shipping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('order', function ($query) {
                $query->where('order_status', '!=', 'Cancelled');
            })
            ->with(['order', 'invoiceDetails'])
            ->get();

        $groupedInvoices = $invoices->groupBy(function ($invoice) {
            return $invoice->order->order_type ?? 'unknown';
        });

        $onlineTotalAmount = 0;
        $onlineTotalBoxes = 0;
        $offlineTotalAmount = 0;
        $offlineTotalBoxes = 0;

        foreach ($groupedInvoices as $orderType => $typeInvoices) {
            $typeAmount = $typeInvoices->sum('total');
            $typeBoxes = $typeInvoices->sum(fn($inv) => $inv->invoiceDetails->sum('quantity'));

            if (strtolower($orderType) === 'online') {
                $onlineTotalAmount += $typeAmount;
                $onlineTotalBoxes += $typeBoxes;
            } else {
                $offlineTotalAmount += $typeAmount;
                $offlineTotalBoxes += $typeBoxes;
            }
        }

        $grandTotalAmount = $onlineTotalAmount + $offlineTotalAmount;
        $grandTotalBoxes = $onlineTotalBoxes + $offlineTotalBoxes;

        $this->orderTypesData = [
            [
                'type' => 'Online',
                'boxes' => $onlineTotalBoxes,
                'amount' => $onlineTotalAmount
            ],
            [
                'type' => 'Offline (Corporate & Individual)',
                'boxes' => $offlineTotalBoxes,
                'amount' => $offlineTotalAmount
            ],
            [
                'type' => 'Grand Total',
                'boxes' => $grandTotalBoxes,
                'amount' => $grandTotalAmount
            ]
        ];
    }

    protected function loadCountriesData()
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $orderType = $this->reportType === 'online_countries' ? 'online' : 'offline';

        $invoices = OrderInvoice::whereHas('order', function ($query) use ($orderType) {
            $query->where('order_type', $orderType)
                ->where('order_status', '!=', 'Cancelled');
        })
            ->where('invoice_category', '!=', 'shipping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['customer', 'invoiceDetails'])
            ->get();

        $grouped = $invoices->groupBy(function ($invoice) {
            return $invoice->customer->billing_country ?? 'Unknown';
        });

        $this->countriesData = [];

        foreach ($grouped as $country => $countryInvoices) {
            $totalAmount = $countryInvoices->sum('total');
            $totalBoxes = $countryInvoices->sum(function ($invoice) {
                return $invoice->invoiceDetails->sum('quantity');
            });

            $this->countriesData[] = [
                'country' => $country,
                'boxes' => $totalBoxes,
                'amount' => $totalAmount
            ];
        }

        usort($this->countriesData, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });
    }

    public function exportExcel()
    {
        try {
            $countriesData = $this->getCountriesDataForExport();
            $orderTypesData = $this->getOrderTypesDataForExport();

            return Excel::download(
                new YtdCombinedReportExport(
                    $this->year,
                    $orderTypesData,
                    $countriesData,
                    $this->reportType
                ),
                $this->generateExportFilename('xlsx')
            );
        } catch (\Exception $e) {
            $this->dispatch('notify-error', message: 'Export failed: ' . $e->getMessage());
        }
    }

    public function exportCsv()
    {
        try {
            $countriesData = $this->getCountriesDataForExport();
            $orderTypesData = $this->getOrderTypesDataForExport();

            return Excel::download(
                new YtdCombinedReportExport(
                    $this->year,
                    $orderTypesData,
                    $countriesData,
                    $this->reportType
                ),
                $this->generateExportFilename('csv'),
                \Maatwebsite\Excel\Excel::CSV
            );
        } catch (\Exception $e) {
            $this->dispatch('notify-error', message: 'Export failed: ' . $e->getMessage());
        }
    }

    protected function getOrderTypesDataForExport()
    {
        switch ($this->reportType) {
            case 'online_countries':
                return array_filter($this->orderTypesData, function ($item) {
                    return $item['type'] === 'Online';
                });

            case 'corporate_countries':
                return array_filter($this->orderTypesData, function ($item) {
                    return $item['type'] === 'Offline (Corporate & Individual)';
                });

            default: // order_types
                return $this->orderTypesData;
        }
    }

    protected function getCountriesDataForExport()
    {
        switch ($this->reportType) {
            case 'online_countries':
                return [
                    'online' => [
                        'name' => 'Online',
                        'countries' => $this->countriesData
                    ]
                ];

            case 'corporate_countries':
                return [
                    'offline' => [
                        'name' => 'Offline (Corporate & Individual)',
                        'countries' => $this->countriesData
                    ]
                ];

            default: // order_types
                return [
                    'online' => [
                        'name' => 'Online',
                        'countries' => $this->getCountriesDataByType('online')
                    ],
                    'offline' => [
                        'name' => 'Offline (Corporate & Individual)',
                        'countries' => $this->getCountriesDataByType('offline')
                    ]
                ];
        }
    }
    protected function prepareExportData()
    {
        $data = [
            'orderTypesData' => $this->orderTypesData,
            'countriesData' => []
        ];

        if ($this->reportType === 'order_types') {
            $data['countriesData'] = [
                'online' => [
                    'name' => 'Online',
                    'countries' => $this->getCountriesDataByType('online')
                ],
                'offline' => [
                    'name' => 'Offline',
                    'countries' => $this->getCountriesDataByType('offline')
                ]
            ];
        } else {
            $orderType = $this->reportType === 'online_countries' ? 'online' : 'offline';
            $data['countriesData'] = [
                $orderType => [
                    'name' => ucfirst($orderType),
                    'countries' => $this->countriesData
                ]
            ];
        }

        return $data;
    }

    protected function generateExportFilename($extension)
    {
        $reportTypeName = strtolower(str_replace(' ', '-', $this->reportTypes[$this->reportType]));
        return "ytd-{$reportTypeName}-{$this->year}.{$extension}";
    }

    protected function getCountriesDataByType($orderType)
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $invoices = OrderInvoice::whereHas('order', function ($query) use ($orderType) {
            $query->where('order_type', $orderType);
        })
            ->where('invoice_category', '!=', 'shipping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['customer', 'invoiceDetails'])
            ->get();

        $grouped = $invoices->groupBy(function ($invoice) {
            return $invoice->customer->billing_country ?? 'Unknown';
        });

        $countriesData = [];

        foreach ($grouped as $country => $countryInvoices) {
            $totalAmount = $countryInvoices->sum('total');
            $totalBoxes = $countryInvoices->sum(function ($invoice) {
                return $invoice->invoiceDetails->sum('quantity');
            });

            $countriesData[] = [
                'country' => $country,
                'boxes' => $totalBoxes,
                'amount' => $totalAmount
            ];
        }

        usort($countriesData, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });

        return $countriesData;
    }

    protected function paginateCollection(Collection $items, $perPage = 15, $page = null)
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage();
        $results = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $results,
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function render()
    {
        $data = $this->reportType === 'order_types'
            ? collect($this->orderTypesData)
            : collect($this->countriesData);

        $paginated = $this->reportType === 'order_types'
            ? $data
            : $this->paginateCollection($data, $this->perPage);

        return view('livewire.admin.reports.ytd-report', [
            'data' => $paginated,
            'isOrderTypeReport' => $this->reportType === 'order_types',
        ]);
    }
}