<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Category List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <a href="{{ route('admin.productscategory.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Category
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <select wire:model="perPage" class="form-select me-2" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" wire:model.debounce.300ms="search" placeholder="Search categories..."
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
                            <th wire:click="sortBy('category_name')" style="cursor: pointer;">Category Name</th>
                            <th wire:click="sortBy('status')" style="cursor: pointer;">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($categories->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No categories found.</td>
                            </tr>
                        @else
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->status }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-black" type="button"
                                                id="actionMenu{{ $category->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" style="width: 20px; height: 20px;">
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="12" cy="6" r="2" />
                                                    <circle cx="12" cy="18" r="2" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $category->id }}">
                                                <li>
                                                    <a class="dropdown-item" wire:click="edit({{ $category->id }})"
                                                        style="cursor: pointer;">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ $category->trashed() ? 'text-danger' : 'text-warning' }}"
                                                        wire:click="{{ $category->trashed() ? 'confirmDelete(' . $category->id . ')' : 'suspend(' . $category->id . ')' }}"
                                                        style="cursor: pointer;">
                                                        {{ $category->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                    </a>
                                                </li>
                                                @if ($category->trashed())
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            wire:click="restoreProduct({{ $category->id }})"
                                                            style="cursor: pointer;">Restore</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
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
                            <p>Are you sure you want to permanently delete this category? This action cannot be undone.</p>
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
