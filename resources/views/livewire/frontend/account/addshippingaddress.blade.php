<div class="col-xl-9 account-wrapper">
    <div class="account-card">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="row">
            <h3 class="m-b30">Shipping address</h3>

            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">First Name *</label>
                    <input wire:model="firstName" class="form-control @error('firstName') is-invalid @enderror">
                    @error('firstName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">Last Name *</label>
                    <input wire:model="lastName" class="form-control @error('lastName') is-invalid @enderror">
                    @error('lastName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Company name (optional)</label>
                    <input wire:model="companyName" class="form-control">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Street address *</label>
                    <input wire:model="streetAddress"
                        class="form-control m-b15 @error('streetAddress') is-invalid @enderror"
                        placeholder="House number and street name">
                    @error('streetAddress')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <input wire:model="apartmentAddress" class="form-control"
                        placeholder="Apartment, suite, unit, etc. (optional)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="m-b25">
                    <label class="label-title">Country / Region *</label>
                    <select wire:model="country" class="form-select @error('country') is-invalid @enderror">
                        <option value="">Select Country</option>
                        @foreach ($countries as $id => $name)
                            <option value="{{ $name }}">{{ $name }}</option> 
                        @endforeach
                    </select>
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">Contact Number *</label>
                    <input wire:model="phoneNumber" class="form-control @error('phoneNumber') is-invalid @enderror">
                    @error('phoneNumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">City *</label>
                    <input wire:model="city" class="form-control @error('city') is-invalid @enderror">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">State *</label>
                    <input wire:model="state" class="form-control @error('state') is-invalid @enderror">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Pincode *</label>
                    <input wire:model="pincode" class="form-control @error('pincode') is-invalid @enderror">
                    @error('pincode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-secondary">Save changes</button>
            </div>
        </form>
    </div>
</div>
