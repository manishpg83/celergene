
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="banner">
        <div class="table-cell">
            <div class="v-align">
                Join The Transformation <br>
                of Your Health Now !
            </div>
        </div>
    </div>
    <form wire:submit.prevent="submit">
        <input type="hidden" wire:model="customerId">
        <div class="form-bg">
            <div class="container frm">
                <div class="row">
                    <div class="header-form">
                        Billing Address
                    </div>
                    <div class="form-item">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <div class="input">
                                    <input type="text" wire:model="firstname" placeholder="First name">
                                    @error('firstname') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="input">
                                    <input type="text" wire:model="lastname" placeholder="Last name">
                                    @error('lastname') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="input">
                                    <input type="text" wire:model="companyname" placeholder="Company Name">
                                    @error('companyname') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <div class="input">
                                    <input 
                                    type="text" 
                                    wire:model="address1" 
                                    placeholder="Address" 
                                    class="@error('address1')input-error @enderror">
                                    @error('address1') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="input">
                                    <input type="text" wire:model="address2" placeholder="Address 2 (optional)">
                                    @error('address2') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="input">
                                    <input type="text" wire:model="zip" placeholder="Postcode">
                                    @error('zip') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="input">
                                    <select wire:model="country">
                                        <option value="" disabled>Select country</option>
                                        <option value="AF">Afghanistan</option>
                                        <option value="AX">Aland Islands</option>
                                        <option value="AL">Albania</option>
                                        <!-- Add more countries as needed -->
                                    </select>
                                    @error('country') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="input">
                                    <input type="text" wire:model="phone" placeholder="Phone">
                                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text">
                            <button type="submit" class="join">Save Address</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
