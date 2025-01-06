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
        <div class="container" style="font-family: 'OpenSans';">
            <div class="clearfix">
                <div id="box-auth" class="clearfix">
                    <div class="pull-left w100m">
                        <a class="button-register" id="submitbutton"
                            style="margin-top:0px;margin-right:10px;margin-left:0px;"
                            href="http://store.celergenswiss.com/register.php?referrer=checkout">Register for New
                            Customer</a>
                    </div>
                    <a id="atext" class="pull-left w100m">or</a>
                    <div class="pull-left w100m">
                        <a class="button-login" style="margin-top:0px;" id="submitbutton"
                            href="http://store.celergenswiss.com/login.php?referrer=checkout">Login</a> &nbsp;&nbsp;
                    </div>
                    <div class="pull-left w100m">
                        <a id="atext">
                            for your convenience
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8">
                    <!-- Billing Address -->
                    <div class="row  form-item-ck">
                        <div class="col-xs-12 " style="margin-top: 20px;margin-bottom: 20px;">
                            <div class="icons-number pull-left">1</div>
                            <div style=" padding-left:10px;float: left;">Billing Address</div>
                        </div>
                        <br><br>


                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="bill_firstname" id="bill_firstname"
                                class="form-control" placeholder="First Name" data-validation="required" value="">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="bill_lastname" id="bill_lastname"
                                class="form-control" placeholder="Last Name " data-validation="required" value="">
                        </div>
                        <div class="col-xs-12" style="padding-bottom: 20px;">
                            <input type="text" maxlength="100" name="bill_company" id="bill_company"
                                class="form-control" placeholder="Company Name" data-validation="required"
                                value="">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="100" name="bill_address1" id="bill_address1"
                                class="form-control" placeholder="Address 1" data-validation="required" value="">
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
                                placeholder="Postcode" data-validation="number" value="">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <select class="form-control" id="bill_country" name="bill_country">
                                <option value="" disabled="" selected="">Select country</option>
                                <option data-code="AF" value="AF-Afghanistan"> Afghanistan</option>
                                <option data-code="AX" value="AX-Aland Islands"> Aland Islands</option>
                                <option data-code="AL" value="AL-Albania"> Albania</option>
                                <option data-code="DZ" value="DZ-Algeria"> Algeria</option>
                                <option data-code="AS" value="AS-American Samoa"> American Samoa</option>
                                <option data-code="AD" value="AD-Andorra"> Andorra</option>
                                <option data-code="AO" value="AO-Angola"> Angola</option>
                                <option data-code="AI" value="AI-Anguilla"> Anguilla</option>
                                <option data-code="AQ" value="AQ-Antarctica"> Antarctica</option>
                                <option data-code="AG" value="AG-Antigua and Barbuda"> Antigua and Barbuda</option>
                                <option data-code="AR" value="AR-Argentina"> Argentina</option>
                                <option data-code="AM" value="AM-Armenia"> Armenia</option>
                                <option data-code="AW" value="AW-Aruba"> Aruba</option>
                                <option data-code="AU" value="AU-Australia"> Australia</option>
                                <option data-code="AT" value="AT-Austria"> Austria</option>
                                <option data-code="AZ" value="AZ-Azerbaijan"> Azerbaijan</option>
                                <option data-code="BS" value="BS-Bahamas"> Bahamas</option>
                                <option data-code="BH" value="BH-Bahrain"> Bahrain</option>
                                <option data-code="BD" value="BD-Bangladesh"> Bangladesh</option>
                                <option data-code="BB" value="BB-Barbados"> Barbados</option>
                                <option data-code="BY" value="BY-Belarus"> Belarus</option>
                                <option data-code="BE" value="BE-Belgium"> Belgium</option>
                                <option data-code="BZ" value="BZ-Belize"> Belize</option>
                                <option data-code="BJ" value="BJ-Benin"> Benin</option>
                                <option data-code="BM" value="BM-Bermuda"> Bermuda</option>
                                <option data-code="BT" value="BT-Bhutan"> Bhutan</option>
                                <option data-code="BO" value="BO-Bolivia"> Bolivia</option>
                                <option data-code="BA" value="BA-Bosnia and Herzegovina"> Bosnia and Herzegovina
                                </option>
                                <option data-code="BW" value="BW-Botswana"> Botswana</option>
                                <option data-code="BV" value="BV-Bouvet Island"> Bouvet Island</option>
                                <option data-code="IO" value="IO-British Indian Ocean Territory"> British Indian Ocean
                                    Territory</option>
                                <option data-code="BN" value="BN-Brunei Darussalam"> Brunei Darussalam</option>
                                <option data-code="BG" value="BG-Bulgaria"> Bulgaria</option>
                                <option data-code="BF" value="BF-Burkina Faso"> Burkina Faso</option>
                                <option data-code="BI" value="BI-Burundi"> Burundi</option>
                                <option data-code="KH" value="KH-Cambodia"> Cambodia</option>
                                <option data-code="CM" value="CM-Cameroon"> Cameroon</option>
                                <option data-code="CA" value="CA-Canada"> Canada</option>
                                <option data-code="CV" value="CV-Cape Verde"> Cape Verde</option>
                                <option data-code="KY" value="KY-Cayman Islands"> Cayman Islands</option>
                                <option data-code="CF" value="CF-Central African Republic"> Central African Republic
                                </option>
                                <option data-code="TD" value="TD-Chad"> Chad</option>
                                <option data-code="CL" value="CL-Chile"> Chile</option>
                                <option data-code="CX" value="CX-Christmas Island"> Christmas Island</option>
                                <option data-code="CC" value="CC-Cocos (Keeling) Islands"> Cocos (Keeling) Islands
                                </option>
                                <option data-code="CO" value="CO-Colombia"> Colombia</option>
                                <option data-code="KM" value="KM-Comoros"> Comoros</option>
                                <option data-code="CG" value="CG-Congo"> Congo</option>
                                <option data-code="CD" value="CD-Congo, The Democratic Republic of The"> Congo, The
                                    Democratic Republic of The</option>
                                <option data-code="CK" value="CK-Cook Islands"> Cook Islands</option>
                                <option data-code="CR" value="CR-Costa Rica"> Costa Rica</option>
                                <option data-code="CI" value="CI-Cote D" ivoire'=""> Cote D'ivoire</option>
                                <option data-code="HR" value="HR-Croatia"> Croatia</option>
                                <option data-code="CU" value="CU-Cuba"> Cuba</option>
                                <option data-code="CY" value="CY-Cyprus"> Cyprus</option>
                                <option data-code="CZ" value="CZ-Czech Republic"> Czech Republic</option>
                                <option data-code="DK" value="DK-Denmark"> Denmark</option>
                                <option data-code="DJ" value="DJ-Djibouti"> Djibouti</option>
                                <option data-code="DM" value="DM-Dominica"> Dominica</option>
                                <option data-code="DO" value="DO-Dominican Republic"> Dominican Republic</option>
                                <option data-code="EC" value="EC-Ecuador"> Ecuador</option>
                                <option data-code="EG" value="EG-Egypt"> Egypt</option>
                                <option data-code="SV" value="SV-El Salvador"> El Salvador</option>
                                <option data-code="GQ" value="GQ-Equatorial Guinea"> Equatorial Guinea</option>
                                <option data-code="ER" value="ER-Eritrea"> Eritrea</option>
                                <option data-code="EE" value="EE-Estonia"> Estonia</option>
                                <option data-code="ET" value="ET-Ethiopia"> Ethiopia</option>
                                <option data-code="FK" value="FK-Falkland Islands (Malvinas)"> Falkland Islands
                                    (Malvinas)</option>
                                <option data-code="FO" value="FO-Faroe Islands"> Faroe Islands</option>
                                <option data-code="FJ" value="FJ-Fiji"> Fiji</option>
                                <option data-code="FI" value="FI-Finland"> Finland</option>
                                <option data-code="FR" value="FR-France"> France</option>
                                <option data-code="GF" value="GF-French Guiana"> French Guiana</option>
                                <option data-code="PF" value="PF-French Polynesia"> French Polynesia</option>
                                <option data-code="TF" value="TF-French Southern Territories"> French Southern
                                    Territories</option>
                                <option data-code="GA" value="GA-Gabon"> Gabon</option>
                                <option data-code="GM" value="GM-Gambia"> Gambia</option>
                                <option data-code="GE" value="GE-Georgia"> Georgia</option>
                                <option data-code="DE" value="DE-Germany"> Germany</option>
                                <option data-code="GH" value="GH-Ghana"> Ghana</option>
                                <option data-code="GI" value="GI-Gibraltar"> Gibraltar</option>
                                <option data-code="GR" value="GR-Greece"> Greece</option>
                                <option data-code="GL" value="GL-Greenland"> Greenland</option>
                                <option data-code="GD" value="GD-Grenada"> Grenada</option>
                                <option data-code="GP" value="GP-Guadeloupe"> Guadeloupe</option>
                                <option data-code="GU" value="GU-Guam"> Guam</option>
                                <option data-code="GT" value="GT-Guatemala"> Guatemala</option>
                                <option data-code="GG" value="GG-Guernsey"> Guernsey</option>
                                <option data-code="GN" value="GN-Guinea"> Guinea</option>
                                <option data-code="GW" value="GW-Guinea-bissau"> Guinea-bissau</option>
                                <option data-code="GY" value="GY-Guyana"> Guyana</option>
                                <option data-code="HT" value="HT-Haiti"> Haiti</option>
                                <option data-code="HM" value="HM-Heard Island and Mcdonald Islands"> Heard Island and
                                    Mcdonald Islands</option>
                                <option data-code="VA" value="VA-Holy See (Vatican City State)"> Holy See (Vatican
                                    City State)</option>
                                <option data-code="HN" value="HN-Honduras"> Honduras</option>
                                <option data-code="HK" value="HK-Hong Kong"> Hong Kong</option>
                                <option data-code="HU" value="HU-Hungary"> Hungary</option>
                                <option data-code="IS" value="IS-Iceland"> Iceland</option>
                                <option data-code="IN" value="IN-India"> India</option>
                                <option data-code="IR" value="IR-Iran, Islamic Republic of"> Iran, Islamic Republic of
                                </option>
                                <option data-code="IQ" value="IQ-Iraq"> Iraq</option>
                                <option data-code="IE" value="IE-Ireland"> Ireland</option>
                                <option data-code="IM" value="IM-Isle of Man"> Isle of Man</option>
                                <option data-code="IL" value="IL-Israel"> Israel</option>
                                <option data-code="IT" value="IT-Italy"> Italy</option>
                                <option data-code="JM" value="JM-Jamaica"> Jamaica</option>
                                <option data-code="JE" value="JE-Jersey"> Jersey</option>
                                <option data-code="JO" value="JO-Jordan"> Jordan</option>
                                <option data-code="KZ" value="KZ-Kazakhstan"> Kazakhstan</option>
                                <option data-code="KE" value="KE-Kenya"> Kenya</option>
                                <option data-code="KI" value="KI-Kiribati"> Kiribati</option>
                                <option data-code="KR" value="KR-Korea, Republic of"> Korea, Republic of</option>
                                <option data-code="KW" value="KW-Kuwait"> Kuwait</option>
                                <option data-code="KG" value="KG-Kyrgyzstan"> Kyrgyzstan</option>
                                <option data-code="LA" value="LA-Lao People" s="" democratic="" republic'=""> Lao
                                    People's Democratic Republic</option>
                                <option data-code="LV" value="LV-Latvia"> Latvia</option>
                                <option data-code="LS" value="LS-Lesotho"> Lesotho</option>
                                <option data-code="LR" value="LR-Liberia"> Liberia</option>
                                <option data-code="LY" value="LY-Libyan Arab Jamahiriya"> Libyan Arab Jamahiriya
                                </option>
                                <option data-code="LI" value="LI-Liechtenstein"> Liechtenstein</option>
                                <option data-code="LT" value="LT-Lithuania"> Lithuania</option>
                                <option data-code="LU" value="LU-Luxembourg"> Luxembourg</option>
                                <option data-code="MO" value="MO-Macao"> Macao</option>
                                <option data-code="MK" value="MK-Macedonia, The Former Yugoslav Republic of">
                                    Macedonia, The Former Yugoslav Republic of</option>
                                <option data-code="MG" value="MG-Madagascar"> Madagascar</option>
                                <option data-code="MW" value="MW-Malawi"> Malawi</option>
                                <option data-code="MV" value="MV-Maldives"> Maldives</option>
                                <option data-code="ML" value="ML-Mali"> Mali</option>
                                <option data-code="MT" value="MT-Malta"> Malta</option>
                                <option data-code="MH" value="MH-Marshall Islands"> Marshall Islands</option>
                                <option data-code="MQ" value="MQ-Martinique"> Martinique</option>
                                <option data-code="MR" value="MR-Mauritania"> Mauritania</option>
                                <option data-code="MU" value="MU-Mauritius"> Mauritius</option>
                                <option data-code="YT" value="YT-Mayotte"> Mayotte</option>
                                <option data-code="MX" value="MX-Mexico"> Mexico</option>
                                <option data-code="FM" value="FM-Micronesia, Federated States of"> Micronesia,
                                    Federated States of</option>
                                <option data-code="MD" value="MD-Moldova, Republic of"> Moldova, Republic of</option>
                                <option data-code="MC" value="MC-Monaco"> Monaco</option>
                                <option data-code="MN" value="MN-Mongolia"> Mongolia</option>
                                <option data-code="ME" value="ME-Montenegro"> Montenegro</option>
                                <option data-code="MS" value="MS-Montserrat"> Montserrat</option>
                                <option data-code="MA" value="MA-Morocco"> Morocco</option>
                                <option data-code="MZ" value="MZ-Mozambique"> Mozambique</option>
                                <option data-code="MM" value="MM-Myanmar"> Myanmar</option>
                                <option data-code="NA" value="NA-Namibia"> Namibia</option>
                                <option data-code="NR" value="NR-Nauru"> Nauru</option>
                                <option data-code="NP" value="NP-Nepal"> Nepal</option>
                                <option data-code="NL" value="NL-Netherlands"> Netherlands</option>
                                <option data-code="AN" value="AN-Netherlands Antilles"> Netherlands Antilles</option>
                                <option data-code="NC" value="NC-New Caledonia"> New Caledonia</option>
                                <option data-code="NZ" value="NZ-New Zealand"> New Zealand</option>
                                <option data-code="NI" value="NI-Nicaragua"> Nicaragua</option>
                                <option data-code="NE" value="NE-Niger"> Niger</option>
                                <option data-code="NG" value="NG-Nigeria"> Nigeria</option>
                                <option data-code="NU" value="NU-Niue"> Niue</option>
                                <option data-code="NF" value="NF-Norfolk Island"> Norfolk Island</option>
                                <option data-code="MP" value="MP-Northern Mariana Islands"> Northern Mariana Islands
                                </option>
                                <option data-code="NO" value="NO-Norway"> Norway</option>
                                <option data-code="OM" value="OM-Oman"> Oman</option>
                                <option data-code="PK" value="PK-Pakistan"> Pakistan</option>
                                <option data-code="PW" value="PW-Palau"> Palau</option>
                                <option data-code="PS" value="PS-Palestinian Territory, Occupied"> Palestinian
                                    Territory, Occupied</option>
                                <option data-code="PA" value="PA-Panama"> Panama</option>
                                <option data-code="PG" value="PG-Papua New Guinea"> Papua New Guinea</option>
                                <option data-code="PY" value="PY-Paraguay"> Paraguay</option>
                                <option data-code="PE" value="PE-Peru"> Peru</option>
                                <option data-code="PN" value="PN-Pitcairn"> Pitcairn</option>
                                <option data-code="PL" value="PL-Poland"> Poland</option>
                                <option data-code="PT" value="PT-Portugal"> Portugal</option>
                                <option data-code="PR" value="PR-Puerto Rico"> Puerto Rico</option>
                                <option data-code="QA" value="QA-Qatar"> Qatar</option>
                                <option data-code="RE" value="RE-Reunion"> Reunion</option>
                                <option data-code="RO" value="RO-Romania"> Romania</option>
                                <option data-code="RU" value="RU-Russian Federation"> Russian Federation</option>
                                <option data-code="RW" value="RW-Rwanda"> Rwanda</option>
                                <option data-code="SH" value="SH-Saint Helena"> Saint Helena</option>
                                <option data-code="KN" value="KN-Saint Kitts and Nevis"> Saint Kitts and Nevis
                                </option>
                                <option data-code="LC" value="LC-Saint Lucia"> Saint Lucia</option>
                                <option data-code="PM" value="PM-Saint Pierre and Miquelon"> Saint Pierre and Miquelon
                                </option>
                                <option data-code="VC" value="VC-Saint Vincent and The Grenadines"> Saint Vincent and
                                    The Grenadines</option>
                                <option data-code="WS" value="WS-Samoa"> Samoa</option>
                                <option data-code="SM" value="SM-San Marino"> San Marino</option>
                                <option data-code="ST" value="ST-Sao Tome and Principe"> Sao Tome and Principe
                                </option>
                                <option data-code="SA" value="SA-Saudi Arabia"> Saudi Arabia</option>
                                <option data-code="SN" value="SN-Senegal"> Senegal</option>
                                <option data-code="RS" value="RS-Serbia"> Serbia</option>
                                <option data-code="SC" value="SC-Seychelles"> Seychelles</option>
                                <option data-code="SL" value="SL-Sierra Leone"> Sierra Leone</option>
                                <option data-code="SK" value="SK-Slovakia"> Slovakia</option>
                                <option data-code="SI" value="SI-Slovenia"> Slovenia</option>
                                <option data-code="SB" value="SB-Solomon Islands"> Solomon Islands</option>
                                <option data-code="SO" value="SO-Somalia"> Somalia</option>
                                <option data-code="ZA" value="ZA-South Africa"> South Africa</option>
                                <option data-code="GS" value="GS-South Georgia and The South Sandwich Islands"> South
                                    Georgia and The South Sandwich Islands</option>
                                <option data-code="ES" value="ES-Spain"> Spain</option>
                                <option data-code="LK" value="LK-Sri Lanka"> Sri Lanka</option>
                                <option data-code="SD" value="SD-Sudan"> Sudan</option>
                                <option data-code="SR" value="SR-Suriname"> Suriname</option>
                                <option data-code="SJ" value="SJ-Svalbard and Jan Mayen"> Svalbard and Jan Mayen
                                </option>
                                <option data-code="SZ" value="SZ-Swaziland"> Swaziland</option>
                                <option data-code="SE" value="SE-Sweden"> Sweden</option>
                                <option data-code="SY" value="SY-Syrian Arab Republic"> Syrian Arab Republic</option>
                                <option data-code="TW" value="TW-Taiwan, Province of China"> Taiwan, Province of China
                                </option>
                                <option data-code="TJ" value="TJ-Tajikistan"> Tajikistan</option>
                                <option data-code="TZ" value="TZ-Tanzania, United Republic of"> Tanzania, United
                                    Republic of</option>
                                <option data-code="TH" value="TH-Thailand"> Thailand</option>
                                <option data-code="TL" value="TL-Timor-leste"> Timor-leste</option>
                                <option data-code="TG" value="TG-Togo"> Togo</option>
                                <option data-code="TK" value="TK-Tokelau"> Tokelau</option>
                                <option data-code="TO" value="TO-Tonga"> Tonga</option>
                                <option data-code="TT" value="TT-Trinidad and Tobago"> Trinidad and Tobago</option>
                                <option data-code="TN" value="TN-Tunisia"> Tunisia</option>
                                <option data-code="TR" value="TR-Turkey"> Turkey</option>
                                <option data-code="TM" value="TM-Turkmenistan"> Turkmenistan</option>
                                <option data-code="TC" value="TC-Turks and Caicos Islands"> Turks and Caicos Islands
                                </option>
                                <option data-code="TV" value="TV-Tuvalu"> Tuvalu</option>
                                <option data-code="UG" value="UG-Uganda"> Uganda</option>
                                <option data-code="UA" value="UA-Ukraine"> Ukraine</option>
                                <option data-code="AE" value="AE-United Arab Emirates"> United Arab Emirates</option>
                                <option data-code="UY" value="UY-Uruguay"> Uruguay</option>
                                <option data-code="UZ" value="UZ-Uzbekistan"> Uzbekistan</option>
                                <option data-code="VU" value="VU-Vanuatu"> Vanuatu</option>
                                <option data-code="VE" value="VE-Venezuela"> Venezuela</option>
                                <option data-code="VN" value="VN-Viet Nam"> Viet Nam</option>
                                <option data-code="VG" value="VG-Virgin Islands, British"> Virgin Islands, British
                                </option>
                                <option data-code="VI" value="VI-Virgin Islands, U.S."> Virgin Islands, U.S.</option>
                                <option data-code="WF" value="WF-Wallis and Futuna"> Wallis and Futuna</option>
                                <option data-code="EH" value="EH-Western Sahara"> Western Sahara</option>
                                <option data-code="YE" value="YE-Yemen"> Yemen</option>
                                <option data-code="ZM" value="ZM-Zambia"> Zambia</option>
                                <option data-code="ZW" value="ZW-Zimbabwe"> Zimbabwe</option>
                            </select>
                            <span class="select-dropdown-icon glyphicon glyphicon-chevron-down">&nbsp;</span>
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input maxlength="100" type="text" name="bill_state" id="bill_state"
                                class="form-control" placeholder="States" data-validation="required" value="">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <input type="text" maxlength="20" name="bill_phone" id="bill_phone"
                                class="form-control" placeholder="Phone" data-validation="number" value="">
                        </div>
                        <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                            <input type="email" maxlength="100" name="bill_email" id="bill_email"
                                class="form-control" placeholder="Email" data-validation="required" value="">
                        </div>
                        <div class="col-xs-12 col-md-12" style="padding-bottom: 5px;">
                            Please ensure that the courier service (DHL/UPS) can reach you at your contact
                            number to avoid delivery failure.
                            <hr>
                        </div>
                        <!-- Shipping Address -->
                        <br><br>
                        <div class="col-xs-12" style="margin-bottom: 20px;">
                            <div class="icons-number pull-left">2</div>
                            <div style="padding-left:10px;float: left;">Shipping Address
                            </div>
                            <div class="pull-right remember-rev" style="margin-right: 0px;">
                                <input type="checkbox" name="add_same" id="add_same" checked="true" value="on"
                                    onclick="javascript:SwitchAddress(this);">
                                <label for="add_same" class="pull-right">Ship to same address ?</label>
                            </div>
                        </div>
                        <div id="ship_address" style="display:none;">
                            <br><br>
                            <div class="col-xs-12 col-md-6">
                                <input maxlength="100" type="text" name="firstname" id="firstname"
                                    class="form-control" placeholder="First Name" value="">
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                <input maxlength="100" type="text" name="lastname" id="lastname"
                                    class="form-control" placeholder="Last Name" value="">
                            </div>
                            <div class="col-xs-12" style="padding-bottom: 20px;">
                                <input maxlength="100" type="text" name="companyname" id="company"
                                    class="form-control" placeholder="Company Name" value="">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <input type="text" maxlength="100" name="address1" id="address1"
                                    class="form-control" placeholder="Address 1" value="">
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                <input type="text" maxlength="100" name="address2" id="address2"
                                    class="form-control" placeholder="Address 2" value="">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <input type="text" maxlength="100" name="city" id="city"
                                    class="form-control" placeholder="City" valuevalue="">
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                <input maxlength="20" type="text" name="zip" id="zip"
                                    class="form-control" placeholder="Postcode" value="">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <select class="form-control" id="country" name="country">
                                    <option value="" disabled="" selected="">Select country</option>
                                    <option data-code="AF" value="AF-Afghanistan"> Afghanistan</option>
                                    <option data-code="AX" value="AX-Aland Islands"> Aland Islands</option>
                                    <option data-code="AL" value="AL-Albania"> Albania</option>
                                    <option data-code="DZ" value="DZ-Algeria"> Algeria</option>
                                    <option data-code="AS" value="AS-American Samoa"> American Samoa</option>
                                    <option data-code="AD" value="AD-Andorra"> Andorra</option>
                                    <option data-code="AO" value="AO-Angola"> Angola</option>
                                    <option data-code="AI" value="AI-Anguilla"> Anguilla</option>
                                    <option data-code="AQ" value="AQ-Antarctica"> Antarctica</option>
                                    <option data-code="AG" value="AG-Antigua and Barbuda"> Antigua and Barbuda
                                    </option>
                                    <option data-code="AR" value="AR-Argentina"> Argentina</option>
                                    <option data-code="AM" value="AM-Armenia"> Armenia</option>
                                    <option data-code="AW" value="AW-Aruba"> Aruba</option>
                                    <option data-code="AU" value="AU-Australia"> Australia</option>
                                    <option data-code="AT" value="AT-Austria"> Austria</option>
                                    <option data-code="AZ" value="AZ-Azerbaijan"> Azerbaijan</option>
                                    <option data-code="BS" value="BS-Bahamas"> Bahamas</option>
                                    <option data-code="BH" value="BH-Bahrain"> Bahrain</option>
                                    <option data-code="BD" value="BD-Bangladesh"> Bangladesh</option>
                                    <option data-code="BB" value="BB-Barbados"> Barbados</option>
                                    <option data-code="BY" value="BY-Belarus"> Belarus</option>
                                    <option data-code="BE" value="BE-Belgium"> Belgium</option>
                                    <option data-code="BZ" value="BZ-Belize"> Belize</option>
                                    <option data-code="BJ" value="BJ-Benin"> Benin</option>
                                    <option data-code="BM" value="BM-Bermuda"> Bermuda</option>
                                    <option data-code="BT" value="BT-Bhutan"> Bhutan</option>
                                    <option data-code="BO" value="BO-Bolivia"> Bolivia</option>
                                    <option data-code="BA" value="BA-Bosnia and Herzegovina"> Bosnia and Herzegovina
                                    </option>
                                    <option data-code="BW" value="BW-Botswana"> Botswana</option>
                                    <option data-code="BV" value="BV-Bouvet Island"> Bouvet Island</option>
                                    <option data-code="IO" value="IO-British Indian Ocean Territory"> British Indian
                                        Ocean Territory</option>
                                    <option data-code="BN" value="BN-Brunei Darussalam"> Brunei Darussalam</option>
                                    <option data-code="BG" value="BG-Bulgaria"> Bulgaria</option>
                                    <option data-code="BF" value="BF-Burkina Faso"> Burkina Faso</option>
                                    <option data-code="BI" value="BI-Burundi"> Burundi</option>
                                    <option data-code="KH" value="KH-Cambodia"> Cambodia</option>
                                    <option data-code="CM" value="CM-Cameroon"> Cameroon</option>
                                    <option data-code="CA" value="CA-Canada"> Canada</option>
                                    <option data-code="CV" value="CV-Cape Verde"> Cape Verde</option>
                                    <option data-code="KY" value="KY-Cayman Islands"> Cayman Islands</option>
                                    <option data-code="CF" value="CF-Central African Republic"> Central African
                                        Republic</option>
                                    <option data-code="TD" value="TD-Chad"> Chad</option>
                                    <option data-code="CL" value="CL-Chile"> Chile</option>
                                    <option data-code="CX" value="CX-Christmas Island"> Christmas Island</option>
                                    <option data-code="CC" value="CC-Cocos (Keeling) Islands"> Cocos (Keeling) Islands
                                    </option>
                                    <option data-code="CO" value="CO-Colombia"> Colombia</option>
                                    <option data-code="KM" value="KM-Comoros"> Comoros</option>
                                    <option data-code="CG" value="CG-Congo"> Congo</option>
                                    <option data-code="CD" value="CD-Congo, The Democratic Republic of The"> Congo,
                                        The Democratic Republic of The</option>
                                    <option data-code="CK" value="CK-Cook Islands"> Cook Islands</option>
                                    <option data-code="CR" value="CR-Costa Rica"> Costa Rica</option>
                                    <option data-code="CI" value="CI-Cote D" ivoire'=""> Cote D'ivoire</option>
                                    <option data-code="HR" value="HR-Croatia"> Croatia</option>
                                    <option data-code="CU" value="CU-Cuba"> Cuba</option>
                                    <option data-code="CY" value="CY-Cyprus"> Cyprus</option>
                                    <option data-code="CZ" value="CZ-Czech Republic"> Czech Republic</option>
                                    <option data-code="DK" value="DK-Denmark"> Denmark</option>
                                    <option data-code="DJ" value="DJ-Djibouti"> Djibouti</option>
                                    <option data-code="DM" value="DM-Dominica"> Dominica</option>
                                    <option data-code="DO" value="DO-Dominican Republic"> Dominican Republic</option>
                                    <option data-code="EC" value="EC-Ecuador"> Ecuador</option>
                                    <option data-code="EG" value="EG-Egypt"> Egypt</option>
                                    <option data-code="SV" value="SV-El Salvador"> El Salvador</option>
                                    <option data-code="GQ" value="GQ-Equatorial Guinea"> Equatorial Guinea</option>
                                    <option data-code="ER" value="ER-Eritrea"> Eritrea</option>
                                    <option data-code="EE" value="EE-Estonia"> Estonia</option>
                                    <option data-code="ET" value="ET-Ethiopia"> Ethiopia</option>
                                    <option data-code="FK" value="FK-Falkland Islands (Malvinas)"> Falkland Islands
                                        (Malvinas)</option>
                                    <option data-code="FO" value="FO-Faroe Islands"> Faroe Islands</option>
                                    <option data-code="FJ" value="FJ-Fiji"> Fiji</option>
                                    <option data-code="FI" value="FI-Finland"> Finland</option>
                                    <option data-code="FR" value="FR-France"> France</option>
                                    <option data-code="GF" value="GF-French Guiana"> French Guiana</option>
                                    <option data-code="PF" value="PF-French Polynesia"> French Polynesia</option>
                                    <option data-code="TF" value="TF-French Southern Territories"> French Southern
                                        Territories</option>
                                    <option data-code="GA" value="GA-Gabon"> Gabon</option>
                                    <option data-code="GM" value="GM-Gambia"> Gambia</option>
                                    <option data-code="GE" value="GE-Georgia"> Georgia</option>
                                    <option data-code="DE" value="DE-Germany"> Germany</option>
                                    <option data-code="GH" value="GH-Ghana"> Ghana</option>
                                    <option data-code="GI" value="GI-Gibraltar"> Gibraltar</option>
                                    <option data-code="GR" value="GR-Greece"> Greece</option>
                                    <option data-code="GL" value="GL-Greenland"> Greenland</option>
                                    <option data-code="GD" value="GD-Grenada"> Grenada</option>
                                    <option data-code="GP" value="GP-Guadeloupe"> Guadeloupe</option>
                                    <option data-code="GU" value="GU-Guam"> Guam</option>
                                    <option data-code="GT" value="GT-Guatemala"> Guatemala</option>
                                    <option data-code="GG" value="GG-Guernsey"> Guernsey</option>
                                    <option data-code="GN" value="GN-Guinea"> Guinea</option>
                                    <option data-code="GW" value="GW-Guinea-bissau"> Guinea-bissau</option>
                                    <option data-code="GY" value="GY-Guyana"> Guyana</option>
                                    <option data-code="HT" value="HT-Haiti"> Haiti</option>
                                    <option data-code="HM" value="HM-Heard Island and Mcdonald Islands"> Heard Island
                                        and Mcdonald Islands</option>
                                    <option data-code="VA" value="VA-Holy See (Vatican City State)"> Holy See (Vatican
                                        City State)</option>
                                    <option data-code="HN" value="HN-Honduras"> Honduras</option>
                                    <option data-code="HK" value="HK-Hong Kong"> Hong Kong</option>
                                    <option data-code="HU" value="HU-Hungary"> Hungary</option>
                                    <option data-code="IS" value="IS-Iceland"> Iceland</option>
                                    <option data-code="IN" value="IN-India"> India</option>
                                    <option data-code="IR" value="IR-Iran, Islamic Republic of"> Iran, Islamic
                                        Republic of</option>
                                    <option data-code="IQ" value="IQ-Iraq"> Iraq</option>
                                    <option data-code="IE" value="IE-Ireland"> Ireland</option>
                                    <option data-code="IM" value="IM-Isle of Man"> Isle of Man</option>
                                    <option data-code="IL" value="IL-Israel"> Israel</option>
                                    <option data-code="IT" value="IT-Italy"> Italy</option>
                                    <option data-code="JM" value="JM-Jamaica"> Jamaica</option>
                                    <option data-code="JE" value="JE-Jersey"> Jersey</option>
                                    <option data-code="JO" value="JO-Jordan"> Jordan</option>
                                    <option data-code="KZ" value="KZ-Kazakhstan"> Kazakhstan</option>
                                    <option data-code="KE" value="KE-Kenya"> Kenya</option>
                                    <option data-code="KI" value="KI-Kiribati"> Kiribati</option>
                                    <option data-code="KR" value="KR-Korea, Republic of"> Korea, Republic of</option>
                                    <option data-code="KW" value="KW-Kuwait"> Kuwait</option>
                                    <option data-code="KG" value="KG-Kyrgyzstan"> Kyrgyzstan</option>
                                    <option data-code="LA" value="LA-Lao People" s="" democratic="" republic'="">
                                        Lao People's Democratic Republic</option>
                                    <option data-code="LV" value="LV-Latvia"> Latvia</option>
                                    <option data-code="LS" value="LS-Lesotho"> Lesotho</option>
                                    <option data-code="LR" value="LR-Liberia"> Liberia</option>
                                    <option data-code="LY" value="LY-Libyan Arab Jamahiriya"> Libyan Arab Jamahiriya
                                    </option>
                                    <option data-code="LI" value="LI-Liechtenstein"> Liechtenstein</option>
                                    <option data-code="LT" value="LT-Lithuania"> Lithuania</option>
                                    <option data-code="LU" value="LU-Luxembourg"> Luxembourg</option>
                                    <option data-code="MO" value="MO-Macao"> Macao</option>
                                    <option data-code="MK" value="MK-Macedonia, The Former Yugoslav Republic of">
                                        Macedonia, The Former Yugoslav Republic of</option>
                                    <option data-code="MG" value="MG-Madagascar"> Madagascar</option>
                                    <option data-code="MW" value="MW-Malawi"> Malawi</option>
                                    <option data-code="MV" value="MV-Maldives"> Maldives</option>
                                    <option data-code="ML" value="ML-Mali"> Mali</option>
                                    <option data-code="MT" value="MT-Malta"> Malta</option>
                                    <option data-code="MH" value="MH-Marshall Islands"> Marshall Islands</option>
                                    <option data-code="MQ" value="MQ-Martinique"> Martinique</option>
                                    <option data-code="MR" value="MR-Mauritania"> Mauritania</option>
                                    <option data-code="MU" value="MU-Mauritius"> Mauritius</option>
                                    <option data-code="YT" value="YT-Mayotte"> Mayotte</option>
                                    <option data-code="MX" value="MX-Mexico"> Mexico</option>
                                    <option data-code="FM" value="FM-Micronesia, Federated States of"> Micronesia,
                                        Federated States of</option>
                                    <option data-code="MD" value="MD-Moldova, Republic of"> Moldova, Republic of
                                    </option>
                                    <option data-code="MC" value="MC-Monaco"> Monaco</option>
                                    <option data-code="MN" value="MN-Mongolia"> Mongolia</option>
                                    <option data-code="ME" value="ME-Montenegro"> Montenegro</option>
                                    <option data-code="MS" value="MS-Montserrat"> Montserrat</option>
                                    <option data-code="MA" value="MA-Morocco"> Morocco</option>
                                    <option data-code="MZ" value="MZ-Mozambique"> Mozambique</option>
                                    <option data-code="MM" value="MM-Myanmar"> Myanmar</option>
                                    <option data-code="NA" value="NA-Namibia"> Namibia</option>
                                    <option data-code="NR" value="NR-Nauru"> Nauru</option>
                                    <option data-code="NP" value="NP-Nepal"> Nepal</option>
                                    <option data-code="NL" value="NL-Netherlands"> Netherlands</option>
                                    <option data-code="AN" value="AN-Netherlands Antilles"> Netherlands Antilles
                                    </option>
                                    <option data-code="NC" value="NC-New Caledonia"> New Caledonia</option>
                                    <option data-code="NZ" value="NZ-New Zealand"> New Zealand</option>
                                    <option data-code="NI" value="NI-Nicaragua"> Nicaragua</option>
                                    <option data-code="NE" value="NE-Niger"> Niger</option>
                                    <option data-code="NG" value="NG-Nigeria"> Nigeria</option>
                                    <option data-code="NU" value="NU-Niue"> Niue</option>
                                    <option data-code="NF" value="NF-Norfolk Island"> Norfolk Island</option>
                                    <option data-code="MP" value="MP-Northern Mariana Islands"> Northern Mariana
                                        Islands</option>
                                    <option data-code="NO" value="NO-Norway"> Norway</option>
                                    <option data-code="OM" value="OM-Oman"> Oman</option>
                                    <option data-code="PK" value="PK-Pakistan"> Pakistan</option>
                                    <option data-code="PW" value="PW-Palau"> Palau</option>
                                    <option data-code="PS" value="PS-Palestinian Territory, Occupied"> Palestinian
                                        Territory, Occupied</option>
                                    <option data-code="PA" value="PA-Panama"> Panama</option>
                                    <option data-code="PG" value="PG-Papua New Guinea"> Papua New Guinea</option>
                                    <option data-code="PY" value="PY-Paraguay"> Paraguay</option>
                                    <option data-code="PE" value="PE-Peru"> Peru</option>
                                    <option data-code="PN" value="PN-Pitcairn"> Pitcairn</option>
                                    <option data-code="PL" value="PL-Poland"> Poland</option>
                                    <option data-code="PT" value="PT-Portugal"> Portugal</option>
                                    <option data-code="PR" value="PR-Puerto Rico"> Puerto Rico</option>
                                    <option data-code="QA" value="QA-Qatar"> Qatar</option>
                                    <option data-code="RE" value="RE-Reunion"> Reunion</option>
                                    <option data-code="RO" value="RO-Romania"> Romania</option>
                                    <option data-code="RU" value="RU-Russian Federation"> Russian Federation
                                    </option>
                                    <option data-code="RW" value="RW-Rwanda"> Rwanda</option>
                                    <option data-code="SH" value="SH-Saint Helena"> Saint Helena</option>
                                    <option data-code="KN" value="KN-Saint Kitts and Nevis"> Saint Kitts and Nevis
                                    </option>
                                    <option data-code="LC" value="LC-Saint Lucia"> Saint Lucia</option>
                                    <option data-code="PM" value="PM-Saint Pierre and Miquelon"> Saint Pierre and
                                        Miquelon</option>
                                    <option data-code="VC" value="VC-Saint Vincent and The Grenadines"> Saint
                                        Vincent and The Grenadines</option>
                                    <option data-code="WS" value="WS-Samoa"> Samoa</option>
                                    <option data-code="SM" value="SM-San Marino"> San Marino</option>
                                    <option data-code="ST" value="ST-Sao Tome and Principe"> Sao Tome and Principe
                                    </option>
                                    <option data-code="SA" value="SA-Saudi Arabia"> Saudi Arabia</option>
                                    <option data-code="SN" value="SN-Senegal"> Senegal</option>
                                    <option data-code="RS" value="RS-Serbia"> Serbia</option>
                                    <option data-code="SC" value="SC-Seychelles"> Seychelles</option>
                                    <option data-code="SL" value="SL-Sierra Leone"> Sierra Leone</option>
                                    <option data-code="SK" value="SK-Slovakia"> Slovakia</option>
                                    <option data-code="SI" value="SI-Slovenia"> Slovenia</option>
                                    <option data-code="SB" value="SB-Solomon Islands"> Solomon Islands</option>
                                    <option data-code="SO" value="SO-Somalia"> Somalia</option>
                                    <option data-code="ZA" value="ZA-South Africa"> South Africa</option>
                                    <option data-code="GS" value="GS-South Georgia and The South Sandwich Islands">
                                        South Georgia and The South Sandwich Islands</option>
                                    <option data-code="ES" value="ES-Spain"> Spain</option>
                                    <option data-code="LK" value="LK-Sri Lanka"> Sri Lanka</option>
                                    <option data-code="SD" value="SD-Sudan"> Sudan</option>
                                    <option data-code="SR" value="SR-Suriname"> Suriname</option>
                                    <option data-code="SJ" value="SJ-Svalbard and Jan Mayen"> Svalbard and Jan Mayen
                                    </option>
                                    <option data-code="SZ" value="SZ-Swaziland"> Swaziland</option>
                                    <option data-code="SE" value="SE-Sweden"> Sweden</option>
                                    <option data-code="SY" value="SY-Syrian Arab Republic"> Syrian Arab Republic
                                    </option>
                                    <option data-code="TW" value="TW-Taiwan, Province of China"> Taiwan, Province of
                                        China</option>
                                    <option data-code="TJ" value="TJ-Tajikistan"> Tajikistan</option>
                                    <option data-code="TZ" value="TZ-Tanzania, United Republic of"> Tanzania, United
                                        Republic of</option>
                                    <option data-code="TH" value="TH-Thailand"> Thailand</option>
                                    <option data-code="TL" value="TL-Timor-leste"> Timor-leste</option>
                                    <option data-code="TG" value="TG-Togo"> Togo</option>
                                    <option data-code="TK" value="TK-Tokelau"> Tokelau</option>
                                    <option data-code="TO" value="TO-Tonga"> Tonga</option>
                                    <option data-code="TT" value="TT-Trinidad and Tobago"> Trinidad and Tobago
                                    </option>
                                    <option data-code="TN" value="TN-Tunisia"> Tunisia</option>
                                    <option data-code="TR" value="TR-Turkey"> Turkey</option>
                                    <option data-code="TM" value="TM-Turkmenistan"> Turkmenistan</option>
                                    <option data-code="TC" value="TC-Turks and Caicos Islands"> Turks and Caicos
                                        Islands</option>
                                    <option data-code="TV" value="TV-Tuvalu"> Tuvalu</option>
                                    <option data-code="UG" value="UG-Uganda"> Uganda</option>
                                    <option data-code="UA" value="UA-Ukraine"> Ukraine</option>
                                    <option data-code="AE" value="AE-United Arab Emirates"> United Arab Emirates
                                    </option>
                                    <option data-code="UY" value="UY-Uruguay"> Uruguay</option>
                                    <option data-code="UZ" value="UZ-Uzbekistan"> Uzbekistan</option>
                                    <option data-code="VU" value="VU-Vanuatu"> Vanuatu</option>
                                    <option data-code="VE" value="VE-Venezuela"> Venezuela</option>
                                    <option data-code="VN" value="VN-Viet Nam"> Viet Nam</option>
                                    <option data-code="VG" value="VG-Virgin Islands, British"> Virgin Islands,
                                        British</option>
                                    <option data-code="VI" value="VI-Virgin Islands, U.S."> Virgin Islands, U.S.
                                    </option>
                                    <option data-code="WF" value="WF-Wallis and Futuna"> Wallis and Futuna</option>
                                    <option data-code="EH" value="EH-Western Sahara"> Western Sahara</option>
                                    <option data-code="YE" value="YE-Yemen"> Yemen</option>
                                    <option data-code="ZM" value="ZM-Zambia"> Zambia</option>
                                    <option data-code="ZW" value="ZW-Zimbabwe"> Zimbabwe</option>
                                </select>
                                <span class="select-dropdown-icon glyphicon glyphicon-chevron-down">&nbsp;</span>
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                <input type="text" maxlength="100" name="state" id="state"
                                    class="form-control" placeholder="State" value="">
                            </div>
                            <div class="col-xs-12 col-md-6" style="padding-bottom: 20px;">
                                <input type="text" maxlength="20" name="phone" id="phone"
                                    class="form-control" placeholder="Phone" value="">
                            </div>
                            <div class="col-xs-12" style="padding-bottom: 20px;">
                                <textarea class="form-control" type="text" name="shipnotes" id="shipnotes" rows="8"
                                    placeholder="Notes">                                                                            </textarea>
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
                <div class="col-sm-4" style="padding: 10px 30px 0px 30px;">
                    <div class="myBox-right">
                        <div class="section-title">ORDER SUMMARY</div>
                        <table width="100%" id="itemslist" border="0" cellspacing="0" cellpadding="0">
                            <input type="hidden" name="prod[]" value="CEL"><input type="hidden"
                                name="quantity_CEL" value="0"><input type="hidden" name="item_CEL"
                                value="0"><input type="hidden" name="prod[]" value="SER"><input
                                type="hidden" name="quantity_SER" value="1"><input type="hidden"
                                name="item_SER" value="1"><input type="hidden" name="prod[]"
                                value="PK1"><input type="hidden" name="quantity_PK1" value="1"><input
                                type="hidden" name="item_PK1" value="1">
                            <tbody>
                                <tr
                                    style="color:#0a1f3a;text-transform:uppercase;font-family: &quot;AdelleSansW01-Regular&quot;;">
                                    <td colspan="2">Celergen Serum</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:20px; ">
                                        (<input type="text" value="1" disabled="" class="noborder"
                                            id="quantity2_SER" name="quantity_SER"
                                            style="width:10%; text-align:center;color:#333;">ITEMS )
                                        <input type="hidden" name="prod[]" value="SER">
                                    </td>
                                    <td class="price">
                                        <input class="noborder" disabled="" type="text" id="netprice2_SER"
                                            name="netprice_SER" value="270.00">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
                                </tr>
                                <tr
                                    style="color:#0a1f3a;text-transform:uppercase;font-family: &quot;AdelleSansW01-Regular&quot;;">
                                    <td colspan="2">CELERGEN &amp; SERUM ROYALE</td>
                                </tr>
                                <tr>
                                    <td style="padding-left:20px; ">
                                        (<input type="text" value="1" disabled="" class="noborder"
                                            id="quantity2_PK1" name="quantity_PK1"
                                            style="width:10%; text-align:center;color:#333;">ITEMS )
                                        <input type="hidden" name="prod[]" value="PK1">
                                    </td>
                                    <td class="price">
                                        <input class="noborder" disabled="" type="text" id="netprice2_PK1"
                                            name="netprice_PK1" value="620.00">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="sparator-order-summary">&nbsp;</span></td>
                                </tr>
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
                                            id="subtotal_text" name="subtotal_text" value="US$ 890.00">
                                        <input class="noborder" type="hidden" style="text-align:right;"
                                            id="subtotal" name="subtotal" value="0">
                                        <input class="noborder" type="hidden" style="text-align:right;"
                                            id="promocode" name="promocode" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #000;">
                                        Shipping :
                                    </td>
                                    <td align="right"
                                        style="padding: 8px; text-align: right; border-bottom: 1px solid #000; font-size:13px;">
                                        FREE</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #000;">
                                        Order Total :
                                    </td>
                                    <td align="right"
                                        style="padding: 8px; text-align: right; border-bottom: 1px solid #000; font-size:13px;">
                                        <input class="noborder" style="text-align:right; font-weight:bold;"
                                            type="text" id="nettotal_text" name="nettotal_text"
                                            value="US$ 890.00">
                                        <input class="noborder" style="text-align:right; font-weight:bold;"
                                            type="hidden" id="nettotal" name="nettotal" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size:12px;">
                                        <br>
                                        <u>Refund policy:</u><br> All sales are final and non-refundable. Please see our
                                        <a target="_blank" href="terms_conditions.html"> terms and conditions.</a>
                                        <br><br>
                                        <div style="text-align:center;">
                                            <span id="siteseal">
                                                <script async="" type="text/javascript"
                                                    src="https://seal.godaddy.com/getSeal?sealID=iiH7qkmyXm0XUMJhpAwJFvbC62rEaacx0BcYhK6lXmWA9XJUBqL9d5htvUWk"></script><img style="cursor:pointer;cursor:hand"
                                                    src="https://seal.godaddy.com/images/3/en/siteseal_gd_3_h_d_m.gif"
                                                    onclick="verifySeal();" alt="SSL site seal - click to verify">
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input class="noborder" style="visibility:hidden;" type="text" id="payment"
                            name="payment" value="creditcard">
                    </div>
                    <div style="margin-bottom: 20px;" class="g-recaptcha"
                        data-sitekey="6Ld7BQ4UAAAAAFoKqvRzZ89fkFHswZ2-oPyDiqpM">
                        <div style="width: 304px; height: 78px;">
                            <div><iframe title="reCAPTCHA" width="304" height="78" role="presentation"
                                    name="a-5fgeezhgndxk" frameborder="0" scrolling="no"
                                    sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation"
                                    src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Ld7BQ4UAAAAAFoKqvRzZ89fkFHswZ2-oPyDiqpM&amp;co=aHR0cHM6Ly9zdG9yZS5jZWxlcmdlbnN3aXNzLmNvbTo0NDM.&amp;hl=en&amp;v=zIriijn3uj5Vpknvt_LnfNbF&amp;size=normal&amp;cb=a2skmfonm7qn"></iframe>
                            </div>
                            <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response"
                                style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                        </div><iframe style="display: none;"></iframe>
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

<script type="text/javascript">

    var ControlArray = [
        ['bill_firstname', 'You can\'t Leave First Name empty.', '', 'info'],
        ['bill_address1', 'You can\'t Leave Billing Address1 empty.', '', ''],
        ['bill_zip', 'You can\'t Leave Postalcode Empty.', '', ''],
        ['bill_country', 'Please Select Country from List', '', ''],
        ['bill_city', 'Please Select City from List', '', ''],
        ['bill_phone', 'Please Enter Phone no.', '', ''],
        ['bill_email', 'Please Enter a valid email id.', '', ''],
        ['firstname', 'You can\'t Leave First Name empty.', '', 'info'],
        ['address1', 'You can\'t Leave Shipping Address1 empty.', '', ''],
        ['zip', 'You can\'t Leave Postalcode Empty.', '', ''],
        ['country', 'Please Select Country from List', '', ''],
        ['phone', 'Please Enter Phone no.', '', ''],
        ['email', 'Please Enter a valid email id.', '', ''],
        ['city', 'Please Select City from List', '', '']
    ];

    function SwitchAddress(ID)
    {
        var CurControl = $('#ship_address');
        CurControl.css("display" , (ID.checked ? "none" : "block"));
    }
    function ValidateFormInputs()
    {
        var addSame = document.getElementById('add_same').checked;
        var CurControl = null;
        for (var i = 0; i < ControlArray.length; i++)
        {

            CurControl = document.getElementById(ControlArray[i][0]);
            //alert(CurControl[i][0]);
            if (CurControl != null)
            {

                if (ControlArray[i][0].substring(0, 3) != "bil" && addSame)
                    continue;
                if (ControlArray[i][0] == 'bill_email')
                {
                    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(CurControl.value) == false)
                    {
                        alert("Please key in valid email address.");
                        CurControl.focus();
                        CurControl.style.backgroundColor = '#F3F781';
                        return false;
                    }
                }
                if (CurControl.value == "" && ControlArray[i][1] != '')
                {
                    alert(ControlArray[i][1]);
                    CurControl.focus();
                    CurControl.style.backgroundColor = '#F3F781';  //'#F8E0F7' -- Light Pink;
                    return false;
                } else
                {
                    CurControl.style.backgroundColor = '#FFFFFF';
                }
            }
        }
        return true;
    }


    function UpdateTotals(mode, itembox)
    {
        // var cart_count_mobile = document.getElementById("mobile-cart").getElementsByTagName("span")[0];
        // var cart_count_desktop = document.getElementById("desktop-cart").getElementsByTagName("span")[0];
        var uni_a = document.getElementById('unitprice_' + itembox).value.split(" ");
        var nett_a = document.getElementById('nettotal_text').value.split(" ");
        var nett_value = parseInt(nett_a[1].replace(',', ''));
        var uni = parseInt(uni_a[1].replace(',', ''));
        console.log(nett_value);
        var qty = document.getElementById('quantity_' + itembox);
        var net = document.getElementById('netprice_' + itembox);
        var net2 = document.getElementById('netprice2_' + itembox);
        var sub_text = document.getElementById('subtotal_text');
        var nett_text = document.getElementById('nettotal_text');
        var sub = document.getElementById('subtotal');
        var nett = document.getElementById('nettotal');

        if (qty != null && uni != null && net != null && sub != null)
        {
            net.value = "US$ " + (parseInt(qty.value) * parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            net2.value = "US$ " + (parseInt(qty.value) * parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            if (mode == "+") {
                sub_text.value = nett_text.value = "US$ " + (parseInt(nett_value) + parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                sub.value = nett.value = parseInt(nett_value) + parseInt(uni);

                // cart_count_desktop.innerHTML = parseInt(cart_count_desktop.innerHTML) + 1;
                // cart_count_mobile.innerHTML = parseInt(cart_count_mobile.innerHTML) + 1;
            }
            if (mode == "-") {
                sub_text.value = nett_text.value = "US$ " + (parseInt(nett_value) - parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                sub.value = nett.value = parseInt(nett_value) - parseInt(uni);
                // cart_count_desktop.innerHTML = parseInt(cart_count_desktop.innerHTML) - 1;
                // cart_count_mobile.innerHTML = parseInt(cart_count_mobile.innerHTML) - 1;
            }
        }
    }
    function OnQuantityChanged(mode, itembox)
    {
        var qty = document.getElementById('quantity_' + itembox);
        var qty2 = document.getElementById('quantity2_' + itembox);
        var Item = document.getElementById("item_" + itembox);
        var sub = document.getElementById("submitbutton");
        if (qty != null && Item != null)
        {
            var qe = qty.value.split(" ");
            console.log(itembox)
            var cur = qty.value;
            if (mode == "+")
            {
                Item.value = qty.value = qty2.value = parseInt(cur) + 1;
                UpdateTotals(mode, itembox);
                if (sub != null)
                    sub.disabled = false;

            } else
            {
                if (parseInt(cur) >= 1)
                {
                    Item.value = qty.value = qty2.value = parseInt(cur) - 1;
                    UpdateTotals(mode, itembox);
                }
                if (parseInt(cur) - 1 == 0)
                {
                    //Disable Proceed
                    if (sub != null)
                        sub.disabled = true;
                }
            }

        }
    }
</script>
<script>
    function showDivs(start)
    {
        var div;
        while ((div = document.getElementById('div' + start)) !== false)
        {
            div.style.display = (div.style.display == 'none') ? '' : 'none';
            start++;
        }
    }
</script>
