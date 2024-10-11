<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $vendorId ? 'Edit User' : 'Add New User' }}</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row g-3 mt-2">
                                <!-- Name Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Name</label>
                                    <input wire:model="name" type="text" id="name" class="form-control"
                                        placeholder="John Doe" />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input wire:model="email" type="email" id="email" class="form-control"
                                        placeholder="example@domain.com" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Password</label>
                                    <input wire:model="password" type="password" id="password" class="form-control"
                                        placeholder="Enter password" />
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-md-6">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                        class="form-control" placeholder="Confirm password" />
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Roles Field -->
                                <div class="col-md-6">
                                    <label class="form-check-label">Roles</label>
                                    <div class="mt-2">
                                        @foreach ($availableRoles as $role)
                                            <div class="form-check">
                                                <input wire:model="roles" class="form-check-input" type="checkbox"
                                                    value="{{ $role->id }}" id="role_{{ $role->id }}" />
                                                <label class="form-check-label"
                                                    for="role_{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Status Field -->
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input wire:model="status" class="form-check-input" type="radio"
                                                value="active" id="status_active" />
                                            <label class="form-check-label" for="status_active">Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input wire:model="status" class="form-check-input" type="radio"
                                                value="inactive" id="status_inactive" />
                                            <label class="form-check-label" for="status_inactive">Inactive</label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button wire:click.prevent="save" class="btn btn-primary">
                                        {{ $vendorId ? 'Update User' : 'Add User' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
