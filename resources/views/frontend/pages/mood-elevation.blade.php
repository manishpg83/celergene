@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

    <style>
        ul.bullet li::before {
            background: url("images/common/ic_benefit_list.png");
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

        .top-banner {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            width: 100%;
            height: 592px;
        }

        .top-banner-txt {
            position: absolute;
            top: 8%;
            left: 53%;
            font-size: 50px;
            line-height: 0.9;
        }

        @media (max-width:420px) {
            .top-banner {
                height: 237px;
            }

            .top-banner-txt {
                display: none !important;
            }
        }

        @media (min-width: 421px) and (max-width:576px) {
            .top-banner {
                height: 237px;
            }

            .top-banner-txt {
                position: absolute;
                top: 4%;
                left: 52%;
                font-size: 28px;
            }
        }

        @media (min-width:577px) and (max-width:768px) {
            .top-banner {
                height: 323px;
            }

            .top-banner-txt {
                position: absolute;
                top: 3%;
                left: 50%;
                font-size: 38px;
                line-height: 0.9;
            }
        }

        @media (min-width: 993px) and (max-width: 1366px) {
            .top-banner {
                height: 475px;
            }

            .top-banner-txt {
                position: absolute;
                top: 7%;
                left: 55%;
                font-size: 40px;
            }
        }

        .row>* {
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x)* .5);
            padding-left: calc(var(--bs-gutter-x)* .5);
            margin-top: var(--bs-gutter-y);
        }
    </style>

    <section>
        <div class="container-fluid px-0">
            <div class="CallunaRegular padding-x bg-blue text-white">
                <h1 class="text-white section-heading CallunaRegular border-left m-0">MOOD ELEVATION</h1>
            </div>
            <div class="top-banner aos-init"
                style="background-image: url('{{ asset('frontend/images/celergen-benefit-mood-elevation.jpg') }}');"
                data-aos="fadeIn" data-aos-duration="500">
                <h1 class="top-banner-txt text-blue CallunaRegular aos-init" data-aos="fadeIn"
                    data-aos-duration="1000" data-aos-delay="500">
                    Are You Suffering <br>
                    From Mild Depression <br>
                    or Mental Fatigue ?
                </h1>
            </div>

        </div>
    </section>

    <section>
        <div class="container-fluid px-0">
            <div class="container px-lg-5">
                <p class="text-grey AdelleSan-Light-Opensans text-center px-lg-5 py-lg-5 pb-3">
                    Do you feel anxious for no reason, unable to sleep or concentrate properly? It could be low-level
                    depression. <br>
                    According to recent estimates by the World Health Organization, as many as 120 million people worldwide
                    suffer from some
                    form of depression. Depression can be as disabling as a physical illness. It can bring about pain,
                    fatigue, headaches,
                    and digestive problems.
                </p>
            </div>
            <div class="container pt-lg-5">
                <h1 class="section-heading text-blue AdelleSansLight text-center">
                    DOCTORS' CELERGEN REVIEWS
                </h1>
                <div class="col-xl-10 col-xxl-10 text-lg-start text-center mx-auto float-none px-0">
                    <div class="benefits-review owl-carousel owl-theme owl-loaded">
                        <div class="owl-stage-outer">
                            <div class="owl-stage"
                                style="transform: translate3d(-1980px, 0px, 0px); transition: all; width: 6930px;">
                                <div class="owl-item cloned" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="{{ asset('frontend/images/benefits/DrBruceKLowellMD_3684_162.png') }}" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “One of my patients suffer from mild depression and was taking
                                                        anti-depression medication but
                                                        within one month of Celergen, she was back to being herself and
                                                        wards off her depression drugs.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Bruce Lowell
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item cloned" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="{{ asset('frontend/images/benefits/Dr.-Sharon-Norling.jpg') }}" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I don’t believe in prescribing mood-altering drugs. So when a
                                                        natural therapy like Celergen comes along, it’s a huge gift. There
                                                        no apparent side effects.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Sharon Norling
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item active" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="{{ asset('frontend/images/benefits/Dr.-Nina.jpg') }}" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “My overall mood and outlook have definitely improved. I feel more
                                                        energized and focused.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Nina Svino
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="images/benefits/DrBruceKLowellMD_3684_162.png" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “One of my patients suffer from mild depression and was taking
                                                        anti-depression medication but
                                                        within one month of Celergen, she was back to being herself and
                                                        wards off her depression drugs.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Bruce Lowell
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="images/benefits/Dr.-Sharon-Norling.jpg" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I don’t believe in prescribing mood-altering drugs. So when a
                                                        natural therapy like Celergen comes along, it’s a huge gift. There
                                                        no apparent side effects.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Sharon Norling
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item cloned" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="images/benefits/Dr.-Nina.jpg" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “My overall mood and outlook have definitely improved. I feel more
                                                        energized and focused.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Nina Svino
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="owl-item cloned" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="images/benefits/DrBruceKLowellMD_3684_162.png" alt=""
                                                        class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “One of my patients suffer from mild depression and was taking
                                                        anti-depression medication but
                                                        within one month of Celergen, she was back to being herself and
                                                        wards off her depression drugs.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Bruce Lowell
                                                    </h5>
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
        <div class="container-fluid px-sm-4">
            <div class="container padding-y px-lg-5">
                <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 pt-lg-5">
                    CLINICAL STUDIES ON THE EFFECTIVENESS OF
                    CELERGEN ON MOOD ELEVATION AND MENTAL HEALTH
                </h1>
                <div class="border-bottom"></div>
                <div class="pt-5">
                    <div class="row pt-lg-3">
                        <div class="col-lg-4">
                            <img src="{{ asset('frontend/images/benefits/mood-elevation-graph.png') }}" alt="" class=""
                                width="100%">
                        </div>
                        <div class="col-lg-8">
                            <p class="text-grey pt-3 lh-base">
                                This figure shows the effects of 800 mg/Day Bio-DNA Cellular Marine Complex on self-reported
                                markers of mental health in 688 subjects (average age 44 years). After 15 days, subjects
                                reported s
                                ignificant improvement in anxiety and apprehension (32%); mental fatigue (54%); irrational
                                fears (54%);
                                sleep disorders (47%); memory loss (45%); and sadness/depression (50%).
                            </p>
                            <p class="text-grey pt-3 lh-base">
                                This study shows that Bio-DNA Cellular Marine Complex is highly effective in improving
                                various aspects
                                of mental health after just 15 days, without any of the toxic side effects of commercial
                                mental health
                                drugs.
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-lg-5 pb-3">
        <div class="container-fluid px-0 bg-blue text-center pb-lg-5 pb-3">
            <div class="container px-lg-5">
                <div class="border-right"></div>
                <div class="pt-3 px-lg-5">
                    <h5 class="benefits-box pb-lg-5 pb-3 AdelleSan-Regular-Opensans">
                        CELERGEN, THE WORLD’S ONLY SWISS MARINE ORAL CELL THERAPY SUPPLEMENT, WILL IMPROVE YOUR MOOD,
                        RESTORE SATISFACTION IN YOUR DAILY ACTIVITIES, AND RENEW PLEASURE IN RECONNECTING WITH YOUR FRIENDS
                        AND LOVED ONES WHILE ALSO <span> BANISHING ANXIETY, SLEEP DISORDERS, MEMORY LOSS, AND DEPRESSION.
                        </span> IN OTHER WORDS,
                        CELERGEN WILL ENABLE YOU TO LEAD AN EMOTIONALLY RICH AND FULFILLING LIFE.
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="container  pt-3 pb-lg-5 pb-3">
                <p class="text-grey mood-disorders AdelleSan-Light-Opensans text-center px-lg-5">
                    While anti-depressants are typically the standard medical treatment for such mood disorders,
                    many are discovering that Celergen offers tangible results in this area too.
                </p>
                <div class="">
                    <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 pt-lg-5 pt-3">
                        DON’T LET DEPRESSION ROB YOU OF LIFE’S JOYS.
                    </h1>
                </div>
                <div class="pt-4 pb-4 text-center">
                    <a href="order-here.php" class="ordernow-btn AdelleSansBold bg-darkred text-white blink">
                        ORDER CELERGEN NOW
                    </a>
                </div>
                <div class="container padding-x">
                    <ul style="list-style: none" class="bullet">
                        <div class="row padding-top">
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">SIGNIFICANT RELIEF FROM ANXIETY, EMOTIONAL AND
                                    IRRATIONAL FEARS</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">BANISH SLEEP DISORDERS WHILE IMPROVING YOUR ABILITY TO
                                    CONCENTRATE</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">ACT AS MEMORY BOOSTER</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">IMPROVE OPTIMISM AND POSITIVITY</li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
