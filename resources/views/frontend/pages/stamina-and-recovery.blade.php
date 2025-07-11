@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

    <style>
        ul.bullet li::before {
            background: url("{{ asset('frontend/images/benefits/ic_benefit_list.png') }}");
            content: '';
            width: 33px;
            height: 25px;
            position: absolute;
            left: 0px;
            top: 5px;
        }

        .benefits-text {
            position: relative;
            padding-left: 60px;
            font-size: 22px;
            margin-bottom: 50px
        }

        .text{
            padding-right: calc(var(--bs-gutter-x)* .5);
            padding-left: calc(var(--bs-gutter-x)* .5);
        }

        .top-banner {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            width: 100%;
            height: 592px;
        }

        .top-banner-txt {
            position: absolute;
            top: 64%;
            right: 50%;
            font-size: 50px;
            line-height: 1;
        }

        .grey-box {
            font-size: 20px;
            line-height: 2;
        }

        .grey-box span {
            font-size: 25px;
        }

        .customers-job {
            font-size: 16px
        }

        @media (max-width:576px) {
            .top-banner {
                height: 237px;
            }

            .top-banner-txt {
                position: absolute;
                top: 6%;
                right: 37%;
                font-size: 28px;
            }

            .grey-box,
            .grey-box span {
                font-size: 16px !important;
                line-height: 2;
            }

            .customers-job {
                font-size: 13px
            }
        }

        @media (min-width:577px) and (max-width:768px) {
            .top-banner {
                height: 323px;
            }

            .top-banner-txt {
                position: absolute;
                top: 9%;
                right: 37%;
                font-size: 38px;
            }

            .grey-box,
            .grey-box span {
                font-size: 16px !important;
                line-height: 2;
            }

        }

        @media (min-width:769px) and (max-width: 1024px) {
            .top-banner {
                height: 475px;
            }

            .top-banner-txt {
                position: absolute;
                top: 10%;
                right: 51%;
                font-size: 40px;
            }
        }

        @media (max-width:768px) {
            .benefits-text {
                font-size: 16px;
                padding-left: 30px;
                margin-bottom: 30px;
            }

            ul.bullet li::before {
                width: 20px;
                height: 15px;
                background-size: cover;
            }
        }
    </style>

    <section>
        <div class="px-0 container-fluid">
            <div class="text-white CallunaRegular padding-x bg-blue">
                <h1 class="m-0 text-white section-heading CallunaRegular border-left">STAMINA AND RECOVERY</h1>
            </div>
            <div class="top-banner aos-init"
                style="background-image: url('{{ asset('frontend/images/benefits/celergen-benefit-stamina-recovery.jpg') }}');"
                data-aos="fadeIn" data-aos-duration="500">
                <h1 class="text-white top-banner-txt CallunaRegular aos-init" data-aos="fadeIn"
                    data-aos-duration="1000" data-aos-delay="500">
                    Do You Need More Stamina<br>and Enhanced Performance ?
                </h1>
            </div>
        </div>
    </section>

    <section>
        <div class="px-0 container-fluid padding-y">
            <div class="container px-lg-5">
                <p class="pb-3 text-center text-grey AdelleSan-Light-Opensans px-lg-5 pb-lg-5">
                    Do you sometimes find you lack energy and feels exhausted after a normal workout? Do you wish for more
                    stamina and faster recovery for better performance?
                </p>
                <div class="pt-lg-5">
                    <h1 class="text-center section-heading text-blue AdelleSansRegular">
                        CUSTOMERS' CELERGEN REVIEWS
                    </h1>
                    <div class="float-none px-0 mx-auto text-center  col-xl-10 col-xxl-10 text-lg-start">
                        <div class="benefits-review owl-carousel owl-theme owl-loaded">
                            <div class="owl-stage-outer">
                                <div class="owl-stage"
                                    style="transform: translate3d(-1860px, 0px, 0px); transition: all; width: 5580px;">
                                    <div class="owl-item active" style="width: 870px; margin-right: 60px;">
                                        <div class="item benefits-item">
                                            <div class="item-shadow">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <img src="{{ asset('frontend/images/benefits/curtis-mitchell.png') }}"
                                                            alt="" class="imag-frame">
                                                    </div>
                                                    <div class="col-lg-9 text">
                                                        <h5
                                                            class="py-4 doctors-review-energy text-blue AdelleSansRegular pb-lg-4">
                                                            “The first thing I noticed was that I was able to recover a lot
                                                            quicker from my workouts…
                                                            a huge boost to my training regimen because it allows me to work
                                                            harder without a drop-off in
                                                            energy and really take it to the next level.”
                                                        </h5>
                                                        <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                            CURTIS MITCHELL (ELITE SPRINTER)
                                                        </h5>
                                                        <h6 class="customers-job text-blue">
                                                            IAAF WORLD CHAMPIONSHIP 200M BRONZE MEDALLIST
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="owl-item" style="width: 870px; margin-right: 60px;">
                                        <div class="item benefits-item">
                                            <div class="item-shadow">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <img src="{{ asset('frontend/images/benefits/george-michael.png') }}"
                                                            alt="" class="imag-frame">
                                                    </div>
                                                    <div class="col-lg-9 text">
                                                        <h5
                                                            class="py-4 doctors-review-energy text-blue AdelleSansRegular pb-lg-4">
                                                            “I now suggest that my clients reconsider all the supplements
                                                            they take and reduce the
                                                            long list to only Celergen.”
                                                        </h5>
                                                        <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                            GEORGE MICHAEL
                                                        </h5>
                                                        <h6 class="customers-job text-blue">
                                                            CELEBRITY PERSONAL TRAINER
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="px-0 container-fluid bg-lightgrey padding-y">
            <div class="container padding-x">
                <div class="row">
                    <div class="text-center col-lg-3 text-lg-start ">
                        <img src="{{ asset('frontend/images/benefits/celergen-stamina-recovery-certified-1.png') }}"
                            alt="" width="245px" height="201px">
                    </div>
                    <div class="text-center col-lg-9 text-lg-start">
                        <h5 class="pt-3 grey-box text-grey AdelleSan-Regular-Opensans ps-lg-3">
                            CELERGEN IS BSCG (BANNED SUBSTANCES CONTROL GROUP) APPROVED AND IS
                            <span>CERTIFIED DRUG-FREE FOR PROFESSIONALS AND ELITE ATHLETES.</span> THIS MEANS THAT CELERGEN
                            DOES
                            NOT CONTAIN STIMULANTS, HORMONES, CONTAMINANTS OR ADDITIVES.
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid px-sm-2">
            <div class="container padding px-lg-4">
                <h1 class="text-center section-heading lh-base text-blue CallunaRegular px-lg-5">
                    CLINICAL STUDIES ON THE EFFECTIVENESS OF
                    CELERGEN ON STAMINA AND RECOVERY
                </h1>
                <div class="border-bottom"></div>
                <div class="aos-init" data-aos="fade-up" data-aos-delay="150" data-aos-easing="linear"
                    data-aos-duration="1500">
                    <div class="py-5 pb-3 padding-x" align="center">
                        <img src="{{ asset('frontend/images/benefits/stamina-recovery-chart-1.png') }}"
                            alt="">
                    </div>
                    <p class="px-2 text-center text-grey px-lg-5">
                        These figures show the effects Bio-DNA Cellular Marine Complex on increased stamina during exercise
                        and
                        recuperation after exercise for athletes tested based using a double blind placebo protocol.
                    </p>
                </div>
                <div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-3 pb-lg-5">
        <div class="px-0 pb-3 text-center container-fluid bg-blue pb-lg-5">
            <div class="container px-lg-5">
                <div class="border-right"></div>
                <div class="pt-3 px-lg-5">
                    <h5 class="pb-3 benefits-box pb-lg-5 AdelleSan-Regular-Opensans">
                        CELERGEN, THE WORLD’S ONLY SWISS MARINE ORAL CELL THERAPY SUPPLEMENT, WILL ENHANCE YOUR STAMINA AND
                        RECOVERY IN YOUR WORKOUTS, GIVING YOU <span>OPTIMAL PERFORMANCE. </span>
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="container pt-5">
                <h1 class="text-center section-heading text-blue CallunaRegular padding aos-init"
                    data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
                    THERE’S NO REASON TO FACE AN ENERGY SHORTAGE!
                </h1>
                <div class="pt-2 pb-4 text-center">
                    <a href="{{ route('cart') }}" class="text-white ordernow-btn AdelleSansBold bg-darkred blinking">
                        ORDER CELERGEN NOW
                    </a>
                </div>
                <div class="container float-none mx-auto padding-x col-lg-12 col-xl-8 col-7">
                    <ul style="list-style: none" class="bullet">
                        <div class="row padding-top">
                            <li class="benefits-text text-blue">ENERGY BOOST AND ENHANCED STAMINA</li>
                            <li class="benefits-text text-blue">FAST RECOVERY FROM WORKOUTS AND PHYSICAL EXERTIONS</li>
                            <li class="benefits-text text-blue">IMPROVED PERFORMANCES AND RESULTS</li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
