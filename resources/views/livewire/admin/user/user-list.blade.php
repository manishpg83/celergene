<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 text-2xl ml-2">User List</h4>
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
                <a href="{{ route('admin.user.add') }}" class="btn btn-primary">
                    <i class="ti ti-plus ti-xs me-md-2"></i>Add User
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="position-relative me-3">
                        <input wire:model.live="search" type="text" placeholder="Search Users..."
                            class="form-control" style="width: auto;">
                    </div>

                    <div class="d-flex">
                        <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                            <option value="5">5</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>

                        <select wire:model.live="statusFilter" class="form-select" style="width: auto;">
                            <option value="all">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
                                <th>Sl</th>
                                <th wire:click="sortBy('id')" style="cursor: pointer;">ID</th>
                                <th wire:click="sortBy('name')" style="cursor: pointer;">Name</th>
                                <th wire:click="sortBy('email')" style="cursor: pointer;">Email</th>
                                <th wire:click="sortBy('role')" style="cursor: pointer;">Role</th>
                                <th wire:click="sortBy('status')" style="cursor: pointer;">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users && $users->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">No users found.</td>
                                </tr>
                            @else
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <!-- Updated Status Display -->
                                            @if ($user->trashed())
                                                <span class="text-warning">Suspended</span>
                                            @else
                                                <button wire:click="toggleActive({{ $user->id }})"
                                                    class="btn btn-sm {{ $user->status ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button"
                                                    id="actionMenu{{ $user->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" style="width: 20px; height: 20px;">
                                                        <circle cx="12" cy="12" r="2" />
                                                        <circle cx="12" cy="6" r="2" />
                                                        <circle cx="12" cy="18" r="2" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="actionMenu{{ $user->id }}">
                                                    <li>
                                                        <a class="dropdown-item" wire:click="edit({{ $user->id }})"
                                                            style="cursor: pointer;">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item {{ $user->trashed() ? 'text-danger' : 'text-warning' }}"
                                                            wire:click="confirmDelete({{ $user->id }})"
                                                            style="cursor: pointer;">
                                                            {{ $user->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                        </a>
                                                    </li>
                                                    @if ($user->trashed())
                                                        <li>
                                                            <a class="dropdown-item text-success"
                                                                wire:click="restore({{ $user->id }})"
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

                <div class="d-flex justify-content-between mt-3">
                    <div>
                        {{ $users->links() }}
                    </div>
                    {{-- <div>
                        <span class="text-muted">Showing {{ $users->count() }} of {{ $users->total() }} users</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Deletion Modal -->
    <!-- Add this at the end of your Livewire component's view -->
    @if ($confirmingDeletion)
        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Permanent Deletion</h5>
                        <button type="button" class="close" wire:click="$set('confirmingDeletion', false)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to permanently delete this user? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('confirmingDeletion', false)">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">Permanently Delete</button>
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
