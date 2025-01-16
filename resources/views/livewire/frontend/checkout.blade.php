<div>
    <div>
        <div id="header-title">
            <div class="container">
                <div class="header-box"></div>
                <div class="header-text" style="background-color:silver;">CHECKOUT</div>
            </div>
        </div>
    </div>
    <form method="post" id="checkout-form" action="confirmation.php">
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
                    <div class="myBox-right">
                        <div class="section-title">ORDER SUMMARY</div>
                        <table width="100%" id="itemslist" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                @if (!empty($cartItems))
                                    @foreach ($cartItems as $code => $item)
                                        <tr style="color:#0a1f3a;text-transform:uppercase;">
                                            <td colspan="2">{{ $item['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:20px;">
                                                (<input type="text" value="{{ $item['quantity'] }}" disabled
                                                    class="noborder" id="quantity2_{{ $code }}"
                                                    style="width:10%; text-align:center;color:#333;">ITEMS)
                                            </td>
                                            <td class="price">
                                                <input class="noborder" disabled type="text"
                                                    id="netprice2_{{ $code }}"
                                                    value="{{ number_format($item['netPrice'], 2) }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <table style="border-collapse: collapse; width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #000;">
                                        Sub Total :
                                    </td>
                                    <td align="right"
                                        style="padding: 8px; text-align: right; border-bottom: 1px solid #000; font-size:13px;">
                                        <input class="noborder" type="text" style="text-align:right;"
                                            id="subtotal_text" name="subtotal_text"
                                            value="US$ {{ number_format($subtotal, 2) }}">
                                        <input class="noborder" type="hidden" style="text-align:right;"
                                            id="subtotal" name="subtotal" value="{{ $subtotal }}">
                                        <input class="noborder" type="hidden" style="text-align:right;"
                                            id="promocode" name="promocode" value="{{ $promocode ?? '' }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #000;">
                                        Shipping :
                                    </td>
                                    <td align="right"
                                        style="padding: 8px; text-align: right; border-bottom: 1px solid #000; font-size:13px;">
                                        FREE
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #000;">
                                        Order Total :
                                    </td>
                                    <td align="right"
                                        style="padding: 8px; text-align: right; border-bottom: 1px solid #000; font-size:13px;">
                                        <input class="noborder" style="text-align:right; font-weight:bold;"
                                            type="text" id="nettotal_text" name="nettotal_text"
                                            value="US$ {{ number_format($subtotal, 2) }}">
                                        <input class="noborder" style="text-align:right; font-weight:bold;"
                                            type="hidden" id="nettotal" name="nettotal"
                                            value="{{ $subtotal }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size:12px;">
                                        <br>
                                        <u>Refund policy:</u><br>
                                        All sales are final and non-refundable. Please see our
                                        <a target="_blank" href="terms_conditions.html">terms and conditions.</a>
                                        <br><br>
                                        <div style="text-align:center;">
                                            <span id="siteseal">
                                                <script async="" type="text/javascript"
                                                    src="https://seal.godaddy.com/getSeal?sealID=iiH7qkmyXm0XUMJhpAwJFvbC62rEaacx0BcYhK6lXmWA9XJUBqL9d5htvUWk"></script>
                                                <img style="cursor:pointer;cursor:hand"
                                                    src="https://seal.godaddy.com/images/3/en/siteseal_gd_3_h_d_m.gif"
                                                    onclick="verifySeal();" alt="SSL site seal - click to verify">
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div id="paypalinfo" style="margin-top:10px;">
                        <div class="col-xl-12 col-l-12 col-m-12" align="right">
                            <a class="myButton" name="submit" id="submitbutton"
                                onclick="javascript:if (ValidateFormInputs() &amp;&amp; $('#g-recaptcha-response').val()!='') {
                                    document.forms[0].submit();}else{if($('#g-recaptcha-response').val()==''){alert('Please confirm you are not a robot')}}">PLACE
                                ORDER &gt;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
