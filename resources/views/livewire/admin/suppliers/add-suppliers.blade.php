<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $isEditMode ? 'Edit Distributor' : 'Add New Distributor' }}</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <form wire:submit.prevent="submit" class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="supplier_name">Distributor Name</label>
                                    <input type="text" class="form-control" id="supplier_name" wire:model="supplier_name" placeholder="Enter Distributor name" required>
                                    @error('supplier_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input type="text" class="form-control" id="country" wire:model="country" placeholder="Enter country" required>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" wire:model="remarks" placeholder="Enter remarks"></textarea>
                                    @error('remarks')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                               {{--  <div class="col-md-6">
                                    <label class="form-label" for="created_by">Created By</label>
                                    <input type="text" class="form-control" id="created_by" wire:model="created_by" placeholder="Enter creator's name" required>
                                    @error('created_by')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                {{-- <div class="col-md-6">
                                    <label class="form-label" for="created_date">Created Date</label>
                                    <input type="datetime-local"  min="{{ date('Y-m-d\TH:i') }}" class="form-control" id="created_date" wire:model="created_date" required>
                                    @error('created_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="modified_date">Modified Date</label>
                                    <input type="datetime-local"  min="{{ date('Y-m-d\TH:i') }}" class="form-control" id="modified_date" wire:model="modified_date" required>
                                    @error('modified_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEditMode ? 'Update Distributor' : 'Add Distributor' }}
                                    </button>
                                </div>
                            </form>

                            @if (session()->has('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
