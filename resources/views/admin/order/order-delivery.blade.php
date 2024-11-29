@extends('layouts.admin')

@section('title', 'Order Delivery')
@section('header', 'Order Delivery')

@section('content')
    @livewire('admin.orders.order-delivery', ['order_id' => $order_id])
@endsection
