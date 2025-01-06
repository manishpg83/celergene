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
                            <iframe width="100%" 
                                src="https://www.youtube.com/embed/{{ $currentVideo ? $currentVideo['youtube_id'] : $videos[0]['youtube_id'] }}"
                                class="ifream-video"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="col-lg-11 col-11 mx-auto float-none">
                    <p class="text-grey mb-2">{{ $currentVideo ? $currentVideo['title'] : $videos[0]['title'] }}</p>
                    <p class="text-grey mb-2">{{ $currentVideo ? $currentVideo['presenter'] : $videos[0]['presenter'] }}</p>
                    <p class="text-grey mb-2">0 Likes 0 Views</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid px-0 pt-2 pb-5">
        <div class="container">
            <div class="col-lg-11 col-11 mx-auto float-none">
                <div class="py-3">
                    <div class="bg-darkgrey p-lg-4 p-3">
                        <h3 class="CallunaRegular text-white mb-0">OTHER VIDEO</h3>
                    </div>
                </div>
                <div class="row">
                    @foreach($videos as $video)
                        <div class="col-lg-4 col-xl-3 pt-4 video">
                            @if(isset($video['url']))
                                <a href="{{ route('celergenvideo') }}">
                            @else
                                <a href="{{ route('show.video', $video['id']) }}">
                            @endif
                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/success_stories/{{ $video['thumbnail'] }}"
                                    alt="{{ $video['title'] }}" class="w-100">
                            </a>
                            <p class="my-1">{{ $video['title'] }}</p>
                            <p class="mb-1">{{ $video['presenter'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection