<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $batchNumberId ? 'Edit' : 'Add' }} Batch Number</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="bg-green-500 text-white p-2 mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="saveBatchNumber">
                        <input type="hidden" wire:model="batchNumberId">
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label class="form-label" for="batch_number">Batch Number</label>
                                <input type="text" id="batch_number" wire:model="batch_number" class="form-control" placeholder="Enter batch number" required>
                                @error('batch_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input wire:model="status" class="form-check-input" type="radio" value="active" id="status_active" required>
                                        <label class="form-check-label" for="status_active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:model="status" class="form-check-input" type="radio" value="inactive" id="status_inactive" required>
                                        <label class="form-check-label" for="status_inactive">Inactive</label>
                                    </div>
                                </div>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $batchNumberId ? 'Update Batch Number' : 'Add Batch Number' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>