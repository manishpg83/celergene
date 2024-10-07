@extends('layouts.admin')

@section('title', 'Admin Customers')
@section('header', 'Customers Management')

@section('content')
    <h1>Customer Management</h1>
    @livewire('admin.admin-customer') <!-- This should work now -->
@endsection
