<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
        <!-- Account -->
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-6">
                @if ($admin->profile_image)
                    <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="user-avatar"
                        class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                @elseif ($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
                        id="uploadedAvatar" />
                @else
                    <img src="{{ asset('/admin/assets/img/avatars/1.png') }}" alt="user-avatar" class="rounded-circle" />
                @endif

                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" class="account-file-input" hidden
                            accept="image/png, image/jpeg" wire:model="image" />
                    </label>

                    {{-- Uncomment the reset button if you want a reset functionality --}}
                    {{-- <button type="button" class="btn btn-label-secondary account-image-reset mb-4" wire:click="resetImage">
                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                    </button> --}}

                    <div>Allowed JPG or PNG. Max size of 1MB</div>
                </div>
            </div>
        </div>

        <div class="card-body pt-4">
            <form wire:submit.prevent="updateProfile">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" id="name" name="name" wire:model="name"
                            autofocus />
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control" type="email" id="email" name="email" wire:model="email"
                            placeholder="john.doe@example.com" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <label for="new_password" class="form-label">New Password (optional)</label>
                        <input class="form-control" type="password" id="new_password" wire:model="new_password" />
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input class="form-control" type="password" id="new_password_confirmation"
                            wire:model="new_password_confirmation" />
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-3">Save changes</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account -->
    {{-- <div class="card">
        <h5 class="card-header">Delete Account</h5>
        <div class="card-body">
            @if (!$deleteConfirmation)
                <button wire:click="confirmDelete" class="btn btn-danger">Delete Account</button>
            @else
                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                    <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                </div>
                <form wire:submit.prevent="deleteAccount">
                    <div class="mb-4">
                        <label for="password_for_deletion" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_for_deletion"
                            wire:model="password_for_deletion">
                        @error('password_for_deletion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger me-2">Confirm Deletion</button>
                    <button type="button" wire:click="cancelDelete" class="btn btn-secondary">Cancel</button>
                </form>
            @endif
        </div>
    </div> --}}
    <!-- /Delete Account -->
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('notify', (data) => {
            notyf[data.type](data.message);
        });
    });
</script>
