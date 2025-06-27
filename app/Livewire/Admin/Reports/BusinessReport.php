<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;
use App\Models\OrderInvoice;
use App\Models\Currency;
use Carbon\Carbon;
use App\Exports\BusinessReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class BusinessReport extends Component
{
    use WithPagination;

    public $year;
    public $loading = false;
    public $perPage = 25;
    public $currency = 'USD';
    public $availableCurrencies = [];

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->year = date('Y');
        $this->availableCurrencies = $this->getAvailableCurrencies();
    }

    protected function getAvailableCurrencies()
    {
        return Currency::where('status', Currency::STATUS_ACTIVE)
            ->orderBy('code')
            ->pluck('code')
            ->toArray();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedCurrency()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function getCustomersData()
    {
        $this->loading = true;

        $cacheKey = "business-report-{$this->year}-{$this->currency}";

        Cache::forget($cacheKey);

        $data = Cache::remember($cacheKey, now()->addHours(1), function () {
            $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
            $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

            $invoices = OrderInvoice::with(['customer', 'invoiceDetails'])
                ->join('order_master', 'order_invoice.order_id', '=', 'order_master.order_id')
                ->whereBetween('order_invoice.created_at', [$startDate, $endDate])
                ->where('order_invoice.status', '!=', 'cancelled')
                ->where('order_master.order_status', '!=', 'Cancelled')
                ->where(function ($query) {
                    $query->whereRaw("invoice_number NOT LIKE 'SHIP-%'")
                        ->orWhereNull('invoice_number');
                })
                ->get();

            $customerGroups = $invoices->groupBy('customer_id');
            $result = [];

            foreach ($customerGroups as $customerId => $customerInvoices) {
                $firstInvoice = $customerInvoices->first();
                $customer = $firstInvoice->customer;

                if (!$customer) {
                    \Log::warning("Customer not found for ID: {$customerId}, skipping");
                    continue;
                }

                $fullname = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: null;

                // Set up customer data structure
                $customerData = [
                    "country" => $customer->billing_country ?? null,
                    "fullname" => $fullname,
                    "currencycode" => $this->currency,
                    "JanQty" => 0,
                    "JanUSD" => 0,
                    "FebQty" => 0,
                    "FebUSD" => 0,
                    "MarQty" => 0,
                    "MarUSD" => 0,
                    "AprQty" => 0,
                    "AprUSD" => 0,
                    "MayQty" => 0,
                    "MayUSD" => 0,
                    "JunQty" => 0,
                    "JunUSD" => 0,
                    "JulQty" => 0,
                    "JulUSD" => 0,
                    "AugQty" => 0,
                    "AugUSD" => 0,
                    "SepQty" => 0,
                    "SepUSD" => 0,
                    "OctQty" => 0,
                    "OctUSD" => 0,
                    "NovQty" => 0,
                    "NovUSD" => 0,
                    "DecQty" => 0,
                    "DecUSD" => 0,
                    "TotalQty" => 0,
                    "TotalUSD" => 0,
                ];

                foreach ($customerInvoices as $invoice) {
                    $month = $invoice->created_at->format('M');

                    $qty = 0;
                    if ($invoice->invoiceDetails->count() > 0) {
                        $qty = $invoice->invoiceDetails->sum('quantity');
                    } else {
                        \Log::warning("Invoice has no detail records");
                    }

                    $amount = $invoice->total;
                    $sourceCurrency = $invoice->currency_code ?? 'USD';
                    $convertedAmount = $this->convertCurrency($amount, $sourceCurrency, $this->currency);

                    switch ($month) {
                        case 'Jan':
                            $customerData['JanQty'] += $qty;
                            $customerData['JanUSD'] += $convertedAmount;
                            break;
                        case 'Feb':
                            $customerData['FebQty'] += $qty;
                            $customerData['FebUSD'] += $convertedAmount;
                            break;
                        case 'Mar':
                            $customerData['MarQty'] += $qty;
                            $customerData['MarUSD'] += $convertedAmount;
                            break;
                        case 'Apr':
                            $customerData['AprQty'] += $qty;
                            $customerData['AprUSD'] += $convertedAmount;
                            break;
                        case 'May':
                            $customerData['MayQty'] += $qty;
                            $customerData['MayUSD'] += $convertedAmount;
                            break;
                        case 'Jun':
                            $customerData['JunQty'] += $qty;
                            $customerData['JunUSD'] += $convertedAmount;
                            break;
                        case 'Jul':
                            $customerData['JulQty'] += $qty;
                            $customerData['JulUSD'] += $convertedAmount;
                            break;
                        case 'Aug':
                            $customerData['AugQty'] += $qty;
                            $customerData['AugUSD'] += $convertedAmount;
                            break;
                        case 'Sep':
                            $customerData['SepQty'] += $qty;
                            $customerData['SepUSD'] += $convertedAmount;
                            break;
                        case 'Oct':
                            $customerData['OctQty'] += $qty;
                            $customerData['OctUSD'] += $convertedAmount;
                            break;
                        case 'Nov':
                            $customerData['NovQty'] += $qty;
                            $customerData['NovUSD'] += $convertedAmount;
                            break;
                        case 'Dec':
                            $customerData['DecQty'] += $qty;
                            $customerData['DecUSD'] += $convertedAmount;
                            break;
                    }

                    $customerData['TotalQty'] += $qty;
                    $customerData['TotalUSD'] += $convertedAmount;
                }

                $result[] = $customerData;
            }
            usort($result, function ($a, $b) {
                return ($a['fullname'] ?? '') <=> ($b['fullname'] ?? '');
            });
            return $result;
        });
        $this->loading = false;
        return $data;
    }

    protected function convertCurrency($amount, $fromCurrency, $toCurrency)
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        // Get all active currencies with their rates
        $currencies = Currency::where('status', Currency::STATUS_ACTIVE)
            ->pluck('rate', 'code')
            ->toArray();

        // If either currency is not found in database, return original amount
        if (!isset($currencies[$fromCurrency])) {
            \Log::warning("Currency rate not found for: {$fromCurrency}");
            return $amount;
        }

        if (!isset($currencies[$toCurrency])) {
            \Log::warning("Currency rate not found for: {$toCurrency}");
            return $amount;
        }

        // Convert to USD first, then to target currency
        $usdAmount = $amount / $currencies[$fromCurrency];
        return $usdAmount * $currencies[$toCurrency];
    }

    public function exportExcel()
    {
        $data = $this->getCustomersData();
        $currency = $this->currency;
        $year = $this->year;

        return Excel::download(
            new BusinessReportExport($data, $currency, $year),
            "business-report-{$year}-{$currency}.xlsx"
        );
    }

    public function exportCsv()
    {
        $data = $this->getCustomersData();
        $currency = $this->currency;
        $year = $this->year;

        return Excel::download(
            new BusinessReportExport($data, $currency, $year),
            "business-report-{$year}-{$currency}.csv",
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    public function render()
    {
        $data = $this->getCustomersData();

        return view('livewire.admin.reports.business-report', [
            'customers' => $data,
            'currencySymbol' => $this->getCurrencySymbol($this->currency)
        ]);
    }

    protected function getCurrencySymbol($currency)
    {
        $currencyModel = Currency::where('code', $currency)->first();
        
        return $currencyModel ? $currencyModel->symbol : '$';
    }
}