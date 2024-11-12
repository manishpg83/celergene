@extends('layouts.admin')

@section('title', 'Add orders')
@section('header', 'Add orders')

@section('content')
    @livewire('admin.orders.order-details', ['invoice_id' => $invoice_id])
@endsection
