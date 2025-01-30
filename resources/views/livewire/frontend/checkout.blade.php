<div>
    <div>
        <div id="header-title">
            <div class="container">
                <div class="header-box"></div>
                <div class="header-text" style="background-color:silver;">CHECKOUT</div>
            </div>
        </div>
    </div>
    <form method="post" id="checkout-form">
        <div class="container">
            <div class="clearfix checkbox-row">
                @unless (Auth::check())
                    <div id="box-auth" class="clearfix">
                        <div class="pull-left w100m">
                            <a class="button-register" id="submitbutton"
                                style="margin-top:0px;margin-right:10px;margin-left:0px;"
                                href="{{ route('register', ['referrer' => 'checkout']) }}">Register for New Customer</a>
                        </div>
                        <a id="atext" class="pull-left w100m">or</a>
                        <div class="pull-left w100m">
                            <a class="button-login" style="margin-top:0px;" id="submitbutton"
                                href="{{ route('login', ['referrer' => 'checkout']) }}">Login</a> &nbsp;&nbsp;
                        </div>
                        <div class="pull-left w100m">
                            <a id="atext">for your convenience</a>
                        </div>
                    </div>
                @endunless
                <div class="col-xs-12 col-md-8">
                    <div class="row  form-item-ck">
                        <div class="col-xs-12 " style="margin-top: 20px;margin-bottom: 20px;">
                            <div class="icons-number pull-left">1</div>
                            <div style=" padding-left:10px;float: left;">Billing Address</div>
                        </div>
                        <br><br>
                        {{-- <div class="col-xs-12 select-address-wrapper">
                            <select id="bill-address">
                                <option>Select Billing Address</option>
                                <option> {{ $billingAddress->billing_address ?? '' }}</option>
                            </select>
                            <span class="select-dropdown-icon glyphicon glyphicon-chevron-down">&nbsp;</span>
                        </div> --}}
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="billing_fname" id="billing_fname"
                                class="form-control" placeholder="First Name" data-validation="required"
                                value="{{ $billingAddress->first_name ?? '' }}" wire:model="billing_fname">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="billing_lname" id="billing_lname"
                                class="form-control" placeholder="Last Name " data-validation="required"
                                value="{{ $billingAddress->last_name ?? '' }}" wire:model="billing_lname">
                        </div>
                        <div class="col-xs-12" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="billing_company_name" id="billing_company_name"
                                class="form-control" placeholder="Company Name" data-validation="required"
                                value="{{ $billingAddress->billing_company_name ?? '' }}"
                                wire:model="billing_company_name">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="billing_address" id="billing_address"
                                class="form-control" placeholder="Address 1" data-validation="required"
                                value="{{ $billingAddress->billing_address ?? '' }}" wire:model="billing_address">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="billing_address_2" id="billing_address_2"
                                class="form-control" placeholder="Address 2" data-validation="required"
                                value="{{ $billingAddress->billing_address_2 ?? '' }}" wire:model="billing_address_2">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="billing_city" id="billing_city"
                                class="form-control" placeholder="City" data-validation="required"
                                value="{{ $billingAddress->billing_city ?? '' }}" wire:model="billing_city">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input maxlength="20" type="text" name="billing_postal_code" id="billing_postal_code"
                                class="form-control" placeholder="Postcode" data-validation="number"
                                value="{{ $billingAddress->billing_postal_code ?? '' }}"
                                wire:model="billing_postal_code">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <select class="form-control" id="billing_country" name="billing_country"
                                wire:model="billing_country">
                                <option value="{{ $billingAddress->billing_country ?? '' }}" disabled=""
                                    selected="">Select country</option>
                                <option data-code="AF" value="AF-Afghanistan"> Afghanistan</option>
                                <option data-code="AX" value="AX-Aland Islands"> Aland Islands</option>
                                <option data-code="AL" value="AL-Albania"> Albania</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input maxlength="100" type="text" name="billing_state" id="billing_state"
                                class="form-control" placeholder="States" data-validation="required"
                                wire:model="billing_state" value="{{ $billingAddress->billing_state ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="20" name="billing_phone" id="billing_phone"
                                class="form-control" placeholder="Phone" data-validation="number"
                                wire:model="billing_phone" value="{{ $billingAddress->billing_phone ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="email" maxlength="100" name="billing_email" id="billing_email"
                                class="form-control" placeholder="Email" data-validation="required"
                                wire:model="billing_email" value="{{ $billingAddress->billing_email ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-12" style="padding-bottom: 5px;">
                            Please ensure that the courier service (DHL/UPS) can reach you at your contact
                            number to avoid delivery failure.
                            <hr>
                        </div>
                        <br><br>
                        <div class="col-xs-12" style="margin-bottom: 20px;">
                            <div class="icons-number pull-left">2</div>
                            <div style="padding-left:10px;float: left;">Shipping Address
                            </div>
                            <div class="pull-right remember-rev" style="margin-right: 0px;">
                                <input type="checkbox" name="add_same" id="add_same" value="on"
                                    wire:model="useBillingAddress" onclick="SwitchAddress(this);">
                                <label for="add_same" class="pull-right">Ship to same address?</label>
                            </div>
                        </div>
                        <div id="ship_address">
                            <div class="row form-item-ck">
                                <div class="col-xs-12 select-address-wrapper">
                                    <select wire:model="selectedShippingAddress" wire:change="handleAddressChange">
                                        @foreach ($shippingAddresses as $address)
                                            <option value="{{ $address['address'] }}">{{ $address['address'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <input type="text" maxlength="100" name="firstname" id="firstname"
                                        class="form-control" placeholder="First Name" data-validation="required"
                                        wire:model="shipping_firstname">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="lastname" id="lastname"
                                        class="form-control" placeholder="Last Name" data-validation="required"
                                        wire:model="shipping_lastname">
                                </div>
                                <div class="col-xs-12" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="shipping_company_name"
                                        id="shipping_company_name" class="form-control"
                                        placeholder="Shipping Company Name" data-validation="required"
                                        wire:model="shipping_company_name">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" maxlength="100" name="address1" id="address1"
                                        class="form-control" placeholder="Address 1" data-validation="required"
                                        wire:model="shipping_address1">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="address2" id="address2"
                                        class="form-control" placeholder="Address 2" wire:model="shipping_address2">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" maxlength="100" name="city" id="city"
                                        class="form-control" placeholder="City" data-validation="required"
                                        wire:model="shipping_city">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="20" name="zip" id="zip"
                                        class="form-control" placeholder="Postcode" data-validation="required"
                                        wire:model="shipping_zip">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <select class="form-control" id="country" name="country"
                                        wire:model="shipping_country">
                                        <option value="" disabled selected>Select country</option>
                                        <option data-code="AF" value="AF-Afghanistan">Afghanistan</option>
                                        <option data-code="AX" value="AX-Aland Islands">Aland Islands</option>
                                        <option data-code="AL" value="AL-Albania">Albania</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="state" id="state"
                                        class="form-control" placeholder="State" data-validation="required"
                                        wire:model="shipping_state">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="20" name="phone" id="phone"
                                        class="form-control" placeholder="Phone" data-validation="number"
                                        wire:model="shipping_phone">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="email" maxlength="20" name="shipping_email" id="shipping_email"
                                        class="form-control" placeholder="shipping_email" data-validation="number"
                                        wire:model="shipping_email">
                                </div>
                                <div class="col-xs-12 col-md-12" style="padding-bottom: 20px;">
                                    <textarea class="form-control" name="shipnotes" id="shipnotes" rows="4" placeholder="Notes"
                                        wire:model="shipping_notes"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class=" col-xs-12 col-md-10">
                            Note:
                            <br><br>
                            1. To avoid customs delay, orders to Turkey and some other countries will be sent via
                            Registered Post (approximately 10-14 days)
                            <br><br>
                            2. Taxes, duties and custom charges may apply and are determined by your local
                            government and vary by country.
                        </div>

                    </div>
                </div>
                <div class="col-sm-4">
                    <livewire:order-summary-component :show-checkout-button="false" />

                    {{--  @if ($billingAddress && count($cartItems) > 0)
                        <div class="text-center mt-4">
                            <button wire:click="processOrder" class="btn btn-primary btn-lg"
                                wire:loading.attr="disabled">
                                <span wire:loading wire:target="processOrder">
                                    Processing...
                                </span>
                                <span wire:loading.remove wire:target="processOrder">
                                    Place Order
                                </span>
                            </button>
                        </div>
                    @endif --}}

                    @if (session()->has('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div id="paypalinfo" style="margin-top:10px;">
                        <div class="col-xl-12 col-l-12 col-m-12" align="right">
                            @if ($billingAddress && count($cartItems) > 0)
                                <a href="javascript:void(0);" class="myButton" name="submit" id="submitbutton"
                                    wire:click="processOrder" wire:loading.attr="disabled">
                                    <span wire:loading wire:target="processOrder">
                                        Processing...
                                    </span>
                                    <span wire:loading.remove wire:target="processOrder">
                                        PLACE ORDER &gt;
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
