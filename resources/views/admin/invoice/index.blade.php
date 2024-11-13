@extends('layouts.admin')

@section('title', 'Invoice List')
@section('header', 'Invoice List')

@section('content')
    @livewire('admin.invoice.custom-invoice-list')
@endsection
