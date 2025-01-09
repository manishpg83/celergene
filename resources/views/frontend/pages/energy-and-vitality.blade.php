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
            background-position: center center;
            background-repeat: no-repeat;
            width: 100%;
            height: 592px;
        }

        .top-banner-txt {
            position: absolute;
            top: 50%;
            text-align: right;
            right: 6%;
            font-size: 50px;
        }

        @media(min-width: 421px) and (max-width:576px) {
            .top-banner {
                height: 237px;
            }

            .top-banner-txt {
                position: absolute;
                top: 3%;
                right: 1%;
                font-size: 28px;
            }
        }

        @media (min-width:577px) and (max-width:768px) {
            .top-banner {
                height: 323px;
            }

            .top-banner-txt {
                position: absolute;
                top: 4%;
                right: 2%;
                font-size: 38px;
            }
        }

        @media (min-width:769px) and (max-width:1024px) {
            .top-banner {
                height: 475px;
            }

            .top-banner-txt {
                position: absolute;
                top: 8%;
                right: 6%;
                font-size: 41px;
            }
        }

        @media (max-width:420px) {
            .top-banner {
                height: 237px;
            }

            .top-banner-txt {
                display: none !important;
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
            <h1 class="text-white section-heading CallunaRegular border-left m-0"> ENERGY AND VITALITY </h1>
        </div>
        <div class="top-banner aos-init" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/celergen-benefit-increase-energy.jpg');" data-aos="fadeIn" data-aos-duration="500">
            <h1 class="top-banner-txt text-blue CallunaRegular aos-init" data-aos="fadeIn" data-aos-duration="1000" data-aos-delay="500">
                Are You Suffering <br>
                From Chronic Fatigue?
            </h1>
        </div>
    </div>
</section>

 <section class="shadow">
    <div class="container-fluid padding-y">
       <div class="container pb-5">
          <p class="text-grey AdelleSan-Light-Opensans text-center px-lg-5 pb-lg-5 pb-3">
             Do you feel tired most of the time and you find it extremely difficult to recover from a normal workout,
             irrespective of your age? If you find that you don’t always have the energy you once did, you are not alone.
             Lack of energy is a common complaint. And this is primarily due to lack of nutrition and essential proteins
             at the cellular level. You may be suffering from biological aging.
          </p>
          <h1 class="section-heading CallunaRegular text-blue text-center mt-lg-4">
             DOCTORS' CELERGEN REVIEWS
          </h1>
          <div class="col-lg-9 mx-auto float-none">
             <div class="row box-shadow p-4">
                <div class="col-lg-3 px-4 py-3 text-lg-start text-center">
                   <img class="imag-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/DrBruceKLowellMD_3684_162.png" alt="" width="160px" height="190px">
                </div>
                <div class="col-lg-9 px-4 pt-3 mt-sm-3 text-center text-lg-start">
                   <p class="doctors-review-energy text-blue AdelleSansRegular pb-3">
                      "Celergen affects different patients in different ways. Some of my male atients reported
                      improved libido and sexual performance. While some said it helped to reduce joint pain
                      and give them a better night's sleep."
                   </p>
                   <p class="w-100 doctors-name AdelleSansBold text-blue m-0"> Dr. Bruce Lowell </p>
                </div>
             </div>
          </div>
          <div class="pt-lg-5 pt-3 aos-init" data-aos="fadeIn" data-aos-duration="1500">
             <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 pt-lg-5 pt-3">
                CLINICAL STUDIES ON THE EFFECTIVENESS OF CELERGEN ON DECREASING FATIGUE
             </h1>
             <div class="border-bottom"></div>
             <div class="row pt-5 px-lg-5">
                <div class="col-lg-6 pt-lg-5">
                   <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/benefit-clinical-studies.png" alt="" class="" width="100%">
                </div>
                <div class="col-lg-6 pt-lg-5">
                   <p class="benefit-text text-grey  mb-lg-5">
                      This figure shows the effect of 800 mg/day of Bio-DNA Cellular Marine Complex given orally
                      for 15 days on various physical symptoms of aging. Consumption of Bio-DNA Cellular Marine Complex
                      led to significant reductions in evening tiredness, tiredness upon waking up, difficulty concentrating,
                      sleep disorders and appetite disorders.
                   </p>
                   <p class="benefit-text text-grey">
                      In other words, Bio-DNA Cellular Marine Complex significantly
                      improves physical well-being by reducing many of the unpleasant physical
                      symptoms associated with aging, chronological or biological. There’s no reason to face an energy<br>
                      shortage!
                   </p>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 <section>
    <div class="container-fluid px-0 bg-blue text-center pb-lg-5 pb-3">
       <div class="container">
          <div class="border-right px-5"></div>
          <div class="pt-3 px-lg-5">
             <h5 class="benefits-box AdelleSan-Regular-Opensans pb-lg-5 pb-3">
                CELERGEN, THE WORLD’S ONLY SWISS MARINE ORAL CELL THERAPY SUPPLEMENT, DRAMATICALLY RESTORES YOUR PHYSICAL
                WELLBEING BY <span> FIGHTING OFF EXHAUSTION </span> AND OTHER UNPLEASANT PHYSICAL SYMPTOMS OF AGING. CELERGEN STIMULATES
                SELF-HEALING AND ENERGY PRODUCTION BY <span> TRIGGERING CELLULAR REJUVENATION WITHOUT ANY NEGATIVE SIDE EFFECTS. </span>
             </h5>
          </div>
       </div>
    </div>
 </section>
 <section>
    <div class="container-fluid">
       <div class="container pt-5">
          <h1 class="section-heading text-blue text-center CallunaRegular padding aos-init" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
             THERE’S NO REASON TO FACE AN ENERGY SHORTAGE!
          </h1>
          <div class="pt-2 pb-4 text-center">
             <a href="order-here.php" class="ordernow-btn AdelleSansBold bg-darkred text-white blinking">
             ORDER CELERGEN NOW
             </a>
          </div>
          <div class="container padding-x">
             <ul style="list-style: none" class="bullet">
                <div class="row padding-top">
                   <div class="col-lg-6">
                      <li class="benefits-text text-blue">ENHANCED ENERGY LEVELS</li>
                   </div>
                   <div class="col-lg-6">
                      <li class="benefits-text text-blue">ENHANCED SLEEP QUALITY</li>
                   </div>
                   <div class="col-lg-6">
                      <li class="benefits-text text-blue">INCREASED STAMINA</li>
                   </div>
                   <div class="col-lg-6">
                      <li class="benefits-text text-blue">IMPROVED SLEEP QUALITY</li>
                   </div>
                   <div class="col-lg-6">
                      <li class="benefits-text text-blue">REDUCED STRESS AND INCREASED PHYSICAL CAPACITY</li>
                   </div>
                </div>
             </ul>
          </div>
       </div>
    </div>
 </section>
@endsection