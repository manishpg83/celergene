<?php

namespace App\Livewire\Admin\Debtors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OrderInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;
use Carbon\Carbon;

class DebtorsList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 25;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function downloadPdf()
    {
        $debtors = OrderInvoice::with(['customer', 'createdBy', 'order'])->latest()->get();

        $debtors->each(function ($invoice) {
            $invoice->overdue_days = (int)Carbon::parse($invoice->created_at)->diffInDays(now());
        });

        $pdf = Pdf::loadView('livewire.admin.debtors.pdf-template', [
            'debtors' => $debtors,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'debtors-list.pdf');
    }

    public function downloadCsv()
    {
        $debtors = OrderInvoice::with(['customer', 'createdBy', 'order'])->latest()->get();

        $debtors->each(function ($invoice) {
            $invoice->overdue_days = (int)Carbon::parse($invoice->created_at)->diffInDays(now());
        });

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=debtors-list.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($debtors) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Invoice ID',
                'Invoice Date',
                'Name',
                'Company Name',
                'Country',
                'Net Amount Balance',
                'Overdue by (Days)',
                'Created By',
            ]);

            foreach ($debtors as $debtor) {
                fputcsv($file, [
                    $debtor->invoice_number,
                    $debtor->invoice_date ?? $debtor->created_at->format('Y-m-d'),
                    $debtor->customer->first_name . ' ' . $debtor->customer->last_name,
                    $debtor->customer->company_name,
                    $debtor->customer->billing_country,
                    number_format($debtor->total, 2) . ' ' . number_format($debtor->order->total ?? 0, 2),
                    $debtor->overdue_days,
                    $debtor->createdBy->name,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadExcel()
    {
        $debtors = OrderInvoice::with(['customer', 'createdBy', 'order'])->latest()->get();

        $debtors->each(function ($invoice) {
            $invoice->overdue_days = (int)Carbon::parse($invoice->created_at)->diffInDays(now());
        });

        return Excel::download(new PaymentsExport($debtors), 'debtors-list.xlsx');
    }

    public function render()
    {
        $debtors = OrderInvoice::with(['customer', 'createdBy', 'order'])
            ->whereHas('order', function($query) {
                $query->whereHas('payments', function($q) {
                    $q->where('status', 'pending');
                })->orWhereDoesntHave('payments');
            })
            ->when($this->search, function ($query) {
                $query->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhere('invoice_date', 'like', '%' . $this->search . '%')
                    ->orWhere('total', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$this->search}%"])
                            ->orWhere('company_name', 'like', '%' . $this->search . '%')
                            ->orWhere('billing_country', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('createdBy', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate($this->perPage);

        $debtors->each(function ($invoice) {
            $invoice->overdue_days = (int)Carbon::parse($invoice->created_at)->diffInDays(now());
        });

        return view('livewire.admin.debtors.debtors-list', [
            'debtors' => $debtors,
        ]);
    }
}
