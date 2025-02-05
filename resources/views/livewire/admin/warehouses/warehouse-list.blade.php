<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Warehouse List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            {{-- <div class="d-flex gap-4">
                <div class="btn-group"><button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
                        tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                        aria-expanded="false"><span><i class="ti ti-upload me-1 ti-xs"></i>Export</span></button>
                </div>
            </div> --}}
            <a href="{{ route('admin.warehouses.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Warehouse
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
                    <input type="text" wire:model.live="search" placeholder="Search Warehouses..."
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
                            <th wire:click="sortBy('warehouse_name')" style="cursor: pointer;">Warehouse Name</th>
                            <th class="text-center" wire:click="sortBy('country')" style="cursor: pointer;">Country</th>
                            <th class="text-center" wire:click="sortBy('type')" style="cursor: pointer;">Type</th>
                            <th class="text-center">Phone</th>
                            {{-- <th class="text-center">Email</th> --}}
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($warehouses->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">No warehouses found.</td>
                            </tr>
                        @else
                            @foreach ($warehouses as $warehouse)
                                <tr class="{{ $warehouse->trashed() ? 'table-warning' : '' }}">
                                    <td>{{ $warehouse->warehouse_name }}</td>
                                    <td class="text-center">{{ $warehouse->country }}</td>
                                    <td class="text-center">{{ $warehouse->type }}</td>
                                    <td class="text-center">{{ $warehouse->phone ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button"
                                                    id="actionMenu{{ $warehouse->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" style="width: 20px; height: 20px;">
                                                        <circle cx="12" cy="12" r="2" />
                                                        <circle cx="12" cy="6" r="2" />
                                                        <circle cx="12" cy="18" r="2" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $warehouse->id }}">
                                                    <li>
                                                        <a class="dropdown-item" wire:click="edit({{ $warehouse->id }})"
                                                            style="cursor: pointer;">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item {{ $warehouse->trashed() ? 'text-danger' : 'text-warning' }}"
                                                            wire:click="confirmDelete({{ $warehouse->id }})"
                                                            style="cursor: pointer;">
                                                            {{ $warehouse->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                        </a>
                                                    </li>
                                                    @if ($warehouse->trashed())
                                                        <li>
                                                            <a class="dropdown-item text-success"
                                                                wire:click="restore({{ $warehouse->id }})"
                                                                style="cursor: pointer;">Restore</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            @if($warehouse->trashed())
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
                {{ $warehouses->links() }}
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
                            <p>Are you sure you want to permanently delete this warehouse? This action cannot be undone.
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
