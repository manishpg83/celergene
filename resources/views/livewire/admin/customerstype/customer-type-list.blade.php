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
                <input type="text" wire:model.live="search" placeholder="Search Customer Types..."
                    class="form-control me-2" style="width: auto;" />
                <a href="" class="btn btn-primary">
                    <i class="ti ti-plus ti-xs me-1"></i>Add Customer Type
                </a>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th wire:click="sortBy('id')" style="cursor: pointer;">ID</th>
                        <th wire:click="sortBy('customertype')" style="cursor: pointer;">Customer Type</th>
                        <th wire:click="sortBy('status')" style="cursor: pointer;">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($customerTypes->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">No customer types found.</td>
                        </tr>
                    @else
                        @foreach ($customerTypes as $customerType)
                            <tr>
                                <td>{{ $customerType->id }}</td>
                                <td>{{ $customerType->customertype }}</td>
                                <td>{{ ucfirst($customerType->status) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-black" type="button"
                                            id="actionMenu{{ $customerType->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" style="width: 20px; height: 20px;">
                                                <circle cx="12" cy="12" r="2" />
                                                <circle cx="12" cy="6" r="2" />
                                                <circle cx="12" cy="18" r="2" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $customerType->id }}">
                                            <li>
                                                <a class="dropdown-item" wire:click="editCustomerType({{ $customerType->id }})" style="cursor: pointer;">Edit</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" wire:click="deleteCustomerType({{ $customerType->id }})" style="cursor: pointer;">Delete</a>
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


    </div>
</div>
