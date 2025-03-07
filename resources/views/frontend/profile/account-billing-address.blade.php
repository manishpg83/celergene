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
            <div class="dz-bnr-inr bg-secondary overlay-black-light" style="background-image:url(images/background/bg1.jpg);">
                <div class="container">
                    <div class="dz-bnr-inr-entry">
                        <h1>My Account</h1>
                        <nav aria-label="breadcrumb" class="breadcrumb-row">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('myaccount') }}"> Home</a></li>
                                <li class="breadcrumb-item">Account Address</li>
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

                        @livewire('frontend.account.billingaddress')
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
