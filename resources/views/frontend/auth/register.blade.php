@extends('frontend.layouts.app')
@section('title', 'Home | Celergen')
@section('header', 'Home | Celergen')
@section('content')
    <div class="wrapper-fixed">
        <div class="banner">
            <div class="table-cell">
                <div class="v-align">
                    Experience Swiss Cell Therapy
                </div>
            </div>
        </div>
        <form id="registration" method="POST" action="{{ route('frontend.register') }}" class="has-validation-callback">
            @csrf
            <div class="form-bg">
                <div class="container ">
                    <div class="clearfix frm">
                        <div class="header-form">
                            Register for New Customer
                        </div>
                        <div class="form-item">
                            <div class="">
                                <div class="label-cons"><span>1</span> Your basic information</div>
                                <div class="row align-items-center">
                                    <!-- First Name -->
                                    <div class="col-4 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="25" data-validation="required"
                                               name="reg_firstname" id="reg_firstname" placeholder="First name"
                                               value="">
                                         </div>
                                    </div>
                                    
                                    <!-- Last Name -->
                                    <div class="col-4 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="50" data-validation="required"
                                               name="reg_lastname" id="reg_lastname" placeholder="Last name"
                                               value="">
                                         </div>
                                    </div>
                                    
                                    <!-- DOB Label -->
                                    <div class="col-auto ps-2 form-group">
                                        <label class="mb-0">DOB :</label>
                                    </div>
                                    
                                    <!-- Date -->
                                    <div class="col-auto form-group">
                                        <select class="form-select input border-0" name="dob_day" style="min-width: 90px;">
                                            <option value="">Date</option>
                                            <script>
                                                for (let i = 1; i <= 31; i++) {
                                                    document.write(`<option value="${i}">${i}</option>`);
                                                }
                                            </script>
                                        </select>
                                    </div>
                                    
                                    <!-- Month -->
                                    <div class="col-auto ps-1 form-group">
                                        <select class="form-select border-0 input" name="dob_month" style="min-width: 90px;">
                                            <option value="">Month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Year -->
                                    <div class="col-auto ps-1 form-group">
                                        <select class="form-select input border-0" name="dob_year" style="min-width: 90px;">
                                            <option value="">Year</option>
                                            <script>
                                                const currentYear = new Date().getFullYear();
                                                for (let i = currentYear; i >= 1900; i--) {
                                                    document.write(`<option value="${i}">${i}</option>`);
                                                }
                                            </script>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="100" name="reg_company" id="reg_company"
                                                placeholder="Company Name (optional)" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="text" maxlength="20" name="reg_phone" id="reg_phone"
                                                data-validation="number" placeholder="Phone Number" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <div class="form-group">
                                <div class="label-cons"><span>2</span> Your account credentials</div>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12 form-group has-success">
                                        <div class="input">
                                            <input type="email" maxlength="50" name="reg_email" id="reg_email"
                                                data-validation="required" placeholder="Email address" value=""
                                                class="valid">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group has-success">
                                        <div class="input">
                                            <input type="password" name="reg_pass" id="reg_pass"
                                                data-validation="length,required" data-validation-length="min8"
                                                value="" placeholder="Password" class="valid">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 form-group">
                                        <div class="input">
                                            <input type="password" name="reg_pass_confirmation"
                                                id="reg_pass_confirmation" data-validation="confirmation"
                                                data-validation-confirm="reg_pass" placeholder="Re-enter Password">
                                        </div>
                                    </div>
                                </div>
                                {{--  
                     <div class="g-recaptcha" data-sitekey="6Ld7BQ4UAAAAAFoKqvRzZ89fkFHswZ2-oPyDiqpM">
                        <div style="width: 304px; height: 78px;">
                           <div><iframe title="reCAPTCHA" width="304" height="78" role="presentation" name="a-ia8iljo3gmyg" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Ld7BQ4UAAAAAFoKqvRzZ89fkFHswZ2-oPyDiqpM&amp;co=aHR0cHM6Ly9zdG9yZS5jZWxlcmdlbnN3aXNzLmNvbTo0NDM.&amp;hl=en&amp;v=zIriijn3uj5Vpknvt_LnfNbF&amp;size=normal&amp;cb=so32snm10bs2"></iframe></div>
                           <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                        </div>
                        <iframe style="display: none;"></iframe>
                     </div>
                     --}}
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <!-- <div class="text">
                             <div class="ext">
                                 You can add your detail payment later or you can <a href="#" title="">click here</a> to  add it now.
                             </div>
                             </div> -->
                            <div class="text" style="margin-top: 42px;">
                                <button type="submit" name="submit" class="join" id="submitbutton">
                                    JOIN CELERGEN
                                </button>
                            </div>
                            <div class="text">
                                <div class="ext">
                                    When you click JOIN CELERGEN you are agreeing to our <a
                                        href="https://celergenswiss.com/privacy-policy" title="">Privacy Policy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
