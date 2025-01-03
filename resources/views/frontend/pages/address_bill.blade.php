@extends('frontend.layouts.app')

@section('title', 'Billing | Celergen')
@section('header', 'Billing | Celergen')

@section('content')
<div class="wrapper-fixed">
    <div class="banner">
        <div class="table-cell">
            <div class="v-align">
                Join The Transformation <br>
                of Your Health Now !
            </div>
        </div>
    </div>
    <form method="post" id="registration" action="" class="has-validation-callback">
        <div class="form-bg">
            <div class="container frm">
                <div class="row">
                    <div class="header-form">
                        Billing Address
                    </div>
                    <div class="form-item">
                        <div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <div class="input">
                                        <input type="text" data-validation="length,required" name="firstname"
                                            data-validation-length="max100" id="firstname" placeholder="First name"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input">
                                        <input type="text" data-validation="length,required" name="lastname"
                                            id="lastname" data-validation-length="max100" placeholder="Last name"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input">
                                        <input type="text" data-validation="length,required" name="companyname"
                                            id="companyname" data-validation-length="max100" placeholder="Company Name"
                                            value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <div class="input">
                                        <input name="address1" data-validation="length,required" id="address1"
                                            data-validation-length="max100" placeholder="Address" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <div class="input">
                                        <input name="address2" id="address2" data-validation="length"
                                            placeholder="Address 2 (optional)" data-validation-length="max100"
                                            value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <div class="input">
                                        <input type="text" data-validation="length,required"
                                            data-validation-length="max100" name="state" id="state"
                                            placeholder="State" value="">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input">
                                        <input type="text" data-validation="length,required"
                                            data-validation-length="max100" name="city" id="city"
                                            placeholder="City" value="">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input">
                                        <input type="text" name="zip" data-validation="number,length,required"
                                            data-validation-length="max20" maxlength="20" id="zip"
                                            placeholder="Postcode" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="input">
                                        <select id="country" data-validation="required" name="country">
                                            <option value="" disabled="" selected="">Select country</option>
                                            <option data-code="AF" value="AF"> Afghanistan</option>
                                            <option data-code="AX" value="AX"> Aland Islands</option>
                                            <option data-code="AL" value="AL"> Albania</option>
                                            <option data-code="DZ" value="DZ"> Algeria</option>
                                            <option data-code="AS" value="AS"> American Samoa</option>
                                            <option data-code="AD" value="AD"> Andorra</option>
                                            <option data-code="AO" value="AO"> Angola</option>
                                            <option data-code="AI" value="AI"> Anguilla</option>
                                            <option data-code="AQ" value="AQ"> Antarctica</option>
                                            <option data-code="AG" value="AG"> Antigua and Barbuda</option>
                                            <option data-code="AR" value="AR"> Argentina</option>
                                            <option data-code="AM" value="AM"> Armenia</option>
                                            <option data-code="AW" value="AW"> Aruba</option>
                                            <option data-code="AU" value="AU"> Australia</option>
                                            <option data-code="AT" value="AT"> Austria</option>
                                            <option data-code="AZ" value="AZ"> Azerbaijan</option>
                                            <option data-code="BS" value="BS"> Bahamas</option>
                                            <option data-code="BH" value="BH"> Bahrain</option>
                                            <option data-code="BD" value="BD"> Bangladesh</option>
                                            <option data-code="BB" value="BB"> Barbados</option>
                                            <option data-code="BY" value="BY"> Belarus</option>
                                            <option data-code="BE" value="BE"> Belgium</option>
                                            <option data-code="BZ" value="BZ"> Belize</option>
                                            <option data-code="BJ" value="BJ"> Benin</option>
                                            <option data-code="BM" value="BM"> Bermuda</option>
                                            <option data-code="BT" value="BT"> Bhutan</option>
                                            <option data-code="BO" value="BO"> Bolivia</option>
                                            <option data-code="BA" value="BA"> Bosnia and Herzegovina</option>
                                            <option data-code="BW" value="BW"> Botswana</option>
                                            <option data-code="BV" value="BV"> Bouvet Island</option>
                                            <option data-code="IO" value="IO"> British Indian Ocean Territory
                                            </option>
                                            <option data-code="BN" value="BN"> Brunei Darussalam</option>
                                            <option data-code="BG" value="BG"> Bulgaria</option>
                                            <option data-code="BF" value="BF"> Burkina Faso</option>
                                            <option data-code="BI" value="BI"> Burundi</option>
                                            <option data-code="KH" value="KH"> Cambodia</option>
                                            <option data-code="CM" value="CM"> Cameroon</option>
                                            <option data-code="CA" value="CA"> Canada</option>
                                            <option data-code="CV" value="CV"> Cape Verde</option>
                                            <option data-code="KY" value="KY"> Cayman Islands</option>
                                            <option data-code="CF" value="CF"> Central African Republic</option>
                                            <option data-code="TD" value="TD"> Chad</option>
                                            <option data-code="CL" value="CL"> Chile</option>
                                            <option data-code="CX" value="CX"> Christmas Island</option>
                                            <option data-code="CC" value="CC"> Cocos (Keeling) Islands</option>
                                            <option data-code="CO" value="CO"> Colombia</option>
                                            <option data-code="KM" value="KM"> Comoros</option>
                                            <option data-code="CG" value="CG"> Congo</option>
                                            <option data-code="CD" value="CD"> Congo, The Democratic Republic of
                                                The</option>
                                            <option data-code="CK" value="CK"> Cook Islands</option>
                                            <option data-code="CR" value="CR"> Costa Rica</option>
                                            <option data-code="CI" value="CI"> Cote D'ivoire</option>
                                            <option data-code="HR" value="HR"> Croatia</option>
                                            <option data-code="CU" value="CU"> Cuba</option>
                                            <option data-code="CY" value="CY"> Cyprus</option>
                                            <option data-code="CZ" value="CZ"> Czech Republic</option>
                                            <option data-code="DK" value="DK"> Denmark</option>
                                            <option data-code="DJ" value="DJ"> Djibouti</option>
                                            <option data-code="DM" value="DM"> Dominica</option>
                                            <option data-code="DO" value="DO"> Dominican Republic</option>
                                            <option data-code="EC" value="EC"> Ecuador</option>
                                            <option data-code="EG" value="EG"> Egypt</option>
                                            <option data-code="SV" value="SV"> El Salvador</option>
                                            <option data-code="GQ" value="GQ"> Equatorial Guinea</option>
                                            <option data-code="ER" value="ER"> Eritrea</option>
                                            <option data-code="EE" value="EE"> Estonia</option>
                                            <option data-code="ET" value="ET"> Ethiopia</option>
                                            <option data-code="FK" value="FK"> Falkland Islands (Malvinas)
                                            </option>
                                            <option data-code="FO" value="FO"> Faroe Islands</option>
                                            <option data-code="FJ" value="FJ"> Fiji</option>
                                            <option data-code="FI" value="FI"> Finland</option>
                                            <option data-code="FR" value="FR"> France</option>
                                            <option data-code="GF" value="GF"> French Guiana</option>
                                            <option data-code="PF" value="PF"> French Polynesia</option>
                                            <option data-code="TF" value="TF"> French Southern Territories
                                            </option>
                                            <option data-code="GA" value="GA"> Gabon</option>
                                            <option data-code="GM" value="GM"> Gambia</option>
                                            <option data-code="GE" value="GE"> Georgia</option>
                                            <option data-code="DE" value="DE"> Germany</option>
                                            <option data-code="GH" value="GH"> Ghana</option>
                                            <option data-code="GI" value="GI"> Gibraltar</option>
                                            <option data-code="GR" value="GR"> Greece</option>
                                            <option data-code="GL" value="GL"> Greenland</option>
                                            <option data-code="GD" value="GD"> Grenada</option>
                                            <option data-code="GP" value="GP"> Guadeloupe</option>
                                            <option data-code="GU" value="GU"> Guam</option>
                                            <option data-code="GT" value="GT"> Guatemala</option>
                                            <option data-code="GG" value="GG"> Guernsey</option>
                                            <option data-code="GN" value="GN"> Guinea</option>
                                            <option data-code="GW" value="GW"> Guinea-bissau</option>
                                            <option data-code="GY" value="GY"> Guyana</option>
                                            <option data-code="HT" value="HT"> Haiti</option>
                                            <option data-code="HM" value="HM"> Heard Island and Mcdonald Islands
                                            </option>
                                            <option data-code="VA" value="VA"> Holy See (Vatican City State)
                                            </option>
                                            <option data-code="HN" value="HN"> Honduras</option>
                                            <option data-code="HK" value="HK"> Hong Kong</option>
                                            <option data-code="HU" value="HU"> Hungary</option>
                                            <option data-code="IS" value="IS"> Iceland</option>
                                            <option data-code="IN" value="IN"> India</option>
                                            <option data-code="IR" value="IR"> Iran, Islamic Republic of</option>
                                            <option data-code="IQ" value="IQ"> Iraq</option>
                                            <option data-code="IE" value="IE"> Ireland</option>
                                            <option data-code="IM" value="IM"> Isle of Man</option>
                                            <option data-code="IL" value="IL"> Israel</option>
                                            <option data-code="IT" value="IT"> Italy</option>
                                            <option data-code="JM" value="JM"> Jamaica</option>
                                            <option data-code="JE" value="JE"> Jersey</option>
                                            <option data-code="JO" value="JO"> Jordan</option>
                                            <option data-code="KZ" value="KZ"> Kazakhstan</option>
                                            <option data-code="KE" value="KE"> Kenya</option>
                                            <option data-code="KI" value="KI"> Kiribati</option>
                                            <option data-code="KR" value="KR"> Korea, Republic of</option>
                                            <option data-code="KW" value="KW"> Kuwait</option>
                                            <option data-code="KG" value="KG"> Kyrgyzstan</option>
                                            <option data-code="LA" value="LA"> Lao People's Democratic Republic
                                            </option>
                                            <option data-code="LV" value="LV"> Latvia</option>
                                            <option data-code="LS" value="LS"> Lesotho</option>
                                            <option data-code="LR" value="LR"> Liberia</option>
                                            <option data-code="LY" value="LY"> Libyan Arab Jamahiriya</option>
                                            <option data-code="LI" value="LI"> Liechtenstein</option>
                                            <option data-code="LT" value="LT"> Lithuania</option>
                                            <option data-code="LU" value="LU"> Luxembourg</option>
                                            <option data-code="MO" value="MO"> Macao</option>
                                            <option data-code="MK" value="MK"> Macedonia, The Former Yugoslav
                                                Republic of</option>
                                            <option data-code="MG" value="MG"> Madagascar</option>
                                            <option data-code="MW" value="MW"> Malawi</option>
                                            <option data-code="MV" value="MV"> Maldives</option>
                                            <option data-code="ML" value="ML"> Mali</option>
                                            <option data-code="MT" value="MT"> Malta</option>
                                            <option data-code="MH" value="MH"> Marshall Islands</option>
                                            <option data-code="MQ" value="MQ"> Martinique</option>
                                            <option data-code="MR" value="MR"> Mauritania</option>
                                            <option data-code="MU" value="MU"> Mauritius</option>
                                            <option data-code="YT" value="YT"> Mayotte</option>
                                            <option data-code="MX" value="MX"> Mexico</option>
                                            <option data-code="FM" value="FM"> Micronesia, Federated States of
                                            </option>
                                            <option data-code="MD" value="MD"> Moldova, Republic of</option>
                                            <option data-code="MC" value="MC"> Monaco</option>
                                            <option data-code="MN" value="MN"> Mongolia</option>
                                            <option data-code="ME" value="ME"> Montenegro</option>
                                            <option data-code="MS" value="MS"> Montserrat</option>
                                            <option data-code="MA" value="MA"> Morocco</option>
                                            <option data-code="MZ" value="MZ"> Mozambique</option>
                                            <option data-code="MM" value="MM"> Myanmar</option>
                                            <option data-code="NA" value="NA"> Namibia</option>
                                            <option data-code="NR" value="NR"> Nauru</option>
                                            <option data-code="NP" value="NP"> Nepal</option>
                                            <option data-code="NL" value="NL"> Netherlands</option>
                                            <option data-code="AN" value="AN"> Netherlands Antilles</option>
                                            <option data-code="NC" value="NC"> New Caledonia</option>
                                            <option data-code="NZ" value="NZ"> New Zealand</option>
                                            <option data-code="NI" value="NI"> Nicaragua</option>
                                            <option data-code="NE" value="NE"> Niger</option>
                                            <option data-code="NG" value="NG"> Nigeria</option>
                                            <option data-code="NU" value="NU"> Niue</option>
                                            <option data-code="NF" value="NF"> Norfolk Island</option>
                                            <option data-code="MP" value="MP"> Northern Mariana Islands</option>
                                            <option data-code="NO" value="NO"> Norway</option>
                                            <option data-code="OM" value="OM"> Oman</option>
                                            <option data-code="PK" value="PK"> Pakistan</option>
                                            <option data-code="PW" value="PW"> Palau</option>
                                            <option data-code="PS" value="PS"> Palestinian Territory, Occupied
                                            </option>
                                            <option data-code="PA" value="PA"> Panama</option>
                                            <option data-code="PG" value="PG"> Papua New Guinea</option>
                                            <option data-code="PY" value="PY"> Paraguay</option>
                                            <option data-code="PE" value="PE"> Peru</option>
                                            <option data-code="PN" value="PN"> Pitcairn</option>
                                            <option data-code="PL" value="PL"> Poland</option>
                                            <option data-code="PT" value="PT"> Portugal</option>
                                            <option data-code="PR" value="PR"> Puerto Rico</option>
                                            <option data-code="QA" value="QA"> Qatar</option>
                                            <option data-code="RE" value="RE"> Reunion</option>
                                            <option data-code="RO" value="RO"> Romania</option>
                                            <option data-code="RU" value="RU"> Russian Federation</option>
                                            <option data-code="RW" value="RW"> Rwanda</option>
                                            <option data-code="SH" value="SH"> Saint Helena</option>
                                            <option data-code="KN" value="KN"> Saint Kitts and Nevis</option>
                                            <option data-code="LC" value="LC"> Saint Lucia</option>
                                            <option data-code="PM" value="PM"> Saint Pierre and Miquelon</option>
                                            <option data-code="VC" value="VC"> Saint Vincent and The Grenadines
                                            </option>
                                            <option data-code="WS" value="WS"> Samoa</option>
                                            <option data-code="SM" value="SM"> San Marino</option>
                                            <option data-code="ST" value="ST"> Sao Tome and Principe</option>
                                            <option data-code="SA" value="SA"> Saudi Arabia</option>
                                            <option data-code="SN" value="SN"> Senegal</option>
                                            <option data-code="RS" value="RS"> Serbia</option>
                                            <option data-code="SC" value="SC"> Seychelles</option>
                                            <option data-code="SL" value="SL"> Sierra Leone</option>
                                            <option data-code="SK" value="SK"> Slovakia</option>
                                            <option data-code="SI" value="SI"> Slovenia</option>
                                            <option data-code="SB" value="SB"> Solomon Islands</option>
                                            <option data-code="SO" value="SO"> Somalia</option>
                                            <option data-code="ZA" value="ZA"> South Africa</option>
                                            <option data-code="GS" value="GS"> South Georgia and The South
                                                Sandwich Islands</option>
                                            <option data-code="ES" value="ES"> Spain</option>
                                            <option data-code="LK" value="LK"> Sri Lanka</option>
                                            <option data-code="SD" value="SD"> Sudan</option>
                                            <option data-code="SR" value="SR"> Suriname</option>
                                            <option data-code="SJ" value="SJ"> Svalbard and Jan Mayen</option>
                                            <option data-code="SZ" value="SZ"> Swaziland</option>
                                            <option data-code="SE" value="SE"> Sweden</option>
                                            <option data-code="SY" value="SY"> Syrian Arab Republic</option>
                                            <option data-code="TW" value="TW"> Taiwan, Province of China</option>
                                            <option data-code="TJ" value="TJ"> Tajikistan</option>
                                            <option data-code="TZ" value="TZ"> Tanzania, United Republic of
                                            </option>
                                            <option data-code="TH" value="TH"> Thailand</option>
                                            <option data-code="TL" value="TL"> Timor-leste</option>
                                            <option data-code="TG" value="TG"> Togo</option>
                                            <option data-code="TK" value="TK"> Tokelau</option>
                                            <option data-code="TO" value="TO"> Tonga</option>
                                            <option data-code="TT" value="TT"> Trinidad and Tobago</option>
                                            <option data-code="TN" value="TN"> Tunisia</option>
                                            <option data-code="TR" value="TR"> Turkey</option>
                                            <option data-code="TM" value="TM"> Turkmenistan</option>
                                            <option data-code="TC" value="TC"> Turks and Caicos Islands</option>
                                            <option data-code="TV" value="TV"> Tuvalu</option>
                                            <option data-code="UG" value="UG"> Uganda</option>
                                            <option data-code="UA" value="UA"> Ukraine</option>
                                            <option data-code="AE" value="AE"> United Arab Emirates</option>
                                            <option data-code="UY" value="UY"> Uruguay</option>
                                            <option data-code="UZ" value="UZ"> Uzbekistan</option>
                                            <option data-code="VU" value="VU"> Vanuatu</option>
                                            <option data-code="VE" value="VE"> Venezuela</option>
                                            <option data-code="VN" value="VN"> Viet Nam</option>
                                            <option data-code="VG" value="VG"> Virgin Islands, British</option>
                                            <option data-code="VI" value="VI"> Virgin Islands, U.S.</option>
                                            <option data-code="WF" value="WF"> Wallis and Futuna</option>
                                            <option data-code="EH" value="EH"> Western Sahara</option>
                                            <option data-code="YE" value="YE"> Yemen</option>
                                            <option data-code="ZM" value="ZM"> Zambia</option>
                                            <option data-code="ZW" value="ZW"> Zimbabwe</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="input">
                                        <input type="text" data-validation="number,length,required"
                                            data-validation-length="max20" maxlength="20" name="phone"
                                            id="phone" placeholder="Phone" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <hr>
                        </div>

                        <div class="text">
                            <button type="submit" style="margin-top:0px;margin-bottom:0px;" class="join"
                                name="submit" id="submitbutton">
                                Save Address
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection
