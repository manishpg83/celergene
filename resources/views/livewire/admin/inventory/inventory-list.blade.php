<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Inventory List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <a href="{{ route('admin.inventory.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Inventory
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
                    <input type="text" wire:model.live="search" placeholder="Search Inventory..."
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
                            <th wire:click="sortBy('product_id')" style="cursor: pointer;">Product</th>
                            <th class="text-center" wire:click="sortBy('product_code')" style="cursor: pointer;">Product code</th>
                            <th class="text-center" wire:click="sortBy('warehouse_id')" style="cursor: pointer;">Warehouse</th>
                            <th class="text-center" wire:click="sortBy('batch_number')" style="cursor: pointer;">Batch Number</th>
                            <th class="text-center" wire:click="sortBy('quantity')" style="cursor: pointer;">Quantity</th>
                            <th class="text-center" wire:click="sortBy('expiry')" style="cursor: pointer;">Expiry</th>
                            <th class="text-center" wire:click="sortBy('modified_by')" style="cursor: pointer;">Modify By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($inventories->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">No inventory records found.</td>
                            </tr>
                        @else
                            @foreach ($inventories as $inventory)
                                <tr class="{{ $inventory->trashed() ? 'text-muted' : '' }}">
                                    <td>{{ $inventory->product->product_name }}</td>
                                    <td class="text-center">{{ $inventory->product->product_code }}</td>
                                    <td class="text-center">{{ $inventory->warehouse->warehouse_name }}</td>
                                    <td class="text-center">{{ $inventory->batch_number }}</td>
                                    <td class="text-center">{{ $inventory->quantity }}</td>
                                    <td class="text-center">{{ $inventory->expiry }}</td>
                                    <td class="text-center">{{ $inventory->modifiedBy ? $inventory->modifiedBy->name : 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-black" type="button"
                                                id="actionMenu{{ $inventory->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" style="width: 20px; height: 20px;">
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="12" cy="6" r="2" />
                                                    <circle cx="12" cy="18" r="2" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $inventory->id }}">
                                                <li>
                                                    <a class="dropdown-item" wire:click="edit({{ $inventory->id }})"
                                                        style="cursor: pointer;">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ $inventory->trashed() ? 'text-danger' : 'text-warning' }}"
                                                        wire:click="{{ $inventory->trashed() ? 'confirmDelete(' . $inventory->id . ')' : 'suspend(' . $inventory->id . ')' }}"
                                                        style="cursor: pointer;">
                                                        {{ $inventory->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                    </a>
                                                </li>
                                                @if ($inventory->trashed())
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            wire:click="restoreInventory({{ $inventory->id }})"
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
                {{ $inventories->links() }}
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
                            <p>Are you sure you want to delete this inventory item? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('confirmingDeletion', false)">Cancel</button>
                            <button type="button" class="btn btn-danger" wire:click="deleteInventory">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
