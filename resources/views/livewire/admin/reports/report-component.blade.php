<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row-gap-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 ml-2 text-2xl">Sales Report</h4>
        </div>
        <div class="flex-wrap gap-4 d-flex align-content-center">
            <div class="gap-4 d-flex">
                <div class="btn-group">
                    <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light" 
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="ti ti-upload me-1 ti-xs"></i>Export</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" wire:click="exportExcel">Export to Excel</a></li>
                        <li><a class="dropdown-item" href="#" wire:click="exportCsv">Export to CSV</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4 row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" wire:model.lazy="search" class="form-control" placeholder="Search by name or invoice #">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" wire:model.lazy="startDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" wire:model.lazy="endDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-danger" wire:click="resetFilters" wire:loading.attr="disabled">Reset Filters</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-center table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Date</th>
                            <th>Invoice #</th>
                            <th>Name</th>
                            <th>CAV Per Box</th>
                            <th>Per Box</th>
                            <th>Amount</th>
                            <th>Country</th>
                            <th>USD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['date'] }}</td>
                                <td>{{ $item['invoice_number'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['box_count'] }}</td>
                                <td>{{ $item['price_per_box'] }}</td>
                                <td>{{ $item['amount_chf'] }}</td>
                                <td>{{ $item['country'] }}</td>
                                <td class="text-right">{{ $item['amount_usd'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total:</strong></td>
                            <td><strong>{{ $reportData->sum('box_count') }}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong>{{ number_format($reportData->sum(function($item) {
                                return floatval(str_replace(',', '', $item['amount_usd']));
                            }), 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
