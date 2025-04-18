<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row-gap-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 ml-2 text-2xl">Report Filters</h4>
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
                </div>
                
                <div class="flex-wrap gap-2 d-flex">
                    <select wire:model.live="reportType" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        @foreach($reportTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
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
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                @if($isCustomerTypeReport)
                                    <th>Type</th>
                                @else
                                    <th>Country</th>
                                @endif
                                <th># of boxes</th>
                                <th>Total Amount (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($isCustomerTypeReport)
                                @foreach($data as $item)
                                    <tr class="{{ $item['type'] === 'Grand Total' ? 'table-active' : '' }}">
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ number_format($item['boxes'], 2) }}</td>
                                        <td>${{ number_format($item['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item['country'] }}</td>
                                        <td>{{ number_format($item['boxes'], 2) }}</td>
                                        <td>${{ number_format($item['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(!$isCustomerTypeReport)
                    <div class="mt-3">
                        {{ $data->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
