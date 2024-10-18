<div class="mb-4">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1">Role Manager</h4>
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
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="{{ $editingRole ? 'updateRole' : 'createRole' }}">
                <div class="form-group">
                    <label for="roleName">Role Name</label>
                    <input type="text" wire:model="roleName" class="form-control" id="roleName" required>
                </div>

                <div class="form-group">
                    <label for="permissions">Permissions</label>
                    <select wire:model="selectedPermissions" class="form-control" id="permissions" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-2">
                    {{ $editingRole ? 'Update Role' : 'Create Role' }}
                </button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
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

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge bg-info">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button wire:click="editRole({{ $role->id }})"
                                        class="btn btn-sm btn-primary">Edit</button>
                                    @if ($role->name !== 'super-admin')
                                        <button wire:click="deleteRole({{ $role->id }})"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <div>
                    {{ $paginator->links() }}
                </div>
                <div>
                    <span class="text-muted">Showing {{ $paginator->count() }} of {{ $paginator->total() }}
                        roles</span>
                </div>
            </div>
        </div>
    </div>
</div>
