<section class="col-xl-9 account-wrapper">
    <div class="account-card">
        <form wire:submit.prevent="saveAddress" class="row">
            <h3 class="m-b30">Billing Address</h3>
            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">First Name</label>
                    <input type="text" wire:model="first_name" required class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group m-b25">
                    <label class="label-title">Last Name</label>
                    <input type="text" wire:model="last_name" required class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Company Name (optional)</label>
                    <input type="text" wire:model="company_name" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Billing Address *</label>
                    <input type="text" wire:model="billing_address" required class="form-control" placeholder="House number and street name">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Postal Code *</label>
                    <input type="text" wire:model="billing_postal_code" required class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Phone *</label>
                    <input type="text" wire:model="mobile_number" required class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group m-b25">
                    <label class="label-title">Email Address *</label>
                    <input type="email" wire:model="email" required class="form-control">
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-secondary">Save Changes</button>
            </div>
        </form>
    </div>
</section>