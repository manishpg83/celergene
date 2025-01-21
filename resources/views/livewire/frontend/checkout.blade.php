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
                        <!-- Check if the user is NOT logged in -->
                        <!-- Show Register and Login if not logged in -->
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
                    <!-- Billing Address -->
                    <div class="row  form-item-ck">
                        <div class="col-xs-12 " style="margin-top: 20px;margin-bottom: 20px;">
                            <div class="icons-number pull-left">1</div>
                            <div style=" padding-left:10px;float: left;">Billing Address</div>
                        </div>
                        <br><br>
                        <div class="col-xs-12 select-address-wrapper">
                            <select id="bill-address">
                                <option>Select Billing Address</option>
                                <option> {{ $billingAddress->billing_address ?? '' }}</option>
                            </select>
                            <span class="select-dropdown-icon glyphicon glyphicon-chevron-down">&nbsp;</span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="bill_firstname" id="bill_firstname"
                                class="form-control" placeholder="First Name" data-validation="required"
                                value="{{ $billingAddress->first_name ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="bill_lastname" id="bill_lastname"
                                class="form-control" placeholder="Last Name " data-validation="required"
                                value="{{ $billingAddress->last_name ?? '' }}">
                        </div>
                        <div class="col-xs-12" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="bill_company" id="bill_company"
                                class="form-control" placeholder="Company Name" data-validation="required"
                                value="{{ $billingAddress->company_name ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="bill_address1" id="bill_address1"
                                class="form-control" placeholder="Address 1" data-validation="required"
                                value="{{ $billingAddress->billing_address ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="bill_address2" id="bill_address2"
                                class="form-control" placeholder="Address 2" data-validation="required" value="">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="bill_city" id="bill_city" class="form-control"
                                placeholder="City" data-validation="required" value="">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input maxlength="20" type="text" name="bill_zip" id="bill_zip" class="form-control"
                                placeholder="Postcode" data-validation="number"
                                value="{{ $billingAddress->billing_postal_code ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <select class="form-control" id="bill_country" name="bill_country">
                                <option value="{{ $billingAddress->billing_country ?? '' }}" disabled=""
                                    selected="">Select country</option>
                                <option data-code="AF" value="AF-Afghanistan"> Afghanistan</option>
                                <option data-code="AX" value="AX-Aland Islands"> Aland Islands</option>
                                <option data-code="AL" value="AL-Albania"> Albania</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input maxlength="100" type="text" name="bill_state" id="bill_state"
                                class="form-control" placeholder="States" data-validation="required" value="">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="20" name="bill_phone" id="bill_phone"
                                class="form-control" placeholder="Phone" data-validation="number"
                                value="{{ $billingAddress->mobile_number ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="email" maxlength="100" name="bill_email" id="bill_email"
                                class="form-control" placeholder="Email" data-validation="required"
                                value="{{ $billingAddress->email ?? '' }}">
                        </div>
                        <div class="col-xs-12 col-md-12" style="padding-bottom: 5px;">
                            Please ensure that the courier service (DHL/UPS) can reach you at your contact
                            number to avoid delivery failure.
                            <hr>
                        </div>
                        <!-- Shipping Address -->

                        <br><br>
                        <!-- Updated HTML -->
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
                                    <select id="ship-address" name="ship_address" class="form-control">
                                        <option value="">Select Shipping Address</option>
                                        @foreach ($shippingAddresses as $address)
                                            @if ($address['address'])
                                                <option value="{{ $address['address'] }}" 
                                                    data-receiver-name="{{ $address['receiver_name'] }}"
                                                    data-country="{{ $address['country'] }}" 
                                                    data-postal-code="{{ $address['postal_code'] }}">
                                                    {{ $address['receiver_name'] }} - {{ $address['address'] }}, {{ $address['country'] }}, {{ $address['postal_code'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="select-dropdown-icon glyphicon glyphicon-chevron-down">&nbsp;</span>
                                </div>
                        
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" maxlength="100" name="firstname" id="firstname" class="form-control"
                                        placeholder="First Name" data-validation="required">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="lastname" id="lastname" class="form-control"
                                        placeholder="Last Name" data-validation="required">
                                </div>
                                <div class="col-xs-12" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="companyname" id="company" class="form-control"
                                        placeholder="Company Name" data-validation="required">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" maxlength="100" name="address1" id="address1" class="form-control"
                                        placeholder="Address 1" data-validation="required">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="address2" id="address2" class="form-control"
                                        placeholder="Address 2">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input type="text" maxlength="100" name="city" id="city" class="form-control" placeholder="City"
                                        data-validation="required">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="20" name="zip" id="zip" class="form-control" placeholder="Postcode"
                                        data-validation="required">
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <select class="form-control" id="country" name="country">
                                        <option value="" disabled selected>Select country</option>
                                        <option data-code="AF" value="AF-Afghanistan">Afghanistan</option>
                                        <option data-code="AX" value="AX-Aland Islands">Aland Islands</option>
                                        <option data-code="AL" value="AL-Albania">Albania</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="100" name="state" id="state" class="form-control" placeholder="State"
                                        data-validation="required">
                                </div>
                                <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                    <input type="text" maxlength="20" name="phone" id="phone" class="form-control" placeholder="Phone"
                                        data-validation="number">
                                </div>
                                <div class="col-xs-12 col-md-12" style="padding-bottom: 20px;">
                                    <textarea class="form-control" name="shipnotes" id="shipnotes" rows="4"
                                        placeholder="Notes"></textarea>
                                </div>
                                <div class="col-xs-12 col-md-12" style="padding-bottom: 5px;">
                                    Please ensure that the courier service (DHL/UPS) can reach you at your contact number to avoid delivery failure.
                                    <hr>
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
    <!-- Modal -->
    <div class="modal fade" id="thankYouModal" tabindex="-1" role="dialog" aria-labelledby="thankYouModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thankYouModalLabel">Thank You for Your Order!</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <p>Your order has been successfully placed</p>
                    <p>Thank you for shopping with us!</p>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
