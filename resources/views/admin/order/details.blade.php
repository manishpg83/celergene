@extends('layouts.admin')

@section('title', 'Add orders')
@section('header', 'Add orders')

@section('content')
    @livewire('admin.orders.order-details', ['order_id' => $order_id])
@endsection
