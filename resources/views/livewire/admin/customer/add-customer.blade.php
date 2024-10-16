<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">Add New Customer</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <form wire:submit.prevent="{{ $isEditing ? 'save' : 'save' }}">
                                <input type="hidden" wire:model="customerId">
                                <!-- Customer Details -->
                                <div class="row g-3">
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label" for="customer_type_id">Customer Type</label>
                                        <select wire:model="customer_type_id"
                                            class="form-select @error('customer_type_id') is-invalid @enderror"
                                            id="customer_type_id">
                                            <option value="">Select</option>
                                            @foreach ($customerTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->customer_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" for="salutation">Salutation</label>
                                        <select wire:model="salutation"
                                            class="form-select @error('salutation') is-invalid @enderror"
                                            id="salutation">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                        </select>
                                        @error('salutation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label" for="first_name">First Name</label>
                                        <input type="text" wire:model="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name">
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label" for="last_name">Last Name</label>
                                        <input type="text" wire:model="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            id="last_name">
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="mobile_number">Mobile Number</label>
                                        <input type="text" wire:model="mobile_number"
                                            class="form-control @error('mobile_number') is-invalid @enderror"
                                            id="mobile_number">
                                        @error('mobile_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" wire:model="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="vat_number">VAT Number</label>
                                        <input type="text" wire:model="vat_number"
                                            class="form-control @error('vat_number') is-invalid @enderror"
                                            id="vat_number">
                                        @error('vat_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="business_reg_number">Business Registration
                                            Number</label>
                                        <input type="text" wire:model="business_reg_number"
                                            class="form-control @error('business_reg_number') is-invalid @enderror"
                                            id="business_reg_number">
                                        @error('business_reg_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="company_name">Company Name</label>
                                        <input type="text" wire:model="company_name"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            id="company_name">
                                        @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="address">Customer Address</label>
                                        <textarea wire:model="address" class="form-control @error('address') is-invalid @enderror" id="address"
                                            rows="4"></textarea>
                                        @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Payment Details -->
                                <h5 class="my-4">Payment Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="payment_term_display">Payment Term
                                            Display</label>
                                        <input type="text" wire:model="payment_term_display"
                                            class="form-control @error('payment_term_display') is-invalid @enderror"
                                            id="payment_term_display">
                                        @error('payment_term_display')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="payment_term_actual">Payment Term
                                            Actual</label>
                                        <select wire:model="payment_term_actual"
                                            class="form-select @error('payment_term_actual') is-invalid @enderror"
                                            id="payment_term_actual">
                                            <option value="">Select</option>
                                            <option value="7D">7 Days</option>
                                            <option value="14D">14 Days</option>
                                            <option value="30D">30 Days</option>
                                        </select>
                                        @error('payment_term_actual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="credit_rating">Credit Rating</label>
                                        <input type="text" wire:model="credit_rating"
                                            class="form-control @error('credit_rating') is-invalid @enderror"
                                            id="credit_rating">
                                        @error('credit_rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="allow_consignment">Allow Consignment</label>
                                        <select wire:model="allow_consignment"
                                            class="form-select @error('allow_consignment') is-invalid @enderror"
                                            id="allow_consignment">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        @error('allow_consignment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label" for="must_receive_payment">Must Receive Payment
                                            Before Delivery</label>
                                        <select wire:model="must_receive_payment"
                                            class="form-select @error('must_receive_payment') is-invalid @enderror"
                                            id="must_receive_payment">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        @error('must_receive_payment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h5 class="my-4">Billing Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="billing_address">Billing Address</label>
                                        <textarea wire:model="billing_address" class="form-control" id="billing_address" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="billing_country">Billing Country</label>
                                        <select wire:model="billing_country" class="form-select" id="billing_country">
                                            <option value="">Select</option>
                                            <option value="LUX">Luxembourg</option>
                                            <option value="USA">United States of America</option>
                                            <option value="MAL">Malaysia</option>
                                            <option value="IND">India</option>
                                            <option value="SIN">Singapore</option>
                                            <option value="CHI">China</option>
                                            <option value="SWI">Switzerland</option>
                                            <option value="THA">Thailand</option>
                                            <option value="PHI">Philippines</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="billing_postal_code">Billing Postal Code</label>
                                        <input type="text" wire:model="billing_postal_code" class="form-control" id="billing_postal_code">
                                    </div>
                                </div>

                                <div class="form-check mt-3 mb-3">
                                    <input type="checkbox" class="form-check-input" id="sameAsBilling">
                                    <label class="form-check-label" for="sameAsBilling">My billing and shipping address are the same</label>
                                </div>

                                <!-- Shipping Details -->
                                <h5 class="my-4">Shipping Details</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="shipping_address_receiver_name_1">Shipping Address Receiver Name 1</label>
                                        <input type="text" wire:model="shipping_address_receiver_name_1" class="form-control" id="shipping_address_receiver_name_1">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="shipping_address_1">Shipping Address 1</label>
                                        <input type="text" wire:model="shipping_address_1" class="form-control" id="shipping_address_1">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="shipping_country_1">Shipping Country 1</label>
                                        <select wire:model="shipping_country_1" class="form-select" id="shipping_country_1">
                                            <option value="">Select</option>
                                            <option value="LUX">Luxembourg</option>
                                            <option value="USA">United States of America</option>
                                            <option value="MAL">Malaysia</option>
                                            <option value="IND">India</option>
                                            <option value="SIN">Singapore</option>
                                            <option value="CHI">China</option>
                                            <option value="SWI">Switzerland</option>
                                            <option value="THA">Thailand</option>
                                            <option value="PHI">Philippines</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="shipping_postal_code_1">Shipping Postal Code 1</label>
                                        <input type="text" wire:model="shipping_postal_code_1" class="form-control" id="shipping_postal_code_1">
                                    </div>
                                </div>

                                <!-- Shipping Details 2 -->
                                <h5 class="my-4">Shipping Details 2</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="shipping_address_receiver_name_2">Shipping
                                            Address Receiver Name 2</label>
                                        <input type="text" wire:model="shipping_address_receiver_name_2"
                                            class="form-control @error('shipping_address_receiver_name_2') is-invalid @enderror"
                                            id="shipping_address_receiver_name_2">
                                        @error('shipping_address_receiver_name_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="shipping_address_2">Shipping Address 2</label>
                                        <input type="text" wire:model="shipping_address_2"
                                            class="form-control @error('shipping_address_2') is-invalid @enderror"
                                            id="shipping_address_2">
                                        @error('shipping_address_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="shipping_country_2">Shipping Country 2</label>
                                        <select wire:model="shipping_country_2"
                                            class="form-select @error('shipping_country_2') is-invalid @enderror"
                                            id="shipping_country_2">
                                            <option value="">Select</option>
                                            <option value="LUX">Luxembourg</option>
                                            <option value="USA">United States of America</option>
                                            <option value="MAL">Malaysia</option>
                                            <option value="IND">India</option>
                                            <option value="SIN">Singapore</option>
                                            <option value="CHI">China</option>
                                            <option value="SWI">Switzerland</option>
                                            <option value="THA">Thailand</option>
                                            <option value="PHI">Philippines</option>
                                        </select>
                                        @error('shipping_country_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="shipping_postal_code_2">Shipping Postal Code
                                            2</label>
                                        <input type="text" wire:model="shipping_postal_code_2"
                                            class="form-control @error('shipping_postal_code_2') is-invalid @enderror"
                                            id="shipping_postal_code_2">
                                        @error('shipping_postal_code_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Shipping Details 3 -->
                                <h5 class="my-4">Shipping Details 3</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label" for="shipping_address_receiver_name_3">Shipping
                                            Address Receiver Name 3</label>
                                        <input type="text" wire:model="shipping_address_receiver_name_3"
                                            class="form-control @error('shipping_address_receiver_name_3') is-invalid @enderror"
                                            id="shipping_address_receiver_name_3">
                                        @error('shipping_address_receiver_name_3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label" for="shipping_address_3">Shipping Address 3</label>
                                        <input type="text" wire:model="shipping_address_3"
                                            class="form-control @error('shipping_address_3') is-invalid @enderror"
                                            id="shipping_address_3">
                                        @error('shipping_address_3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="shipping_country_3">Shipping Country 3</label>
                                        <select wire:model="shipping_country_3"
                                            class="form-select @error('shipping_country_3') is-invalid @enderror"
                                            id="shipping_country_3">
                                            <option value="">Select</option>
                                            <option value="LUX">Luxembourg</option>
                                            <option value="USA">United States of America</option>
                                            <option value="MAL">Malaysia</option>
                                            <option value="IND">India</option>
                                            <option value="SIN">Singapore</option>
                                            <option value="CHI">China</option>
                                            <option value="SWI">Switzerland</option>
                                            <option value="THA">Thailand</option>
                                            <option value="PHI">Philippines</option>
                                        </select>
                                        @error('shipping_country_3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="shipping_postal_code_3">Shipping Postal Code
                                            3</label>
                                        <input type="text" wire:model="shipping_postal_code_3"
                                            class="form-control @error('shipping_postal_code_3') is-invalid @enderror"
                                            id="shipping_postal_code_3">
                                        @error('shipping_postal_code_3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <!-- Status -->
                                <div class="mt-4">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="status"
                                            value="active" id="status_active">
                                        <label class="form-check-label" for="status_active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="status"
                                            value="inactive" id="status_inactive">
                                        <label class="form-check-label" for="status_inactive">Inactive</label>
                                    </div>
                                </div> --}}

                                <!-- Submit Button -->
                                <div class="row g-3 mt-4">
                                    <div class="col-sm-6 col-4 d-grid">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
