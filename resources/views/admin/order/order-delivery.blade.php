@extends('layouts.admin')

@section('title', 'Order Delivery')
@section('header', 'Order Delivery')

@section('content')
    @livewire('admin.orders.order-delivery', ['invoiceId' => $invoice_id])
@endsection
