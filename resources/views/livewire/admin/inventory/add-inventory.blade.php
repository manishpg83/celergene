<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $isEditMode ? 'Edit Inventory' : 'Add New Inventory' }}</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="saveInventory" class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="product_code">Product</label>
                                    <select wire:model="product_code" id="product_code" class="form-select" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_code }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="warehouse_id">Warehouse</label>
                                    <select wire:model="warehouse_id" id="warehouse_id" class="form-select" required>
                                        <option value="">-- Select Warehouse --</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="batch_number">Batch Number</label>
                                    <input type="text" wire:model="batch_number" id="batch_number" class="form-control" placeholder="Enter batch number" required>
                                    @error('batch_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="expiry">Expiry Date</label>
                                    <input type="date" wire:model="expiry" id="expiry"  min="{{ date('Y-m-d') }}" class="form-control" required>
                                    @error('expiry') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="quantity">Quantity</label>
                                    <input type="number" wire:model="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
                                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEditMode ? 'Update Inventory' : 'Add Inventory' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
