<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Product List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <a href="{{ route('admin.products.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Product
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                        @foreach ($perpagerecords as $pagekey => $pagevalue)
                            <option value="{{ $pagekey }}">{{ $pagevalue }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" wire:model.live="search" placeholder="Search Products..."
                        class="form-control me-2" style="width: auto;" />
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('product_code')" style="cursor: pointer;">Product code</th>
                            <th class="text-center" wire:click="sortBy('brand')" style="cursor: pointer;">Brand</th>
                            <th class="text-center" wire:click="sortBy('product_name')" style="cursor: pointer;">Product Name</th>
                            <th class="text-center" wire:click="sortBy('product_category')" style="cursor: pointer;">Product Category</th>
                            <th class="text-center" wire:click="sortBy('unit_price')" style="cursor: pointer;">Unit Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">No products found.</td>
                            </tr>
                        @else
                            @foreach ($products as $product)
                                <tr class="text-center {{ $product->trashed() ? 'table-warning' : '' }}">
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                    <td>{{ $product->unit_price }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('admin.products.details', $product->id) }}" class="text-black" title="View Details" target="_blank">
                                                <i class="fa fa-eye" style="font-size: 20px; color: #7367f0;"></i>
                                            </a>
                     
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button" id="actionMenu{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" style="font-size: 20px;"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $product->id }}">
                                                    <li><a class="dropdown-item" wire:click="edit({{ $product->id }})" style="cursor: pointer;">Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item {{ $product->trashed() ? 'text-danger' : 'text-warning' }}" 
                                                           wire:click="{{ $product->trashed() ? 'confirmDelete(' . $product->id . ')' : 'suspend(' . $product->id . ')' }}" 
                                                           style="cursor: pointer;">
                                                            {{ $product->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                        </a>
                                                    </li>
                                                    @if ($product->trashed())
                                                        <li><a class="dropdown-item text-success" wire:click="restoreProduct({{ $product->id }})" style="cursor: pointer;">Restore</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                     
                                            @if($product->trashed())
                                                <span class="text-danger" title="Suspended">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16" style="width: 16px; height: 16px;">
                                                        <path d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 11.987c.042.073.042.163 0 .236a.13.13 0 0 1-.125.061H1.375a.13.13 0 0 1-.125-.061.176.176 0 0 1 0-.236L7.938 2.016zM8 5c-.535 0-.954.462-.9.995l.35 4.507c.035.416.38.748.9.748s.865-.332.9-.748L8.9 5.995C8.954 5.462 8.535 5 8 5zm.002 6a1 1 0 1 0-.002 2 1 1 0 0 0 .002-2z"/>
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                     </tbody>
                </table>
                
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>

        <!-- Confirm Deletion Modal -->
        @if ($confirmingDeletion)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('confirmingDeletion', false)"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this product? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('confirmingDeletion', false)">Cancel</button>
                            <button type="button" class="btn btn-danger" wire:click="deleteProduct">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
