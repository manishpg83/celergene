@extends('layouts.admin')

@section('title', 'Admin Customers')
@section('header', 'Customers Management')

@section('content')
    @livewire('admin.customer.customer-details', ['id' => $id])
@endsection
