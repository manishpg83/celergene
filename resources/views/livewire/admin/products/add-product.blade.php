<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="brand" wire:model="brand">
            @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" wire:model="product_name">
            @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="product_category" class="form-label">Product Category</label>
            <select class="form-select" id="product_category" wire:model="product_category">
                <option value="">Select a category</option>
                <option value="Supplement">Supplement</option>
                <option value="Skincare">Skincare</option>
                <!-- Add more options as needed -->
            </select>
            @error('product_category') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="origin" class="form-label">Origin</label>
            <select class="form-select" id="origin" wire:model="origin">
                <option value="">Select origin</option>
                <option value="Swiss">Swiss</option>
                <option value="Eckhart">Eckhart</option>
                <!-- Add more options as needed -->
            </select>
            @error('origin') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="batch_number" class="form-label">Batch Number</label>
            <input type="text" class="form-control" id="batch_number" wire:model="batch_number">
            @error('batch_number') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="expire_date" class="form-label">Expire Date</label>
            <input type="date" class="form-control" id="expire_date" wire:model="expire_date">
            @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="currency" class="form-label">Currency</label>
            <select class="form-select" id="currency" wire:model="currency">
                <option value="">Select currency</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <!-- Add more options as needed -->
            </select>
            @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="unit_price" class="form-label">Unit Price</label>
            <input type="number" class="form-control" id="unit_price" wire:model="unit_price">
            @error('unit_price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="remarks_notes" class="form-label">Remarks/Notes</label>
            <textarea class="form-control" id="remarks_notes" wire:model="remarks_notes"></textarea>
            @error('remarks_notes') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="created_by" class="form-label">Created By</label>
            <input type="text" class="form-control" id="created_by" wire:model="created_by">
            @error('created_by') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="modified_by" class="form-label">Modified By</label>
            <input type="text" class="form-control" id="modified_by" wire:model="modified_by">
            @error('modified_by') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
