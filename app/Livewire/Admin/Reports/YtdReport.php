<?php

namespace App\Livewire\Admin\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\CustomerType;
use App\Models\OrderInvoice;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\YtdCombinedReportExport;
use Illuminate\Pagination\LengthAwarePaginator;

class YtdReport extends Component
{
    use WithPagination;

    public $year;
    public $reportType = 'customer_types';
    public $loading = false;
    public $perPage = 25;
    public $customerTypes = [];
    public $countriesData = [];

    protected $paginationTheme = 'tailwind';
    public $reportTypes = [
        'customer_types' => 'YTD SALES BY CUSTOMER TYPE',
        'online_countries' => 'YTD SALES BY COUNTRY (ONLINE)',
        'corporate_countries' => 'YTD SALES BY COUNTRY (CORPORATE CLIENTS)',
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

        if ($this->reportType === 'customer_types') {
            $this->loadCustomerTypeData();
        } else {
            $this->loadCountriesData();
        }

        $this->loading = false;
    }

    protected function loadCustomerTypeData()
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $types = CustomerType::all();

        $this->customerTypes = [];
        $grandTotalBoxes = 0;
        $grandTotalAmount = 0;

        foreach ($types as $type) {
            $invoices = OrderInvoice::whereHas('customer', function ($query) use ($type) {
                $query->where('customer_type_id', $type->id);
            })->where('invoice_category', '!=', 'shipping')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $totalAmount = $invoices->sum('total');
            $totalBoxes = $invoices->sum(function ($invoice) {
                return $invoice->invoiceDetails->sum('quantity');
            });

            $this->customerTypes[] = [
                'type' => $type->customer_type,
                'boxes' => $totalBoxes,
                'amount' => $totalAmount
            ];

            $grandTotalBoxes += $totalBoxes;
            $grandTotalAmount += $totalAmount;
        }
        $this->customerTypes[] = [
            'type' => 'Grand Total',
            'boxes' => $grandTotalBoxes,
            'amount' => $grandTotalAmount
        ];
    }

    protected function loadCountriesData()
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $customerTypeId = $this->reportType === 'online_countries' ? 1 : 2;

        $invoices = OrderInvoice::whereHas('customer', function ($query) use ($customerTypeId) {
            $query->where('customer_type_id', $customerTypeId);
        })
            ->where('invoice_category', '!=', 'shipping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('customer')
            ->get();

        $grouped = $invoices->groupBy('customer.billing_country');

        $this->countriesData = [];

        foreach ($grouped as $country => $countryInvoices) {
            $totalAmount = $countryInvoices->sum('total');
            $totalBoxes = $countryInvoices->sum(function ($invoice) {
                return $invoice->invoiceDetails->sum('quantity');
            });

            if ($country) {
                $this->countriesData[] = [
                    'country' => $country,
                    'boxes' => $totalBoxes,
                    'amount' => $totalAmount
                ];
            }
        }

        usort($this->countriesData, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });
    }

    public function exportExcel()
    {
        $this->loadAllDataForExport();

        return Excel::download(
            new YtdCombinedReportExport(
                $this->year,
                $this->customerTypes,
                $this->allCountriesByCustomerType
            ),
            "ytd-report-{$this->year}.xlsx"
        );
    }

    public function exportCsv()
    {
        $this->loadAllDataForExport();

        return Excel::download(
            new YtdCombinedReportExport(
                $this->year,
                $this->customerTypes,
                $this->allCountriesByCustomerType
            ),
            "ytd-report-{$this->year}.csv",
            \Maatwebsite\Excel\Excel::CSV
        );
    }
    protected function loadAllDataForExport()
    {
        $currentReportType = $this->reportType;

        $this->reportType = 'customer_types';
        $this->loadCustomerTypeData();

        $allCustomerTypes = CustomerType::all();

        $this->allCountriesByCustomerType = [];

        foreach ($allCustomerTypes as $customerType) {
            $this->allCountriesByCustomerType[$customerType->id] = [
                'name' => $customerType->customer_type,
                'countries' => $this->getCountriesDataByType($customerType->id)
            ];
        }

        $this->reportType = $currentReportType;
    }

    protected function getCountriesDataByType($customerTypeId)
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $invoices = OrderInvoice::whereHas('customer', function ($query) use ($customerTypeId) {
            $query->where('customer_type_id', $customerTypeId);
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('customer')
            ->get();

        $grouped = $invoices->groupBy('customer.shipping_country_1');

        $countriesData = [];

        foreach ($grouped as $country => $countryInvoices) {
            $totalAmount = $countryInvoices->sum('total');
            $totalBoxes = $countryInvoices->sum(function ($invoice) {
                return $invoice->invoiceDetails->sum('quantity');
            });

            if ($country) {
                $countriesData[] = [
                    'country' => $country,
                    'boxes' => $totalBoxes,
                    'amount' => $totalAmount
                ];
            }
        }

        usort($countriesData, function ($a, $b) {
            return $b['amount'] <=> $a['amount'];
        });

        return $countriesData;
    }
    protected function paginateCollection(Collection $items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage();
        $results = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator($results, $items->count(), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }
    public function render()
    {
        $data = $this->reportType === 'customer_types'
            ? collect($this->customerTypes)
            : collect($this->countriesData);

        $paginated = $this->reportType === 'customer_types'
            ? $data
            : $this->paginateCollection($data, $this->perPage);

        return view('livewire.admin.reports.ytd-report', [
            'data' => $paginated,
            'isCustomerTypeReport' => $this->reportType === 'customer_types',
        ]);
    }
}