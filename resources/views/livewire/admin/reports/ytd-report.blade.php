<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Report Header with Export Options -->
    <div class="report-header mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <h4 class="mb-1 ml-2 text-2xl">Report Filters</h4>
        
        <div class="export-options">
            <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle btn-label-secondary me-4 waves-effect waves-light" 
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

    <!-- Report Card -->
    <div class="card">
        <div class="card-body">
            <!-- Filters Row -->
            <div class="filters-row mb-3 d-flex flex-wrap justify-content-between align-items-center">
                <!-- Year Selector -->
                <div class="filter-group">
                    <select wire:model.live="year" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <!-- Report Type Selector -->
                <div class="filter-group">
                    <select wire:model.live="reportType" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        @foreach($reportTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Items Per Page Selector -->
                <div class="filter-group">
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <!-- Loading State -->
            @if($loading)
                <div class="text-center loading-spinner">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            
            <!-- Data Table -->
            @else
                <div class="table-responsive">
                    <table class="table report-table text-center">
                        <thead>
                            <tr>
                                @if($isOrderTypeReport)
                                    <th class="text-start">Type</th>
                                @else
                                    <th class="text-start">Country</th>
                                @endif
                                <th># of Boxes</th>
                                <th>Total Amount (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($isOrderTypeReport)
                                <!-- Order Type Report Data -->
                                @foreach($data as $item)
                                    <tr class="{{ $item['type'] === 'Grand Total' ? 'table-active fw-bold' : '' }}">
                                        <td class="text-start">{{ $item['type'] }}</td>
                                        <td>{{ number_format($item['boxes']) }}</td>
                                        <td>${{ number_format($item['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- Countries Report Data -->
                                @foreach($data as $item)
                                    <tr>
                                        <td class="text-start">{{ $item['country'] }}</td>
                                        <td>{{ number_format($item['boxes']) }}</td>
                                        <td>${{ number_format($item['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (for non-order type reports) -->
                @if(!$isOrderTypeReport && $data->hasPages())
                    <div class="mt-3 pagination-wrapper">
                        {{ $data->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .report-table th {
        background-color: #f8f9fa;
        white-space: nowrap;
    }
    .loading-spinner {
        padding: 2rem 0;
    }
    .filters-row {
        gap: 0.5rem;
    }
    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .report-header {
        gap: 1rem;
    }
    .table-active {
        background-color: rgba(0, 0, 0, 0.05);
    }
</style>
@endpush