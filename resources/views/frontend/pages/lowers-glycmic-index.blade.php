@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

    <style>
        .benefits-list {
            position: relative;
            float: left;
            left: 50%;
            transform: translateX(-50%);
        }

        ul.bullet li::before {
            background: url("https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_benefit_list.png");
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
            top: 42%;
            right: 56%;
            font-size: 50px;
        }

        .border-left {
            letter-spacing: 1.5px !important;
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
                height: 213px;
            }

            .top-banner-txt {
                position: absolute;
                top: 6%;
                right: 46%;
                font-size: 28px;
            }
        }

        @media (min-width:577px) and (max-width:768px) {
            .top-banner {
                height: 307px;
            }

            .top-banner-txt {
                position: absolute;
                top: 8%;
                right: 45%;
                font-size: 38px;
            }
        }

        @media (min-width:769px) and (max-width:1024px) {
            .top-banner {
                height: 407px;
            }

            .top-banner-txt {
                position: absolute;
                top: 9%;
                right: 56%;
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

    <section class="margin-top">
        <div class="container-fluid px-0">
            <div class="CallunaRegular padding-x bg-blue text-white">
                <h1 class="text-white section-heading CallunaRegular border-left m-0">LOWER GLYCEMIC INDEX FOR BETTER BLOOD
                    SUGAR LEVELS</h1>
            </div>
            <div class="top-banner aos-init"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/celergen-benefit-lowers-glycemic-index.jpg');"
                data-aos="fadeIn" data-aos-duration="500">
                <h1 class="top-banner-txt text-white CallunaRegular aos-init" data-aos="fadeIn"
                    data-aos-duration="1000" data-aos-delay="500">
                    Do You Want To Lower <br>Your Blood Sugar Levels ?
                </h1>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid px-0 padding-y">
            <div class="container px-lg-5">
                <p class="text-grey AdelleSan-Light-Opensans text-center px-lg-5 pb-lg-5 pb-3">
                    The glycemic index is a value assigned to foods based on how slowly or how quickly those foods cause
                    increases in
                    blood glucose levels. Also known as “blood sugar,” blood glucose levels above normal are toxic and can
                    cause type 2
                    diabetes. The slow and steady release of glucose in low-glycemic foods is helpful in keeping blood
                    glucose under control.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid px-sm-4">
            <div class="container px-lg-4">
                <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 lh-base">
                    CLINICAL STUDIES ON THE EFFECTIVENESS OF CELERGEN ON LOWERING GLYCEMIC INDEX
                </h1>
                <div class="border-bottom"></div>
                <div class="col-lg-10 mx-auto float-none pt-5">
                    <div class="row py-5">
                        <div class="col-lg-6">
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/lowers-chart.png"
                                alt="">
                        </div>
                        <div class="col-lg-6 px-0">
                            <p class="text-grey pt-3">
                                Peptide N in Celergen has the Glycemic Index reducing property, and, thus, is a natural mean
                                to fight against the increasing number of<br>
                                overweight people and health disorders that are linked with obesity.
                            </p>
                            <p class="text-grey pt-4">
                                This figure shows the results of a study evaluating the effects of 4
                                different proteins – Peptide N, fish fillet, casein milk protein and soy protein isolate –
                                on blood glucose levels in 17 female volunteers (aged 32-64 years). Each volunteer consumed
                                these proteins in random order, always as part of composite meals of similar macronutrient
                                composition with a 1-week gap between each meal. Blood samples were taken from each
                                volunteer to assess levels of glucose, insulin and other biomarkers in the fasting state and
                                7 times after each meal, for up to 240 minutes.
                            </p>
                        </div>
                        <div class="col-lg-12 py-4">
                            <p class="text-grey">
                                This study found that Peptide N supplementation resulted in a significantly blunted blood
                                glucose response
                                than with fish fillet protein or soy protein isolate, lowering the risk of obesity and
                                alleviating symptoms of
                                type II diabetes. In other clinical studies, Peptide N has also been shown to reduce the
                                appetite and promote
                                satiety via its actions on metabolic hormones.
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid px-0 bg-blue text-center pb-lg-5 pb-3">
            <div class="container">
                <div class="border-right"></div>
                <div class="pt-3 px-lg-5">
                    <h5 class="benefits-box AdelleSan-Regular-Opensans pb-lg-5 pb-3">
                        PEPTIDE N, ONE OF CELERGEN’S INGREDIENTS IS A MARINE PROTEIN HYDROLYSATE PROVEN TO REDUCE THE
                        DIETARY GLYCEMIC
                        INDEX OR GI. PEPTIDE N HAS BEEN SHOWN TO PREVENT UNHEALTHY BODY FAT ACCUMULATION, WHICH AIDS IN
                        MAINTAINING A
                        HEALTHY BODY WEIGHT AND REDUCING THE RISK OF OBESITY, WHILST ALLEVIATING SYMPTOMS OF TYPE II
                        DIABETES.
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="container pt-5">
                <div class="pt-2 pb-4 text-center">
                    <a href="order-here.php" class="ordernow-btn AdelleSansBold bg-darkred text-white blinking">
                        ORDER CELERGEN NOW
                    </a>
                </div>
                <div class="container padding-x col-lg-6 col-md-7 col-8 mx-auto float-none ">
                    <ul style="list-style: none" class="bullet">
                        <div class="row padding-top ">
                            <li class="benefits-text text-blue">EFFECTIVE GLUCOSE MANAGEMENT</li>
                            <li class="benefits-text text-blue">LOWERING GLYCEMIC INDEX BY 37%</li>
                            <li class="benefits-text text-blue">WEIGHT MANAGEMENT AND CONTROL</li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
