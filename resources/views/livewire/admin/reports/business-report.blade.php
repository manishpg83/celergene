<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row-gap-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 ml-2 text-2xl">Business Report - {{ $year }}</h4>
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
            <div class="flex-wrap gap-2 mb-3 d-flex justify-content-between align-items-center">
                <div class="flex-wrap gap-2 d-flex">
                    <select wire:model.live="year" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    
                    <select wire:model.live="currency" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        @foreach($availableCurrencies as $curr)
                            <option value="{{ $curr }}">{{ $curr }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-wrap gap-2 d-flex">
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            @if($loading)
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            @else
                <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-white sticky-top">
                            <tr>
                                <th>Country</th>
                                <th>Full Name</th>
                                <th>Customer Type</th>
                                <th>Currency</th>
                                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <th>{{ $month }} Qty</th>
                                    <th>{{ $month }} {{ $currencySymbol }}</th>
                                @endforeach
                                <th>Total Qty</th>
                                <th>Total {{ $currencySymbol }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer['country'] }}</td>
                                    <td>{{ $customer['fullname'] }}</td>
                                    <td>{{ $customer['customer_type'] ?: '-' }}</td>
                                    <td>{{ $customer['currencycode'] }}</td>
                                    @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                        <td>{{ $customer[$month . 'Qty'] ?: '-' }}</td>
                                        <td>{{ $customer[$month . 'USD'] ? number_format($customer[$month . 'USD'], 2) : '-' }}</td>
                                    @endforeach
                                    <td>{{ $customer['TotalQty'] ?: '-' }}</td>
                                    <td>{{ $customer['TotalUSD'] ? number_format($customer['TotalUSD'], 2) : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="sticky-bottom bg-light">
                            <tr>
                                <th colspan="4">Grand Total</th>
                                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <th>{{ array_sum(array_column($customers, $month . 'Qty')) ?: '-' }}</th>
                                    <th>{{ number_format(array_sum(array_column($customers, $month . 'USD')), 2) ?: '-' }}</th>
                                @endforeach
                                <th>{{ array_sum(array_column($customers, 'TotalQty')) ?: '-' }}</th>
                                <th>{{ number_format(array_sum(array_column($customers, 'TotalUSD')), 2) ?: '-' }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>