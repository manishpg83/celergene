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

        .top-banner {
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            width: 100%;
            height: 592px;
        }

        .top-banner-txt {
            position: absolute;
            top: 48%;
            right: 54%;
            font-size: 50px;
            line-height: 1;
        }

        .cellular-skincare {
            padding: 10px 30px 10px 40px;
            max-width: 650px;
            width: 65%;
            background: #9F9F9F;
            margin-bottom: 40px;
            border-top-right-radius: 110px;
            border-bottom-right-radius: 110px
        }

        .cellular-skincare-text {
            font-size: 22px;
            line-height: 1.7;
        }

        .bg-darkgrey {
            background-color: #bac0c6
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
                right: 53%;
                font-size: 28px;
            }

            .cellular-skincare {
                width: 95%;
            }
        }

        @media (min-width:577px) and (max-width:768px) {
            .top-banner {
                height: 323px;
            }

            .top-banner-txt {
                position: absolute;
                top: 5%;
                right: 54%;
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
                right: 54%;
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
        <div class="container-fluid px-0">
            <div class="CallunaRegular padding-x bg-blue text-white">
                <h1 class="text-white section-heading CallunaRegular border-left m-0">BEAUTY ENHANCEMENT</h1>
            </div>
            <div class="top-banner aos-init"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/celergen-benefit-beautyenhancement.jpg');"
                data-aos="fadeIn" data-aos-duration="500">
                <h1 class="top-banner-txt text-blue CallunaRegular aos-init" data-aos="fadeIn"
                    data-aos-duration="1000" data-aos-delay="500">
                    Do You Want to Look <br> Youthful and Ageless?
                </h1>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid px-0 padding-y">
            <div class="container px-lg-5">
                <p class="text-grey AdelleSan-Light-Opensans text-center px-lg-5 pb-lg-5 pb-3">
                    It is never too early or late to arrest the aging of your skin by stimulating cell renewal and repair.
                    Beauty from the inside out is crucial for sustaining and maintaining ageless beauty.
                </p>
            </div>
            <div class="container pt-lg-5">
                <h1 class="seaction-heading text-blue AdelleSansLight text-center">
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Thomas-Tzikas.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “The result varied from person to person. Many said they noticed an
                                                        improvement in their skin texture and thought they had a certain
                                                        glow they didn’t have before.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. THOMAS TZIKAS
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Eleana-Papacharalambous.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “After a month of Celergen, I noticed my skin look more radiant than
                                                        before.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. ELEANA PAPACHARALAMBOUS
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Rene.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I am amazed in the difference in my skin. It went from dull and
                                                        lifeless to radiant,
                                                        hydrated and gorgeous.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. RENE DELL’ACQUA
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Thomas-Tzikas.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “The result varied from person to person. Many said they noticed an
                                                        improvement in their skin texture and thought they had a certain
                                                        glow they didn’t have before.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. THOMAS TZIKAS
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Eleana-Papacharalambous.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “After a month of Celergen, I noticed my skin look more radiant than
                                                        before.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. ELEANA PAPACHARALAMBOUS
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Rene.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “I am amazed in the difference in my skin. It went from dull and
                                                        lifeless to radiant,
                                                        hydrated and gorgeous.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. RENE DELL’ACQUA
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
                                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/Dr.-Thomas-Tzikas.jpg"
                                                        alt="" class="imag-frame">
                                                </div>
                                                <div class="col-lg-9">
                                                    <h5
                                                        class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                                        “The result varied from person to person. Many said they noticed an
                                                        improvement in their skin texture and thought they had a certain
                                                        glow they didn’t have before.”
                                                    </h5>
                                                    <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                                        DR. THOMAS TZIKAS
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
        <div class="container-fluid px-sm-2">
            <div class="container padding px-lg-4">
                <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 lh-base">
                    CLINICAL STUDIES ON THE EFFECTIVENESS OF CELERGEN ON REDUCTION IN WRINKLES
                </h1>
                <div class="border-bottom"></div>
                <div class=" pt-lg-5 pt-3 px-lg-5">
                    <div class="row pt-lg-5 pt-5">
                        <div class="col-lg-5">
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/beauty-enchancement-diagram.png"
                                alt="" width="100%">
                        </div>
                        <div class="col-lg-7">
                            <p class=" text-grey pb-lg-4 pb-3">
                                This figure shows the effect of 2 grams/day of Peptide E Collagen given orally for 28 days
                                on
                                forearm wrinkles and crow’s feet in 43 healthy female volunteers, aged 40-55 years.
                            </p>
                            <p class="text-grey pb-lg-4 pb-3">
                                At 28 days, 71% of subjects in the Peptide E Collagen group showed a significant decrease in
                                the number
                                of deep wrinkles. The average deep wrinkle reduction was equal to 19%. On the other hand,
                                the control
                                group showed further damage to their skin in the same period with a significant increase in
                                deep wrinkles
                                by 28% in 82% of subjects.
                            </p>
                            <p class="text-grey pb-lg-4 pb-3">
                                In other words – Peptide E Collagen and Peptide M in Celergen rebuild outer skin layers from
                                the
                                inside out and make your skin toned, supple and well hydrated while also reducing lines,
                                wrinkles
                                and roughness.
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-lg-5 pt-3">
        <div class="container-fluid px-0">
            <div class="col-lg-6 col-sm-10 mx-auto float-none text-center aos-init" data-aos="fade-up"
                data-aos-delay="150" data-aos-easing="linear" data-aos-duration="1500">
                <h1 class="section-heading text-blue CallunaReguler-Opensans "> CELERGEN SERUM ROYALE</h1>
                <hr>
                <h2 class="section-subheading text-blue AdelleSan-Regular-Opensans">PERFECT MATCH TO REGAIN YOUTH</h2>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid bg-darkgrey ">
            <div class="row">
                <div class="col-lg-5 px-0">
                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/celergen-SERUM-ROYALE-BEAUTY.png"
                        alt="" width="100%">
                </div>
                <div class="col-lg-7 px-0">
                    <div class="pt-5">
                        <h2 class="text-white section-subheading lh-base CallunaReguler-Opensans cellular-skincare">
                            PAMPER YOURSELF WITH SWISS CELLULAR SKINCARE
                        </h2>
                    </div>
                    <div class="px-lg-5 px-3">
                        <h4 class="cellular-skincare-text text-blue AdelleSan-Light-Opensans">
                            CELERGEN SERUM ROYALE HELPS PREVENT MOISTURE LOSS AND TREAT INVISIBLE, DEEP SEATED INFLAMMATION,
                            REPAIRING DAMAGE BY STIMULATING TURNOVER OF SKIN CELLS AND BOOSTING COLLAGEN SYNTHESIS.
                        </h4>
                    </div>
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
                        THE SYNERGISTIC COMBINATION OF CELERGEN MARINE CELL THERAPY SUPPLEMENT, AND SERUM ROYALE
                        SKIN CARE RETARDS THE AGING PROCESS, INTERVENING AND FIGHTING AGING AT THE CELLULAR LEVEL,
                        STIMULATING SKIN REGENERATION AND ENHANCED BEAUTY, <span> WITHOUT ANY OF THE NEGATIVE CONSEQUENCES
                            OF INJECTABLE OR THE EXPENSE AND INCONVENIENCE AND DOWNTIME OF COSMETIC SURGERY.</span>
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
                <div class="container padding-x">
                    <ul style="list-style: none" class="bullet">
                        <div class="row padding-top">
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">REDUCTION IN THE APPEARANCE OF LINES AND WRINKLES</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">FIRMER SKIN TEXTURE AND ENHANCED SKIN TONE</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">TRANSFORMATIVE SKIN COMPLEXION WHICH IS FIRMER, MORE
                                    ILLUMINATING AND GLOWING</li>
                            </div>
                            <div class="col-lg-6">
                                <li class="benefits-text text-blue">RESTORE YOUTHFUL APPEARANCE</li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
