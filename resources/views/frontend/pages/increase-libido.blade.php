@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

<style>
    .top-banner {
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        width: 100%;
        height: 592px;
    }

    .top-banner-txt {
        position: absolute;
        top: 27%;
        right: 55%;
        font-size: 50px;
        line-height: 1;
    }

    .border {
        border: 5px solid #D1D2D2 !important;
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
            right: 50%;
            font-size: 28px;
        }
    }

    @media (min-width:577px) and (max-width:768px) {
        .top-banner {
            height: 323px;
        }

        .top-banner-txt {
            position: absolute;
            top: 5%;
            right: 50%;
            font-size: 38px;
        }
    }

    @media (min-width:769px) and (max-width:1024px) {
        .top-banner {
            height: 475px;
        }

        .top-banner-txt {
            position: absolute;
            top: 6%;
            right: 60%;
            font-size: 40px;
        }
    }
</style>

<section class="margin-top">
    <div class="container-fluid px-0">
       <div class="CallunaRegular padding-x bg-blue text-white">
          <h1 class="text-white section-heading CallunaRegular border-left m-0">INCREASE LIBIDO</h1>
       </div>
       <div class="top-banner aos-init" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/celergen-benefit-increase-libido.jpg');" data-aos="fadeIn" data-aos-duration="500">
          <h1 class="top-banner-txt text-blue CallunaRegular aos-init" data-aos="fadeIn" data-aos-duration="1000" data-aos-delay="500">
             Are You Suffering from <br>
             Sexual Dysfunction?
          </h1>
       </div>
    </div>
 </section>

 <section>
    <div class="container-fluid px-0 padding-y">
       <div class="container px-lg-5">
          <p class="text-grey AdelleSan-Light-Opensans text-center px-lg-5 pb-lg-5 pb-3">
             ED is often the result of diseases or conditions that become more common with age.
             It can also be a side effect of the medications used to treat them. Other age-related factors besides disease can
             also affect a man’s ability to have an erection — for example, with age, tissues become less elastic and nerve
             communication slows down.
          </p>
       </div>
       <div class="container pt-lg-5">
          <h1 class="seaction-heading text-blue AdelleSansLight text-center">
             DOCTORS' CELERGEN REVIEWS
          </h1>
          <div class="col-xl-10 col-xxl-10 text-lg-start text-center mx-auto float-none px-0">
             <div class="benefits-review owl-carousel owl-theme owl-loaded">
                <div class="owl-stage-outer">
                   <div class="owl-stage" style="transform: translate3d(-1980px, 0px, 0px); transition: all; width: 5940px;">
                      <div class="owl-item cloned" style="width: 930px; margin-right: 60px;">
                         <div class="item benefits-item">
                            <div class="item-shadow">
                               <div class="row">
                                  <div class="col-lg-3">
                                     <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/DrBruceKLowellMD_3684_162.png" alt="" class="imag-frame">
                                  </div>
                                  <div class="col-lg-9">
                                     <h5 class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                        “Some of my male patients reported improved libido and sexual performance.”
                                     </h5>
                                     <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                        DR. BRUCE LOWELL
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
                                     <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/dr-juan-remos-e1479280710760.jpg" alt="" class="imag-frame">
                                  </div>
                                  <div class="col-lg-9">
                                     <h5 class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                        “I’ve had several male patients who, having been on Celergen for a month or two, no longer see the need to take Viagra. It gives them a renewed sense of vitality across the board.”
                                     </h5>
                                     <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                        DR. JUAN REMOS
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
                                     <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/DrBruceKLowellMD_3684_162.png" alt="" class="imag-frame">
                                  </div>
                                  <div class="col-lg-9">
                                     <h5 class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                        “Some of my male patients reported improved libido and sexual performance.”
                                     </h5>
                                     <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                        DR. BRUCE LOWELL
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
                                     <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/dr-juan-remos-e1479280710760.jpg" alt="" class="imag-frame">
                                  </div>
                                  <div class="col-lg-9">
                                     <h5 class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                        “I’ve had several male patients who, having been on Celergen for a month or two, no longer see the need to take Viagra. It gives them a renewed sense of vitality across the board.”
                                     </h5>
                                     <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                        DR. JUAN REMOS
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
                                     <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/DrBruceKLowellMD_3684_162.png" alt="" class="imag-frame">
                                  </div>
                                  <div class="col-lg-9">
                                     <h5 class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                        “Some of my male patients reported improved libido and sexual performance.”
                                     </h5>
                                     <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                        DR. BRUCE LOWELL
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
                                     <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/dr-juan-remos-e1479280710760.jpg" alt="" class="imag-frame">
                                  </div>
                                  <div class="col-lg-9">
                                     <h5 class="doctors-review-energy text-blue AdelleSansRegular pb-lg-4 py-4">
                                        “I’ve had several male patients who, having been on Celergen for a month or two, no longer see the need to take Viagra. It gives them a renewed sense of vitality across the board.”
                                     </h5>
                                     <h5 class="doctors-name text-blue AdelleSansBold pt-lg-3">
                                        DR. JUAN REMOS
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
          <div class="aos-init" data-aos="fade-up" data-aos-delay="300" data-aos-easing="linear" data-aos-duration="1000">
             <h1 class="section-heading text-center text-blue CallunaRegular px-lg-5 lh-base">
                SCIENTIFIC PEER REVIEWED JOURNAL
             </h1>
             <div class="border-bottom"></div>
          </div>
          <div class="pt-5 aos-init" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
             <h5 class="text-blue text-center pt-lg-3 pt-3">REPRODUCTIVE SYSTEM &amp; SEXUAL DISORDERS: CURRENT RESEARCH</h5>
          </div>
          <div>
          </div>
       </div>
    </div>
 </section>

 <section>
    <div class="container-fluid px-0">
       <div class="container">
          <div class="col-lg-10 mx-auto float-none">
             <div class="row border p-4">
                <div class="col-lg-3 text-center">
                   <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/benefits/reviewed-journal.png" alt="" class="">
                </div>
                <div class="col-lg-9 p-0 text-lg-start text-center">
                   <h5 class="text-blue lh-base"><strong>Clinical and Laboratory Assessment of Supplementation with Marine Protein Peptides and Selected Antioxidants in Men with Mild-to-Moderate Erectile Dysfunction </strong></h5>
                </div>
             </div>
             <div class="py-5">
                <h5 class="text-blue AdelleSan-Regular-Opensans"> CONCLUSIONS: </h5>
                <p class="text-grey">
                   For the first time, marine protein peptides combined with selected antioxidants are shown to have pro-erectile
                   effects, through different mechanisms than those described previously. This oral supplementation could be
                   considered as a safe and effective alternative to anti-ED drugs in the case of mild-to-moderate ED. More
                   mechanistic studies are needed, along with larger-scale multi-centre placebo-controlled clinical trials.
                </p>
             </div>
             <div class="pt-lg-4 py-5">
                <h5 class="text-blue AdelleSan-Regular-Opensans">CELERGEN IS SAFE AND EFFECTIVE <span class="text-darkred">FOR LONG TERM USE </span></h5>
                <p class="text-grey">
                   The never ending advertisements for erectile dysfunction drugs seem to suggest that popping a pill
                   guarantees a great sex life for men dealing with this challenging problem. But a satisfying sex life takes a
                   lot more than functioning body parts, it involves energy, stamina and mood.
                </p>
             </div>
          </div>
       </div>
    </div>
 </section>



@endsection