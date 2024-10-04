@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')

@section('content')
    <h1>Entity Management</h1>
    @livewire('admin.entity-manager') <!-- This should work now -->
@endsection
