<?php

namespace App\Livewire\Admin\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\OrderInvoice;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Exports\CountryReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class CountryReport extends Component
{
    use WithPagination;

    public $year;
    public $selectedCountry = '';
    public $loading = false;
    public $perPage = 12;
    public $monthlyData = [];
    public $grandTotalBoxes = 0;
    public $grandTotalAmount = 0;

    protected $paginationTheme = 'tailwind';

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

    public function updatedSelectedCountry()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function loadData()
    {
        $this->loading = true;
        $this->monthlyData = [];
        $this->grandTotalBoxes = 0;
        $this->grandTotalAmount = 0;
        $this->monthlyData = $this->fetchMonthlyData();

        foreach ($this->monthlyData as $month) {
            $this->grandTotalBoxes += $month['boxes'];
            $this->grandTotalAmount += $month['amount'];
        }

        $this->loading = false;
    }

    protected function fetchMonthlyData()
    {
        $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $query = OrderInvoice::with(['invoiceDetails'])
            ->join('order_master', 'order_invoice.order_id', '=', 'order_master.order_id')
            ->whereBetween('order_invoice.created_at', [$startDate, $endDate])
            ->where('order_invoice.invoice_category', '!=', 'shipping')
            ->where('order_master.order_status', '!=', 'Cancelled');

        if ($this->selectedCountry) {
            $query->whereHas('customer', function ($q) {
                $q->where('billing_country', $this->selectedCountry);
            });
        }
        $invoices = $query->get();
        $monthlyData = [];

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        foreach ($months as $index => $monthName) {
            $monthNumber = $index + 1;

            $monthInvoices = $invoices->filter(function ($invoice) use ($monthNumber) {
                return Carbon::parse($invoice->created_at)->month === $monthNumber;
            });

            $totalBoxes = $monthInvoices->sum(function ($invoice) {
                return $invoice->invoiceDetails->sum('quantity');
            });
            $totalAmount = $monthInvoices->sum('total');

            $monthlyData[] = [
                'month' => $monthName,
                'boxes' => $totalBoxes,
                'amount' => $totalAmount
            ];
        }

        return $monthlyData;
    }


    public function exportExcel()
    {
        return Excel::download(
            new CountryReportExport($this->monthlyData, $this->selectedCountry, $this->year),
            "country-monthly-report-{$this->year}-{$this->selectedCountry}.xlsx"
        );
    }

    public function exportCsv()
    {
        return Excel::download(
            new CountryReportExport($this->monthlyData, $this->selectedCountry, $this->year),
            "country-monthly-report-{$this->year}-{$this->selectedCountry}.csv",
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function getCountriesProperty()
    {
        return OrderInvoice::with('customer')
            ->whereHas('customer')
            ->get()
            ->pluck('customer.billing_country')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    public function resetFilters()
    {
        $this->year = date('Y');
        $this->selectedCountry = '';
        $this->resetPage();
        $this->loadData();
    }
    
    public function render()
    {
        return view('livewire.admin.reports.country-report', [
            'countries' => $this->countries,
            'monthlyData' => $this->monthlyData,
            'grandTotalBoxes' => $this->grandTotalBoxes,
            'grandTotalAmount' => $this->grandTotalAmount,
        ]);
    }
}