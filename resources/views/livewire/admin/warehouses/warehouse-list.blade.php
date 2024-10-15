<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Warehouse List</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <div class="d-flex gap-4">
                    <div class="btn-group">
                        <button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-upload me-1 ti-xs"></i>Export</span>
                        </button>
                    </div>
                </div>
                <a href="{{ route('admin.warehouses.add') }}" class="btn btn-primary">
                    <i class="ti ti-plus ti-xs me-md-2"></i>Add Warehouse
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="position-relative me-3">
                        <input wire:model.live="search" type="text" placeholder="Search Warehouses..." class="form-control" style="width: auto;">
                    </div>

                    <div class="d-flex">
                        <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                            <option value="5">5</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th wire:click="sortBy('warehouse_name')" style="cursor: pointer;">Warehouse Name</th>
                                <th wire:click="sortBy('country')" style="cursor: pointer;">Country</th>
                                <th wire:click="sortBy('type')" style="cursor: pointer;">Type</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($warehouses->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No warehouses found.</td>
                                </tr>
                            @else
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $warehouse->warehouse_name }}</td>
                                        <td>{{ $warehouse->country }}</td>
                                        <td>{{ $warehouse->type }}</td>
                                        <td>{{ $warehouse->remarks }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button" id="actionMenu{{ $warehouse->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px;">
                                                        <circle cx="12" cy="12" r="2" />
                                                        <circle cx="12" cy="6" r="2" />
                                                        <circle cx="12" cy="18" r="2" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $warehouse->id }}">
                                                    <li>
                                                        <a class="dropdown-item" wire:click="editWarehouse({{ $warehouse->id }})" style="cursor: pointer;">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" wire:click="confirmDelete({{ $warehouse->id }})" style="cursor: pointer;">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <div>
                        {{ $warehouses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Deletion Modal -->
    @if ($confirmingDeletion)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                        <button type="button" class="close" wire:click="$set('confirmingDeletion', false)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this warehouse? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('confirmingDeletion', false)">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteWarehouse">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        Livewire.on('showConfirmDeleteModal', () => {
            var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        });
    </script>
@endpush
