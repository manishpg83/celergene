<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="row-gap-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div class="d-flex flex-column justify-content-center">
            <h2 class="mb-1 ml-2 text-2xl">
                @if($selectedCountry)
                    {{ $selectedCountry }} Sales Report - {{ $year }}
                @else
                    Country Sales Report - {{ $year }}
                @endif
            </h2>
        </div>
        <div class="flex-wrap gap-4 d-flex align-content-center">
            <div class="gap-4 d-flex">
                <div class="btn-group">
                    <button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
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
                        <label for="year">Year</label>
                        <select wire:model.lazy="year" class="form-control">
                            @foreach(range(date('Y'), date('Y') - 5) as $yearOption)
                                <option value="{{ $yearOption }}">{{ $yearOption }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select wire:model.lazy="selectedCountry" class="form-control">
                            <option value="">All Countries</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">                   
                    <button class="btn btn-outline-danger" wire:click="resetFilters" wire:loading.attr="disabled">
                        Reset Filters
                    </button>
                </div>
            </div>

            @if($loading)
                <div class="flex items-center justify-center py-8">
                    <svg class="w-8 h-8 mr-3 -ml-1 text-blue-500 animate-spin" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Loading...</span>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table text-center table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left">Month</th>
                                <th class="text-left"># of Boxes</th>
                                <th class="text-left">Total Amount (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyData as $month)
                                <tr>
                                    <td>{{ $month['month'] }}</td>
                                    <td>{{ number_format($month['boxes'], 2) }}</td>
                                    <td>${{ number_format($month['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="font-semibold">
                                <td>Grand Total</td>
                                <td>{{ number_format($grandTotalBoxes, 2) }}</td>
                                <td>${{ number_format($grandTotalAmount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>