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
    <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm" onsubmit="showLoader()">
        @csrf
       <div class="form-bg">
          <div class="container login-form">
             <div class="con-small frm">
                <div class="header-form">
                   Forgot password
                </div>
                <div class="form-item">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                   <div class="">
                      <div class="row">
                         <div class="col-md-12 col-xs-12 form-group">
                            <div class="input">
                            <input type="text" class="form-control" id="email" name="email"
                            placeholder="Enter your email or username" autofocus required />
                            </div>
                         </div>

                         <div class="col-md-12 col-xs-12">
                            <div class="input">
                            <button class="btn btn-primary d-grid w-100" type="submit" id="submitBtn">Send Password
                            Reset Link</button>
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
