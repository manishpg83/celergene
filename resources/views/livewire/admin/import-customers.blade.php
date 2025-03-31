<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4">
        <h2 class="h4 fw-semibold text-primary mb-2">
            <i class="bi bi-upload me-2"></i>Import Customers
        </h2>
        <p class="text-muted mb-0">Upload an Excel file (XLSX, XLS) containing customer data. We'll validate the contents before importing.</p>
    </div>

    @if(!$showPreview)
        <div class="border rounded p-4 bg-light">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3 text-center">
                    <i class="bi bi-file-earmark-excel text-primary" style="font-size: 2.5rem;"></i>
                </div>
                
                <div class="w-100 mb-3">
                    <input type="file" wire:model="file" accept=".xlsx,.xls" 
                        class="form-control" id="customerImportFile">
                    <div class="form-text text-center">Max file size: 5MB • Excel formats only</div>
                </div>
                
                <button wire:click="preview" wire:loading.attr="disabled" 
                    class="btn btn-primary px-4 py-2" :disabled="!$file">
                    <span wire:loading.remove>Validate File</span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                        Validating...
                    </span>
                </button>
            </div>
        </div>
    @else
        <div class="border rounded p-4 bg-light">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3 text-center text-success">
                    <i class="bi bi-check-circle-fill" style="font-size: 2.5rem;"></i>
                    <div class="fw-semibold mt-2">File Validated Successfully</div>
                    <p class="text-muted mb-0">{{ $totalRows ?? 0 }} records found</p>
                </div>
                
                <div class="d-flex gap-3 mt-2">
                    <button wire:click="import" wire:loading.attr="disabled" 
                        class="btn btn-success px-4 py-2">
                        <span wire:loading.remove>Confirm Import</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                            Importing...
                        </span>
                    </button>

                    <button wire:click="cancelPreview" 
                        class="btn btn-outline-secondary px-4 py-2">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Import Summary Section -->
    @if($imported > 0 || $skipped > 0)
        <div class="alert alert-info mt-4 d-flex align-items-center">
            <i class="bi bi-clipboard-check me-2"></i>
            <div>
                <strong>Import Summary:</strong>
                <ul class="mb-0">
                    <li><strong>Imported:</strong> {{ $imported }} customers</li>
                    <li><strong>Skipped:</strong> {{ $skipped }} duplicate records</li>
                </ul>
            </div>
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="alert alert-danger mt-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <h4 class="mb-0 fw-semibold">Validation Issues</h4>
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
