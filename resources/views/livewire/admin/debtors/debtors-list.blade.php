<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Debtors List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                <div class="btn-group">
                    <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light" 
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="ti ti-upload me-1 ti-xs"></i>Export</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" wire:click="downloadPdf">Export as PDF</a></li>
                        <li><a class="dropdown-item" href="#" wire:click="downloadExcel">Export as Excel</a></li>
                        <li><a class="dropdown-item" href="#" wire:click="downloadCsv">Export as CSV</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex flex-wrap gap-2">
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                
                <div>
                    <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search Debtors..." style="width: 150px;">
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Order ID</th>
                            <th>Invoice ID</th>
                            <th>Invoice Date</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Country</th>
                            <th>Net Amount</th>
                            <th>Paid Amount</th>
                            <th>Balance</th>
                            <th>Overdue by (Days)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($debtors as $index => $debtor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $debtor->order_id }}</td>
                                <td>{{ $debtor->invoice_number }}</td>
                                <td>{{ $debtor->invoice_date ?? $debtor->created_at->format('Y-m-d') }}</td>
                                <td>{{ $debtor->customer->first_name }} {{ $debtor->customer->last_name }}</td>
                                <td>{{ $debtor->customer->company_name }}</td>
                                <td>{{ $debtor->customer->billing_country }}</td>
                                <td>
                                    {{ $debtor->currencySymbol }}{{ number_format($debtor->order->total ?? 0, 2) }}
                                </td>
                                <td>{{ $debtor->currencySymbol }}{{ number_format($debtor->totalPaid, 2) }}</td>
                                <td>{{ $debtor->currencySymbol }}{{ number_format($debtor->pendingAmount, 2) }}</td>
                                <td>{{ $debtor->overdue_days }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No debtors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $debtors->links() }}
            </div>
        </div>
    </div>
</div>