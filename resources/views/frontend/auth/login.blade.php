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
    <form method="POST" id="registration" action="{{ route('login') }}">
       @csrf
       <div class="form-bg">
          <div class="container login-form">
             <div class="con-small frm">
                <div class="header-form">
                   Login for Returning Customers
                </div>
                <div class="form-item">
                   <div class="note notepopup" style="display: none;">
                      <h4>For Our Returning Customers,</h4>
                      Please note that we have upgraded our system. Your registered Email will now be your login ID. Please click on 'forgot password' to reset your password. We apologise for the inconvenience caused.
                      <span class="closeNa">×</span>
                   </div>
                   <div class="">
                      <div class="row">
                         <div class="col-md-12 col-xs-12 form-group">
                            <div class="input">
                               <input type="email" data-validation="required" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                               @error('email')
                                   <span class="text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                         </div>
                         <div class="col-md-12 col-xs-12 form-group">
                            <div class="input">
                               <input type="password" data-validation="required" name="password" id="password" placeholder="Password">
                               @error('password')
                                   <span class="text-danger">{{ $message }}</span>
                               @enderror
                            </div>
                         </div>
                         <div class="col-md-12 col-xs-12 form-group">
                            <div class="atr">
                               <div class="row">
                                  <div class="col-sm-6 remember">
                                     <input type="checkbox" id="test2" checked="checked">   
                                     <label for="test2">Remember Me</label>
                                  </div>
                                  <div class="col-sm-6 col-xs-12 pull-right forgot">
                                     <a href="recover.php" title="">Forgot Password ?</a>
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-12 col-xs-12">
                            <div class="input">
                               <button type="submit" name="submit" class="join">
                               SIGN IN
                               </button>
                               <button class="join grey">
                               <a href="{{ route('register') }}">SIGN UP FOR NEW ACCOUNT</a>
                               </button>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </form>
 </div>
@endsection