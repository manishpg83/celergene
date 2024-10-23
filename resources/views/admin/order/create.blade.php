@extends('layouts.admin')

@section('title', 'Add orders')
@section('header', 'Add orders')

@section('content')
    @livewire('admin.orders.create-order')
@endsection
