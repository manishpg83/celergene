@extends('frontend.layouts.app')
@section('title', 'Home | Celergen')
@section('header', 'Home | Celergen')
@section('content')
    <div class="wrapper-fixed">
        <div class="banner">
            <div class="table-cell">
                <div class="v-align">
                    Experience Swiss Cell Therapy
                </div>
            </div>
        </div>
        @livewire('frontend.registration')
    </div>
@endsection

