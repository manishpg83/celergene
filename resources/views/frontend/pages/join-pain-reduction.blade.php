@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')
<style>
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

    .what-is-celergen-bg {
        padding: 60px 0px;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: left center;
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
        top: 40%;
        left: 50%;
        font-size: 50px;
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
            top: 3%;
            left: 45%;
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
            left: 45%;
            font-size: 38px;
        }
    }

    @media (min-width:769px) and (max-width:1024px) {
        .top-banner {
            height: 475px;
        }

        .top-banner-txt {
            position: absolute;
            top: 4%;
            font-size: 41px;
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
        <div class="container-fluid px-0">
            <div class="CallunaRegular padding-x bg-blue text-white">
                <h1 class="text-white section-heading CallunaRegular border-left m-0">JOINT PAIN REDUCTION</h1>
            </div>
            <div class="top-banner aos-init"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/edt2-GettyImages-542510485_medium.jpg');"
                data-aos="fadeIn" data-aos-duration="500">
                <h1 class="top-banner-txt text-blue CallunaRegular aos-init" data-aos="fadeIn"
                    data-aos-duration="1000" data-aos-delay="500">
                    Are You Suffering <br>
                    From Chronic Joint Pain?
                </h1>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid px-0 what-is-celergen-bg padding-y"
            style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/celergen_02.png');">
            <div class="container">
                <p class="text-grey AdelleSan-Light-Opensans text-center px-lg-5 pb-5 ">
                    Osteoarthritis (OA) affects tens of millions of Americans and is a leading cause of disability and
                    reduced quality of life across the globe. <br>
                    Joint pain can affect physical mobility and our daily chores and activities.
                </p>
                <div class="aos-init" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
                    <h1 class="section-heading text-darkred CallunaReguler-Opensans text-center pt-3 pb-lg-5 pb-3">
                        WHAT CAUSES JOINT PAIN ?
                    </h1>
                </div>
                <h5 class="px-lg-5">
                    <ul class="text-blue">
                        <div class="row">
                            <div class="col-lg-4 pb-3 pb-lg-0">
                                <li>OSTEOPOROSIS</li>
                            </div>
                            <div class="col-lg-4 pb-3 pb-lg-0">
                                <li>OLD INJURIES</li>
                            </div>
                            <div class="col-lg-4 pb-3 pb-lg-0">
                                <li>SIDE EFFECTS FROM LONG TERM USE OF NSAIDS OR STEROIDS</li>
                            </div>
                            <div class="col-lg-4 pb-3 pb-lg-0">
                                <li>RHEUMATOID ARTHRITIS</li>
                            </div>
                            <div class="col-lg-4 pb-3 pb-lg-0">
                                <li>AGING</li>
                            </div>
                        </div>
                    </ul>
                </h5>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid px-0 bg-blue text-center pb-lg-5 pb-3">
            <div class="container">
                <div class="border-right"></div>
                <div class="pt-3 px-lg-5">
                    <h5 class="benefits-box AdelleSan-Regular-Opensans pb-lg-5 pb-3">
                        Celergen can help you start living an active, pain-free life within weeks <span>without painkillers
                            or surgery.</span>
                        It’s a proven natural remedy to manage osteoarthritis pain effectively and naturally without any
                        negative side effects.
                    </h5>
                </div>
            </div>
        </div>
    </section>
    <section class="padding-y">
        <div class="container-fluid padding-y px-0">
            <div class="container mt-3">
                <div class="px-3">
                    <h1 class=" section-heading text-blue AdelleSansLight text-center">
                        DOCTORS' CELERGEN REVIEWS
                    </h1>
                </div>
                <div class=" col-xl-10 col-xxl-10 text-lg-start text-center mx-auto float-none px-0">
                    <div class="benefits-review owl-carousel owl-theme owl-loaded">
                        <div class="owl-stage-outer">
                            <div class="owl-stage"
                                style="transform: translate3d(-5940px, 0px, 0px); transition: 0.25s; width: 10890px;">
                                <div class="owl-item cloned" style="width: 930px; margin-right: 60px;">
                                    <div class="item benefits-item">
                                        <div class="item-shadow">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/doctor-2.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “My patient, she couldn’t straighten her fingers. In addition to the
                                                        pain, it caused her great
                                                        embarrassment.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Uzzi Reiss
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Robban-Sica.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I was plagued by chronic hip pain and I was considering hip
                                                        replacement. I started taking Celergen
                                                        daily and within a month, my hip ailments had disappeared.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Robban Sica
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Alex-Alonso.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “Three months later, a subsequent MRI found bona fide cartilage
                                                        growth in the afflicted area.
                                                        Where the cartilage had once been thinning, there was now a
                                                        substantial increase in volume.
                                                        It was remarkable.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Alex Alonso
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Michael.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “Moreover, I had a complete tear on the left knee meniscus. The
                                                        orthopaedist advised me go for surgery.
                                                        I refused. I took Celergen: and now, I have no more problems and I
                                                        will soon do a second MRI to verify
                                                        the result. I now strongly endorse this product having experienced
                                                        its effects.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Michael Klentz
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Angelo-Baccellieri.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I have been on Celergen for about three months and have suffered
                                                        chronic pain to my ankle from a fall.
                                                        Now I am walking without a limp and have decreased the pain and
                                                        stiffness. I no longer need to take
                                                        NSAIDS.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Angelo Baccellieri
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/doctor-2.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “My patient, she couldn’t straighten her fingers. In addition to the
                                                        pain, it caused her great
                                                        embarrassment.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Uzzi Reiss
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Robban-Sica.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I was plagued by chronic hip pain and I was considering hip
                                                        replacement. I started taking Celergen
                                                        daily and within a month, my hip ailments had disappeared.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Robban Sica
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Alex-Alonso.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “Three months later, a subsequent MRI found bona fide cartilage
                                                        growth in the afflicted area.
                                                        Where the cartilage had once been thinning, there was now a
                                                        substantial increase in volume.
                                                        It was remarkable.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Alex Alonso
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Michael.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “Moreover, I had a complete tear on the left knee meniscus. The
                                                        orthopaedist advised me go for surgery.
                                                        I refused. I took Celergen: and now, I have no more problems and I
                                                        will soon do a second MRI to verify
                                                        the result. I now strongly endorse this product having experienced
                                                        its effects.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Michael Klentz
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Angelo-Baccellieri.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I have been on Celergen for about three months and have suffered
                                                        chronic pain to my ankle from a fall.
                                                        Now I am walking without a limp and have decreased the pain and
                                                        stiffness. I no longer need to take
                                                        NSAIDS.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Angelo Baccellieri
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/doctor-2.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “My patient, she couldn’t straighten her fingers. In addition to the
                                                        pain, it caused her great
                                                        embarrassment.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        Dr. Uzzi Reiss
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
            <div class="container padding-y">
                <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5">
                    CLINICAL STUDIES ON THE EFFECTIVENESS OF CELERGEN ON JOINT PAIN REDUCTION
                </h1>
                <div class="border-bottom"></div>
                <div class="padding-x pt-5">
                    <div class="row pt-5">
                        <div class="col-lg-6">
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/join-pain-reduction-left.png"
                                alt="" class="" widht="100%">
                        </div>
                        <div class="col-lg-6">
                            <p class="text-grey pt-3 lh-base">
                                This figure shows the effects of 200 mg/day of Bio-DNA Cellular Marine Complex given orally
                                for 30 days for 2,960
                                clinical subjects with an average age of 61 years. About 21% of the subjects reported
                                complete relief of their joint
                                pain and 83.6% reported significant physical improvement.
                            </p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/join-pain-reduction-right.png"
                            alt="" class="col-lg-6 float-lg-end mb-3 ms-md-3" width="527px" height="498px">
                        <p class="text-grey pt-lg-4 pt-3 lh-lg">
                            This figure shows the effects of 200 mg/day of Bio-DNA Cellular Marine Complex (Bio-DNA CMC)
                            given orally for
                            21 days and 42 days respectively, on self-reported knee and hip pain associated with
                            osteoarthritis in 67 invalids.
                            The effects of Diclofenac, a painkilling non-steroidal anti-inflammatory drug (NSAID) is also
                            provided for comparison.
                        </p>
                        <p class="text-grey pt-lg-4 pt-3  lh-lg">
                            At 21 days, just under 15% of invalids treated with Bio-DNA CMC reported significantly less knee
                            and hip pain,
                            compared to just over 25% for Diclofenac. At 42 days, nearly 40% of invalids reported a
                            significant reduction in
                            their knee and hip pain with Bio-DNA CMC, relative to 35% with Diclofenac.
                        </p>
                        <p class="text-grey pt-lg-4 pt-3 lh-lg">
                            In other words, Bio-DNA CMC is as or more effective than Diclofenac after 6 weeks of treatment
                            in managing arthritis
                            pain – without any of Diclofenac’s side effects.
                        </p>
                        <p class="text-grey pt-lg-4 pt-3  lh-lg">
                            While we are fairly good at acute pain management, many chronic pain conditions such as OA, low
                            back pain, and others
                            are harder to treat effectively. Many researchers in the field believe that a multidisciplinary
                            team
                            (which includes health care providers with different backgrounds) working together to use a
                            number of
                            different approaches to manage pain offers the most effective way of managing chronic pain.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid pt-lg-5">
            <div class="container">
                <div class="aos-init" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
                    <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 pt-5 lh-base">
                        DON’T LET JOINT PAIN DEPRIVED YOU OF AN<br>ACTIVE LIFESTYLE
                    </h1>
                </div>
                <div class="pt-4 pb-4 text-center">
                    <a href="order-here.php" class="ordernow-btn AdelleSansBold bg-darkred text-white">ORDER CELERGEN
                        NOW</a>
                </div>
                <div class="container padding-x">
                    <ul style="list-style: none" class="bullet">
                        <div class="row padding-top">
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue"> PAIN FREE LIFE WITH IMPROVED PHYSICAL AND JOINT
                                    MOBILITY </li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue"> SLOWS DOWN CARTILAGE DESTRUCTION IN JOINTS, ALONG WITH
                                    REDUCING JOINT PAIN AND INFLAMMATION</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">LESS DEPENDENCE ON PAINKILLERS AND NAAIDS WHICH HAS
                                    LONG TERM SIDE EFFECTS</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">REBUILDS CARTILAGE AND OTHER JOINT STRUCTURES</li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
