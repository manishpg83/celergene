@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

    <style>
        .acc {
            font-family: 'OpenSans' !important;
            background: #fff;
        }

        .bg-gradient {
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#00102a+0,ffffff+17&0.1+0,1+36 */
            background: -moz-linear-gradient(top, rgba(0, 16, 42, 0.1) 0%, rgba(255, 255, 255, 0.53) 17%, rgba(255, 255, 255, 1) 36%);
            /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(0, 16, 42, 0.1) 0%, rgba(255, 255, 255, 0.53) 17%, rgba(255, 255, 255, 1) 36%);
            /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(0, 16, 42, 0.1) 0%, rgba(255, 255, 255, 0.53) 17%, rgba(255, 255, 255, 1) 36%);
            /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#1a00102a', endColorstr='#ffffff', GradientType=0);
            /* IE6-9 */


            width: 100%;
            height: 104px;
        }

        .banner-grad {

            height: 104px;
            text-align: left;
            color: #002b49;
            font-size: 30px;
        }

        .tab-a a.active {
            color: #000 !important;
            background: #fff;

        }

        .tab-a a {
            background: #d2d2d2;
            color: #000 !important;
            padding: 20px 30px;
            border: 1px solid #b8b8b8;
            text-decoration: none !important;
            border-bottom: none;
            float: left;
        }

        .ru {
            border-top: 1px solid #dedede;
        }

        .ro {
            border-bottom: 1px solid #dedede;
        }

        .desc {
            padding: 20px 20px;
            padding-left: 32px;
            width: 100%;
            color: #666666;
        }

        .desc .title {
            font-size: 16px;
        }

        .desc .ib {
            font-size: 14px;
        }

        .desc a {
            display: block;
            color: #002b49;
            margin-bottom: 20px;

        }

        .no-padding {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .head-sec {
            background: #0a639f;
            color: #fff;
            padding: 10px 20px;
        }

        .head-sec-long {
            background: #002D59;
            color: #fff;
            padding: 16px 20px;
            text-align: center;
        }

        .rba {
            border-left: 1px solid #dedede;
        }

        .rba .paddingsec {
            padding: 15px 40px;
        }

        .rba .paddingseclong {
            padding: 13px 40px;
        }


        .section .sem {
            background: #fff;
            border-bottom: 1px solid #dedede;
        }

        .section .sem-title {
            background: #D2D2D2;
        }

        .section .sem-content {
            background: #fff;
        }


        .section .sem a {
            padding: 6px 15px;
            border: 1px solid #0a639f;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .section .sem span {
            padding-top: 3px;
        }

        .section .sem a:hover {
            background: #0a639f;
            color: #fff;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .section .act {
            border-bottom: 1px solid #dedede;
        }

        .rba .addmore {
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .bo-op {
            border-right: 1px solid #dedede;
            border-left: 1px solid #dedede;
            border-bottom: 1px solid #dedede;
        }

        .table-res tr:nth-child(even) {
            background: #e9e9e9;
        }

        .table-res tdhead {
            background: #d2d2d2;
        }
    </style>


    <div class="wrapper-fixed acc">
        <div class="bg-gradient">
            <div class="container">
                <div class="row ro-none">
                    <div class="banner-grad">
                        <div class="table-cell">
                            <div class="v-align">
                                {{ $user->name ?? $user->first_name . ' ' . $user->last_name }}
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-a container">
            <div class="row ro-none">
                <div class="clearfix">
                    <a class="item active" href="{{ route('myaccount') }}">
                        ACCOUNT
                    </a>
                    <a class="item " href="#transaction">
                        TRANSACTION
                    </a>
                </div>
            </div>
        </div>
        <div class="content-p">
            <div id="">
                <div class="container bo-op">
                    <div class="row ro-none">
                        <div class="col-sm-6 col-xs-12 ru bo-mob">
                            <div class="row">
                                <div class="desc ro">
                                    <div class="title">
                                        Email
                                    </div>
                                    <div class="ib">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="desc ro">
                                    <div class="title">
                                        Company
                                    </div>
                                    <div class="ib">
                                        {{ $user->company ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="desc ro">
                                    <div class="title">
                                        Phone Number
                                    </div>
                                    <div class="ib">
                                        {{ $user->phone ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="desc ro">
                                    <div class="title">
                                        Date of Birth
                                    </div>
                                    <div class="ib">
                                        {{ $user->date_of_birth ? $user->date_of_birth->format('d-m-Y') : 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="desc ">
                                    <a href="{{ route('edit.account') }}" title="">&gt; EDIT ACCOUNT</a>
                                    <a href="{{ route('change.password') }}" title="">&gt; CHANGE PASSWORD</a>
                                    <a href="{{ route('logout') }}" title="">&gt; LOGOUT</a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-sm-6 col-xs-12 no-padding rba bo-mob2">
                            <div class="section">
                                <div class="head-sec padr">
                                    BILLING INFORMATION
                                </div>
                                <div class="content padr">
                                    <p>{{ $user->billing_address ?? 'No billing address provided' }}</p>
                                </div>
                                <div class="content padr">
                                    <a class="addmore paddingsec" href="{{ route('addbillingaddress') }}">
                                        + ADD BILLING ADDRESS
                                    </a>
                                </div>
                            </div>
                            <div class="section">
                                <div class="head-sec padr">
                                    SHIPPING INFORMATION
                                </div>
                                <div class="content padr">
                                    <p>{{ $user->shipping_address ?? 'No shipping address provided' }}</p>
                                </div>
                                <div class="content padr">
                                    <a class="addmore paddingsec" href="#">
                                        + ADD SHIPPING ADDRESS
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
