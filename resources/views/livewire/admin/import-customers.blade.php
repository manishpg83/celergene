<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4">
        <h2 class="mb-2 h4 fw-semibold text-primary">
            <i class="bi bi-upload me-2"></i>Import Customers
        </h2>
        <p class="mb-0 text-muted">Upload an Excel file (XLSX, XLS) containing customer data. We'll validate the
            contents before importing.</p>
    </div>

    @if(!$showPreview)
        <div class="p-4 border rounded bg-light">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3 text-center">
                    <i class="bi bi-file-earmark-excel text-primary" style="font-size: 2.5rem;"></i>
                </div>

                <div class="mb-3 w-100">
                    <input type="file" wire:model="file" accept=".xlsx,.xls" class="form-control" id="customerImportFile">
                    <div class="text-center form-text">Max file size: 10MB • Excel formats only</div>
                </div>

                <button wire:click="preview" wire:loading.attr="disabled" class="px-4 py-2 btn btn-primary"
                    :disabled="!$file">
                    <span wire:loading.remove>Validate File</span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                        Validating...
                    </span>
                </button>
            </div>
        </div>
    @else
        <div class="p-4 border rounded bg-light">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3 text-center text-success">
                    <i class="bi bi-check-circle-fill" style="font-size: 2.5rem;"></i>
                    <div class="mt-2 fw-semibold">File Validated Successfully</div>
                    <p class="mb-0 text-muted">{{ $totalRows }} total records found</p>
                </div>

                <!-- Row Range Selection -->
                <div class="max-w-md mb-3 w-100">
                    <div class="p-3 bg-white border rounded">
                        <h5 class="mb-3">Select Row Range to Import</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="startRow" class="form-label">Start Row</label>
                                <input type="number" wire:model.live="startRow" min="1" max="{{ $totalRows }}"
                                    class="form-control" id="startRow">
                            </div>
                            <div class="col-md-6">
                                <label for="endRow" class="form-label">End Row (optional)</label>
                                <input type="number" wire:model.live="endRow" min="{{ $startRow }}" max="{{ $totalRows }}"
                                    class="form-control" id="endRow" placeholder="Leave empty for all">
                            </div>
                        </div>

                        <div class="mt-2 mb-1">
                            <button wire:click="updatePreviewData" class="btn btn-sm btn-outline-primary">
                                Update Preview
                            </button>
                        </div>

                        @if($rangeValidationError)
                            <div class="py-2 mt-2 alert alert-danger">
                                <small>{{ $rangeValidationError }}</small>
                            </div>
                        @endif

                        <div class="mt-2">
                            <small class="text-muted">
                                Preview shows rows {{ $startRow }} to
                                {{ empty($endRow) ? $totalRows : min($endRow, $totalRows) }}
                                ({{ empty($endRow) ? $totalRows - $startRow + 1 : min($endRow, $totalRows) - $startRow + 1 }}
                                rows)
                            </small>
                        </div>
                    </div>
                </div>

                <div class="gap-3 mt-2 d-flex">
                    <button wire:click="import" wire:loading.attr="disabled" class="px-4 py-2 btn btn-success" {{ $rangeValidationError ? 'disabled' : '' }}>
                        <span wire:loading.remove>Confirm Import</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                            Importing...
                        </span>
                    </button>

                    <button wire:click="cancelPreview" class="px-4 py-2 btn btn-outline-secondary">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview Table -->
        <div class="mt-4 card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Preview</h5>
                <div>
                    <select wire:model.live="previewPerPage" class="form-select form-select-sm">
                        <option value="5">5 per page</option>
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Row #</th>
                            @if(count($paginatedPreviewData) > 0)
                                @foreach($paginatedPreviewData->first() as $key => $value)
                                    <th>{{ $key }}</th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paginatedPreviewData as $index => $row)
                            <tr>
                                <td class="fw-bold">{{ $startRow + $index + (($currentPage - 1) * $previewPerPage) }}</td>
                                @foreach($row as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 card-footer">
                @if(isset($paginator) && $paginator->lastPage() > 1)
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">
                                Showing {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }} to
                                {{ min($paginator->currentPage() * $paginator->perPage(), $paginator->total()) }}
                                of {{ $paginator->total() }} entries
                            </span>
                        </div>
                        <nav>
                            <ul class="mb-0 pagination">
                                <!-- Previous Page Link -->
                                <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                    <button wire:click="previousPage" class="page-link" {{ $currentPage <= 1 ? 'disabled' : '' }}>
                                        Previous
                                    </button>
                                </li>

                                <!-- First 4 Pages -->
                                @for($i = 1; $i <= min(4, $paginator->lastPage()); $i++)
                                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                        <button wire:click="gotoPage({{ $i }})" class="page-link">{{ $i }}</button>
                                    </li>
                                @endfor

                                <!-- Ellipsis if more than 5 pages -->
                                @if($paginator->lastPage() > 5)
                                    <!-- Show current page if it's outside the first 4 and last page -->
                                    @if($currentPage > 4 && $currentPage < $paginator->lastPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                        <li class="page-item active">
                                            <button wire:click="gotoPage({{ $currentPage }})"
                                                class="page-link">{{ $currentPage }}</button>
                                        </li>
                                    @endif

                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif

                                <!-- Last Page -->
                                @if($paginator->lastPage() > 4)
                                    <li class="page-item {{ $currentPage == $paginator->lastPage() ? 'active' : '' }}">
                                        <button wire:click="gotoPage({{ $paginator->lastPage() }})"
                                            class="page-link">{{ $paginator->lastPage() }}</button>
                                    </li>
                                @endif

                                <!-- Next Page Link -->
                                <li class="page-item {{ $currentPage >= $paginator->lastPage() ? 'disabled' : '' }}">
                                    <button wire:click="nextPage" class="page-link" {{ $currentPage >= $paginator->lastPage() ? 'disabled' : '' }}>
                                        Next
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Import Summary Section -->
    @if($imported > 0 || $skippedDuplicates > 0 || $skippedInvalid > 0)
        <div class="mt-4 alert alert-info">
            <div class="mb-2 d-flex align-items-center">
                <i class="bi bi-clipboard-check me-2 fs-4"></i>
                <h4 class="mb-0 fw-semibold">Import Summary</h4>
            </div>
            <ul class="mb-1">
                <li><strong>Successfully imported:</strong> {{ $imported }} customers</li>
                <li><strong>Skipped duplicates:</strong> {{ $skippedDuplicates }} records</li>
                @if($skippedInvalid > 0)
                    <li><strong>Skipped invalid:</strong> {{ $skippedInvalid }} records</li>
                @endif
                <li><strong>Row range:</strong> {{ $startRow }} to
                    {{ empty($endRow) ? $totalRows : min($endRow, $totalRows) }}</li>
            </ul>

            @if(count($duplicateEmails) > 0)
                <div class="mt-3">
                    <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse"
                        data-bs-target="#duplicateEmails">
                        Show Duplicate Emails ({{ count($duplicateEmails) }})
                    </button>
                    <div class="mt-2 collapse" id="duplicateEmails">
                        <div class="card card-body">
                            <div style="max-height: 300px; overflow-y: auto;">
                                <ul class="mb-0">
                                    @foreach($duplicateEmails as $duplicate)
                                        <li>Row {{ $duplicate['row'] }}: {{ $duplicate['email'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="mt-4 alert alert-danger">
            <div class="mb-2 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <h4 class="mb-0 fw-semibold">Import Issues</h4>
            </div>
            <div class="mb-3 alert alert-warning">
                <strong>Note:</strong> The following rows were not imported due to errors.
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Log Download Button (Optional) -->
    @if($imported > 0 || count($errors) > 0)
        <div class="mt-4 text-end">
            <button wire:click="downloadLog" class="btn btn-outline-secondary">
                <i class="bi bi-download me-2"></i>Download Import Log
            </button>
        </div>
    @endif
</div>