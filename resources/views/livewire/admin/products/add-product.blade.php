<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $isEditMode ? 'Edit Product' : 'Add New Product' }}</h5>
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
                                    <label class="form-label" for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" wire:model="brand" placeholder="Enter brand" required>
                                    @error('brand')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="product_name">Product Name</label>
                                    <input type="text" class="form-control" id="product_name" wire:model="product_name" placeholder="Enter product name" required>
                                    @error('product_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="product_category">Product Category</label>
                                    <select class="form-select" id="product_category" wire:model="product_category" required>
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                

                                <div class="col-md-6">
                                    <label class="form-label" for="origin">Origin</label>
                                    <select class="form-select" id="origin" wire:model="origin" required>
                                        <option value="">Select origin</option>
                                        <option value="Swiss">Swiss</option>
                                        <option value="Eckhart">Eckhart</option>
                                    </select>
                                    @error('origin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="batch_number">Batch Number</label>
                                    <input type="text" class="form-control" id="batch_number" wire:model="batch_number" placeholder="Enter batch number" required>
                                    @error('batch_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="expire_date">Expire Date</label>
                                    <input type="date" class="form-control" id="expire_date" wire:model="expire_date" required>
                                    @error('expire_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="currency">Currency</label>
                                    <select class="form-select" id="currency" wire:model="currency" required>
                                        <option value="">Select currency</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="unit_price">Unit Price</label>
                                    <input type="number" class="form-control" id="unit_price" wire:model="unit_price" placeholder="Enter unit price" required>
                                    @error('unit_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="description">Product Description</label>
                                    <textarea class="form-control" id="description" wire:model="description" placeholder="Enter product description" required></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label" for="remarks_notes">Remarks/Notes</label>
                                    <textarea class="form-control" id="remarks_notes" wire:model="remarks_notes" placeholder="Enter remarks or notes"></textarea>
                                    @error('remarks_notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEditMode ? 'Update Product' : 'Add Product' }}
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
