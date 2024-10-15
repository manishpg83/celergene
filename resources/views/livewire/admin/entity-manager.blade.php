<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Entity / Company List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
           {{--  <div class="d-flex gap-4">
                <div class="btn-group"><button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
                        tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                        aria-expanded="false"><span><i class="ti ti-upload me-1 ti-xs"></i>Export</span></button>
                </div>
            </div> --}}
            <a href="{{ route('admin.entities.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Entity
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="position-relative me-3">
                    <input wire:model.live="search" type="text" placeholder="Search Entities..." class="form-control"
                        style="width: auto;">
                </div>

                <div class="d-flex">
                    <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                        <option value="5">5</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    <select wire:model.live="status" class="form-select" style="width: auto;">
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
                            <th wire:click="sortBy('company_name')" style="cursor: pointer;">Company Name</th>
                            <th wire:click="sortBy('country')" style="cursor: pointer;">Country</th>
                            <th wire:click="sortBy('created_by')" style="cursor: pointer;">Created By</th>
                            <th wire:click="sortBy('is_active')" style="cursor: pointer;">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($entities && $entities->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No entities found.</td>
                            </tr>
                        @else
                            @foreach ($entities as $index => $entity)
                                <tr>
                                    <td>{{ ($entities->currentPage() - 1) * $entities->perPage() + $index + 1 }}</td>
                                    <td>{{ $entity->id }}</td>
                                    <td>{{ $entity->company_name }}</td>
                                    <td>{{ $entity->country }}</td>
                                    <td>{{ $entity->createdBy->name }}</td>
                                    <td>
                                        @if ($entity->trashed())
                                            <span class="text-warning">Suspended</span>
                                        @else
                                            <button wire:click="toggleActive({{ $entity->id }})"
                                                class="btn btn-sm {{ $entity->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $entity->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-black" type="button"
                                                id="actionMenu{{ $entity->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" style="width: 20px; height: 20px;">
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="12" cy="6" r="2" />
                                                    <circle cx="12" cy="18" r="2" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $entity->id }}">
                                                <li>
                                                    <a class="dropdown-item" wire:click="edit({{ $entity->id }})"
                                                        style="cursor: pointer;">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ $entity->trashed() ? 'text-danger' : 'text-warning' }}"
                                                        wire:click="confirmDelete({{ $entity->id }})"
                                                        style="cursor: pointer;">
                                                        {{ $entity->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                    </a>
                                                </li>
                                                @if ($entity->trashed())
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            wire:click="restore({{ $entity->id }})"
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

            <div class="mt-4">
                {{ $entities->links() }}
            </div>
        </div>
        @if ($isEditing)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal"
                role="dialog" aria-labelledby="modal-title">
                <div
                    class="relative mt-10 mb-10 mx-auto border w-11/12 md:w-4/5 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="text-center border-2 border-gray-300 rounded-lg">
                        <h2 id="modal-title"
                            class="text-2xl leading-6 font-medium text-white bg-blue-600 border-b-2 border-gray-300 pb-2 px-4 py-2 rounded-t">
                            {{ $entityId ? 'Edit' : 'Add' }} Entity
                        </h2>
                        <div class="mt-2 px-7 py-3">
                            <form wire:submit.prevent="save">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    <div class="mb-4">
                                        <label for="company_name"
                                            class="block text-gray-700 text-sm font-bold mb-2">Company
                                            Name</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="company_name" wire:model.defer="company_name" required>
                                        @error('company_name')
                                            <span class="text-red-500 text-xs">The company name field is required.</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="country"
                                            class="block text-gray-700 text-sm font-bold mb-2">Country</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="country" wire:model.defer="country" required>
                                        @error('country')
                                            <span class="text-red-500 text-xs">The country field is required.</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="address"
                                            class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="address" wire:model.defer="address" required>
                                        @error('address')
                                            <span class="text-red-500 text-xs">The address field is required.</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="postal_code"
                                            class="block text-gray-700 text-sm font-bold mb-2">Postal
                                            Code</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="postal_code" wire:model.defer="postal_code" required>
                                        @error('postal_code')
                                            <span class="text-red-500 text-xs">The postal code field is required.</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="business_reg_number"
                                            class="block text-gray-700 text-sm font-bold mb-2">Business Registration
                                            Number</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="business_reg_number" wire:model="business_reg_number">
                                        @error('business_reg_number')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="vat_number" class="block text-gray-700 text-sm font-bold mb-2">VAT
                                            Number</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="vat_number" wire:model="vat_number">
                                        @error('vat_number')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_account_name"
                                            class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            Account Name</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_account_name" wire:model="bank_account_name" required>
                                        @error('bank_account_name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_account_number"
                                            class="block text-gray-700 text-sm font-bold mb-2">Bank Account
                                            Number</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_account_number" wire:model="bank_account_number" required>
                                        @error('bank_account_number')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="currency"
                                            class="block text-gray-700 text-sm font-bold mb-2">Currency</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="currency" wire:model="currency" required maxlength="3">
                                        @error('currency')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_name" class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            Name</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_name" wire:model="bank_name" required>
                                        @error('bank_name')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_address"
                                            class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            Address</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_address" wire:model="bank_address" required>
                                        @error('bank_address')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_swift_code"
                                            class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            Swift Code</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_swift_code" wire:model="bank_swift_code">
                                        @error('bank_swift_code')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_iban_number"
                                            class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            IBAN Number</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_iban_number" wire:model="bank_iban_number">
                                        @error('bank_iban_number')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_code" class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            Code</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_code" wire:model="bank_code">
                                        @error('bank_code')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bank_branch_code"
                                            class="block text-gray-700 text-sm font-bold mb-2">Bank
                                            Branch Code</label>
                                        <input type="text"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="bank_branch_code" wire:model="bank_branch_code">
                                        @error('bank_branch_code')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="is_active"
                                            class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                        <select
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="is_active" wire:model="is_active">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="flex justify-end mt-4">
                                    <button type="button"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                        wire:click="cancel">Cancel</button>
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                            <p>Are you sure you want to permanently delete this entity? This action cannot be undone.
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
