<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Currency List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <a href="{{ route('admin.currency.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Currency
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
                    <input type="text" wire:model.live="search" placeholder="Search Currencies..."
                        class="form-control me-2" style="width: auto;" />
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="cursor: pointer;">ID</th>
                            <th style="cursor: pointer;">Name</th>
                            <th style="cursor: pointer;">Code</th>
                            <th style="cursor: pointer;">Symbol</th>
                            <th style="cursor: pointer;">Rate</th>
                            <th style="cursor: pointer;">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($currencies->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No currencies found.</td>
                            </tr>
                        @else
                            @foreach ($currencies as $currency)
                                <tr>
                                    <td>{{ $currency->id }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ $currency->code }}</td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td>{{ $currency->rate }}</td>
                                    <td>
                                        @if ($currency->trashed())
                                            <span class="btn btn-sm btn-warning">Suspended</span>
                                        @else
                                            <button wire:click="toggleActive({{ $currency->id }})"
                                                class="btn btn-sm {{ $currency->status === 'active' ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $currency->status === 'active' ? 'Active' : 'Inactive' }}
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-black" type="button"
                                                id="actionMenu{{ $currency->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" style="width: 20px; height: 20px;">
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="12" cy="6" r="2" />
                                                    <circle cx="12" cy="18" r="2" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $currency->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        wire:click="editCurrency({{ $currency->id }})"
                                                        style="cursor: pointer;">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item {{ $currency->trashed() ? 'text-danger' : 'text-warning' }}"
                                                        wire:click="confirmDelete({{ $currency->id }})"
                                                        style="cursor: pointer;">
                                                        {{ $currency->trashed() ? 'Permanently Delete' : 'Suspend' }}
                                                    </a>
                                                </li>
                                                @if ($currency->trashed())
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            wire:click="restore({{ $currency->id }})"
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

            <div class="d-flex justify-content-end mt-3">
                <div>
                    {{ $currencies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <p>Are you sure you want to permanently delete this currency? This action cannot be undone.</p>
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
