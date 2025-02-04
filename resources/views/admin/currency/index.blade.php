@extends('layouts.admin')

@section('title', 'Admin Currency')
@section('header', 'Currency Management')

@section('content')
    @livewire('admin.currency.currency-list')
@endsection

