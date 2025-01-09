@extends('frontend.layouts.app')

@section('title', 'Billing | Celergen')
@section('header', 'Billing | Celergen')

@section('content')
    @livewire('frontend.shipping-address-form', ['addressNumber' => $addressNumber])
@endsection
