@extends('layouts.admin')

@section('title', 'Admin Customers')
@section('header', 'Customers Management')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-2 ml-4">Customer Management</h1>
    @livewire('admin.admin-customer') <!-- This should work now -->
@endsection
