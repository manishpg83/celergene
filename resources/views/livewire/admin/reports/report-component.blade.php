<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Sales Report</h4>
        </div>
        <div class="card-body">
            <div class="mb-4 row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Search by name or invoice #">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" wire:model.live="startDate" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" wire:model.live="endDate" class="form-control">
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select wire:model.live="country" class="form-control">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-secondary" wire:click="resetFilters">Reset Filters</button>
                </div>
            </div>
            
            <div class="mb-3 row">
                <div class="text-right col-md-12">
                    <button class="mr-2 btn btn-success" wire:click="exportCsv">
                        <i class="mr-1 fas fa-file-csv"></i> Export CSV
                    </button>
                    <button class="btn btn-primary" wire:click="exportExcel">
                        <i class="mr-1 fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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

            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>