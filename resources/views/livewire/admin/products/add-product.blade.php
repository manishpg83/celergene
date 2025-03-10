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
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="col-lg-10 mx-auto">
                            <form wire:submit.prevent="submit" class="row g-3 mt-2" enctype="multipart/form-data" >
                                <div class="col-md-6">
                                    <label class="form-label" for="product_code">Product Code</label>
                                    <input type="text" class="form-control" id="product_code" wire:model="product_code" placeholder="Enter product code" >
                                    @error('product_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                               

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

                                <div class="col-md-12">
                                    <label class="form-label" for="description">Product Description</label>
                                    <textarea class="form-control" id="description" wire:model="description" placeholder="Enter product description" required></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="description">Invoice Description</label>
                                    <textarea class="form-control" id="invoice_description" wire:model="invoice_description" placeholder="Enter product Invoice Description" required></textarea>
                                    @error('invoice_description')
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
                                        <option value="US Eckhart">US Eckhart</option>
                                    </select>
                                    @error('origin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-6">
                                    <label class="form-label" for="batch_number">Batch Number</label>
                                    <input type="text" class="form-control" id="batch_number" wire:model="batch_number" placeholder="Enter batch number" required>
                                    @error('batch_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label" for="currency">Currency</label>
                                    <select class="form-select" id="currency" wire:model="currency" required>
                                        <option value="">Select currency</option>
                                        @foreach($currencies as $code => $name)
                                            <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>  

                                <div class="col-md-6">
                                    <label class="form-label" for="expire_date">Expiry Date</label>
                                    <input type="month" min="{{ date('Y-m') }}" class="form-control" id="expire_date" wire:model="expire_date">
                                    @error('expire_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                                                                           

                                <div class="col-md-6">
                                    <label class="form-label" for="unit_price">Unit price</label>
                                    <input type="number" class="form-control" id="unit_price" wire:model="unit_price" placeholder="Enter unit price" required>
                                    @error('unit_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="is_online">Is Online</label>
                                    <div class="d-flex align-items-center ps-2 bg-transparent" style="height: 38px;">
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input" id="is_online" wire:model="is_online" value="1">
                                            <label class="form-check-label" for="is_online">Available Online</label>
                                        </div>
                                    </div>
                                    @error('is_online')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="remarks_notes">Remarks/Notes</label>
                                    <textarea class="form-control" id="remarks_notes" wire:model="remarks_notes" placeholder="Enter remarks or notes"></textarea>
                                    @error('remarks_notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="product_img">Product Image</label>                                    
                                    <div class="mb-2">
                                        @if ($product_img && $product_img instanceof \Livewire\TemporaryUploadedFile)
                                            <img src="{{ $product_img->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                        @elseif ($isEditMode && $product_img_url)
                                            <img src="{{ asset($product_img_url) }}" alt="Existing Image" class="img-thumbnail" style="max-height: 150px;">
                                        @endif
                                    </div>                                
                                    <input type="file" class="form-control" id="product_img" wire:model="product_img">                                    
                                    @error('product_img')
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
