@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')

    <style>
        .bg-darkgrey {
            background-color: #868686;
        }

        .celergen-videos {
            position: relative;
            padding-top: 56.25%;
            overflow: hidden;
        }

        .ifream-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .video {
            padding-right: calc(var(--bs-gutter-x)* .5);
            padding-left: calc(var(--bs-gutter-x)* .5);
        }
    </style>

    <section class="margin-top">
        <div class="container-fluid px-0">
            <div class="CallunaRegular padding-x bg-blue text-white">
                <h1 class="text-white section-heading CallunaRegular border-left m-0"> CELERGEN VIDEOS </h1>
            </div>
            <div class="bg-black">
                <div class="container">
                    <div class="col-lg-11 col-11 mx-auto float-none">
                        <div class="celergen-videos">
                            <iframe width="100%" src="https://www.youtube.com/embed/pM3r9Q3F_C8"
                                class="ifream-video"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col-lg-11 col-11 mx-auto float-none">
                    <p class="text-grey mb-2"> EXPERT REVIEW </p>
                    <p class="text-grey mb-2"> with Dr. Juan Remos </p>
                    <p class="text-grey mb-2"> 0 Likes 0 Views </p>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid px-0 pt-2 pb-5">
        <div class="container">
            <div class="col-lg-11 col-11 mx-auto float-none">
                <div class="py-3">
                    <div class="bg-darkgrey p-lg-4 p-3">
                        <h3 class="CallunaRegular text-white mb-0"> OTHER VIDEO </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xl-3 pt-4 video">
                        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb1.jpg"
                            alt="">
                        <p class="my-1">EXPERT REVIEW</p>
                        <p class="mb-1">Dr. Juan Remos</p>
                    </div>
                    <div class="col-lg-4 col-xl-3 py-4 video">
                        <a href="video2.php"> <img
                                src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb2.jpg"
                                alt=""> </a>
                        <p class="my-1">EXPERT REVIEW</p>
                        <p class="mb-1">Dr. Ghislaine Beilin</p>
                    </div>
                    <div class="col-lg-4 col-xl-3 py-4 video">
                        <a href="video3.php"> <img
                                src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb3.jpg"
                                alt=""> </a>
                        <p class="my-1">EXPERT REVIEW</p>
                        <p class="mb-1">Dr. Michael Klentze</p>
                    </div>
                    <div class="col-lg-4 col-xl-3  py-4 video">
                        <a href="video4.php"> <img
                                src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb4.jpg"
                                alt=""> </a>
                        <p class="my-1">MOUNTAIN CLIMBING EXPEDITION</p>
                        <p class="mb-1">Celergen Mexico Team</p>
                    </div>
                    <div class="col-lg-4 col-xl-3 py-xl-5 py-4 video">
                        <a href="video5.php"> <img
                                src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb5.jpg"
                                alt=""> </a>
                        <p class="my-1">CELERGEN CORPORATE</p>
                        <p class="mb-1">Celergen Swiss</p>
                    </div>
                    <div class="col-lg-4 col-xl-3 py-xl-5 pt-3 video">
                        <a href="video6.php"> <img
                                src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb6.jpg"
                                alt=""> </a>
                        <p class="my-1">CUSTOMER TESTIMONIAL</p>
                        <p class="mb-1">Aaron Younger</p>
                    </div>
                    <div class="col-lg-4 col-xl-3 py-xl-5 py-4 video">
                        <a href="video7.php"> <img
                                src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/videothumb7.jpg"
                                alt=""></a>
                        <p class="my-1">CUSTOMER TESTIMONIAL</p>
                        <p class="mb-1">Sarah Corbettw</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
