@extends('frontend.layouts.app')

@section('title', 'Home | Celergen')
@section('header', 'Home | Celergen')

@section('content')
    <!--Swiper Banner Start -->
<section>
    <div class="container-fluid px-0">
      <div class="home-slider owl-carousel owl-theme owl-loaded">
        <div class="owl-stage-outer">
          <div class="owl-stage"
            style="transform: translate3d(-8967px, 0px, 0px); transition: all; width: 14091px;">
            <div class="owl-item" style="width: 1281px;">
              <div class="item home-slide-item"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/home-slide1.jpg');">
                <div class="slide1-text-box">
                  <h2 class="h2 text-blue mb-2 mb-lg-4">The Only Non-Injectable <br>Swiss Marine Cell Therapy
                    <br>Supplement In The World </h2>
                  <a href="{{ route ('about') }}" class="a-btn blue-btn1">learn more</a>
                </div>
              </div>
            </div>
            <div class="owl-item" style="width: 1281px;">
              <div class="item home-slide-item"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/home-slide2.jpg');">
                <div class="slide2-text-box">
                  <h2 class="h2 text-white mb-2 mb-lg-4">Significantly Reduce<br>Joint Pain and Increase Mobility
                  </h2>
                  <a href="{{ route ('joinpainreduction') }}" class="a-btn blue-btn1">learn more</a>
                </div>
              </div>
            </div>
            <div class="owl-item" style="width: 1281px;">
              <div class="item home-slide-item"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/home-slide3.jpg');">
                <div class="slide3-text-box">
                  <h2 class="h2 text-blue mb-2 mb-lg-4">A Celebrity's Secret for<br>Ageless Beauty </h2>
                  <a href="{{ route ('beautyenhancement') }}" class="a-btn blue-btn1">learn more</a>
                </div>
              </div>
            </div>
            <div class="owl-item" style="width: 1281px;">
              <div class="item home-slide-item"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/home-slide4.jpg');">
                <div class="slide4-text-box">
                  <h2 class="h2 text-blue mb-2 mb-lg-4">Regain Vibrant Youth<br>Energy and Vitality</h2>
                  <a href="{{ route ('energyandvitality') }}" class="a-btn blue-btn1">learn more</a>
                </div>
              </div>
            </div>
            <div class="owl-item animated owl-animated-in fadeIn active" style="width: 1281px;">
              <div class="item home-slide-item"
                style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/home-slide5.jpg');">
                <div class="slide5-text-box text-lg-end text-center">
                  <h2 class="h2 text-blue text-center text-lg-end mb-2 mb-lg-4 fadeIn">The Transformative Power of
                    <br>Swiss Marine Cell Therapy</h2>
                  <a href="{{ route ('celergenreviews') }}" class="a-btn blue-btn1 fadeIn2">learn more</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
  <!--Swiper Banner End-->

  <!-- Product Start-->
  <section>
    <div class="container-fluid px-0 based-benefits-bg pt-4">
       <div class="col-lg-10 float-none mx-auto px-4 px-lg-0">
          <header>
             <h1 class="section-heading text-center text-blue  px-5 py-4"> EVIDENCE BASED BENEFITS </h1>
          </header>
          <div class="row pt-4 mx-0 mx-lg-auto">
             <div class="col-lg-4 col-md-6 benefits aos-init row-0" data-aos="fade-up" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_stimulates_cellular.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3  text-blue"> STIMULATES CELLULAR REJUVENATION AND REPAIR </h2>
                <p class="benefits-content mb-3 text-darkgrey "> Helps delay aging and the onset of metabolic ailments and degenerative diseases </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_reduces-joint.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3   text-blue">REDUCES JOINT &amp; MUSCLE PAIN </h2>
                <p class="benefits-content mb-3  text-darkgrey"> Proven effective for healing back, hip, and knee pain associated with osteoarthritis </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_enhances-skin.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3   text-blue"> ENHANCES SKIN COMPLEXION AND BEAUTY </h2>
                <p class="benefits-content mb-3 text-darkgrey"> Reduces the appearance of wrinkles and gives a natural glow to the skin </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-delay="150" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_boosts-energy.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3 text-blue"> BOOSTS ENERGY AND VITALITY </h2>
                <p class="benefits-content mb-3 text-darkgrey"> Noticeably reduces chronic physical and mental fatigue </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-delay="150" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_elevated-mood.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3 text-blue"> ELEVATES MOOD, ALLEVIATES MILD DEPRESSION </h2>
                <p class=" benefits-content mb-3 text-darkgrey"> Reduces anxiety and depression as well as improves sleep quality </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-delay="150" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_increases_brain.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3 text-blue">INCREASES BRAIN FUNCTION </h2>
                <p class="benefits-content mb-3 text-darkgrey"> Enhances memory, sharpens mental concentration and alertness </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500">
                <div class="benefits-icon"> <img src=" https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_improves_physical.png " alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3    text-blue"> IMPROVES PHYSICAL PERFORMANCE </h2>
                <p class="benefits-content mb-3 text-darkgrey">Enhances stamina during workouts and speeds up recovery process</p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500">
                <div class="benefits-icon"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_lowers_blood.png" alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3   text-blue"> LOWERS BLOOD SUGAR LEVELS </h2>
                <p class="benefits-content mb-3 text-darkgrey"> Reduces glycemic index by 37% </p>
             </div>
             <div class="col-lg-4 col-md-6 benefits aos-init" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500">
                <div class="benefits-icon"> <img src=" https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/ic_enhances_sexual.png " alt="">
                </div>
                <h2 class="heading AdelleSansRegular mb-3 text-blue"> ENHANCES SEXUAL PERFORMANCE </h2>
                <p class="benefits-content mb-3 text-darkgrey "> Improves libido and sexual satisfaction </p>
             </div>
          </div>
       </div>
    </div>
 </section>

  <!-- Product End-->
  <section>
    <div class="container-fluid px-0 py-5 guarded-secret-bg">
       <header>
          <h1 class="section-heading mb-3 px-2 text-white">A WELL GUARDED SECRET</h1>
          <div class="px-3 mb-lg-5 mb-4 aos-init" data-aos="fadeIn" data-duration="1000">
             <h4 class="section-subheading m-0 text-white"> CELERGEN IS EMBRACED BY WORLD RENOWNED CELEBRITIES </h4>
             <h4 class="section-subheading m-0 text-white">AND DISTINGUISHED PERSONALITIES </h4>
          </div>
       </header>
       <div class="container text-center pb-4">
          <div class="guarded-box1 bg-white box-shadow position-relative aos-init" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/guarded-secret.png" class="guarded-img" alt="" width="100%">
          </div>
          <div class="guarded-box2 bg-white box-shadow position-relative aos-init" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">
             <p class="px-4 text-darkgrey"> DISTINGUISHED PERSONALITIES FROM MORE THAN</p>
             <h4 class="section-subheading text-darkgrey mb-4"> <strong>56 COUNTRIES TAKE CELERGEN EVERY DAY </strong> </h4>
             <a href="#what-is-celergen" class="next-div position-absolute text-center w-100" style="bottom: -50px; left:0;"><img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/btn-next-div.png" alt="" width="100"> </a>
          </div>
       </div>
    </div>
 </section>

  <!--Recommend Section Start-->
  <section id="what-is-celergen">
    <div class="container-fluid px-0 what-is-celergen-bg py-3">
       <div class="container celergen-content text-center mt-3">
          <header>
             <h3 class="px-5 px-lg-0 section-heading text-darkgrey text-center"> WHAT IS CELERGEN ? </h3>
          </header>
          <div class="container px-lg-5 py-3 text-darkgrey OpenSansSerif">
             <p class=" px-lg-5 mb-4"> Celergen is a potent Non Injectable Swiss Cell Therapy Treatment that stimulates
                our own natural healing powers to trigger the repair and rejuvenation of cells
                by providing biologically active micronutrients and essential nutrition at the cellular level, boosting
                the production of proteins and enzymes. Celergen combats aging by maintaining energy and vitality and
                delaying the onset of chronic degenerative diseases.
             </p>
             <p class="px-lg-5 pb-lg-5"> Manufactured by Swiss Caps in Switzerland using Swiss Proprietary Cold Extraction Technology, Celergen
                is an enteric coated oral softgel, which ensures maximum absorption for optimal anti-aging benefits and
                results.
             </p>
          </div>
          <div class="row py-5 py-lg-5 px-4">
             <div class="col-lg-3 col-md-6 p-1 aos-init" data-aos="fade-down" data-aos-delay="100" data-aos-easing="linear" data-aos-duration="1000">
                <a href="{{ route ('about') }}#aboutbtn1" class="blue-button text-blue border-0 pt-3" width="100%">
                BIOACTIVE <br>
                INGREDIENTS </a>
             </div>
             <div class="col-lg-3 col-md-6 p-1 aos-init" data-aos="fade-down" data-aos-delay="300" data-aos-easing="linear" data-aos-duration="1000">
                <a href="{{ route ('about') }}#aboutbtn2" class="blue-button text-blue border-0 pt-3" width="100%">
                HOW <br>
                CELERGEN WORKS </a>
             </div>
             <div class="col-lg-3 p-1 col-md-6 aos-init" data-aos="fade-down" data-aos-delay="600" data-aos-easing="linear" data-aos-duration="1000">
                <a href="{{ route ('about') }}#aboutbtn3" class="blue-button text-blue border-0" width="100%">
                WHY CELERGEN? </a>
             </div>
             <div class="col-lg-3 p-1 col-md-6 aos-init" data-aos="fade-down" data-aos-delay="900" data-aos-easing="linear" data-aos-duration="1000">
                <a href="{{ route ('serumroyale') }}" class="blue-button text-blue border-0" width="100%">
                SERUM ROYALE </a>
             </div>
          </div>
          <div class="px-3">
             <h4 class="section-subheading pt-lg-5 text-darkgrey mb-5"> <strong>GLOBAL ACCREDITATION</strong> </h4>
             <div> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/global-accreditaion.png" alt="" width="778" height="98">
             </div>
             <p class="opensans pt-5 pb-5 text-darkgrey"> Celergen is not a drug but a pharmaceutical grade food supplement approved by Swiss Federal office of Public Health. </p>
          </div>
       </div>
    </div>
 </section>
  <!--Recommend Section End-->

  <!-- abouts-Secthion Start -->
  <section>
    <div class="container-fluid px-0 bg-blue py-4 ">
       <div class="container mt-2 doctors-use-celergen">
          <h4 class="m-0 text-center text-white py-3 pb-lg-4"> <span class="me-2 me-lg-5"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/celergen-quote.png" alt="" class="quatation"> </span> <span class="section-heading"> WHY DOCTORS USE CELERGEN ? </span> <span class="ms-2 ms-lg-5"> <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/celergen-quote.png" alt="" class="quatation" style="transform: rotate(180deg);"> </span></h4>
          <div class="docter-review owl-carousel owl-theme owl-loaded owl-drag aos-init" data-aos="fadeIn" data-aos-duration="1000" data-aos-delay="500">
             <div class="owl-stage-outer">
                <div class="owl-stage" style="transition: 0.25s; width: 13392px; transform: translate3d(-2232px, 0px, 0px);">
                   <div class="owl-item cloned" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/DrOrbeck-197x300-197x300-e1479285899794.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review"> "What is special about Celergen is that it is not a pharmaceutical and yet truly works on a cellular level to promote
                                  regeneration and can slow, if not reverse, the aging process."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Kenneth Orbeck
                               </p>
                               <p>
                               </p>
                               <p class="w-100 doctor-designation">- </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item cloned" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/Dr.-Rene.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> "Celergen is amazing because I look more youthful and my skin is glowing. My energy
                                  throughout the day is boosted so much that I don't need caffeine to sustain."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Rene Dell’Acqua </p>
                               <p class="w-100 doctor-designation"> Dental Studio, Palm Desert, CA </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item cloned active center" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/dr-juan-remos-e1479280710760.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> “Celergen is the best natural product that I have come across since I started practicing medicine.
                                  It is definitely the next big thing for those seeking wellbeing and good health.”
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Juan Remos </p>
                               <p class="w-100 doctor-designation"> The Wellness Institute
                               </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/DrBruceKLowellMD_3684_162.png" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review">"Celergen affects different patients in different ways. Some of my male atients reported
                                  improved libido and sexual performance. While some said it helped to reduce joint pain
                                  and give them a better night's sleep."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Bruce Lowell </p>
                               <p class="w-100 doctor-designation">-</p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/beilinA-e1479285690261.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> "I am very pleased with the outstanding benefits of Celergen my patients experience
                                  in terms of energy and stamina, mental alertness and enhanced memory."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Ghislaine Beilin </p>
                               <p class="w-100 doctor-designation"> President of European Society for Anti-Aging and Preventive Medicine </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/druziURHQ-e1479285472801.jpeg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> "Celergen is a remarkable tool that can help improve our wellbeing on multiple
                                  levels. It is the Rolls Royce of supplement for the human body."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Uzzi Reiss </p>
                               <p class="w-100 doctor-designation"> Berverly Hills Anti-Aging Centre </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/DrOrbeck-197x300-197x300-e1479285899794.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review"> "What is special about Celergen is that it is not a pharmaceutical and yet truly works on a cellular level to promote
                                  regeneration and can slow, if not reverse, the aging process."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Kenneth Orbeck
                               </p>
                               <p>
                               </p>
                               <p class="w-100 doctor-designation">- </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/Dr.-Rene.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> "Celergen is amazing because I look more youthful and my skin is glowing. My energy
                                  throughout the day is boosted so much that I don't need caffeine to sustain."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Rene Dell’Acqua </p>
                               <p class="w-100 doctor-designation"> Dental Studio, Palm Desert, CA </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/dr-juan-remos-e1479280710760.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> “Celergen is the best natural product that I have come across since I started practicing medicine.
                                  It is definitely the next big thing for those seeking wellbeing and good health.”
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Juan Remos </p>
                               <p class="w-100 doctor-designation"> The Wellness Institute
                               </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item cloned" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/DrBruceKLowellMD_3684_162.png" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review">"Celergen affects different patients in different ways. Some of my male atients reported
                                  improved libido and sexual performance. While some said it helped to reduce joint pain
                                  and give them a better night's sleep."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Bruce Lowell </p>
                               <p class="w-100 doctor-designation">-</p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item cloned" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/beilinA-e1479285690261.jpg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> "I am very pleased with the outstanding benefits of Celergen my patients experience
                                  in terms of energy and stamina, mental alertness and enhanced memory."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Ghislaine Beilin </p>
                               <p class="w-100 doctor-designation"> President of European Society for Anti-Aging and Preventive Medicine </p>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="owl-item cloned" style="width: 1116px;">
                      <div class="item">
                         <div class="row">
                            <div class="col-lg-3 px-4 py-3">
                               <img class="img-frame" src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/druziURHQ-e1479285472801.jpeg" alt="">
                            </div>
                            <div class="col-lg-9 px-4 pt-3 mt-lg-5 mt-sm-3 text-center text-lg-start">
                               <p class="doctors-review "> "Celergen is a remarkable tool that can help improve our wellbeing on multiple
                                  levels. It is the Rolls Royce of supplement for the human body."
                               </p>
                               <p class="w-100 doctor-name m-0"> Dr. Uzzi Reiss </p>
                               <p class="w-100 doctor-designation"> Berverly Hills Anti-Aging Centre </p>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="owl-nav disabled">
                <div class="owl-prev"><span aria-label="Previous">‹</span></div>
                <div class="owl-next"><span aria-label="Next">›</span></div>
             </div>

          </div>
       </div>
    </div>
 </section>
  <!-- abouts-Secthion End -->

  <!-- About Section Start-->
  <section id="customer-review">
    <div class="container-fluaid py-5">
       <div class="customer-slide owl-carousel owl-loaded owl-drag">
          <div class="owl-stage-outer">
             <div class="owl-stage" style="transform: translate3d(-1527px, 0px, 0px); transition: all; width: 6810px; padding-left: 350px; padding-right: 350px;">
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/elizabethm.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Elizabeth M, London, UK </p>
                            <p class="reviewer-job"> Champion Jockey </p>
                            <p class="review">
                               “Yes....... I have already recommended it to my friends.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#elizabeth" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/test_grace.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name">Grace Zenno, Lebanon</p>
                            <p class="reviewer-job"> Champion Jockey </p>
                            <p class="review">
                               “I am beyond happy and I vow to continue taking Celergen forever.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#grace-zenno" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/test_bisimwa.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name">Bisimwa Voglet, Belgium </p>
                            <p class="reviewer-job"></p>
                            <p class="review"> “With Celergen, I can expect a shorter recovery period to allow me to start winter training sooner that expected.” </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#bisimwa-voglet" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned active" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/maserati_dealership_main-e1479286552250.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Phil McCarroll, Australia </p>
                            <p class="reviewer-job"></p>
                            <p class="review"> “I don’t wake up in pain anymore and my knee is getting stronger.” </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#phil-mccarroll" class="text-darkred Read-btn "><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned active" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/test_hector.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name">Héctor Sánchez Torres, Mexico </p>
                            <p class="reviewer-job"></p>
                            <p class="review"> “Without Celergen, it is impossible for an ordinary man like me to accomplish extraordinary feats.” </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#hector" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/nea1.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div class="opensans">
                            <p class="reviewer-name">Nea Wasell, Finland </p>
                            <p class="reviewer-job"></p>
                            <p class="review">
                               “I feel better, I look better and I am feeling proud of myself.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#nea-wasell" class="text-darkred Read-btn">READ MORE</a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/lupita-jones2.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Lupita Jones (Miss Mexico 1990) </p>
                            <p class="reviewer-job"> Miss Universe 1991 </p>
                            <p class="review">
                               “I take Celergen every day and start my day knowing that I am doing the best to take
                               care of my health, to stay strong, full of energy.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#lupita" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/curtis-mitchell.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Curtis Mitchell (Elite Sprinter) </p>
                            <p class="reviewer-job"> IAAF World Championship 200m Bronze Medallist </p>
                            <p class="review">
                               “The first thing I noticed was that I was able to recover a lot quicker from my workouts... a
                               huge boost to my training regimen because it allows me to work harder without a drop-off in energy
                               and really take it to the next level."
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#curtis-mitchell" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/george-michael.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Michael George </p>
                            <p class="reviewer-job"> Celebrity Personal Trainer </p>
                            <p class="review">
                               “I now suggest that my clients reconsider all the supplements they take and reduce the
                               long list to only Celergen.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#michael-george" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/anthony-stephen.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Anthony Stephen </p>
                            <p class="reviewer-job"> Champion Jockey </p>
                            <p class="review">
                               “I could feel a difference the very next day. I was more alert and organised.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#anthony-stephen" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/elizabethm.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Elizabeth M, London, UK </p>
                            <p class="reviewer-job"> Champion Jockey </p>
                            <p class="review">
                               “Yes....... I have already recommended it to my friends.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#elizabeth" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/test_grace.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name">Grace Zenno, Lebanon</p>
                            <p class="reviewer-job"> Champion Jockey </p>
                            <p class="review">
                               “I am beyond happy and I vow to continue taking Celergen forever.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#grace-zenno" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/test_bisimwa.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name">Bisimwa Voglet, Belgium </p>
                            <p class="reviewer-job"></p>
                            <p class="review"> “With Celergen, I can expect a shorter recovery period to allow me to start winter training sooner that expected.” </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#bisimwa-voglet" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/maserati_dealership_main-e1479286552250.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Phil McCarroll, Australia </p>
                            <p class="reviewer-job"></p>
                            <p class="review"> “I don’t wake up in pain anymore and my knee is getting stronger.” </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#phil-mccarroll" class="text-darkred Read-btn "><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/test_hector.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name">Héctor Sánchez Torres, Mexico </p>
                            <p class="reviewer-job"></p>
                            <p class="review"> “Without Celergen, it is impossible for an ordinary man like me to accomplish extraordinary feats.” </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#hector" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/nea1.jpg');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div class="opensans">
                            <p class="reviewer-name">Nea Wasell, Finland </p>
                            <p class="reviewer-job"></p>
                            <p class="review">
                               “I feel better, I look better and I am feeling proud of myself.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#nea-wasell" class="text-darkred Read-btn">READ MORE</a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/lupita-jones2.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Lupita Jones (Miss Mexico 1990) </p>
                            <p class="reviewer-job"> Miss Universe 1991 </p>
                            <p class="review">
                               “I take Celergen every day and start my day knowing that I am doing the best to take
                               care of my health, to stay strong, full of energy.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#lupita" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/curtis-mitchell.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Curtis Mitchell (Elite Sprinter) </p>
                            <p class="reviewer-job"> IAAF World Championship 200m Bronze Medallist </p>
                            <p class="review">
                               “The first thing I noticed was that I was able to recover a lot quicker from my workouts... a
                               huge boost to my training regimen because it allows me to work harder without a drop-off in energy
                               and really take it to the next level."
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#curtis-mitchell" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/george-michael.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Michael George </p>
                            <p class="reviewer-job"> Celebrity Personal Trainer </p>
                            <p class="review">
                               “I now suggest that my clients reconsider all the supplements they take and reduce the
                               long list to only Celergen.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#michael-george" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="owl-item cloned" style="width: 275.5px; margin-right: 30px;">
                   <div class="item">
                      <div class="reviewer-pic" style="background-image: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/anthony-stephen.png');"></div>
                      <div class="reviewer-details d-flex flex-column justify-content-between">
                         <div>
                            <p class="reviewer-name"> Anthony Stephen </p>
                            <p class="reviewer-job"> Champion Jockey </p>
                            <p class="review">
                               “I could feel a difference the very next day. I was more alert and organised.”
                            </p>
                         </div>
                         <div class="p-3">
                            <a href="{{ route ('celergenreviews') }}#anthony-stephen" class="text-darkred Read-btn"><strong>READ MORE</strong></a>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="owl-nav">
             <div class="owl-prev"><a class="prev-btn" aria-hidden="true"><img src="{{ asset('/frontend/images/home/ic_left_arrow.png') }}"></a></div>
             <div class="owl-next"><a class="next-btn" aria-hidden="true"><img src="{{ asset('/frontend/images/home/ic_right_arrow.png') }}"></a></div>
          </div>
          <div class="owl-dots disabled"></div>
       </div>
    </div>
 </section>
  <!-- About Section End-->

  <!-- Saving-Secthion Start -->
  <section>
    <div class="clinical-studies container-fluid px-0 pb-5">
       <div class="container pt-3">
          <header>
             <h4 class="section-heading text-blue text-center my-4"> CLINICAL STUDIES </h4>
          </header>
          <div class="clinical-content">
             <p class="heading opensans text-center mb-5"> Celergen is the World’s only Swiss Marine Oral Cell Therapy.
                Celergen is clinically proven to enhance your body’s natural ability to heal itself.
             </p>
             <p class="heading opensans text-center pb-lg-5"> Unlike most supplements that use intense heat in the production process, Celergen is manufactured
                using our proprietary Swiss Cold Extraction Technology, which ensures that Celergen’s product integrity
                is not compromised.
             </p>
          </div>
          <div class="row py-4">
             <div class="col-12 col-lg-4 mb-2 p-lg-1 px-4">
                <div class="w-100 aos-init" data-aos="fade-up" data-aos-delay="150" data-aos-easing="linear" data-aos-duration="1000">
                   <a href="{{ route ('clinicalstudies') }}#tab1" class="clinical-button">
                   <span>BIO-DNA CELLULAR COMPLEX</span><span class="clinical-button-downarrow"></span>
                   </a>
                </div>
             </div>
             <div class="col-12 col-lg-4  mb-2 p-lg-1 px-4">
                <div class="w-100 aos-init" data-aos="fade-up" data-aos-delay="300" data-aos-easing="linear" data-aos-duration="1000">
                   <a href="{{ route ('clinicalstudies') }}#tab2" class="clinical-button">
                   <span>PEPTIDE E COLLAGEN</span><span class="clinical-button-downarrow"></span>
                   </a>
                </div>
             </div>
             <div class="col-12 col-lg-4 mb-2 p-lg-1 px-4">
                <div class="w-100 aos-init" data-aos="fade-up" data-aos-delay="450" data-aos-easing="linear" data-aos-duration="1000">
                   <a href="{{ route ('clinicalstudies') }}#tab3" class="clinical-button">
                   <span>HYDRO MN PEPTIDE</span><span class="clinical-button-downarrow"></span>
                   </a>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
  <!-- Saving-Secthion End -->

  <!-- Map-Secthion Start -->
  <section>
    <a href="#products" id="products"></a>
    <div class="container-fluid home-products-bg px-0">
       <div class="col-lg-9 col-md-12 col-12 px-4 px-lg-0 float-none mx-auto home-product-list">
          <ul class="home-product-list d-lg-flex d-block px-0 px-lg-0">
             <li id="product1" class="home-product mb-4 mb-lg-0 scale1" onmouseover="scale1()">
                <div class="d-flex flex-column justify-content-between align-items-center h-100">
                   <h3 class="mb-0 p-2 text-blue">1 SERUM ROYALE</h3>
                   <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/product1.png" style="max-width:200px;">
                   <h3 class="mb-0 pb-4 price text-grey">$270.00</h3>
                   <form action="add.php" method="post">
                      <div class="order-buttons row m-0 align-self-end w-100">
                         <div class="col-6 px-0"><a class="view-btn d-block bg-blue" href="1-serum-royale.php">VIEW ITEM</a>
                         </div>
                         <div class="col-6 px-0">
                            <input name="add1" type="submit" class="border-0 outline-none add-btn d-block bg-darkred" value="ADD TO CART">
                            <input type="hidden" name="product_id" value="1">
                            <input type="hidden" name="correct" value="return1">
                         </div>
                      </div>
                   </form>
                </div>
             </li>
             <li id="product2" class="home-product mb-4 mb-lg-0" onmouseover="scale2()">
                <div class="d-flex flex-column justify-content-between align-items-center h-100">
                   <h3 class="mb-0 p-2 text-blue">1 BOX OF CELERGEN </h3>
                   <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/product2.png" style="max-width:200px;">
                   <h3 class="mb-0 pb-4 price text-grey">$350.00</h3>
                   <form action="add.php" method="post">
                      <div class="order-buttons row m-0 align-self-end w-100">
                         <div class="col-6 px-0"><a class="view-btn d-block bg-blue" href="1-boxof-celergen.php">VIEW ITEM</a>
                         </div>
                         <div class="col-6 px-0">
                            <input name="add1" type="submit" class="border-0 outline-none add-btn d-block bg-darkred" value="ADD TO CART">
                            <input type="hidden" name="product_id" value="2">
                            <input type="hidden" name="correct" value="return1">
                         </div>
                      </div>
                   </form>
                </div>
             </li>
             <li id="product3" class="home-product mb-4 mb-lg-0" onmouseover="scale3()">
                <div class="d-flex flex-column justify-content-between align-items-center h-100">
                   <h3 class="mb-0 p-2 text-blue">1 BOX OF CELERGEN + 1 SERUM ROYALE
                   </h3>
                   <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/home/product3.png" style="max-width:200px;">
                   <h3 class="mb-0 pb-4 price text-grey">$620.00</h3>
                   <form action="add.php" method="post">
                      <div class="order-buttons row m-0 align-self-end w-100">
                         <div class="col-6 px-0"><a class="view-btn d-block bg-blue" href="1-boxof-celergen-1-serum-royale.php">VIEW ITEM</a>
                         </div>
                         <div class="col-6 px-0">
                            <input name="add1" type="submit" class="border-0 outline-none add-btn d-block bg-darkred" value="ADD TO CART">
                            <input type="hidden" name="product_id" value="3">
                            <input type="hidden" name="correct" value="return1">
                         </div>
                      </div>
                   </form>
                </div>
             </li>
          </ul>
       </div>
    </div>
 </section>
  <!-- Map-Secthion End -->
@endsection
