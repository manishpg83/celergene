<div>
    <form wire:submit.prevent="register" class="has-validation-callback">
        @csrf
        <div class="form-bg">
            <div class="container">
                <div class="clearfix frm">
                    <div class="header-form">
                        Register for New Customer
                    </div>
                    <div class="form-item">
                        <div>
                            <div class="label-cons"><span>1</span> Your basic information</div>
                            <div class="row align-items-center">
                                <!-- First Name -->
                                <div class="col-4 form-group">
                                    <div class="input">
                                        <input type="text" maxlength="25" wire:model="firstname" placeholder="First name">
                                        @error('firstname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-4 form-group">
                                    <div class="input">
                                        <input type="text" maxlength="50" wire:model="lastname" placeholder="Last name">
                                        @error('lastname') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- DOB Label -->
                                <div class="col-auto ps-2 form-group">
                                    <label class="mb-0">DOB :</label>
                                </div>

                                <!-- Date -->
                                <div class="col-auto form-group">
                                    <select wire:model="dob_day" name="dob_day" id="dob_day" class="form-select input border-0" style="min-width: 90px;">
                                        <option value="">Date</option>
                                        @foreach(range(1, 31) as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                    @error('dob_day') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Month -->
                                <div class="col-auto ps-1 form-group">
                                    <select wire:model="dob_month" name="dob_month" id="dob_month" class="form-select border-0 input" style="min-width: 90px;">
                                        <option value="">Month</option>
                                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $key => $month)
                                            <option value="{{ $key + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    @error('dob_month') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Year -->
                                <div class="col-auto ps-1 form-group">
                                    <select wire:model="dob_year" name="dob_year" id="dob_year" class="form-select input border-0" style="min-width: 90px;">
                                        <option value="">Year</option>
                                        @foreach(range(date('Y'), 1900) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    @error('dob_year') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-8 col-xs-12 form-group">
                                    <div class="input">
                                        <input type="text" maxlength="100" wire:model="company" placeholder="Company Name (optional)">
                                        @error('company') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12 form-group">
                                    <div class="input">
                                        <input type="text" maxlength="20" wire:model="phone" placeholder="Phone Number">
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
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
                                <div class="col-sm-4 col-xs-12 form-group">
                                    <div class="input">
                                        <input type="email" maxlength="50" wire:model="email" placeholder="Email address">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12 form-group">
                                    <div class="input">
                                        <input type="password" wire:model="pass" placeholder="Password">
                                        @error('pass') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12 form-group">
                                    <div class="input">
                                        <input type="password" wire:model="pass_confirmation" placeholder="Re-enter Password">
                                        @error('pass_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <hr>
                        </div>

                        
                        <div class="text" style="margin-top: 42px;">
                            <button type="submit" class="join">JOIN CELERGEN</button>
                        </div>
                        <div class="text">
                            <div class="ext">
                                When you click JOIN CELERGEN you are agreeing to our <a href="https://celergenswiss.com/privacy-policy" title="">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
