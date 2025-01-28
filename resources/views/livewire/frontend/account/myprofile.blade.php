<section class="col-xl-9 account-wrapper">
    <div class="account-card">
        <div class="profile-edit">
            <div class="avatar-upload d-flex align-items-center">
                <div class="position-relative">
                    <div class="avatar-preview thumb">
                        @if($image && is_object($image))
                            <div id="imagePreview" style="background-image: url('{{ $image->temporaryUrl() }}');"></div>
                        @else
                            <div id="imagePreview" style="background-image: url('{{ asset($customer->image ?? 'frontend/images/default.jpeg') }}');"></div>
                        @endif
                    </div>
                    <div class="change-btn thumb-edit d-flex align-items-center flex-wrap">
                        <input type="file" wire:model="image" class="form-control d-none" id="imageUpload" accept=".png, .jpg, .jpeg">
                        <label for="imageUpload" class="btn btn-light ms-0">
                            <i class="fa-solid fa-camera"></i>
                        </label>
                    </div>
                </div>
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="clearfix">
                <h2 class="title mb-0">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h2>
                <span class="text text-primary">{{ Auth::user()->email }}</span>
            </div>
        </div>
        <form wire:submit.prevent="updateProfile" class="row">
            <div class="col-lg-6">
                <div class="form-group m-b25">
                    <label class="label-title">First Name</label>
                    <input wire:model="first_name" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-b25">
                    <label class="label-title">Last Name</label>
                    <input wire:model="last_name" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-b25">
                    <label class="label-title">Email address</label>
                    <input type="email" wire:model="email" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-b25">
                    <label class="label-title">Phone</label>
                    <input type="text" wire:model="phone" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-b25">
                    <label class="label-title">New password</label>
                    <input type="password" wire:model="password" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-b25">
                    <label class="label-title">Confirm new password</label>
                    <input type="password" wire:model="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary mt-3">Update profile</button>
            </div>
        </form>
    </div>
</section>
