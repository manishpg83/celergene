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
                                <div class="col-md-6">
                                    <label class="form-label" for="warehouse_name">Warehouse Name</label>
                                    <input wire:model="warehouse_name" type="text" id="warehouse_name" class="form-control" placeholder="Enter warehouse name" required>
                                    @error('warehouse_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                

                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <input wire:model="country" type="text" id="country" class="form-control" placeholder="Enter country" required>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="type">Type</label>
                                    <input wire:model="type" type="text" id="type" class="form-control" placeholder="Enter warehouse type" required>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="supplier_id">Distributor</label>
                                    <select wire:model="supplier_id" id="supplier_id" class="form-select" required>
                                        <option value="">-- Select Distributor --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                

                                <div class="col-md-6">
                                    <label class="form-label" for="remarks">Remarks</label>
                                    <textarea wire:model="remarks" id="remarks" class="form-control" placeholder="Enter remarks"></textarea>
                                    @error('remarks')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea 
                                        wire:model="address" 
                                        id="address" 
                                        class="form-control" 
                                        rows="3" 
                                        placeholder="Enter warehouse address"
                                    ></textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="emails">Emails</label>
                                    @foreach($emails as $index => $email)
                                        <div class="input-group mb-2">
                                            <input 
                                                type="email" 
                                                wire:model="emails.{{ $index }}" 
                                                class="form-control" 
                                                placeholder="Enter email address"
                                            />
                                            <button 
                                                type="button" 
                                                wire:click="removeEmailField({{ $index }})" 
                                                class="btn btn-danger"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                        @error('emails.' . $index)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @endforeach
                                    <button 
                                        type="button" 
                                        wire:click="addEmailField" 
                                        class="btn btn-secondary mt-2"
                                    >
                                        Add Email
                                    </button>
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
