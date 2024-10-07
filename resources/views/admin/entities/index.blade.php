@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-2 ml-6">Entity Management</h1>
    @livewire('admin.entity-manager') <!-- This should work now -->
@endsection
