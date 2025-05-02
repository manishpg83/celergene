@extends('frontend.layouts.app')

@section('title', 'Billing | Celergen')
@section('header', 'Billing | Celergen')

@section('content')
    {{--  @livewire('frontend.my-account') --}}
    <div class="page-wraper">

        <!-- Header Start -->
        <!-- Header End -->
        <!-- contact-sidebar-start -->
        <!-- contact-sidebar-end -->
        <div class="page-content bg-light-1">

            <!--Banner Start-->
            <div class="dz-bnr-inr1 overlay-black-light" style="background-color: #002d59; background-image: none;">
                <div class="container">
                    <div class="dz-bnr-inr-entry">
                        <h1>My Account</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb-row">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('myaccount') }}"> Home</a></li>
                                <li class="breadcrumb-item">Account Shipping Address</li>
                            </ul>
                        </nav>
                    </div>
                </div>	
            </div>
            <!--Banner End-->

            <div class="content-inner-1">
                <div class="container">
                    <div class="row">
                        @include('frontend.profile.account-sidebar')

                        @livewire('frontend.account.shippingaddress')
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
