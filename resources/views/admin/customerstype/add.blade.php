@extends('layouts.admin')

@section('title', 'Add/Edit Customer Type')
@section('header', 'Add/Edit Customer Type')

@section('content')
    <!-- Render the Livewire component for add/edit form -->
    @livewire('admin.customerstype.add-customer-type')
@endsection
