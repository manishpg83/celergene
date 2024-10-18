<div>
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">User Manager</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                <div class="btn-group">
                    <button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
                        tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                        aria-expanded="false"><span><i class="ti ti-upload me-1 ti-xs"></i>Export</span></button>
                </div>
            </div>
            {{-- <a href="{{ route('admin.vendors.add') }}" class="btn btn-primary">
                    <i class="ti ti-plus ti-xs me-md-2"></i>Add User
                </a> --}}
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="position-relative me-3">
                    <input wire:model.live="searchTerm" type="text" placeholder="Search Roles..."
                        class="form-control" style="width: auto;">
                </div>

                <div class="d-flex">
                    <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                        @foreach ($perpagerecords as $pagekey => $pagevalue)
                            <option value="{{ $pagekey }}">{{ $pagevalue }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->roles->isEmpty())
                                    <span class="badge bg-secondary">No Role</span>
                                @else
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-info">{{ $role->name }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <button wire:click="editUserRole({{ $user->id }})" class="btn btn-sm btn-warning">Edit
                                    Role</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $paginatedUsers->links() }}
    </div>

    @if ($selectedUserId)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Update User Role</h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="updateUserRole">
                    <div class="mb-3">
                        <label for="role" class="form-label">Select Role</label>
                        <select wire:model="selectedRole" id="role" class="form-select">
                            <option value="">Choose a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedRole')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check ti-xs me-1"></i>Update Role
                        </button>
                        <button type="button" wire:click="$set('selectedUserId', null)" class="btn btn-secondary">
                            <i class="ti ti-x ti-xs me-1"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
