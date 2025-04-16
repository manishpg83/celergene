<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $entityId ? 'Edit Entity' : 'Add New Entity' }}</h5>
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
                                <div class="col-md-12">
                                    <label class="form-label" for="company_name">Entity/Company Name</label>
                                    <input wire:model="company_name" type="text" id="company_name" class="form-control" placeholder="ABC Co" />
                                    @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea wire:model="address" class="form-control" id="address" rows="4" placeholder="1456, Kings Road"></textarea>
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="country">Country</label>
                                    <select wire:model="country" id="country" class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $countryName)
                                            <option value="{{ $countryName }}">{{ $countryName }}</option>
                                        @endforeach
                                    </select>
                                    @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="postal_code">Postal Code</label>
                                    <input wire:model="postal_code" type="text" id="postal_code" class="form-control" placeholder="10001" />
                                    @error('postal_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <hr />

                                <h5 class="my-4">Registration Details</h5>

                                <div class="col-md-6">
                                    <label class="form-label" for="business_reg_number">Business Registration Number</label>
                                    <input wire:model="business_reg_number" type="text" id="business_reg_number" class="form-control" placeholder="6587998941" />
                                    @error('business_reg_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="vat_number">VAT Number</label>
                                    <input wire:model="vat_number" type="text" id="vat_number" class="form-control" placeholder="587998941" />
                                    @error('vat_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="gst_number">GST Number</label>
                                    <input wire:model="gst_number" type="text" id="gst_number" class="form-control" placeholder="98799894" />
                                    @error('gst_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="currency">Currency</label>
                                    <select wire:model="currency" id="currency" class="form-select" data-allow-clear="true">
                                        <option value="">Select Currency</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->code }}">
                                                {{ $currency->name }} ({{ $currency->symbol }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <hr />

                                <h5 class="my-4">Bank Details</h5>

                                <div class="col-md-6">
                                    <label class="form-label" for="bank_account_name">Bank Account Name</label>
                                    <input wire:model="bank_account_name" type="text" id="bank_account_name" class="form-control" placeholder="ABC Co Pvt Ltd" />
                                    @error('bank_account_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="bank_account_number">Bank Account Number</label>
                                    <input wire:model="bank_account_number" type="text" id="bank_account_number" class="form-control" placeholder="1234 4567 8901" />
                                    @error('bank_account_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="bank_name">Bank Name</label>
                                    <input wire:model="bank_name" type="text" id="bank_name" class="form-control" placeholder="HSBC Bank" />
                                    @error('bank_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="bank_address">Bank Address</label>
                                    <textarea wire:model="bank_address" class="form-control" id="bank_address" rows="4" placeholder="3456, Queens Road"></textarea>
                                    @error('bank_address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="bank_swift_code">Bank SWIFT Code</label>
                                    <input wire:model="bank_swift_code" type="text" id="bank_swift_code" class="form-control" placeholder="HSBCSGSG" />
                                    @error('bank_swift_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="bank_iban_number">Bank IBAN Number</label>
                                    <input wire:model="bank_iban_number" type="text" id="bank_iban_number" class="form-control" placeholder="SG29HSBCSGSG1234567890" />
                                    @error('bank_iban_number') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="bank_code">Bank Code</label>
                                    <input wire:model="bank_code" type="text" id="bank_code" class="form-control" placeholder="7232" />
                                    @error('bank_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="bank_branch_code">Bank Branch Code</label>
                                    <input wire:model="bank_branch_code" type="text" id="bank_branch_code" class="form-control" placeholder="001" />
                                    @error('bank_branch_code') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-check-label">Status</label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input wire:model="is_active" class="form-check-input" type="radio" value="1" id="status_active" />
                                            <label class="form-check-label" for="status_active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="is_active" class="form-check-input" type="radio" value="0" id="status_inactive" />
                                            <label class="form-check-label" for="status_inactive">Inactive</label>
                                        </div>
                                    </div>
                                    @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <button 
                                        wire:click.prevent="save" 
                                        class="btn btn-primary" 
                                        wire:loading.attr="disabled"
                                    >
                                        <span wire:loading.remove>
                                            {{ $entityId ? 'Update Entity' : 'Add Entity' }}
                                        </span>
                                        <span wire:loading>
                                            <i class="fas fa-spinner fa-spin"></i> Saving...
                                        </span>
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
