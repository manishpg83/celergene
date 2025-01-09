@extends('frontend.layouts.app')

@section('title', 'Billing | Celergen')
@section('header', 'Billing | Celergen')

@section('content')
    @livewire('frontend.billing-address-form', ['customerId' => $customerId])
@endsection
