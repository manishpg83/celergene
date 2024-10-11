<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $vendorId ? 'Edit Vendor' : 'Add New Vendor' }}</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                @if ($successMessage)
                    <div class="alert alert-success">
                        {{ $successMessage }}
                    </div>
                @endif

                @if ($errorMessage)
                    <div class="alert alert-danger">
                        {{ $errorMessage }}
                    </div>
                @endif

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="row g-3 mt-2">
                                <div class="col-md-12">
                                    <label class="form-label" for="name">Vendor Name</label>
                                    <input wire:model="name" type="text" id="name" class="form-control"
                                        placeholder="John Doe" />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="email">Email</label>
                                    <input wire:model="email" type="email" id="email" class="form-control"
                                        placeholder="email@example.com" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="password">Password</label>
                                    <input wire:model="password" type="password" id="password" class="form-control"
                                        placeholder="********" />
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                        class="form-control" placeholder="********" />
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="roles">Assign Roles</label>
                                    <select wire:model="roles" id="roles" class="form-select" multiple>
                                        @foreach ($availableRoles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button wire:click.prevent="submit" class="btn btn-primary">
                                        {{ $vendorId ? 'Update Vendor' : 'Add Vendor' }}
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
<script>
    window.addEventListener('vendor-added', event => {
        console.log(event.detail.message); // Log to console for debugging
        alert(event.detail.message); // Show alert
    });
</script>
