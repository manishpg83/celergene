<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Customer List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            {{-- <div class="d-flex gap-4">
                <div class="btn-group">
                    <button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
                        tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                        aria-expanded="false"><span><i class="ti ti-upload me-1 ti-xs"></i>Export</span></button>
                </div>
            </div> --}}
            <a href="{{ route('admin.customer.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Customer
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                        <option value="5">5</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" wire:model.live="search" placeholder="Search Customers..."
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
                            <th wire:click="sortBy('first_name')" style="cursor: pointer;">First Name</th>
                            <th wire:click="sortBy('last_name')" style="cursor: pointer;">Last Name</th>
                            <th wire:click="sortBy('email')" style="cursor: pointer;">Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($customers->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No customers found.</td>
                            </tr>
                        @else
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->first_name }}</td>
                                    <td>{{ $customer->last_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-black" type="button"
                                                id="actionMenu{{ $customer->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" style="width: 20px; height: 20px;">
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="12" cy="6" r="2" />
                                                    <circle cx="12" cy="18" r="2" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $customer->id }}">
                                                <li>
                                                    <a class="dropdown-item" wire:click="edit({{ $customer->id }})"
                                                        style="cursor: pointer;">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ $customer->trashed() ? 'text-danger' : 'text-warning' }}"
                                                        wire:click="confirmDelete({{ $customer->id }})"
                                                        style="cursor: pointer;">
                                                        {{ $customer->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                    </a>
                                                </li>
                                                @if ($customer->trashed())
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            wire:click="restore({{ $customer->id }})"
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
                {{ $customers->links() }}
            </div>
        </div>
        <!-- Confirm Deletion Modal -->
        @if ($confirmingDeletion)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Permanent Deletion</h5>
                            <button type="button" class="btn-close"
                                wire:click="$set('confirmingDeletion', false)"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to permanently delete this customer? This action cannot be undone.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('confirmingDeletion', false)">Cancel</button>
                            <button type="button" class="btn btn-danger" wire:click="delete">Permanently
                                Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
