@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')


    <style>
        .Roboto {
            font-family: 'Roboto', sans-serif;
        }

        .reviews-padding {
            padding-top: 80px;
            padding-right: 100px;
            padding-left: 175px;
            padding-bottom: 50px
        }

        .strg {
            font-weight: 700;
        }

        .bottom-shadow:after {
            content: '';
            background: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/bottom-shadow.png');
            position: absolute;
            bottom: 0px;
            width: 100%;
            height: 49px;
            left: 0px;
        }

        .customers-box {
            box-shadow: 0px 0px 10px rgba(19, 19, 19, 0.48);
        }

        .customer {
            padding-top: 50px;
            padding-left: 50px
        }

        .customer-review {
            padding-right: 50px;
            padding-left: 20px;
        }

        .customer-item {
            border-bottom: 1px solid #D2D2D2;
            padding: 0px 30px;
            margin-top: 50px;
        }

        .boder-blue {
            border-bottom: 10px solid #00355f;
            width: 75px;
        }

        .doctors-review {
            padding-top: 70px;
            padding-right: 40px;
            padding-left: 40px;
            padding-bottom: 50px;
            box-shadow: 0px 0px 10px rgba(19, 19, 19, 0.48);
        }

        #Doctors {
            position: relative;
            margin-bottom: 75px;
        }

        .doctors-img {
            width: 50%;
            height: 50%;
            box-shadow: 15px 15px 0px 1px #00355F;
        }

        .doct-name {
            font-size: 25px;
        }

        .doct-desing {
            font-size: 15px;
        }

        .doctors-review::after {
            background: url('https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/shadow-arrow-slick.png');
            content: '';
            width: 84px;
            height: 38px;
            position: absolute;
            bottom: -38px;
            left: 50%;
            margin-left: -42px
        }

        .review-tabs .nav-link {
            background-color: #dfdfdf;
            border-radius: 0;
            letter-spacing: 2px;
            font-size: 14px;
        }

        .review-tabs .nav-link.active {
            background-color: #00355f !important;
            color: #ffffff !important;
        }

        @media (max-width: 768px) {
            .reviews-padding {
                padding: 50px 30px 30px !important;
            }

            .reviews-txt {
                font-size: 16px;
            }

            .doct-name {
                font-size: 18px;
            }

            .customer-review {
                padding: 0px 30px 20px 30px !important;
            }

            .customer-item {
                padding: 0px;
                margin-top: 30px;
            }

        }

        @media (max-width: 1024px) and (min-width: 768px) {
            .doct-name {
                font-size: 18px
            }

            .doctors-review {
                padding: 35px 20px 25px;
            }
        }
    </style>

    <section>
        <div class="container-fluid px-0 position-relative bottom-shadow">
            <div class="CallunaRegular padding-x bg-blue text-white">
                <h1 class="text-white section-heading CallunaRegular border-left m-0"> CELERGEN REVIEWS </h1>
            </div>
            <div class="reviews-padding">
                <h5 class="text-blue AdelleSansRegular strg mb-lg-4 mb-4 reviews-txt"> CUSTOMERS FROM MORE THAN 56 COUNTRIES
                    HAVE BENEFITED FROM CELERGEN. </h5>
                <h6 class="text-grey  opensans fst-italic m-0 reviews-txt"> All of the Celergen Reviews on this website
                    reflect the honest opinions of the doctors and consumers
                    and are non-paid reviews. All the doctors and customers listed do not have any financial interest in
                    Celergen.
                </h6>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid padding-x bg-lightgrey d-lg-block d-none">
            <div class="row">
                <div class="col-lg-8">
                    <div class="customers-box bg-white">
                        <h1 class="section-heading text-blue CallunaReguler-Opensans customer strg"> CUSTOMERS’ REVIEWS
                        </h1>
                        <a name="lupita"></a>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Lupita Jones (Miss Mexico 1990) </h5>
                                        <h5 class="text-blue AdelleSansRegular"> Miss Universe 1991 </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “I take Celergen every day and start my day knowing that I am doing the best to
                                            take care of my
                                            health, to stay strong, full of energy.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/lupita-jones2.png"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        I’ve lead a very hectic and non-stop life since I became Miss Universe in 1991. I
                                        live in one of the biggest
                                        and most complicated cities in the world, Mexico City I’m a public figure and
                                        executive of one of the biggest
                                        communications companies in the world. I travel all the time and I’m always in
                                        interviews, meetings, photo shoots.
                                        I’m a mother, writer, spokesperson for different causes, and of course I have a
                                        personal life too.I take Celergen
                                        every day and start my day knowing that I am doing the best to take care of my
                                        health, to stay strong, full of energy
                                        and with a great attitude to continue with my “non-stop life”.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <a name="curtis-mitchell">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Curtis Mitchell (Elite Sprinter) </h5>
                                            <h5 class="text-blue AdelleSansRegular"> IAAF World Championship 200m Bronze
                                                Medallist </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “The first thing I noticed was that I was able to recover a lot quicker from
                                                my workouts... a huge boost to my
                                                training regimen because it allows me to work harder without a drop-off in
                                                energy and really take it to the
                                                next level."
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/curtis-mitchell.png"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            I’m feeling good no matter where I am or what I’ve had to go through to get
                                            there. But it’s not
                                            just a matter of physical strength and endurance.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="michael-george">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Michael George </h5>
                                            <h5 class="text-blue AdelleSansRegular"> Celebrity Personal Trainer </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “I now suggest that my clients reconsider all the supplements they take and
                                                reduce the long list to only Celergen.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/george-michael.png"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            At my age, I had grown accustomed to having to mix up my workout regimen to
                                            allow for recovery
                                            from one day to the next as I am more than 50. Now I can do a full-blown
                                            hour-long workout,
                                            come back the next day and do it all over again. Celergen has me believing that
                                            I’m a 20-year-old
                                            in terms of my libido. It has definitely increased my performance. It is really
                                            the only product
                                            out there that is capable of addressing a multitude of areas.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="anthony-stephen">
                            <div class="customer-review">
                                <div class="customer-item ">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Anthony Stephen </h5>
                                            <h5 class="text-blue AdelleSansRegular"> Champion Jockey </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “I could feel a difference the very next day. I was more alert and
                                                organised.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/anthony-stephen.png"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            Being a jockey means you have to stay alert at all times and be able to make
                                            split-second
                                            decisions on the race track. Celergen has made me better at what I do. Now at
                                            the end of the day,
                                            instead of coming home, crashing on the couch and being exhausted, I’ve got
                                            plenty of energy to do
                                            other things I want.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="elizabeth">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Elizabeth M, London, UK </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “Yes....... I have already recommended it to my friends.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/elizabethm.jpg"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            I am in my mid-fifties and a busy art dealer based in Central London, I had
                                            heard of the benefits
                                            of Celergen from an American business woman and bought one month’s supply to
                                            try. Today, I
                                            can’timagine being without it, my energy level is great, I wake more ready to
                                            face the daily
                                            challenges and since taking Celergen, I feel that the arthritis on my thumb
                                            joints are less painful.
                                            Just one more thing, my hairdresser tells me that I have lots of new hair growth
                                            on my head.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="grace-zenno"></a>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Grace Zenno, Lebanon </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “I am beyond happy and I vow to continue taking Celergen forever.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_grace.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        Prior to my Celergen days, people around me used to think that I am more than 30
                                        years old. It was
                                        very distressing. However after taking Celergen for just 1 week, I experienced a
                                        tremendous increase
                                        in energy, a smoother complexion and an elevation of my moods. What delighted me
                                        most is that people
                                        started to compliment my radiant complexion and I was mistaken to be only 24 years
                                        old.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <a name="bisimwa-voglet">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Bisimwa Voglet, Belgium </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “With Celergen, I can expect a shorter recovery period to allow me to start
                                                winter training
                                                sooner that expected.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_bisimwa.jpg"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            I started Celergen 15 days after the Brussels’ marathon. The use of Celergen has
                                            absolutely
                                            shortened my recovery period and allowed me to start winter training sooner than
                                            expected.
                                            Besides my running activities, I also practice mountaineering ski and I expect
                                            to take benefit
                                            from Celergen in the next few weeks in the French Alps. As a lawyer, I can also
                                            state that I have
                                            increased my intellectual productivity to work longer hours and have better
                                            quality sleep.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="phil-mccarroll">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Phil McCarroll, Australia </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “I don’t wake up in pain anymore and my knee is getting stronger.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/maserati_dealership_main-e1479286552250.jpg"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            My son read about it in The Robb report whilst we were skiing at Silver Star in
                                            Canada at
                                            Christmas 2013, so I ordered it to be ready for me when I returned to Australia
                                            late January 2014.
                                            I was experiencing hip and knee pain, meaning among other things I couldn’t walk
                                            the Golf Course.
                                            The hip pain was the result of a bicycle accident whilst riding behind The Tour
                                            de France in 2010,
                                            causing me to have restricted movement and wake up at nights in pain. The knee
                                            was from meniscus
                                            problems that the Doctors said was caused by my age (I am 65), wear and tear and
                                            I’d have to live
                                            with it. Well the great news is I walked the 18 holes of golf last weekend with
                                            no pain or restricted
                                            movement, I don’t wake up in pain from my hip anymore and my knee is getting
                                            stronger each day.
                                            That’ after only 6 weeks, so fingers crossed these early, amazing results will
                                            continue.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="hector">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Héctor Sánchez Torres, Mexico </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “Without Celergen, it is impossible for an ordinary man like me to
                                                accomplish extraordinary
                                                feats.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_hector.jpg"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            As an inspirational mountain climber, I face many physical and mental
                                            challenges. Ever since I have taken Celergen,
                                            I was amazed by the recovery I experience after a formidable expedition. A
                                            mountain climbing expedition usually takes
                                            40 to 70 days. It is easy to feel depressed and exhausted. With Celergen, I am
                                            always positive and mentally alert compared
                                            to my team mates.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a name="nea-wasell">
                            <div class="customer-review">
                                <div class="customer-item">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="text-blue AdelleSansBold"> Nea Wasell, Finland </h5>
                                            <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                                “I feel better, I look better and I am feeling proud of myself.”
                                            </p>
                                            <div class="boder-blue"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/nea1.jpg"
                                                alt="" class="" width="100%">
                                        </div>
                                    </div>
                                    <div class="my-lg-5 ">
                                        <p class="text-grey lh-lg">
                                            During the past ten years I have noticed how my body is getting older. I mean
                                            all the pain and aches
                                            you get when you train and move. It also began to disturb my mental health.
                                            Because of this I
                                            tried many different pills, vitamins etc. Nothing helped. Finally I visited a
                                            doctor last spring
                                            and guess what? I was prescribed stronger painkillers! I have rheumatoid
                                            arthritis and detritions
                                            in my spine. I have taken Celergen now for more than 26 days. When I get up in
                                            the morning after a
                                            good night’s sleep, I feel great because I do not feel any pain. I can be active
                                            all day long without
                                            feeling tired. I can stand with my high heels for hours and walk till the next
                                            day. I can use my
                                            right hand all day long — without enormous pain on my neck and shoulder. My
                                            waist is smaller and
                                            my breasts seem firmer.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Dion Friedland 69, USA </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            I have been using Celergen for the past year. I feel it played a significant
                                            part in my fast
                                            recovery from a major surgery in June, 2011. Six months after my surgery, I was
                                            in sufficiently
                                            good shape to compete in the World Masters Body Building Championships in Spain
                                            where
                                            I represented South Africa.
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/12558427_1798007863760089_2089721837_n-e1479289427813.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        I have been using Celergen for the past year. I feel it played a significant part in
                                        my fast
                                        recovery from a major surgery in June, 2011. Six months after my surgery, I was in
                                        sufficiently
                                        good shape to compete in the World Masters Body Building Championships in Spain
                                        where I represented
                                        South Africa.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Shaun Keating, USA </h5>
                                        <h5 class="text-blue AdelleSansRegular"> Founder of Keating Dental Arts </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “Every day I seem to notice a new benefit.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/P1100930-e1479286822673.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        I used to have acne scars from my teenage years; they’ve gone away. I used to have
                                        heartburn; not
                                        anymore. I used to suffer from insomnia; now I fall asleep like a baby. Celergen is
                                        like the gift
                                        that keeps on giving.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Suha Yenigul, Turkey </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “Celergen is the reason for my improved libido... I can last longer than
                                            normal.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/photo-e1479287228733.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        After a mere 3 days of using Celergen, I feel an enormous surge in energy, my sleep
                                        quality
                                        improved as well. My overall energy and performance levels seem to last longer than
                                        normal.
                                        My girlfriend even complimented me about my improved skin and complexion. I feel
                                        great!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Rie Loo, Japan </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “My skin looks brighter and my pores… less visible.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/testimonial-rie-loo.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        For the first 2-3 weeks, I didn’t find any special change in me maybe because I have
                                        always been
                                        in relatively good condition. But one morning, I found that my skin texture has
                                        become smoother,
                                        brighter and my pores less visible.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Wang Furong, China </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “I never expect Celergen’s benefits to manifest so quickly and with such
                                            potency.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_wang.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        After only 15 days of Celergen, I am able to sleep better and wake up feeling a lot
                                        fresher and more
                                        energized than ever before. The dizzy spells I used to experience have left me and
                                        as a result now,
                                        I am more efficient and effective at work. Most importantly, Celergen helps to
                                        reduce the pain which
                                        I had experienced in my neck and back significantly.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Kim Young Ho, Korea </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “Even though I am only young, Celergen is the perfect Anti-Aging Food Supplement
                                            because it invigorates me at work.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_kim.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        For the first 2 weeks, I did not find any special change in me except that I was
                                        perspiring more
                                        often than before. After continued consumption of Celergen, I wake up feeling more
                                        refreshed and
                                        invigorated. I am also pleased to find that I recovered much faster after my evening
                                        exercises.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review pb-lg-5">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Dr. Keren Priyadarshini, India </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-lg-2 ">
                                            “Celergen… is a supplement that has multi-faceted advantages.”
                                        </p>
                                        <div class="boder-blue"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_drkeren.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-lg-5 ">
                                    <p class="text-grey lh-lg">
                                        Having taken Celergen for just over 10 days, I must say that it is a supplement that
                                        has
                                        multi-faceted advantages. I had to conduct interviews non-stop for 8 hrs a day, 3
                                        days consecutively,
                                        and never did I feel an iota of fatigue while taking Celergen. The following morning
                                        is always bright
                                        and fresh with no hangover of the previous day. Celergen is quite effective in
                                        helping my body cope
                                        with the daily vagaries of life keeping my energy levels at an optimum high!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 ps-lg-5">
                    <h1 class="section-heading text-blue CallunaReguler-Opensans strg customer pb-lg-5">
                        DOCTORS’ REVIEWS
                    </h1>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Rene.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. RENE DELL’ACQUA </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Dell’Acqua Dental Studio </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I am amazed in the difference in my skin. It went from dull and lifeless to radiant, hydrated
                            and gorgeous.
                            I am sleeping much better and my energy throughout the day has dramatically improved. Celergen
                            proves over and
                            over again to be the most incredible supplement I have ever used.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Michael.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. MICHAEL KLENTZ </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Germany </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “No surgery. Celergen heals the tear on my left knee meniscus. Celergen really works wonders, by
                            directly
                            affecting the immune system, regenerating, rejuvenating, reducing inflammation and creating a
                            more youthful
                            looking, energetic personality."
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Michael-Hall.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. MICHAEL HALL </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Hall Longevity Clinic </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “There is definitely a regenerative component to Celergen. I noticed almost immediately that my
                            skin is softer
                            and more elastic, and my hair is fuller. I now recommend to my patients without reservations and
                            have heard
                            countless stories about how Celergen has improved their lives.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/DrBruceKLowellMD_3684_162.png"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR BRUCE LOWELL </h5>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “ Celergen affects different patients in different ways. Some of my male patients reported
                            improved libido
                            and sexual performance. While some said it helped to reduce joint pain and give them a better
                            night’s sleep.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Yanis.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. YANIS DATSERIS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> OMMA Eye Institute of Athens </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen fills me with endless energy and an intense desire for life. Every day, as soon as I
                            wake up, I
                            start my day with a Celergen tablet/capsule. I have no doubt, whatsoever, that my new found
                            energy and my
                            ultra-positive attitude towards life are the most precious gifts, offered by Celergen.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Karla-Groves.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. KARLA GROVES </h5>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I started taking Celergen two months ago and my skin has never looked better! The dark circles
                            and volume
                            loss are dramatically improved! I’ve also noted significant improvement in my energy level and
                            ability to
                            concentrate. I no longer have headaches or allergy symptoms.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Terry-Grossman.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. TERRY GROSSMAN</h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Grossman Medical Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Friends I haven’t seen in a year or so would comment; ‘You look great, so much younger. Did you
                            have laser
                            surgery or something?’ The only thing that had changed in my daily regimen was the addition of
                            Celergen so I
                            had to attribute it to that.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Stephen-Pfeifer.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. STEPHEN PFEIFER </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Integrative Wellness Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I can’t even begin to tell you how excited I am about the cumulative benefits that will occur
                            over time for
                            our patients who are taking Celergen. It’s reducing inflammation and getting rid of everything
                            from insomnia
                            to muscle pain and fatigue.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-David-Minkoff.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. DAVID MINKOFF </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Lifeworks Wellness Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “My patient who is suffering from Parkinson told me that taking Celergen is like injecting fuel
                            in her veins.
                            Her energy levels was so significantly increased that she was not taking her Parkinson’s
                            medication because she
                            felt so good.
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Thomas-Tzikas.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. THOMAS TZIKAS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Tzikas Facial Plastic Surgery Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “After taking Celergen on a daily basis, I began noticing that tiredness was no longer an issue
                            after a
                            day’s work. It helped me push myself a little more and be more effective in my daily routine. I
                            experienced
                            fewer joint and muscle aches. Plus I didn’t have a craving for sweets that I sometime have and
                            lost a little
                            weight that needed losing. I hadn’t changed anything else in my diet or taken other supplements,
                            so I can only
                            attribute the change to Celergen.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Michael-Hytros.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. MICHAEL HYTROS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> The Anti-Aging and Bariatric Clinic </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I sleep much better now and wake up with renewed energy. I believe Celergen is the best natural
                            supplement
                            enhancing the quality of life.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Donovan-Christie.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. DONOVAN CHRISTIE </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Anwan Medical Wellness Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “There is an urgent need to get away from being prescription drug-dependent and focus more on
                            the root
                            causes of disease by getting people to commit to a wellness lifestyle. I’m very impressed how
                            Celergen
                            benefits patients afflicted with arthritis, chronic pain, and fatigue. One middle-aged gentleman
                            came
                            to us suffering from so much chronic fatigue that it was everything he could do just to leave
                            the house."
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Angelo-Baccellieri.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. ANGELO BACCELLIERI </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Westchester Wellness Medicine </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I have been on Celergen for about three months and have suffered chronic pain to my ankle from
                            a fall.
                            Now I am walking without a limp and have decreased the pain and stiffness. I no longer need to
                            take NSAIDS
                            or painkillers.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Sharon-Norling.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. SHARON NORLING </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Conventional and Natural Medicine </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I don’t believe in prescribing mood altering drugs. So when a natural therapy like Celergen
                            comes along,
                            it’s a huge gift. There are no apparent side effects, and it can help people live their best
                            possible lives.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Kenneth-Orbeck.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. KENNETH ORBECK </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Body logic MD </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “My patients come in complaining about knee pain or joint swelling. After a short regime of
                            Celergen, the
                            pain often disappears altogether and the afflicted area shows improved range of motion and
                            strength.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/druziURHQ-e1479285472801.jpeg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. UZZI REISS</h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Beverly Hills Anti-Aging Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen is a remarkable tool that can help improve our wellbeing on multiple levels. It is the
                            Rolls Royce of
                            supplement for the human body.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Ghislaine-Beilin.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. GHISLAINE BEILIN, PLASTIC SURGEON </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> President of European Society Anti-Aging
                                and Preventive Medicine </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen is amazing and incredible because it enhances our cell renewal and repair process as
                            if we had
                            hormone treatments. This significant energy boost is very similar to the administration of
                            growth hormones
                            and anabolic hormones. Also, the thyroid levels for my patients have improved significantly. I’m
                            very surprised
                            that with Celergen, the overall hormonal balance is maintained at an improved, optimal level.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Juan-Remos.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. JUAN REMOS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Wellness Institute of the Americas </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I’ve had several male patients who, having been on Celergen for a month or two, no longer see
                            the need to take
                            Viagra. It gives them a renewed sense of vitality across the board.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Eleana-Papacharalambous.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. ELEANA PAPACHARALAMBOUS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Orthobiotiki </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “After 4 days of Celergen, I can proudly proclaim that I felt more energetic, had a better
                            quality of sleep and
                            woke up feeling invigorated. After a month of Celergen, I noticed my skin looking more radiant
                            than before.
                            Another benefit that took me by surprise was the fact that I stopped feeling dizzy whenever I
                            felt tired.
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. GLEN GUILLET </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> Anti-Aging Cell Therapy of Texas </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “At 74, after bypass surgery, I figured things might never get better. Enter Celergen! I no
                            longer wear a back
                            brace, I work 14 hours a day, and I never complain of being tired.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/dr-juan-remos-e1479280710760.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-lg-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. JUAN REMOS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular"> The Wellness Institute </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen is the best natural product that I have come across since I started practicing
                            medicine.
                            It is definitely the next big thing for those seeking wellbeing and good health.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="review-tabs d-lg-none d-block">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active Roboto strg border-0 text-black lh-1" id="home-tab"
                        data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab"
                        aria-controls="home-tab-pane" aria-selected="true"> CUSTOMERS’ REVIEWS </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link Roboto strg border-0 text-black px-5 lh-1" id="profile-tab"
                        data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">DOCTORS’ REVIEWS</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <div class="bg-white">
                        <div class="customer-review" id="lupita-jones">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Lupita Jones (Miss Mexico 1990) </h5>
                                        <h5 class="text-blue AdelleSansRegular"> Miss Universe 1991 </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “I take Celergen every day and start my day knowing that I am doing the best to
                                            take care of my
                                            health, to stay strong, full of energy.”
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/lupita-jones2.png"
                                        alt="" class="pb-2" width="100%">
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        I’ve lead a very hectic and non-stop life since I became Miss Universe in 1991. I
                                        live in one of the biggest
                                        and most complicated cities in the world, Mexico City I’m a public figure and
                                        executive of one of the biggest
                                        communications companies in the world. I travel all the time and I’m always in
                                        interviews, meetings, photo shoots.
                                        I’m a mother, writer, spokesperson for different causes, and of course I have a
                                        personal life too.I take Celergen
                                        every day and start my day knowing that I am doing the best to take care of my
                                        health, to stay strong, full of energy
                                        and with a great attitude to continue with my “non-stop life”.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Curtis Mitchell (Elite Sprinter) </h5>
                                        <h5 class="text-blue AdelleSansRegular"> IAAF World Championship 200m Bronze
                                            Medallist </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “The first thing I noticed was that I was able to recover a lot quicker from my
                                            workouts... a huge boost to my
                                            training regimen because it allows me to work harder without a drop-off in
                                            energy and really take it to the
                                            next level."
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/curtis-mitchell.png"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        I’m feeling good no matter where I am or what I’ve had to go through to get there.
                                        But it’s not
                                        just a matter of physical strength and endurance.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Michael George </h5>
                                        <h5 class="text-blue AdelleSansRegular"> Celebrity Personal Trainer </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “I now suggest that my clients reconsider all the supplements they take and
                                            reduce the long list to only
                                            Celergen.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/george-michael.png"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        At my age, I had grown accustomed to having to mix up my workout regimen to allow
                                        for recovery
                                        from one day to the next as I am more than 50. Now I can do a full-blown hour-long
                                        workout,
                                        come back the next day and do it all over again. Celergen has me believing that I’m
                                        a 20-year-old
                                        in terms of my libido. It has definitely increased my performance. It is really the
                                        only product
                                        out there that is capable of addressing a multitude of areas.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review" id="anthony-stephan">
                            <div class="customer-item ">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Anthony Stephen </h5>
                                        <h5 class="text-blue AdelleSansRegular"> Champion Jockey </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “I could feel a difference the very next day. I was more alert and organised.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/anthony-stephen.png"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        Being a jockey means you have to stay alert at all times and be able to make
                                        split-second
                                        decisions on the race track. Celergen has made me better at what I do. Now at the
                                        end of the day,
                                        instead of coming home, crashing on the couch and being exhausted, I’ve got plenty
                                        of energy to do
                                        other things I want.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Elizabeth M, London, UK </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-2 ">
                                            “Yes....... I have already recommended it to my friends.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/elizabethm.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        I am in my mid-fifties and a busy art dealer based in Central London, I had heard of
                                        the benefits
                                        of Celergen from an American business woman and bought one month’s supply to try.
                                        Today, I
                                        can’timagine being without it, my energy level is great, I wake more ready to face
                                        the daily
                                        challenges and since taking Celergen, I feel that the arthritis on my thumb joints
                                        are less painful.
                                        Just one more thing, my hairdresser tells me that I have lots of new hair growth on
                                        my head.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Grace Zenno, Lebanon </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-2 ">
                                            “I am beyond happy and I vow to continue taking Celergen forever.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_grace.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        Prior to my Celergen days, people around me used to think that I am more than 30
                                        years old. It was
                                        very distressing. However after taking Celergen for just 1 week, I experienced a
                                        tremendous increase
                                        in energy, a smoother complexion and an elevation of my moods. What delighted me
                                        most is that people
                                        started to compliment my radiant complexion and I was mistaken to be only 24 years
                                        old.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Bisimwa Voglet, Belgium </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-2 ">
                                            “With Celergen, I can expect a shorter recovery period to allow me to start
                                            winter training
                                            sooner that expected.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_bisimwa.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        I started Celergen 15 days after the Brussels’ marathon. The use of Celergen has
                                        absolutely
                                        shortened my recovery period and allowed me to start winter training sooner than
                                        expected.
                                        Besides my running activities, I also practice mountaineering ski and I expect to
                                        take benefit
                                        from Celergen in the next few weeks in the French Alps. As a lawyer, I can also
                                        state that I have
                                        increased my intellectual productivity to work longer hours and have better quality
                                        sleep.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Phil McCarroll, Australia </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “I don’t wake up in pain anymore and my knee is getting stronger.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/maserati_dealership_main-e1479286552250.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        My son read about it in The Robb report whilst we were skiing at Silver Star in
                                        Canada at
                                        Christmas 2013, so I ordered it to be ready for me when I returned to Australia late
                                        January 2014.
                                        I was experiencing hip and knee pain, meaning among other things I couldn’t walk the
                                        Golf Course.
                                        The hip pain was the result of a bicycle accident whilst riding behind The Tour de
                                        France in 2010,
                                        causing me to have restricted movement and wake up at nights in pain. The knee was
                                        from meniscus
                                        problems that the Doctors said was caused by my age (I am 65), wear and tear and I’d
                                        have to live
                                        with it. Well the great news is I walked the 18 holes of golf last weekend with no
                                        pain or restricted
                                        movement, I don’t wake up in pain from my hip anymore and my knee is getting
                                        stronger each day.
                                        That’ after only 6 weeks, so fingers crossed these early, amazing results will
                                        continue.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Héctor Sánchez Torres, Mexico </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “Without Celergen, it is impossible for an ordinary man like me to accomplish
                                            extraordinary
                                            feats.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_hector.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        As an inspirational mountain climber, I face many physical and mental challenges.
                                        Ever since I have taken Celergen,
                                        I was amazed by the recovery I experience after a formidable expedition. A mountain
                                        climbing expedition usually takes
                                        40 to 70 days. It is easy to feel depressed and exhausted. With Celergen, I am
                                        always positive and mentally alert compared
                                        to my team mates.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Nea Wasell, Finland </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “I feel better, I look better and I am feeling proud of myself.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/nea1.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        During the past ten years I have noticed how my body is getting older. I mean all
                                        the pain and aches
                                        you get when you train and move. It also began to disturb my mental health. Because
                                        of this I
                                        tried many different pills, vitamins etc. Nothing helped. Finally I visited a doctor
                                        last spring
                                        and guess what? I was prescribed stronger painkillers! I have rheumatoid arthritis
                                        and detritions
                                        in my spine. I have taken Celergen now for more than 26 days. When I get up in the
                                        morning after a
                                        good night’s sleep, I feel great because I do not feel any pain. I can be active all
                                        day long without
                                        feeling tired. I can stand with my high heels for hours and walk till the next day.
                                        I can use my
                                        right hand all day long — without enormous pain on my neck and shoulder. My waist is
                                        smaller and
                                        my breasts seem firmer.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Dion Friedland 69, USA </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            I have been using Celergen for the past year. I feel it played a significant
                                            part in my fast
                                            recovery from a major surgery in June, 2011. Six months after my surgery, I was
                                            in sufficiently
                                            good shape to compete in the World Masters Body Building Championships in Spain
                                            where
                                            I represented South Africa.
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/12558427_1798007863760089_2089721837_n-e1479289427813.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        I have been using Celergen for the past year. I feel it played a significant part in
                                        my fast
                                        recovery from a major surgery in June, 2011. Six months after my surgery, I was in
                                        sufficiently
                                        good shape to compete in the World Masters Body Building Championships in Spain
                                        where I represented
                                        South Africa.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Shaun Keating, USA </h5>
                                        <h5 class="text-blue AdelleSansRegular"> Founder of Keating Dental Arts </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “Every day I seem to notice a new benefit.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/P1100930-e1479286822673.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        I used to have acne scars from my teenage years; they’ve gone away. I used to have
                                        heartburn; not
                                        anymore. I used to suffer from insomnia; now I fall asleep like a baby. Celergen is
                                        like the gift
                                        that keeps on giving.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Suha Yenigul, Turkey </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “Celergen is the reason for my improved libido... I can last longer than
                                            normal.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/photo-e1479287228733.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        After a mere 3 days of using Celergen, I feel an enormous surge in energy, my sleep
                                        quality
                                        improved as well. My overall energy and performance levels seem to last longer than
                                        normal.
                                        My girlfriend even complimented me about my improved skin and complexion. I feel
                                        great!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Rie Loo, Japan </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “My skin looks brighter and my pores… less visible.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/testimonial-rie-loo.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        For the first 2-3 weeks, I didn’t find any special change in me maybe because I have
                                        always been
                                        in relatively good condition. But one morning, I found that my skin texture has
                                        become smoother,
                                        brighter and my pores less visible.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Wang Furong, China </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “I never expect Celergen’s benefits to manifest so quickly and with such
                                            potency.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_wang.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        After only 15 days of Celergen, I am able to sleep better and wake up feeling a lot
                                        fresher and more
                                        energized than ever before. The dizzy spells I used to experience have left me and
                                        as a result now,
                                        I am more efficient and effective at work. Most importantly, Celergen helps to
                                        reduce the pain which
                                        I had experienced in my neck and back significantly.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Kim Young Ho, Korea </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “Even though I am only young, Celergen is the perfect Anti-Aging Food Supplement
                                            because
                                            it invigorates me at work.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_kim.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        For the first 2 weeks, I did not find any special change in me except that I was
                                        perspiring more
                                        often than before. After continued consumption of Celergen, I wake up feeling more
                                        refreshed and
                                        invigorated. I am also pleased to find that I recovered much faster after my evening
                                        exercises.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="customer-review pb-lg-5">
                            <div class="customer-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="text-blue AdelleSansBold"> Dr. Keren Priyadarshini, India </h5>
                                        <p class="text-grey lh-lg AdelleSansRegular pt-lg-2 pb-4 ">
                                            “Celergen… is a supplement that has multi-faceted advantages.”
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/test_drkeren.jpg"
                                            alt="" class="" width="100%">
                                    </div>
                                </div>
                                <div class="my-5 ">
                                    <p class="text-grey lh-lg">
                                        Having taken Celergen for just over 10 days, I must say that it is a supplement that
                                        has
                                        multi-faceted advantages. I had to conduct interviews non-stop for 8 hrs a day, 3
                                        days consecutively,
                                        and never did I feel an iota of fatigue while taking Celergen. The following morning
                                        is always bright
                                        and fresh with no hangover of the previous day. Celergen is quite effective in
                                        helping my body cope
                                        with the daily vagaries of life keeping my energy levels at an optimum high!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Rene.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. RENE DELL’ACQUA </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Dell’Acqua Dental Studio </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I am amazed in the difference in my skin. It went from dull and lifeless to radiant, hydrated
                            and gorgeous.
                            I am sleeping much better and my energy throughout the day has dramatically improved. Celergen
                            proves over and
                            over again to be the most incredible supplement I have ever used.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Michael.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. MICHAEL KLENTZ </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Germany </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “No surgery. Celergen heals the tear on my left knee meniscus. Celergen really works wonders, by
                            directly
                            affecting the immune system, regenerating, rejuvenating, reducing inflammation and creating a
                            more youthful
                            looking, energetic personality."
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Michael-Hall.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. MICHAEL HALL </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Hall Longevity Clinic </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “There is definitely a regenerative component to Celergen. I noticed almost immediately that my
                            skin is softer
                            and more elastic, and my hair is fuller. I now recommend to my patients without reservations and
                            have heard
                            countless stories about how Celergen has improved their lives.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/DrBruceKLowellMD_3684_162.png"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR BRUCE LOWELL </h5>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “ Celergen affects different patients in different ways. Some of my male patients reported
                            improved libido
                            and sexual performance. While some said it helped to reduce joint pain and give them a better
                            night’s sleep.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Yanis.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. YANIS DATSERIS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> OMMA Eye Institute of Athens </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen fills me with endless energy and an intense desire for life. Every day, as soon as I
                            wake up, I
                            start my day with a Celergen tablet/capsule. I have no doubt, whatsoever, that my new found
                            energy and my
                            ultra-positive attitude towards life are the most precious gifts, offered by Celergen.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Karla-Groves.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. KARLA GROVES </h5>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I started taking Celergen two months ago and my skin has never looked better! The dark circles
                            and volume
                            loss are dramatically improved! I’ve also noted significant improvement in my energy level and
                            ability to
                            concentrate. I no longer have headaches or allergy symptoms.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Terry-Grossman.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. TERRY GROSSMAN</h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Grossman Medical Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Friends I haven’t seen in a year or so would comment; ‘You look great, so much younger. Did you
                            have laser
                            surgery or something?’ The only thing that had changed in my daily regimen was the addition of
                            Celergen so I
                            had to attribute it to that.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Stephen-Pfeifer.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. STEPHEN PFEIFER </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Integrative Wellness Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I can’t even begin to tell you how excited I am about the cumulative benefits that will occur
                            over time for
                            our patients who are taking Celergen. It’s reducing inflammation and getting rid of everything
                            from insomnia
                            to muscle pain and fatigue.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-David-Minkoff.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. DAVID MINKOFF </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Lifeworks Wellness Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “My patient who is suffering from Parkinson told me that taking Celergen is like injecting fuel
                            in her veins.
                            Her energy levels was so significantly increased that she was not taking her Parkinson’s
                            medication because she
                            felt so good.
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Thomas-Tzikas.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. THOMAS TZIKAS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Tzikas Facial Plastic Surgery Centre
                            </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “After taking Celergen on a daily basis, I began noticing that tiredness was no longer an issue
                            after a
                            day’s work. It helped me push myself a little more and be more effective in my daily routine. I
                            experienced
                            fewer joint and muscle aches. Plus I didn’t have a craving for sweets that I sometime have and
                            lost a little
                            weight that needed losing. I hadn’t changed anything else in my diet or taken other supplements,
                            so I can only
                            attribute the change to Celergen.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Michael-Hytros.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. MICHAEL HYTROS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> The Anti-Aging and Bariatric Clinic
                            </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I sleep much better now and wake up with renewed energy. I believe Celergen is the best natural
                            supplement
                            enhancing the quality of life.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Donovan-Christie.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. DONOVAN CHRISTIE </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Anwan Medical Wellness Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “There is an urgent need to get away from being prescription drug-dependent and focus more on
                            the root
                            causes of disease by getting people to commit to a wellness lifestyle. I’m very impressed how
                            Celergen
                            benefits patients afflicted with arthritis, chronic pain, and fatigue. One middle-aged gentleman
                            came
                            to us suffering from so much chronic fatigue that it was everything he could do just to leave
                            the house."
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Angelo-Baccellieri.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. ANGELO BACCELLIERI </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Westchester Wellness Medicine </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I have been on Celergen for about three months and have suffered chronic pain to my ankle from
                            a fall.
                            Now I am walking without a limp and have decreased the pain and stiffness. I no longer need to
                            take NSAIDS
                            or painkillers.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Sharon-Norling.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. SHARON NORLING </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Conventional and Natural Medicine
                            </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I don’t believe in prescribing mood altering drugs. So when a natural therapy like Celergen
                            comes along,
                            it’s a huge gift. There are no apparent side effects, and it can help people live their best
                            possible lives.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Kenneth-Orbeck.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. KENNETH ORBECK </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Body logic MD </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “My patients come in complaining about knee pain or joint swelling. After a short regime of
                            Celergen, the
                            pain often disappears altogether and the afflicted area shows improved range of motion and
                            strength.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/druziURHQ-e1479285472801.jpeg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. UZZI REISS</h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Beverly Hills Anti-Aging Centre </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen is a remarkable tool that can help improve our wellbeing on multiple levels. It is the
                            Rolls Royce of
                            supplement for the human body.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Ghislaine-Beilin.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. GHISLAINE BEILIN, PLASTIC SURGEON </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> President of European Society
                                Anti-Aging and Preventive Medicine </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen is amazing and incredible because it enhances our cell renewal and repair process as
                            if we had
                            hormone treatments. This significant energy boost is very similar to the administration of
                            growth hormones
                            and anabolic hormones. Also, the thyroid levels for my patients have improved significantly. I’m
                            very surprised
                            that with Celergen, the overall hormonal balance is maintained at an improved, optimal level.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Juan-Remos.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. JUAN REMOS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Wellness Institute of the Americas
                            </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “I’ve had several male patients who, having been on Celergen for a month or two, no longer see
                            the need to take
                            Viagra. It gives them a renewed sense of vitality across the board.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/Dr.-Eleana-Papacharalambous.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. ELEANA PAPACHARALAMBOUS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Orthobiotiki </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “After 4 days of Celergen, I can proudly proclaim that I felt more energetic, had a better
                            quality of sleep and
                            woke up feeling invigorated. After a month of Celergen, I noticed my skin looking more radiant
                            than before.
                            Another benefit that took me by surprise was the fact that I stopped feeling dizzy whenever I
                            felt tired.
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular"> DR. GLEN GUILLET </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> Anti-Aging Cell Therapy of Texas
                            </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “At 74, after bypass surgery, I figured things might never get better. Enter Celergen! I no
                            longer wear a back
                            brace, I work 14 hours a day, and I never complain of being tired.”
                        </p>
                    </div>
                    <div id="Doctors" class="text-center doctors-review bg-white">
                        <div>
                            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/dr-juan-remos-e1479280710760.jpg"
                                alt="" class="doctors-img">
                        </div>
                        <div class="pt-5">
                            <h5 class="doct-name text-blue CallunaRegular">DR. JUAN REMOS </h5>
                            <h6 class="doct-desing text-blue AdelleSansRegular pt-3"> The Wellness Institute </h6>
                        </div>
                        <p class="text-grey AdelleSansRegular lh-lg pt-lg-4">
                            “Celergen is the best natural product that I have come across since I started practicing
                            medicine.
                            It is definitely the next big thing for those seeking wellbeing and good health.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
