<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $isEditMode ? 'Edit Warehouse' : 'Add New Warehouse' }}</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <form wire:submit.prevent="saveWarehouse" class="row g-3 mt-2">
                                <!-- Warehouse Name Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="warehouse_name">Warehouse Name</label>
                                    <input wire:model="warehouse_name" type="text" id="warehouse_name" class="form-control" placeholder="Enter warehouse name" required>
                                    @error('warehouse_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Country Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input wire:model="country" type="text" id="country" class="form-control" placeholder="Enter country" required>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Type Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="type">Type</label>
                                    <input wire:model="type" type="text" id="type" class="form-control" placeholder="Enter warehouse type" required>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remarks Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="remarks">Remarks</label>
                                    <textarea wire:model="remarks" id="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                                    @error('remarks')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEditMode ? 'Update Warehouse' : 'Add Warehouse' }}
                                    </button>
                                </div>
                            </form>

                            @if (session()->has('message'))
                                <div class="alert alert-success mt-3">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
