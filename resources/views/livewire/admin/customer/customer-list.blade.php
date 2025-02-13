<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Customer List</h4> 
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                <div class="btn-group"><button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
                        tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                        aria-expanded="false"><span><i class="ti ti-upload me-1 ti-xs"></i>Export</span></button>
                </div>
            </div>
            <a href="{{ route('admin.customer.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Customer
            </a>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                    <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                        @foreach ($perpagerecords as $pagekey => $pagevalue)
                            <option value="{{ $pagekey }}">{{ $pagevalue }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="status" class="form-select" style="width: auto;">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="position-relative">
                    <input wire:model.live="search" type="text" placeholder="Search Customers..."
                        class="form-control" style="width: auto;">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th wire:click="sortBy('first_name')" style="cursor: pointer;">Name</th>
                            <th wire:click="sortBy('email')" style="cursor: pointer;">Email</th>
                            <th wire:click="sortBy('Mobile')" style="cursor: pointer;">Mobile</th>
                            <th wire:click="sortBy('company_name')" style="cursor: pointer;">Company Name</th>
                            <th wire:click="sortBy('billing_country')" style="cursor: pointer;">Country</th>
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
                                <tr class="text-center {{ $customer->trashed() ? 'table-warning' : '' }}">
                                    <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->mobile_number }}</td>
                                    <td>{{ $customer->company_name }}</td>
                                    <td>{{ $customer->billing_country }}</td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('admin.customer.details', $customer->id) }}" class="text-black" title="View Details" target="_blank">
                                                <i class="fa fa-eye" style="font-size: 20px; color: #7367f0;"></i>
                                            </a>
                     
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button" id="actionMenu{{ $customer->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" style="font-size: 20px;"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $customer->id }}">
                                                    <li><a class="dropdown-item" wire:click="edit({{ $customer->id }})" style="cursor: pointer;">Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item {{ $customer->trashed() ? 'text-danger' : 'text-warning' }}" 
                                                           wire:click="confirmDelete({{ $customer->id }})" 
                                                           style="cursor: pointer;">
                                                            {{ $customer->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                        </a>
                                                    </li>
                                                    @if ($customer->trashed())
                                                        <li><a class="dropdown-item text-success" wire:click="restore({{ $customer->id }})" style="cursor: pointer;">Restore</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                     
                                            @if($customer->trashed())
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
        </div>
    </div>

    <div class="mt-3">
        {{ $customers->links() }}
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
                        <p>Are you sure you want to permanently delete this customer? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('confirmingDeletion', false)">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">Permanently Delete</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
